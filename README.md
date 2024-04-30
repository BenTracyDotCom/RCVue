# Getting started:

## Ensure you have a way to run and/or access Docker containers
## Ensure you have php artisan in your PATH
## Run the Docker container using Sail: 
``` vendor/bin/sail up ```
* This also begins all necessary databases and servers
### Run all database functions through the container interface ( php artisan migrate/refresh/ seed, etc)
### File creation can be done through either the container interface or the code editor (e.g. `php artisan make: controller UserController`)
- Start the Vite frontend and initialize its hot swapping:
``` npm run dev ```
- Begin developing!


# How it works: Initial route
## When you navigate to base page ('localhost' in dev):

web.php handles rendering:
```php
//app/routes/web.php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});```
This checks if the request has a 'login' or 'register' route available and passes this info, as well as the laravel and php version info, to the Vue component as props via an associative array.

## When you navigate to '/dashboard':

A controller in web.php checks via the built-in 'auth' and 'verified' middlewares, then renders a Vue view called 'dashboard' if the middlewares check good. If not, Laravel routes to the 'login' page (`app/resources/Pages/Auth/login.vue`): 
```php
Route::get('/dashboard', function () {
	return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
```
## When you register a user:

#### Clicking the 'register' button on the welcome page sends a GET request to the 'register' route, which plugs the request into the RegisteredUsercontroller's 'create' method and returns the 'register' page, adding 'register' to the route name using `->name()`:
```php
//app/routes/auth.php
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');         
```
```php
//app/Http/Controllers/RegisteredUserController.php
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }```

#### The vue page renders a form which updates using 'useForm' and submits a request with the form data to the 'register' route when you click the primary button: 
```php
<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="username" value="Name" />

                <TextInput
                    id="username"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Already registered?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
```
*Note that this form also includes validation*

#### The backend receives the POST request to `'register'` and the auth route passes the request to the RegisteredUserController's 'store' method: 
```php
//app/routes/auth.php
Route::post('register', [RegisteredUserController::class, 'store']);
```

#### The controller's 'store' method takes in the form data on the request and uses it to create a new user if the required data checks out, logs the user in using the Auth library (which interacts with the database to associate an active session with the user) and redirects to the 'dashboard' route:
```php
    //RegisteredUserController.php
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }```
Then, the normal controller passes the request successfully through the 'auth' and 'verified' middleware to render the 'Dashboard' page: 
```php
//web.php
Route::get('/dashboard', function () {
  return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
```
*Note that either the controller or the route can use Inertia to render the appropriate page*


## When you log in:
#### When you click "Log In," the Auth controller calls the 'create' method of AuthenticatedSessionController
```php
//.../routes/auth.php
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');
                ```
```php
//.../Controllers/Auth/AuthenticatedSessionController.php
  /**
   * Display the login view.
   */
  public function create(): Response
  {
    return Inertia::render('Auth/Login', [
      'canResetPassword' => Route::has('password.request'),
      'status' => session('status'),
    ]);
  }
  ```
#### The login page renders a form and submits its data as a POST request to 'login'
```vue
<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
...form inputs
<template>
```
#### If the POST request matches what's in the database, the AuthenticatedSessionController stores a new session for you and redirects you to the dashboard:
```php
// Route
Route::post('login', [AuthenticatedSessionController::class, 'store']);

// Controller method
  /**
   * Handle an incoming authentication request.
   */
  public function store(LoginRequest $request): RedirectResponse
  {
    $request->authenticate();

    $request->session()->regenerate();

    return redirect()->intended(route('dashboard', absolute: false));
  }
```
#### 'canLogin' and 'canRegister' become false because the request gets routed through the 'auth' group of the middleware rather than the 'guest' group:
```php
<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
```
...This means that these props will evaluate to "false" when you navigate to ' / ' and the responsive view will render "dashboard" in the toolbar rather than "login" and "register"

#
