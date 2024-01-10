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
            'show_header' => 'sometimes',
        ]);
    
        $header = new Header;
    
        if ($request->hasFile('header_image')) {
            $file = $request->file('header_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = 'header';
            $file->move(public_path($destinationPath), $filename);
            $header->header_image = $destinationPath . '/' . $filename;
        }
    
        $header->width = $request->input('width');
        $header->height = $request->input('height');
        $header->show_header = $request->input('show_header') === 'on'; 
    
        $header->save();
    
        return redirect()->route('header.index')->with('success', 'Header created successfully.');
    }
    
    


    public function update(Request $request)
{
    $request->validate([
        'header_image' => 'nullable|image|max:2048',
        'width' => 'required|string',
        'height' => 'required|string',
        'show_header' => 'sometimes', 
    ]);

    $header = Header::firstOrNew([]);

    if ($request->hasFile('header_image')) {
        $destinationPath = 'header';
        $filename = time() . '_' . $request->file('header_image')->getClientOriginalName();
        $request->file('header_image')->move(public_path($destinationPath), $filename);
        $header->header_image = $destinationPath . '/' . $filename;
    }

    $header->width = $request->input('width');
    $header->height = $request->input('height');
    $header->show_header = $request->input('show_header') === 'on'; 

    $header->save();

    return redirect()->back()->with('success', 'Header updated successfully.');
}



}
