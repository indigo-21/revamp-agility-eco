<?php

namespace App\Http\Controllers;

use App\Models\AccountLevel;
use App\Models\Navigation;
use Illuminate\Http\Request;

class UserProfileConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accountLevels = AccountLevel::all();
        return view('pages.platform-configuration.user-profile-configuration.index',compact('accountLevels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
            $navigations = Navigation::All();
          return view('pages.platform-configuration.user-profile-configuration.show',compact('navigations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
