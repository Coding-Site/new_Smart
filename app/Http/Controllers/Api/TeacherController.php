<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\User;

class TeacherController extends Controller
{

    public function index()
    {
        try {
            $teacher = User::select('id','name','Teacher_ratio_course','teacher_description')->where('user_type','teacher')->get();
            return response()->json([
                'teacher' => $teacher,
            ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function courses($id)
    {
        try {
            $courses = Course::where('techer_id',$id)->get();
            return response()->json([
                'courses' => $courses,
            ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
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
        //
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
