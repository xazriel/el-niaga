<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SizeGuideTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SizeGuideController extends Controller
{
    public function index()
    {
        $templates = SizeGuideTemplate::all();
        return view('admin.size_guides.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.size_guides.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:general,abaya,khimar,kids,khiban',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('size_guides', 'public');
        }

        SizeGuideTemplate::create([
            'name'  => $request->name,
            'image' => $imagePath,
            'type'  => $request->type,
            'data'  => json_encode([]),
        ]);

        return redirect()->route('admin.size-guides.index')->with('success', 'Template Size Guide berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $template = SizeGuideTemplate::findOrFail($id);
        return view('admin.size_guides.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $template = SizeGuideTemplate::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:general,abaya,khimar,kids,khiban',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'type' => $request->type,
        ];

        if ($request->hasFile('image')) {
            if ($template->image) {
                Storage::disk('public')->delete($template->image);
            }
            $data['image'] = $request->file('image')->store('size_guides', 'public');
        }

        $template->update($data);

        return redirect()->route('admin.size-guides.index')->with('success', 'Template Size Guide berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $template = SizeGuideTemplate::findOrFail($id);

        if ($template->image) {
            Storage::disk('public')->delete($template->image);
        }

        $template->delete();

        return redirect()->route('admin.size-guides.index')->with('success', 'Template Size Guide berhasil dihapus.');
    }
}
