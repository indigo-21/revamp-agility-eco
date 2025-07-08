<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MessageTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    protected $emailData;
    protected $url;

    public function __construct()
    {
        // get the /url and set to url
        $this->url = request()->segment(1);

        $this->emailData = match ($this->url) {
            'pi-email-template' => 1, // PI Email Template
            'uphold-email-template' => 2, // Uphold Email Template
            'remediation-template' => 3, // Remediation Email Template
            'first-template' => 4, // First Email Template
            'second-template' => 5, // Second Email Template
            'automated-email-passed' => 6, // Automated Email Passed Template
        };

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messageTemplates = MessageTemplate::where('data_id', $this->emailData)
            ->get();

        return view("pages.email-templates.{$this->url}.index")
            ->with('messageTemplates', $messageTemplates)
            ->with('url', $this->url);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.email-templates.{$this->url}.form")
            ->with('url', $this->url);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate that we're not creating an inactive template when no active templates exist
        if (!$request->is_active) {
            $activeTemplateCount = MessageTemplate::where('data_id', $this->emailData)
                ->where('is_active', true)
                ->count();

            if ($activeTemplateCount === 0) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['is_active' => 'At least one email template must be active. Cannot create inactive template when no active templates exist.']);
            }
        }

        $messageTemplate = new MessageTemplate;

        $messageTemplate->name = $request->name;
        $messageTemplate->subject = $request->subject;
        $messageTemplate->content = $request->content;
        $messageTemplate->data_id = $this->emailData;
        $messageTemplate->is_active = $request->is_active;
        $messageTemplate->uphold_type = $request->uphold_type;
        $messageTemplate->remediation_type = $request->remediation_type;

        $messageTemplate->save();

        if ($request->is_active) {
            $this->setTemplateActive($messageTemplate->id);
        }

        return redirect()->route("{$this->url}.index")
            ->with('success', 'Email template created successfully.');
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
        $messageTemplate = MessageTemplate::findOrFail($id);

        return view("pages.email-templates.{$this->url}.form")
            ->with('messageTemplate', $messageTemplate)
            ->with('url', $this->url);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messageTemplate = MessageTemplate::findOrFail($id);

        // Check if trying to set this template as inactive when it's the only active template
        if (!$request->is_active && $messageTemplate->is_active) {
            $activeTemplateCount = MessageTemplate::where('data_id', $this->emailData)
                ->where('is_active', true)
                ->where('id', '!=', $id)
                ->count();

            if ($activeTemplateCount === 0) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['is_active' => 'At least one email template must be active. Cannot deactivate the last active template.']);
            }
        }

        $messageTemplate->name = $request->name;
        $messageTemplate->subject = $request->subject;
        $messageTemplate->content = $request->content;
        $messageTemplate->is_active = $request->is_active;
        $messageTemplate->uphold_type = $request->uphold_type;
        $messageTemplate->remediation_type = $request->remediation_type;

        $messageTemplate->save();

        if ($request->is_active) {
            $this->setTemplateActive($messageTemplate->id);
        }

        return redirect()->route("{$this->url}.index")
            ->with('success', 'Email template updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $messageTemplate = MessageTemplate::findOrFail($id);

        // Check if trying to delete the last active template
        if ($messageTemplate->is_active) {
            $activeTemplateCount = MessageTemplate::where('data_id', $this->emailData)
                ->where('is_active', true)
                ->where('id', '!=', $id)
                ->count();

            if ($activeTemplateCount === 0) {
                return redirect()->back()
                    ->withErrors(['general' => 'Cannot delete the last active email template. At least one template must remain active.']);
            }
        }

        $messageTemplate->delete();

        return redirect()->route("{$this->url}.index")
            ->with('success', 'Email template deleted successfully.');
    }

    public function setTemplateActive($id)
    {
        $messageTemplate = MessageTemplate::where('data_id', $this->emailData)
            ->where('is_active', true)
            ->where('id', '!=', $id)
            ->get();

        foreach ($messageTemplate as $template) {
            $template->is_active = 0;
            $template->save();
        }
    }
}
