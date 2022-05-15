<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\User;
use App\Models\Homework;
use App\models\Homework_detail;

class HomeworkController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function add_homework($id){
        $math1s = Unit::where('id','>',100)->where('id','<',200)->get();
        $math2s = Unit::where('id','>',200)->where('id','<',300)->get();
        $math3s = Unit::where('id','>',300)->where('id','<',400)->get();
        $mathAs = Unit::where('id','>',400)->where('id','<',500)->get();
        $mathBs = Unit::where('id','>',500)->where('id','<',600)->get();
        $group_id = $id;
        
        return view('admin/homework/add_homework',compact('math1s','math2s','math3s','mathAs','mathBs','group_id'));
    }

    public function add(Request $request){
        $homework = new Homework();

        $homework->name = $request->caption;
        $homework->group_id = $request->group_id;
        $homework->start = $request->start;
        $homework->end = $request->end;
        $homework->timestamps = false;
        $homework->save();

        for($i=0;$i<count($request->times);$i++){
            $detail = new Homework_detail;
            $detail->homework_id = $homework->id;
            $detail->question_id = $request->question_id[$i];
            $detail->times = $request->times[$i];
            $detail->timestamps = false;
            $detail->save();
        }

        return redirect(route('user_list',$request->group_id));
    }

    public function homework_detail($id){
        //宿題の詳細
        $homework = Homework::where('id','=',$id)->first();
        $users = User::where('group_id','=',$homework->group_id)->get();

        //各ユーザの提出状況
        //宿題の提出状況
        foreach($users as $user){
            $record = $user->records()->where('result','=',1)->where('created_at','>=',date('Y-m-d H:i:s',strtotime($homework->start.' 00:00:00')))->where('created_at','<=',date('Y-m-d H:i:s',strtotime($homework->end.' 23:59:59')))->get();
            foreach($homework->homework_details as $detail){
                if($record->where('question_id','=',$detail->question_id)->count() >= $detail->times){
                    $result[$user->id][$detail->question_id] = true;
                }else{
                    $result[$user->id][$detail->question_id] = false;
                }
                if(in_array(false,$result[$user->id])){
                    $submit[$user->id] = '×';
                }else{
                    $submit[$user->id] = '○';
                }
            }
        }
        
        return view('admin/homework/detail',compact('homework','submit','users'));
    }
}
