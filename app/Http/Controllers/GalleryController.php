<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryImage;
use Storage;
class GalleryController extends Controller
{
    public function viewGallery()
    {
        $images = GalleryImage::all();
        return view('gallery.index', compact('images'));
    }

    // Upload images to gallery
    public function uploadImages(Request $request)
    {
        $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '-' . $image->getClientOriginalName();
                $image->storeAs('public/gallery', $filename);

                // Store in the database
                GalleryImage::create(['file_name' => $filename]);
            }
        }

        return back()->with('success', 'Images uploaded successfully!');
    }

    public function destroy($id)
    {
        $image = GalleryImage::findOrFail($id);

        // Delete image from storage
        if (Storage::exists('public/gallery/' . $image->file_name)) {
            Storage::delete('public/gallery/' . $image->file_name);
        }

        // Delete from the database
        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully!');
    }
}
