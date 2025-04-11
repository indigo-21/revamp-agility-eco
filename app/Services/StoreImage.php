<?php

namespace App\Services;

class StoreImage
{
    public function store($request, $inputFile, $storagePath)
    {
        if ($request->hasFile($inputFile)) {

            $imageName = $request->firstname . $request->lastname . $storagePath . time() . '.' . $request->file($inputFile)->getClientOriginalExtension();
            $request->file($inputFile)->storeAs($storagePath, $imageName, 'public');

            return $imageName;
        }

        return;
    }
}