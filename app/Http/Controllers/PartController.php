<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;
use \App\Rules\UrlBlob;

//TODO: Match all this to my actual part schema!!!

class PartController extends Controller
{
  //Show all parts
  public function index()
  {
    $parts = Part::orderBy('created_at', 'desc')->get();
    //the second argument below is passing an associative array as a second argument
    return view('parts.index', ['parts' => $parts]);
  }
  //Create part
  public function create()
  {
    return view('parts.create');
  }
  //Store part
  public function store(Request $request)
  {
    // validations
    $request->validate([
      'title' => 'required',
      'type' => 'required',
      'description' => 'required',
      'ipaid' => 'required',
      'price' => 'required',
      'image' => ['required', new UrlBlob ],
    ]);

    $part = new Part;

    $file_name = time() . '.' . request()->image;

    $part->title = $request->title;
    $part->type = $request->type;
    $part->description = $request->description;
    $part->ipaid = $request->ipaid;
    $part->price = $request->price;
    $part->image = $request->image;


    $part->save();
    return redirect()->route('parts.index')->with('success', 'Part created successfully.');
  }

  //get available parts
  public function getAvailableParts(Request $request)
  {
    $availableParts = Part::available()->get();
    return $availableParts;
  }
}
