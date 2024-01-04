<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Page;
use App\Models\GridSetting;
use App\Models\ContentBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PageDesignController extends Controller
{
    public function index()
    {
        $pages = Page::all(); // Fetch all pages
        return view('admin.pagedesign.index', compact('pages'));
    }

    public function edit(Page $pagedesign) 
    {
        $contentBlocks = ContentBlock::where('page_id', $pagedesign->id)->get();
        $allBlocks = ContentBlock::all();
        $menusToShow = $pagedesign->menus()->with('menuItems')->get();
        $gridSetting = GridSetting::where('page_id', $pagedesign->id)->first();

    return view('admin.pagedesign.edit', compact('pagedesign', 'contentBlocks', 'allBlocks', 'menusToShow', 'gridSetting'));
    }

    public function saveGrid(Request $request, Page $pagedesign) {
        try {
            $gridData = $request->input('gridData');
    
            if (empty($gridData)) {
                throw new \Exception('No grid data provided.');
            }
    
            // Encoding gridData to JSON
            $gridDataJson = json_encode($gridData);
    
            $gridSetting = GridSetting::firstOrNew(['page_id' => $pagedesign->id]);
            $gridSetting->layout = $gridDataJson;
            $gridSetting->save();
    
            return response()->json(['message' => 'Grid saved successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    
    
    
    
}
