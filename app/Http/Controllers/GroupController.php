<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;
use App\Models\Question;
use App\Models\Homework;
use Illuminate\Support\Facades\DB;

use Goodby\CSV\Import\Standard\LexerConfig;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;

use Illuminate\Support\Facades\Hash;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $groups = Group::where('admin_id','=',auth()->user()->id)->get();

        return view('admin/group/list',compact('groups'));
    }

    public function user_list($group_id)
    {
        //ユーザ情報の取得
        $group = Group::where('id','=',$group_id)->first();
        $users = User::where('group_id','=',$group_id)->get();

        //宿題情報の取得
        //$homeworks = Homework::where('group_id','=',$group_id)->where('start','<=',date('Y-m-d'))->where('end','>=',date('Y-m-d'))->get();
        $homeworks = Homework::where('group_id','=',$group_id)->get();

        return view('admin/group/users',compact('group','users','homeworks'));
    }

    public function user_manage($user_id)
    {
        $user = User::find($user_id)->first();

        //全体の進捗情報の取得
        $record_count = [0,0,0,0,0];
        $question_count = [0,0,0,0,0];
        $records = User::find($user_id)->records()
                                        ->where('result',1)
                                        ->select('unit_id','question_id')
                                        ->groupBy('unit_id','question_id')
                                        ->get();
        foreach($records as $record){
            if($record->unit_id > 100 && $record->unit_id < 200){
                $record_count[0] += 1;
            } elseif($record->unit_id < 300){
                $record_count[1] += 1;
            } elseif($record->unit_id < 400){
                $record_count[2] += 1;
            } elseif($record->unit_id < 500){
                $record_count[3] += 1;
            } else {
                $record_count[4] += 1;
            }
        }
        $question_count[0] = \App\Models\Question::where('unit_id','>',100)->where('unit_id','<',200)->count();
        $question_count[1] = \App\Models\Question::where('unit_id','>',200)->where('unit_id','<',300)->count();
        $question_count[2] = \App\Models\Question::where('unit_id','>',300)->where('unit_id','<',400)->count();
        $question_count[3] = \App\Models\Question::where('unit_id','>',400)->where('unit_id','<',500)->count();
        $question_count[4] = \App\Models\Question::where('unit_id','>',500)->count();

        for($i=0;$i<5;$i++){
            $progress[$i] = $record_count[$i]/$question_count[$i];
        }

        //弱点の問題
        if(\App\Models\User::find($user_id)->records()->count() > 0){
            $rate = [];
            $records = \App\Models\User::find($user_id)->records()
            ->select('question_id',DB::raw('COUNT(result) AS count'),DB::raw('COUNT(result=1 OR NULL) AS a'),DB::raw('COUNT(result=0 OR NULL) AS b'))
            ->groupBy('question_id')
            ->get();

            foreach($records as $record){
                if($record->count != 0){
                    $rate[$record->question_id] = round($record->a / $record->count,4);
                }
            }
    
            asort($rate);
            $weaks = array_slice($rate,0,10,1);
            $w_id = array_keys($weaks);
            $id_order = implode(',', $w_id);
            $items = Question::whereIn('q_id', $w_id)->orderByRaw(DB::raw("FIELD(q_id, $id_order)"))->get();
            $questions = [];
            foreach($items as $item){
                array_push($questions,[$item->unit->name,$item->caption,round($weaks[$item->q_id]*100,1)]);
            }
        }else{
            $questions = [];
        }

        //宿題の提出状況
        $homeworks = Homework::where('group_id','=',$user->group_id)->get();
        $records = User::find($user_id)->records()->where('result','=',1)->get();

        foreach($homeworks as $homework){
            $record = $records->where('created_at','>=',date('Y-m-d H:i:s',strtotime($homework->start.' 00:00:00')))->where('created_at','<=',date('Y-m-d H:i:s',strtotime($homework->end.' 23:59:59')));
            foreach($homework->homework_details as $detail){
                if($record->where('question_id','=',$detail->question_id)->count() >= $detail->times){
                    $result[$homework->id][$detail->question_id] = true;
                }else{
                    $result[$homework->id][$detail->question_id] = false;
                }
            }
            if(in_array(false,$result[$homework->id])){
                $submit[$homework->id] = '×';
            }else{
                $submit[$homework->id] = '○';
            }
        }

        return view('admin/group/user_detail',compact('user','progress','questions','homeworks','submit'));
    }

    public function add_group()
    {
        $admin_id = auth()->user()->id;
        return view('admin/group/add_group',compact('admin_id'));
    }

    public function add(Request $request)
    {
        if($request->hasFile('member')){
            if($request->file('member')->guessExtension() == 'txt'){
                // CSV ファイル保存
                $tmpname = uniqid("CSVUP_").".".$request->file('member')->guessExtension(); //TMPファイル名
                $request->file('member')->move(public_path()."/csv/tmp",$tmpname);
                $tmppath = public_path()."/csv/tmp/".$tmpname;
        
                // Goodby CSVの設定
                $config_in = new LexerConfig();
                $config_in
                    ->setFromCharset("SJIS-win")
                    ->setToCharset("UTF-8") // CharasetをUTF-8に変換
                    ->setIgnoreHeaderLine(true) //CSVのヘッダーを無視
                ;
                $lexer_in = new Lexer($config_in);
        
                $datalist = array();
        
                $interpreter = new Interpreter();
                $interpreter->addObserver(function (array $row) use (&$datalist){
                    // 各列のデータを取得
                    $datalist[] = $row;
                });
        
                // CSVデータをパース
                $lexer_in->parse($tmppath,$interpreter);
        
                // TMPファイル削除
                unlink($tmppath);
        
                // メールアドレスのチェック
                if(!isset($datalist[0][2]) && !isset($request->email)){
                    return redirect(route('add_group'))->with('flashmessage','エラー　メールアドレスを確認してください。');
                }
                //クラスの作成
                $group = new Group();
                $group->name = $request->name;
                $group->admin_id = auth()->user()->id;
                $group->timestamps = false;
                $group->save();
                
                //ユーザの保存
                foreach($datalist as $row){
                    // 各データ保存
                    if(User::where('email','=',$row[0].$request->email)->exists()){
                        $user = User::where('email','=',$row[0].$request->email)->first();
                        $user->group_id = $group->id;
                        $user->save();
                    }else{
                        $user = new User();
                        $user->name = $row[1];
                        if(isset($row[2])){
                            $user->email = $row[2];
                        }elseif(isset($request->email)){
                            $user->email = $row[0].$request->email;
                        }
                        $user->group_id = $group->id;
                        $user->password = Hash::make($row[0]);
                        $user->save();
                    }
                }
                return redirect(route('group_manage'))->with('flashmessage','クラスの追加が正常に完了しました');
            }else{
                return redirect(route('add_group'))->with('flashmessage','CSVの送信エラーが発生しましたので、送信を中止しました。');
            }
        }else{
            $group = new Group();
            $group->name = $request->name;
            $group->admin_id = auth()->user()->id;
            $group->timestamps = false;
            $group->save();
            return redirect(route('group_manage'));
        }
    }

    public function add_member($id)
    {
        $group_id = $id;
        return view('admin/group/user_add',compact('group_id'));
    }

    public function add_member_post(Request $request,$id)
    {
        for($i=0;$i<count($request->name);$i++){
            if(User::where('email','=',$request->email[$i])->exists()){
                $user = User::where('email','=',$request->email[$i])->first();
                $user->group_id = $id;
                $user->save();
            }else{
                $user = new User();
                $user->name = $request->name[$i];
                $user->email = $request->email[$i];
                $user->group_id = $id;
                $user->password = Hash::make(mb_strpos($request->email[$i],"@"));
                $user->save();
            }
        }
        return redirect(route('user_list',$id))->with('flashmessage','生徒の追加が正常に完了しました');
    }
}
