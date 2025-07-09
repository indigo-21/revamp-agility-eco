<?php

namespace App\Http\Controllers;

use App\Models\AccountLevel;
use App\Models\User;
use App\Models\UserType;
use App\Services\MailService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // You can modify this to include trashed users if needed:
        // $users = User::withTrashed()->get(); // Include soft deleted
        // $users = User::onlyTrashed()->get(); // Only soft deleted
        $users = User::all(); // Only active users

        return view('pages.platform-configuration.user-configuration.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accountLevels = AccountLevel::whereNotIn('id', [4, 5, 6, 7, 8])
            ->get();
        $userTypes = UserType::whereIn('id', [1, 2])
            ->get();

        return view('pages.platform-configuration.user-configuration.form')
            ->with('accountLevels', $accountLevels)
            ->with('userTypes', $userTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            // 'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
            'mobile' => 'required|string|max:20',
            'landline' => 'nullable|string|max:20',
            'organisation' => 'required|string|max:255',
            'account_level_id' => 'required|exists:account_levels,id',
            'user_type_id' => 'required|exists:user_types,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        (new UserService)->store($request);

        return redirect()->route('user-configuration.index')
            ->with('success', 'User created successfully.');
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
        $user = User::findOrFail($id);
        $accountLevels = AccountLevel::whereNotIn('id', [4, 5, 6, 7, 8])
            ->get();
        $userTypes = UserType::whereIn('id', [1, 2])
            ->get();

        return view('pages.platform-configuration.user-configuration.form')
            ->with('user', $user)
            ->with('accountLevels', $accountLevels)
            ->with('userTypes', $userTypes);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',id,deleted_at,NULL',
            // 'password' => 'nullable|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
            'mobile' => 'required|string|max:20',
            'landline' => 'nullable|string|max:20',
            'organisation' => 'required|string|max:255',
            'account_level_id' => 'required|exists:account_levels,id',
            'user_type_id' => 'required|exists:user_types,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        (new UserService)->store($request, $id);

        return redirect()->route('user-configuration.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Load related data count for confirmation message
        // $relatedCount = 0;
        // $relatedCount += $user->client ? 1 : 0;
        // $relatedCount += $user->propertyInspector ? 1 : 0;
        // $relatedCount += $user->installer ? 1 : 0;

        $user->delete(); // This will trigger the model events to cascade soft delete

        // $message = $relatedCount > 0 
        //     ? "User and {$relatedCount} related record(s) deleted successfully."
        //     : 'User deleted successfully.';

        return redirect()->route('user-configuration.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Restore a soft deleted user and their related records.
     */
    public function restore(string $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore(); // This will trigger the model events to cascade restore

        return redirect()->route('user-configuration.index')
            ->with('success', 'User and related records restored successfully.');
    }

    /**
     * Force delete a user and their related records permanently.
     */
    public function forceDelete(string $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete(); // This will trigger the model events to cascade force delete

        return redirect()->route('user-configuration.index')
            ->with('success', 'User and related records permanently deleted.');
    }

    public function resetPassword(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $status = Password::sendResetLink(
            $user->email ? ['email' => $user->email] : []
        );
        return $status == Password::RESET_LINK_SENT
            ? response()->json(['status' => $status])
            : response()->json(['error' => __($status)], 400);
    }
}
