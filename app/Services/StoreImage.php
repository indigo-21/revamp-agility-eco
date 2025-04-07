<?php

namespace App\Services;

class StoreImage
{
    public function store($request, $inputFile, $storagePath)
    {
        if ($request->hasFile($inputFile)) {
            // $path = $request->file('image')->store('images', 'public'); // stores in storage/app/public/images
            // OR for custom filename:
            // $filename = time() . '.' . $request->image->extension();
            // $path = $request->image->storeAs($storagePath, $filename);

            $imageName = $request->firstname . $request->lastname . $storagePath . time() . '.' . $request->file($inputFile)->getClientOriginalExtension();
            $request->file($inputFile)->storeAs($storagePath, $imageName, 'public');

            return $imageName;
        }

        return;
    }
}