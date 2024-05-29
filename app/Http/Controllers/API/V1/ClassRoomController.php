<?php

namespace App\Http\Controllers\API\V1;

use Exception;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Enum\API\V1\ClassRoomStatusEnum;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClassRoomController extends Controller
{
    public function index()
    {
        try {
            $classRoom = ClassRoom::all();
            $classRoom->load('teacher');
            return $classRoom;

        } catch (Exception) {
            return response()->json([
                'status' => 500,
                'message' => 'Error in index method from ClassRoomController',
            ]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'teacher_id' => 'required|exists:teachers,id',
            'student_capacity' => 'required|integer',
            'description' => 'nullable|string',
            'status' => 'required|string',
        ], [
            'teacher_id.required' => 'The teacher field is required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }

        try {
            $classRoom = ClassRoom::create([
                'name' => $request->name,
                'teacher_id' => $request->teacher_id,
                'student_capacity' => $request->student_capacity,
                'description' => $request->description,
                'status' => $request->status,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Class room created successfully',
                'data' => $classRoom,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error in store method from ClassRoomController',
            ]);
        }
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        try{
            $classRoom = ClassRoom::findOrFail($id);
            $classRoom->load('teacher');
            return response()->json([
                'status' => 200,
                'data' => $classRoom,
            ]);
        }catch (Exception $e){
            return response()->json([
                'status' => 404,
                'message' => 'Class room not found',
            ]);
        }
    }

    public function update(Request $request, string $id)
    {
    }

    public function destroy(ClassRoom $id)
    {
        try {
            $id->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Class room deleted successfully',
            ]);
        } catch (Exception) {
            return response()->json([
                'status' => 500,
                'message' => 'Error in destroy method from ClassRoomController',
            ]);
        } catch (ModelNotFoundException) {
            return response()->json([
                'status' => 422,
                'message' => 'Class room not found',
            ]);
        }
    }

    public function fetchEnum()
    {
        try {
            return response()->json([
                'status' => 200,
                'data' => [
                    'status' => ClassRoomStatusEnum::cases(),
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
