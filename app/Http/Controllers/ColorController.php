<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colors;

class ColorController extends Controller
{
    public function show()
    {
        $settingsCollection = Colors::pluck('color', 'name');
        $settings = $settingsCollection->toArray(); // Convert the collection to an array
    
        return view('admin.colors.index', compact('settings'));
    }
    

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'menu_background_color' => 'required|string',
            'menu_text_color' => 'required|string',
            'background_color' => 'required|string',
            'text_color' => 'required|string',
            'footer_background_color' => 'required|string',
            'footer_text_color' => 'required|string'
        ]);

        foreach ($validatedData as $name => $color) {
            Colors::updateOrCreate(
                ['name' => $name],
                ['color' => $color]
            );
        }

        return redirect()->back()->with('success', 'Colors updated successfully.');
    }
}
