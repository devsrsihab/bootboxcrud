<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
        $data['students'] = Student::paginate(3);
        return view('student.index',$data);
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
        $data['student'] = Student::find($id);
        return view('student.view',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['student'] = Student::find($id);
        return view('student.edit',$data);
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
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:students,email,'.$id,
            'photo' => 'mimes:png,jpg,jpeg',
            'accepeted'=> 'accepted'
            
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => 400,
                'errors' =>$validator->errors(),
            ]);

        } else {

            $student  =  Student::find($id);
            $student->name = $request->name;
            $student->email = $request->email;

            if ($request->hasfile('photo')) {
                
                $path = 'uploads/student_img'. $student->photo;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file = $request->file('photo');
                $extenttion = $file->getClientOriginalExtension();
                $fileName = time().'.'.$extenttion; //3434242342.png
                $file->move('uploads/student_img/',$fileName);

                // photo save in database
                $student->photo = $fileName;
            }
            $student->save();
        
           return response()->json(['status'=>200, 'message'=> 'student is successfully Updated']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::find($id);

        if ( $student) {
            $student->delete();        
            return response()->json(['status'=>200,'message'=>'Successfully Deleted']);
        } else {
            return response()->json(['status'=>404,'message'=>'Your Student Not Found']);
        }
        
    }


    // pagination
    public function pagination()
    {
      $data['students'] = Student::paginate(3);
       return view('student.pagination',$data);
    }
}
