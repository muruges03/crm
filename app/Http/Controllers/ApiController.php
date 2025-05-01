<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'front_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'back_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'json'        => 'nullable|string'
        ]);

        $jsonData = json_decode($request->input('json'), true);
dd($jsonData);
        $frontImagePath = $request->file('front_image')->store('front_image', 'public');
        $backImagePath = $request->file('back_image')->store('bacK_image', 'public');

        $jsonData['front_image_url'] = asset("storage/{$frontImagePath}");
        $jsonData['back_image_url'] = asset("storage/{$backImagePath}");

        return response()->json([
            'message' => 'Images and data uploaded successfully',
            'data'    => $jsonData
        ]);
    }
}
