<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:students,email',
            'photo' => 'required|mimes:png,jpg,jpeg',
            'accepeted'=> 'accepted'
            
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => 400,
                'errors' =>$validator->errors(),
            ]);

        } else {

            $student  = new Student;
            $student->name = $request->name;
            $student->email = $request->email;

            if ($request->hasfile('photo')) {

                $file = $request->file('photo');
                $extenttion = $file->getClientOriginalExtension();
                $fileName = time().'.'.$extenttion; //3434242342.png
                $file->move('uploads/student_img/',$fileName);

                // photo save in database
                $student->photo = $fileName;
            }
            $student->save();
        
           return response()->json(['status'=>200, 'message'=> 'student is successfully Created']);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
