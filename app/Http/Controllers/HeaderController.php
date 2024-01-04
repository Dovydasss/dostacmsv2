<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Header;
use Illuminate\Support\Facades\Storage;

class HeaderController extends Controller
{
    public function index()
    {
        $header = Header::first();
        return view('admin.header.index', compact('header'));
    }

    public function store(Request $request)
{
    $request->validate([
        'header_image' => 'required|image|max:2048',
        'width' => 'required|string',
        'height' => 'required|string',
    ]);

    $header = new Header;

    if ($request->hasFile('header_image')) {
        $file = $request->file('header_image');
        $filename = time() . '_' . $file->getClientOriginalName();

        // Move the file to the desired location
        $destinationPath = 'header'; // public/header
        $file->move(public_path($destinationPath), $filename);

        // Store the file path in the database
        $header->header_image = $destinationPath . '/' . $filename;
    }

    $header->width = $request->input('width');
    $header->height = $request->input('height');
    $header->save();

    return redirect()->route('header.index')->with('success', 'Header created successfully.');
}


    public function update(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'header_image' => 'nullable|image|max:2048', // Optional, image file
        'width' => 'required|string', // Required, width as a string
        'height' => 'required|string', // Required, height as a string
    ]);

    // Retrieve the first Header record or create a new one if it doesn't exist
    $header = Header::firstOrNew([]);

    // Check if an image file was uploaded
    if ($request->hasFile('header_image')) {
        // Define the destination path relative to the public directory
        $destinationPath = 'header';

        // Create a unique filename
        $filename = time() . '_' . $request->file('header_image')->getClientOriginalName();

        // Move the file to the public/header directory
        $request->file('header_image')->move(public_path($destinationPath), $filename);

        // Update the header_image field with the new file path
        $header->header_image = $destinationPath . '/' . $filename;
    }

    // Update width and height fields
    $header->width = $request->width;
    $header->height = $request->height;

    // Save the changes to the database
    $header->save();

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Header updated successfully.');
}

}
