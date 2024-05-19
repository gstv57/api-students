<?php

namespace App\Http\Controllers\API\V1;

use Exception;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentsController extends Controller
{
    public function index()
    {
        return Student::all();
    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:students,email',
            'phone' => 'required|string|min:7|max:15',
            'course' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }

        try {
            Student::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Student created successfully',
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function show(Student $student)
    {
        return response()->json($student);
    }
    public function edit($id)
    {
        try {
            $student = Student::findOrFail($id);
            return response()->json($student);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Student ID not found'
            ], 404);
        }
    }

    public function update(Request $request, Student $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:50',
                'email' => [
                    'required',
                    'email',
                    'max:50',
                    Rule::unique('students')->ignore($id->id),
                ],
                'phone' => 'required|string|min:7|max:15',
                'course' => 'required|string',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->messages(),
                ], 422);
            }
            $id->update($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Student updated successfully',
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Student ID not found'
            ], 404);
        } catch (Exception $e) {
            Log::info('error: '. $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Student $id)
    {
        try {
            $id->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Student deleted successfully',
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Student ID not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json(['status' => 500 ,'message'=> $e->getMessage()], 500);
        }
    }
}
