<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Log, Validator};
use Illuminate\Validation\Rule;

class TeachersController extends Controller
{
    public function index()
    {
        return Teacher::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|max:50',
            'email'  => 'required|email|max:50|unique:teachers',
            'phone'  => 'required|string|min:7|max:15',
            'matery' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }

        try {
            Teacher::create($request->all());

            return response()->json([
                'status'  => 'success',
                'message' => 'Teacher created successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        try {
            $teacher = Teacher::find($id);
            $teacher->load('photos');

            return response()->json($teacher);
        } catch (Exception $e) {
            Log::info("error: " . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request, Teacher $id)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:50',
            'email' => [
                'required',
                'email',
                'max:50',
                Rule::unique('teachers')->ignore($id->id),
            ],
            'phone'  => 'required|string|min:7|max:15',
            'matery' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }

        try {
            $id->update($request->all());

            return response()->json([
                'status'  => 'success',
                'message' => 'Teacher updated successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 404,
                'message' => $e->getMessage(),
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status'  => 404,
                'message' => 'Teacher ID not found',
            ]);
        }
    }

    public function destroy(Teacher $id)
    {
        try {
            $id->delete();

            return response()->json([
                "status"  => "success",
                'message' => 'Teacher deleted successfully',
            ]);
        } catch (Exception) {
            return response()->json([
                'status'  => 'error',
                'message' => $id->getMessage(),
            ]);
        }
    }
}
