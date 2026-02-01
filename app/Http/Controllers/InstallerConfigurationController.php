<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Installer;
use App\Models\UserType;
use App\Services\UserService;
use Illuminate\Http\Request;

class InstallerConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $installers = Installer::all();

        return view("pages.platform-configuration.installer-configuration.index")
            ->with("installers", $installers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userType = UserType::find(3);

        return view("pages.platform-configuration.installer-configuration.form")
            ->with("userType", $userType);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Ensure the value exists in the request input bag (Request::has checks inputs, not dynamic properties)
        $request->merge(['account_level_id' => 5]); // Installer

        $user = (new UserService)->store($request);

        $installer = new Installer();
        $installer->user_id = $user->id;
        $installer->sent_available = $request->sent_available;
        $installer->save();

        // $installerClients = json_decode($request->input('clientsArray'), true);

        // foreach ($installerClients as $installerClient) {
        //     $client = new InstallerClient();
        //     $client->installer_id = $installer->id;
        //     $client->client_id = $installerClient['suffix'];
        //     $client->tmln = $installerClient['tmln'];
        //     $client->save();
        // }

        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Data processed successfully',
        // ]);

        return redirect()->route('installer-configuration.index');
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
        $installer = Installer::find($id);
        $userType = UserType::find(3);

        return view("pages.platform-configuration.installer-configuration.form")
            ->with("userType", $userType)
            ->with('installer', $installer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $installer = Installer::find($id);
        // Ensure the value exists in the request input bag (Request::has checks inputs, not dynamic properties)
        $request->merge(['account_level_id' => 5]); // Installer

        $installer->sent_available = $request->sent_available;
        $installer->save();

        (new UserService)->store($request, $installer->user_id);

        return redirect()->route('installer-configuration.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $installer = Installer::find($id);
        $installer->user->delete();
        $installer->delete();

        return redirect()
            ->route('installer-configuration.index')
            ->with('message', 'Installer deleted successfully')
            ->with('status', 'success');
    }
}
