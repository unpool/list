<?php

namespace App\Http\Controllers\Api;

use App\Repositories\TeacherRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class TeacherController extends Controller
{

    private $teacher_repo;

    public function __construct(TeacherRepository $teacher)
    {
        $this->teacher_repo = $teacher;
    }


    public function getTeacher(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'teacher_id' => 'required|numeric',
        ], [], [
            'teacher_id' => 'استاد'
        ]);
        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()], JsonResponse::HTTP_BAD_REQUEST);
        }
        return response()->json($this->teacher_repo->getInfoTeacher($request->get('teacher_id')));
    }
}
