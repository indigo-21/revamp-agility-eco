<?php

namespace App\Http\Controllers;

use App\Models\MessageTemplate;
use App\Models\SicknessHoliday;
use App\Services\MailService;
use Illuminate\Http\Request;

class SicknessHolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sicknessHolidays = SicknessHoliday::where('property_inspector_id', auth()->user()->propertyInspector->id)
            ->get();

        return view('pages.property-inspector-portal.sickness-holidays.index')
            ->with('sicknessHolidays', $sicknessHolidays);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.property-inspector-portal.sickness-holidays.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sicknessHoliday = new SicknessHoliday;
        $propertyInspector = auth()->user();

        $sicknessHoliday->property_inspector_id = $propertyInspector->propertyInspector->id;
        $sicknessHoliday->start_date = $request->start_date;
        $sicknessHoliday->end_date = $request->end_date;
        $sicknessHoliday->reason = $request->reason;

        $sicknessHoliday->save();

        $emailTemplates = MessageTemplate::where('data_id', 1)
            ->where('is_active', 1)
            ->where('type', 'email')
            ->first();

        $email = env('EMPLOYER_EMAIL');
        $subject = $emailTemplates->subject;

        $data = [
            '_PI_NAME_' => $propertyInspector->firstname . ' ' . $propertyInspector->lastname,
            '_START_DATE_' => $sicknessHoliday->start_date,
            '_END_DATE_' => $sicknessHoliday->end_date,
            '_REASON_' => $sicknessHoliday->reason,
        ];

        $template = $emailTemplates->content;

        (new MailService)->sendEmail($subject, $template, $email, $data, true);

        return redirect()->route('sickness-holidays.index')->with('success', 'Sickness/Holiday request submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SicknessHoliday $sicknessHoliday)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sicknessHoliday = SicknessHoliday::findOrFail($id);

        return view('pages.property-inspector-portal.sickness-holidays.form')
            ->with('sicknessHoliday', $sicknessHoliday);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sicknessHoliday = SicknessHoliday::findOrFail($id);

        $sicknessHoliday->start_date = $request->start_date;
        $sicknessHoliday->end_date = $request->end_date;
        $sicknessHoliday->reason = $request->reason;

        $sicknessHoliday->save();

        return redirect()->route('sickness-holidays.index')->with('success', 'Sickness/Holiday request updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sicknessHoliday = SicknessHoliday::findOrFail($id);
        $sicknessHoliday->delete();

        return redirect()->route('sickness-holidays.index')->with('success', 'Sickness/Holiday request deleted successfully.');
    }
}
