<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

//TODO: Match all this to my actual part schema!!!

class PartController extends Controller
{
  //Show all parts
  public function index() {
    $parts = Part::orderBy('added_at', 'desc')->get();
    //the second argument below is passing an associative array as a second argument
    return view('parts.index', ['parts' => $parts]);
  }
  //Create part
  public function create() {
    return view('parts.create');
  }
  //Store part
  public function store(Request $request) {
    // validations
    $request->validate([
      'title' => 'required',
      'description' => 'required',
      'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $part = new Part;

    $file_name = time() . '.' . request()->image->getClientOriginalExtension();
    
    $part->title = $request->title;
    $part->description = $request->description;
    $part->image = $file_name;

    $part->save();
    return redirect()->route('parts.index')->with('success', 'Part created successfully.');


  }
}
