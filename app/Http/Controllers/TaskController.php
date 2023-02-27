<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = Auth::user()->tasks()->get();

        $keyword = $request->input('keyword');
        $query = Task::query();
        if(!empty($keyword)) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        }
        $tasks = $query->get();
        return view('tasks.index', compact('tasks', 'keyword'));

         // 5投稿毎にページ移動
        // ->paginate(5);
    }

    // public function index(Request $request)
    // {
    //     $tasks = Auth::user()->tasks()->get();

    //     $keyword = $request->input('keyword');
    //     $query = Task::query();
    //     if (!empty($keyword)) {
    //         $query->where('name', 'LIKE', "%{$keyword}%");
    //     }
    //     $tasks = $query->orderBy($request->narabi)->get();
    //     return view('tasks.index', compact('tasks', 'keyword'));
    // }
  

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'task_name' => 'required|max:100',
          ];
         
          $messages = ['required' => '必須項目です', 'max' => '100文字以下にしてください。'];
         
          Validator::make($request->all(), $rules, $messages)->validate();

        //モデルをインスタンス化
        $task = new Task();
        //モデル->カラム名 = 値 で、データを割り当てる
        $task->name = $request->input('task_name');
        //データベースに保存
        // $task->save();
        Auth::user()->tasks()->save($task);
        //リダイレクト
        return redirect('/tasks');

        //タグ
        preg_match_all('/#([a-zA-z0-9０-９ぁ-んァ-ヶ亜-熙]+)/u', $request->tags, $match);
        $tags = [];
        foreach ($match[1] as $tag) {
            $record = Tag::firstOrCreate(['name' => $tag]);
            array_push($tags, $record);
        };
        $tags_id = [];
        foreach ($tags as $tag) {
            array_push($tags_id, $tag['id']);
        };
        $task->tags()->attach($tags_id);
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
        $task = Task::find($id);
        return view('tasks.edit', compact('task'));
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
        //「編集する」ボタンをおしたとき
        if ($request->status === null) {
        $rules = [
          'task_name' => 'required|max:100',
        ];
    
        $messages = ['required' => '必須項目です', 'max' => '100文字以下にしてください。'];
    
        Validator::make($request->all(), $rules, $messages)->validate();
    
        //該当のタスクを検索
        $task = Task::find($id);
        //モデル->カラム名 = 値 で、データを割り当てる
        $task->name = $request->input('task_name');
        //データベースに保存
        $task->save();
      } else {
        //「完了」ボタンを押したとき
        //該当のタスクを検索
        $task = Task::find($id);
        //モデル->カラム名 = 値 で、データを割り当てる
        $task->status = true; //true:完了、false:未完了
        //データベースに保存
        $task->save();
      }
    
      //リダイレクト
      return redirect('/tasks');
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::find($id)->delete();
  
        return redirect('/tasks');
    }
}
