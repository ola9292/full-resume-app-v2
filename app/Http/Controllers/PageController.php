<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $user = Auth::user();

        // dd($user);

        $resumes = Resume::where('user_id', $id)->get();
        // dd($resumes);
        return Inertia::render('Profile', [
            'resumes' => $resumes,
            'user' => $user
        ]);
    }
}
