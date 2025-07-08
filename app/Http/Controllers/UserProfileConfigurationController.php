<?php

namespace App\Http\Controllers;

use App\Models\AccountLevel;
use App\Models\Navigation;
use App\Models\UserNavigation;
use Illuminate\Http\Request;

class UserProfileConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accountLevels = AccountLevel::all();
        return view('pages.platform-configuration.user-profile-configuration.index', compact('accountLevels'));
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
    public function store(Request $request) {}

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
        //   $navigations = Navigation::All();
        $userNavigations = UserNavigation::where('account_level_id', $id)->get();


        return view('pages.platform-configuration.user-profile-configuration.show', compact('userNavigations', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $accountLevelId)
    {
        $accessedInputs = $request->input('accessed', []);
        $permissionInputs = $request->input('permission', []);

        // foreach ($accessedInputs as $navigationId => $accessedValue) {
        //     $userNavigation = UserNavigation::where('account_level_id', $accountLevelId)
        //                                     ->where('navigation_id', $navigationId)
        //                                     ->first();

        //     if ($userNavigation) {
        //         $userNavigation->accessed = $accessedValue;
        //         $userNavigation->permission = $permissionInputs[$navigationId] ?? $userNavigation->permission;
        //         $userNavigation->save();
        //     } 
        // }

        UserNavigation::where('account_level_id', $accountLevelId)->delete();

        foreach ($accessedInputs as $navigationId => $accessedValue) {
            if ($accessedValue == 1) {
                UserNavigation::create([
                    'account_level_id' => $accountLevelId,
                    'navigation_id' => $navigationId,
                    'accessed' => 1,
                    'permission' => $permissionInputs[$navigationId] ?? 'View', 
                ]);
            }
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
