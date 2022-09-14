<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Image;

class AnnotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Annotation画面にアクセス

        //有効なタスクを抽出
        $user_id = Auth::id();
        $tasks = Task::where('user_id', $user_id)
        ->where('task_open', '!=', null)
        ->where('task_close', null)
        ->where('task_expire', '>', date('Y-m-d H:i:s'))
        ->get();

        return view('annotation', compact('tasks'));
    }

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $task_id
     * @param  int  $image_id
     * @return \Illuminate\Http\Response
     */
    public function show($task_id, $image_id)
    {
        //annotation/{task_id}/{image_id}のときタスク画面を出す
        $user_id = Auth::id();
        
        $task_exists = Task::where('id', $task_id)
        ->where('user_id', $user_id)
        ->where('image_id', $image_id)
        ->where('task_open', '!=', null)
        ->where('task_close', null)
        ->where('task_expire', '>', date('Y-m-d H:i:s'))
        ->exists();

        if (!$task_exists) {
            return redirect('working')->with('alert', '正しいリンク先に移動できませんでした。');
        } else {
            $target_task = Task::where('id', $task_id)
            ->where('user_id', $user_id)
            ->where('image_id', $image_id)
            ->where('task_open', '!=', null)
            ->where('task_close', null)
            ->where('task_expire', '>', date('Y-m-d H:i:s'))
            ->first();

            return view('annotation', compact('target_task'));
        }
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
