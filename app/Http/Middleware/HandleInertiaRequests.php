<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                /*this 'can' method returns a JSON object with boolean values to permission keys:
                {
                  "part_create": true,
                  "part_edit": true,
                  "part_destroy" true,
                }
                */
                'can '=> $request->user()?->loadMissing('roles.permissions')->roles->flatMap(function ($role) {
                  return $role->permissions;
                })->map(function($permission) {
                  return [$permission['title'] => auth()->user()->can($permission['title'])];
                })->collapse()->all(),
            ],
        ];
    }
}
