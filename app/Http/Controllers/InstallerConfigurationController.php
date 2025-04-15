<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Installer;
use App\Models\InstallerClient;
use App\Models\User;
use App\Models\UserType;
use App\Models\Client;
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
        $clients = Client::all();

        return view("pages.platform-configuration.installer-configuration.form")
            ->with("userType", $userType)
            ->with("clients", $clients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->account_level_id = 5; //Installer

        $user = (new UserService)->store($request);

        $installer = new Installer();
        $installer->user_id = $user->id;
        $installer->save();

        $installerClients = json_decode($request->input('clientsArray'), true);

        foreach ($installerClients as $installerClient) {
            $client = new InstallerClient();
            $client->installer_id = $installer->id;
            $client->client_id = $installerClient['suffix'];
            $client->tmln = $installerClient['tmln'];
            $client->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data processed successfully',
        ]);
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
        //
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
