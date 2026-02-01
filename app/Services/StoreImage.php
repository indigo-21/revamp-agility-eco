<?php

namespace App\Services;

use Illuminate\Support\Str;

class StoreImage
{
    public function store($request, $inputFile, $storagePath)
    {
        if ($request->hasFile($inputFile)) {
            $firstName = $request->firstname ?? '';
            $lastName = $request->lastname ?? '';
            $extension = $request->file($inputFile)->getClientOriginalExtension();
            $unique = Str::uuid()->toString();

            $imageName = $firstName . $lastName . $storagePath . $unique . '.' . $extension;
            $request->file($inputFile)->storeAs($storagePath, $imageName, 'public');

            return $imageName;
        }

        return null;
    }
}