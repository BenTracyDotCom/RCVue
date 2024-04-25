<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

//TODO: Match all this to my actual part schema!!!

class PartController extends Controller
{

  //Get available parts
  public function getAvailableParts(Request $request)
  {
    $availableParts = Part::available()->get();
    return $availableParts;
  }

  public function store(Request $request)
  {
    // validations
    $request->validate([
      'title' => 'required',
      'description' => 'required',
      'ipaid' => 'required',
      'price' => 'required',
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
