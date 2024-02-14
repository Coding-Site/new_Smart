<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class TeacherExamController extends Controller
{
    function index(){
        $teacher_id=Auth::user()->id;
        $courses=Course::where('techer_id',$teacher_id)->get();
        return view('teacher.exam.index', compact('courses'));
    }
    function level($level_id){
        $courses=Course::find($level_id);
        return view('teacher.exam.level', compact('courses'));
    }
}
