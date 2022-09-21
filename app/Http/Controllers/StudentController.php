<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(){
        return view('student.index');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=> 'required|max:191',
            'course'=>'required|max:191',
            'email'=>'required|email|max:191',
            'phone'=>'required|max:10|min:10',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        } 
        else
        {
            $student = new Student;
            $student->name = $request->input('name');
            $student->course = $request->input('course');
            $student->email = $request->input('email');
            $student->phone = $request->input('phone');
            $student->save();
            return response()->json([
                'status'=>200,
                'message'=>'Student Added Successfully.'
            ]);
        }
    }

    public function show(){
        $students = Student::all();
        return response()->json([
            'students'=>$students
        ]);
    }

    public function edit($id){
        $student = Student::find($id);
        if($student)
        {
            return response()->json([
                'status'=>200,
                'student'=>$student,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>200,
                'message'=>'Student Not Found.'
            ]);
        }
    }
}
