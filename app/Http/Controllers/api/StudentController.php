<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\StudentMark;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function storeStudentMarks(Request $request){
        $this->validate($request,[
            'user_id'=>'required',
            'subject'=>'required',
            'marks'=>'required',
        ]);
        $studentMarks= StudentMark::create([
            'user_id'=> $request->user_id,
            'subject'=> $request->subject,
            'marks'=>$request->marks,

        ]);
        return response()->json(['student_marks'=>$studentMarks],200);

    }



    public function getStudentHightMarksInEnglish()
    {
        $marksMarks = DB::table('student_marks')
            ->where('subject','=','english')
            ->where('marks','>=','80')
            ->join('users','student_marks.user_id','users.id')
            ->select('student_marks.*','users.name')
            ->get();
        return response()->json(['student_marks'=>$marksMarks],200);
    }
}
