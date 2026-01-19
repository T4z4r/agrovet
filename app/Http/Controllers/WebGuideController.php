<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebGuideController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $guides = Guide::with('creator:id,name')->orderBy('created_at', 'desc')->get();
            return response()->json([
                'data' => $guides
            ]);
        }

        $guides = Guide::with('creator:id,name')->orderBy('created_at', 'desc')->get();
        return view('admin.guides.index', compact('guides'));
    }

    public function create()
    {
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return view('admin.guides.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240', // 10MB max
            'language' => 'required|in:en,sw',
            'target_role' => 'required|in:owner,seller,both',
        ]);

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('guides', 'public');
        }

        $data['created_by'] = auth()->id();

        Guide::create($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Guide created successfully']);
        }

        return redirect()->route('admin.guides.index')->with('success', 'Guide created successfully');
    }

    public function show($id)
    {
        $guide = Guide::with('creator:id,name')->findOrFail($id);
        return view('admin.guides.show', compact('guide'));
    }

    public function edit($id)
    {
        $guide = Guide::findOrFail($id);
        if (request()->ajax()) {
            return response()->json($guide);
        }
        return view('admin.guides.edit', compact('guide'));
    }

    public function update(Request $request, $id)
    {
        $guide = Guide::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240',
            'language' => 'required|in:en,sw',
            'target_role' => 'required|in:owner,seller,both',
        ]);

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($guide->file_path) {
                Storage::disk('public')->delete($guide->file_path);
            }
            $data['file_path'] = $request->file('file')->store('guides', 'public');
        }

        $guide->update($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Guide updated successfully']);
        }

        return redirect()->route('admin.guides.index')->with('success', 'Guide updated successfully');
    }

    public function destroy($id)
    {
        $guide = Guide::findOrFail($id);

        // Delete file if exists
        if ($guide->file_path) {
            Storage::disk('public')->delete($guide->file_path);
        }

        $guide->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Guide deleted successfully']);
        }

        return redirect()->route('admin.guides.index')->with('success', 'Guide deleted successfully');
    }

    public function download($id)
    {
        $guide = Guide::findOrFail($id);

        if (!$guide->file_path || !Storage::disk('public')->exists($guide->file_path)) {
            return redirect()->back()->with('error', 'File not found');
        }

        $filePath = Storage::disk('public')->path($guide->file_path);
        return response()->download($filePath, basename($guide->file_path));
    }
}
