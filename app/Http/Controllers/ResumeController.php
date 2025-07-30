<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ResumeController extends Controller
{
    public function create()
    {
         $user = auth()->user();


        return Inertia::render('Resume/Index', [
            'gemini_api_key' => config('services.gemini.api_key')
        ]);
    }
    // public function store(Request $request)
    // {

    //     $data = $request->validate([
    //       'title' => ['required', 'string', 'max:255', 'unique:resumes,title'],
    //     ]);

    //     $data['user_id'] = Auth::user()->id;

    //     Resume::create($data);

    //     return to_route('home');

    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:255',
            'website' => 'nullable|url',
            'summary' => 'required|string',

            'education' => 'nullable|array',
            'education.*.school' => 'nullable|string',
            'education.*.course' => 'nullable|string',
            'education.*.start' => 'nullable|string',
            'education.*.end' => 'nullable|string',

            'experience' => 'nullable|array',
            'experience.*.company' => 'nullable|string',
            'experience.*.position' => 'nullable|string',
            'experience.*.start' => 'nullable|string',
            'experience.*.end' => 'nullable|string',
            'experience.*.skills' => 'nullable|string',
            'experience.*.description' => 'nullable|string',

            'skills' => 'nullable|array',
            'skills.*.title' => 'nullable|string',
        ]);

        // Store everything in one record
        $resume = Resume::create([
            'user_id' => Auth::user()->id,
            'name' => $validated['name'],
            'role' => $validated['role'],
            'location' => $validated['location'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'website' => $validated['website'],
            'summary' => $validated['summary'],

            'education' => $validated['education'] ?? [],
            'job_experience' => $validated['experience'] ?? [],
            'skills' => $validated['skills'] ?? [],
        ]);

        //return redirect()->back()->with('success', 'Resume saved successfully!');
         return to_route('preview', ['id' => $resume->id]);
    }

    public function preview(Request $request, $id)
    {
        $user = auth()->user();
        $resume = Resume::findOrFail($id);


        return Inertia::render('Preview', [
            'resume' => $resume
        ]);
    }

    public function edit(Request $request, $id)
    {

        $resume = Resume::findOrFail($id);
        // dd($resume);

        return Inertia::render('Resume/Edit', [
            'resume' => $resume
        ]);
    }

    public function update(Request $request, $id)
    {
        $resume = Resume::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:255',
            'website' => 'nullable|url',
            'summary' => 'required|string',

            'education' => 'nullable|array',
            'education.*.school' => 'nullable|string',
            'education.*.course' => 'nullable|string',
            'education.*.start' => 'nullable|string',
            'education.*.end' => 'nullable|string',

            'experience' => 'nullable|array',
            'experience.*.company' => 'nullable|string',
            'experience.*.position' => 'nullable|string',
            'experience.*.start' => 'nullable|string',
            'experience.*.end' => 'nullable|string',
            'experience.*.skills' => 'nullable|string',
            'experience.*.description' => 'nullable|string',

            'skills' => 'nullable|array',
            'skills.*.title' => 'nullable|string',
        ]);

        $resume->update([
            'name' => $validated['name'],
            'role' => $validated['role'],
            'location' => $validated['location'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'website' => $validated['website'],
            'summary' => $validated['summary'],
            'education' => $validated['education'] ?? [],
            'job_experience' => $validated['experience'] ?? [],
            'skills' => $validated['skills'] ?? [],
        ]);

        return to_route('preview', ['id' => $resume->id])->with('success', 'Resume updated!');
    }


    public function download($id)
    {
        $resume = Resume::findOrFail($id);

        // Load the PDF view with resume data
        $pdf = Pdf::loadView('pdf.resume', compact('resume'));

        // Set PDF options for better output
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true
        ]);

        // Generate filename
        $filename = 'resume_' . ($resume->name ? str_replace(' ', '_', strtolower($resume->name)) : 'download') . '_' . now()->format('Y_m_d') . '.pdf';

        // Return PDF download
        return $pdf->download($filename);
    }

    // Alternative method for streaming (opens in browser)
    public function view($id)
    {
        $resume = Resume::findOrFail($id);

        $pdf = Pdf::loadView('pdf.resume', compact('resume'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('resume_preview.pdf');
    }

        public function testAuthComponent()
    {
        return Inertia::render('Auth/Login');
    }
}
