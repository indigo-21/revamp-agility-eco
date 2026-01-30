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

        $navigationLists = Navigation::all();
        $accessLevel = AccountLevel::findOrFail($id);
        // $userNavigations = UserNavigation::where('account_level_id', $id)->get()->keyBy('navigation_id');

        return view('pages.platform-configuration.user-profile-configuration.form')
            ->with('navigationLists', $navigationLists)
            ->with('accountLevelId', $id)
            ->with('accessLevel', $accessLevel);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        if ($request->type === "firm_data_only") {
            $accessLevel = AccountLevel::findOrFail($request->account_level_id);

            if (!in_array($accessLevel->name, ['Firm Admin', 'Firm Agent'], true)) {
                abort(403, 'Unauthorized');
            }

            $accessLevel->firm_data_only = (int) $request->selectedValue === 1;
            $accessLevel->save();

            return response()->json([
                'message' => 'Configuration updated successfully!',
                'data' => $request->all(),
            ]);
        }

        // $userProfileConfiguration = new UserNavigation;

        $userProfileConfiguration = UserNavigation::where('account_level_id', $request->account_level_id)
            ->where('navigation_id', $id)
            ->first();

        if (!$userProfileConfiguration) {
            $userProfileConfiguration = new UserNavigation;
            $userProfileConfiguration->permission = 1;
        }

        if ($request->type === "navigation") {
            if ($request->selectedValue == 1) {
                $userProfileConfiguration->account_level_id = $request->account_level_id;
                $userProfileConfiguration->navigation_id = $id;

                $userProfileConfiguration->save();
            } else {
                $userProfileConfiguration->where('account_level_id', $request->account_level_id)
                    ->where('navigation_id', $id)
                    ->delete();
            }
        } else if ($request->type === "permission") {
            $userProfileConfiguration->account_level_id = $request->account_level_id;
            $userProfileConfiguration->navigation_id = $id;
            $userProfileConfiguration->permission = $request->selectedValue;

            $userProfileConfiguration->save();
        }

        return response()->json([
            'message' => 'Configuration updated successfully!',
            'data' => $request->all(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
