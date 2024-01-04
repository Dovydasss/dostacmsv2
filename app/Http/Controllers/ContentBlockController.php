<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\ContentBlock;

class ContentBlockController extends Controller
{

    public function index()
    {
        // Fetch all blocks with their associated page
        $blocks = ContentBlock::with('page')->orderBy('page_id')->orderBy('order')->get();

        return view('admin.blocks.index', compact('blocks'));
    }

    public function create()
{
    $pages = Page::all();
    return view('admin.blocks.create', compact('pages'));
}


public function edit(ContentBlock $block)
{
    $pages = Page::all(); // Fetch all pages
    return view('admin.blocks.edit', compact('block', 'pages'));
}


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'page_id' => 'required|exists:pages,id',
            'title' => 'required|string|max:255', // Validation rule for title
            'type' => 'required',
            'content' => 'required',
            'order' => 'sometimes|integer'
        ]);
    
        ContentBlock::create($validatedData);
    
        return redirect('admin/blocks')->with('success', 'Block created successfully.');
    }
    

    public function update(Request $request, ContentBlock $block)
    {
        $validatedData = $request->validate([
            'page_id' => 'required|exists:pages,id',
            'title' => 'required|string|max:255', // Validation rule for title
            'type' => 'required',
            'content' => 'required',
            'order' => 'sometimes|integer'
        ]);
    
        $block->update($validatedData);
    
        return redirect('admin/blocks')->with('success', 'Block updated successfully.');

    }

    public function destroy(ContentBlock $block)
    {
        $block->delete();

        return redirect('admin/blocks')->with('success', 'Block deleted successfully.');

    }
}
