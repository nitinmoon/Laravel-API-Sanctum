<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $list = Student::all();
            $data = array(
                'status' => true,
                'message' => 'Student data list',
                'list' => $list
            );
            return response()->json($data, 200);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'fees' => 'required'
        ]);

        try {
            $saveData = Student::create($request->all());
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Studnet created',
                    'saveData' => $saveData
                ],
                201
            );
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $student = Student::findOrFail($id);
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Student details',
                    'student' => $student
                ],
            200
            );
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'fees' => 'required'
        ]);
        try {
            $student = Student::findOrFail($id);
            $student->update($request->all());
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Student details',
                    'student' => $student
                ],
                200
            );
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Student::findOrFail($id)->delete();
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Student deleted'
                ],
                200
            );
        } catch (\Exception $exception) {
             return response()->json($exception->getMessage());
        }
    }
}
