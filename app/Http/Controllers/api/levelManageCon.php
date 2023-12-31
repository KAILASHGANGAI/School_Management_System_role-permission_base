<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\faculty;
use App\Models\section;
use App\Models\semester;

class levelManageCon extends Controller
{
    public function index()
    {
        $section = section::all();
        $faculty = faculty::all();
        $sem = semester::all();

        return response()->json(
            [
                'section' => $section,
                'faculty' => $faculty,
                'sem' => $sem,
            ]
        );
    }
}
