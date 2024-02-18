<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Tutorial;
use App\Models\{
    UserCourse,
    VideoComment
};
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoursesController extends Controller
{
    public function index(Request $request,int $id=null)
    {

        $course=Course::with('techer');
        $classroom = '';
        if ($id!=null) {
            switch ($id) {
                case 6:
                    $classroom = $course->where('classroom', 'الصف السادس')->get();
                    break;
                case 7:
                    $classroom = $course->where('classroom', 'الصف السابع')->get();
                    break;
                case 8:
                    $classroom = $course->where('classroom', 'الصف الثامن')->get();
                    break;
                case 9:
                    $classroom = $course->where('classroom', 'الصف التاسع')->get();
                    break;
                case 10:
                    $classroom = $course->where('classroom', 'الصف العاشر')->get();
                    break;
                case 11:
                    $classroom = $course->where('classroom', 'الصف الحادي عشر')->get();
                    break;
                case 12:
                    $classroom = $course->where('classroom', 'الصف الثاني عشر')->get();
                    break;
                default:
                    // Code to handle when classroom is none of the above
            }

            return response()->json([
                'status' => 200,
                'classroom' => $classroom,

            ], 200);
        }

        $coursesix = Course::with('techer')->where('classroom', 'الصف السادس')->get();

        $courseseven = Course::with('techer')->where('classroom', 'الصف السابع')->get();
        $courseeight = Course::with('techer')->where('classroom', 'الصف الثامن')->get();
        $coursenine = Course::with('techer')->where('classroom', 'الصف التاسع')->get();
        $courseten = Course::with('techer')->where('classroom', 'الصف العاشر')->get();
        $courseeleven = Course::with('techer')->where('classroom', 'الصف الحادي عشر')->get();
        $coursetwelve = Course::with('techer')->where('classroom', 'الصف الثاني عشر')->get();
        return response()->json([
            'status' => 200,
            'coursesix' => $coursesix,
            'courseseven' => $courseseven,
            'courseeight' => $courseeight,
            'coursenine' => $coursenine,
            'courseten' => $courseten,
            'courseeleven' => $courseeleven,
            'coursetwelve' => $coursetwelve,
        ], 200);
    }
    public function tutorial(int $course)
    {
        $tutorial = Tutorial::where('course_id', $course)->with('video.comments.user:id,name')->get();
        return response()->json([
            'status' => 200,
            'tutorial' => $tutorial,
        ], 200);
    }
    public function addCommentVideo(Request $request)

    {
        $data = $request->all();

        $rules = [

            'video_id'        =>  ['required', 'exists:videos,id'],
            'user_id'        =>  ['required', 'exists:users,id'],
            'comment'        =>  ['required'],



        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $videoComment = VideoComment::create($validator->validated());
        return response()->json([
            'status' => 200,
            'videoComment' => $videoComment,
        ], 200);
    }
    public function download($fileName)
    {
        return response()->download(storage_path('app/public/pdfs/' . $fileName));
    }

    public function userSubscription($user)
    {
        $userCourses = UserCourse::where('user_id', $user)->get();
        $courses = [];
        foreach ($userCourses as $course) {
            $courseData = Course::where('id', $course->course_id)->with('techer')->first();
            if ($courseData) {
                $courses[] = $courseData;
            }
        }
        return response()->json([
            'status' => 200,
            'Courses' => $courses,
        ], 200);
    }
}
