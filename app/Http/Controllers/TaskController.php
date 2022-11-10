<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Task;
use App\Models\Image;
use App\Consts\KuzushijiConst;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactToSiteOwner;
use Illuminate\Pagination\Paginator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //ダッシュボードでのタスク候補画像表示
        //ダッシュボードに表示できる画像数
        $image_limit = KuzushijiConst::DASHBOARD_LIMIT;
        $tasks_finished_limit = KuzushijiConst::TASK_FINISHED;

        //完了したタスクと画像データを抽出
        $tasks_finished = Task::with('image')
        ->where('user_id', '!=', null)
        ->where('task_close', '!=', null)
        ->orderBy('task_close', 'desc')
        ->get();

        // タスク予約済みのデータを抽出
        $images_reserved = Task::where('user_id', '!=', null)
        ->where('task_close', null)
        ->where('task_expire', '>', date('Y-m-d H:i:s'))
        ->get(['image_id'])
        ->toArray();

        $images_finished = Task::where('user_id', '!=', null)
        ->where('task_close', '!=', null)
        ->get(['image_id'])
        ->toArray();

        $images_not_available = array_merge($images_reserved, $images_finished);

        //タスク予約済みの画像idを抽出
        $imageids = [];
        foreach($images_not_available as $array) {
            $imageids[] = $array['image_id'];
        }

        //タスク予約されていない画像idを抽出
        $free_images = Image::whereNotIn('id', $imageids)
        ->orderBy('image_url', 'asc')
        ->limit($image_limit)
        ->get();

        $all_images = Image::get(['id']);

        return view('dashboard', compact('free_images', 'all_images', 'tasks_finished'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //タスク登録数上限
        $task_count_valid = KuzushijiConst::ACTIVE_TASK_MAX;
        
        //タスクデータを新規登録する
        //画像選択数確認
        $user_id = Auth::id();

        //有効期限切れタスクがあるか
        $is_task_invalid = Task::where('user_id', $user_id)
        ->where('image_id', $request->image_id)
        ->where('task_expire', '<', date('Y-m-d H:i:s'))
        ->get(['id'])
        ->toArray();

        //有効期限切れのデータをソフトデリート
        if (count($is_task_invalid) > 0) {
            foreach($is_task_invalid as $invalid_task_id) {
                Task::where('id', $invalid_task_id)->delete();
            }
        }

        //タスクが完了しているものがあるか
        $is_task_closed = Task::where('user_id', $user_id)
        ->where('image_id', $request->image_id)
        ->where('task_close', '!=', null)
        ->exists();

        //選択中のタスクの数
        $results_count = Task::where('user_id', $user_id)
        ->where('task_close', null)
        ->where('task_expire', '>', date('Y-m-d H:i:s'))
        ->count();

        //すでに他の人が登録していないか？
        $others_task_exist = Task::where('image_id', $request->image_id)
        ->where('task_open', '!=', null)
        ->where('task_close', null)
        ->where('task_expire', '>', date('Y-m-d H:i:s'))
        ->exists();
        
        if ($others_task_exist) {
            return redirect('dashboard')->with('alert', 'この画像は別の人が担当中です。ダッシュボード画面をリロードしてください。');
        }

        //画像選択数が3より少ない場合は登録できる
        if ($results_count < $task_count_valid && !$is_task_closed) {
            //データベースに書き込み
            $datetime_now = date('Y-m-d H:i:s');
            $task_max = KuzushijiConst::TASK_DAY_LIMIT . ' days';
            $datetime_xdays = date('Y-m-d H:i:s', strtotime($task_max));
            
            Task::insert([
                'user_id' => $user_id,
                'image_id' => $request->image_id,
                'task_open' => $datetime_now,
                'task_expire' => $datetime_xdays,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            //選択中の画像一覧を送る
            // $taskfiles = Task::where('user_id', $user_id)
            // ->orderBy('task_open', 'asc')
            // ->where('task_expire', '>', date('Y-m-d H:i:s'))
            // ->get();

            //workingにフラッシュメッセージを出す
            return redirect('working')->with('info', '作業を登録しました。よろしくお願いします。');
        } else {
            if ($is_task_closed) {
                return redirect('dashboard')->with('alert', '既に作業が完了した画像のため登録できませんでした。');
            } else {
                //dashboardにフラッシュメッセージでアラート
                return redirect('dashboard')->with('alert', '登録済みの作業が' . KuzushijiConst::ACTIVE_TASK_MAX . 'つあります。先に作業を完了させるか、進捗メニューで登録解除してください。');
            }
        }
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //workingを直接クリックした時はuser_idが担当している画像一覧を表示
        //画像選択数確認
        $user_id = Auth::id();

        //選択中の画像一覧を送る
        $tasks = Task::with('image')
        ->where('user_id', $user_id)
        ->where('task_open', '!=', null)
        ->where('task_expire', '>', date('Y-m-d H:i:s'))
        ->where('task_close', null)
        ->orderBy('id', 'asc')
        ->get();

        $tasks_finished = Task::with('image')
        ->where('user_id', $user_id)
        ->where('task_close', '!=', null)
        ->orderBy('id', 'asc')
        ->get();

        return view('working', compact('tasks', 'tasks_finished'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //タスクが完了した
        //モーダル確認後、タスク完了欄に画像を移動
        $user_id = Auth::id();

        try {
            Task::where('user_id', $user_id)
            ->where('id', $request->task_id)
            ->where('image_id', $request->image_id)
            ->where('task_open', '!=', null)
            ->where('task_expire', '>', date('Y-m-d H:i:s'))
            ->update([
                'task_close' => date('Y-m-d H:i:s'),
            ]);

            return redirect('working')->with('info', '⭐️作業が完了しました！お疲れ様でした⭐️');
        } catch(\Throwable $e) {
            \Log::error($e);
            throw $e;

            return redirect('working')->with('alert', 'エラーのため作業は完了していません。');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Taskを削除する
        $user_id = Auth::id();
        $image_id = $request->id;

        $task= Task::where('image_id', $image_id)
        ->where('user_id', $user_id)
        ->get(['id'])
        ->toArray();

        Task::find($task[0]['id'])->delete();

        return redirect('working')->with('info', '作業を解除しました。');
    }

    /**
     * Reopen a closed task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reopen(Request $request)
    {
        //完了Taskを再開
        $task_id = (integer) $request->id;
        $user_id = (integer) $request->user_id;

        $task_count = Task::where('id', $task_id)
        ->where('user_id', $user_id)
        ->count();

        if ($task_count === 1) {
            //update
            $task_update = Task::where('id', $task_id)
            ->update([
                'task_close' => null
            ]);

            $message = '作業を再開しました。';

            $user = User::where('id', Auth::id())->first();
            
            if ($user->user_level !== 1) {
                return redirect('working')->with('info', $message);
            } else {
                return redirect('dashboard')->with('info', $message);
            }

        } else {
            $message = 'タスクid: ' . $task_id . 'を再開できませんでした。';

            return redirect('dashboard')->with('alert', $message);
        }
    }

    /**
     * Send some message from a form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendMessage(Request $request) {
        $request->validate([
            'questions' => 'required',
            'id' => 'required|integer'
        ]);

        $id = $request->id;
        $questions = $request->questions;

        Mail::send(new ContactToSiteOwner($id, $questions));

        session()->flash('info', 'メールを送信しました。');
        return back();
    }

    /**
     * Display lists and search the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function find(Request $request)
    {
        // タスク予約済みのデータを抽出
        $images_reserved = Task::where('user_id', '!=', null)
        ->where('task_close', null)
        ->where('task_expire', '>', date('Y-m-d H:i:s'))
        ->get(['image_id'])
        ->toArray();

        // //完了したタスクと画像データを抽出
        $tasks_finished = Task::where('user_id', '!=', null)
        ->where('task_close', '!=', null)
        ->orderBy('task_close', 'desc')
        ->get();

        $images_finished = Task::where('user_id', '!=', null)
        ->where('task_close', '!=', null)
        ->get(['image_id'])
        ->toArray();

        $images_not_available = array_merge($images_reserved, $images_finished);

        // //タスク予約済みの画像idを抽出
        $imageids = [];
        foreach($images_not_available as $array) {
            $imageids[] = $array['image_id'];
        }

        // //タスク予約されていない画像idを抽出
        $free_images = Image::whereNotIn('id', $imageids)
        ->orderBy('image_url', 'asc')
        ->get();

        $all_images = Image::orderBy('image_url', 'asc')->limit(3)->get(); //pagenation

        return view('search', compact('free_images', 'all_images', 'tasks_finished'));
    }

    public function search(Request $request)
    {
        $keywords = $request->keywords;
        //$anno_condition = $request->anno_condition;
        
        $images = Image::where('image_url', 'like', '%'.$keywords.'%')
        ->orderBy('image_url', 'asc')
        ->get();

        // if ($anno_condition === 'finished') {
        //     $tasks = Task::where('user_id', 'like', '%' . $keywords . '%')
        //     ->where('task_closed', '!=', '')
        //     ->get();
        // } else if ($anno_condition === 'unfinished') {
        //     $tasks = Task::where('user_id', 'like', '%' . $keywords . '%')
        //     ->where('task_closed', '=', '')
        //     ->get();
        // } else {
        //     $tasks = Task::where('user_id', 'like', '%' . $keywords . '%')
        //     ->get();
        // }

        $list = [];
        foreach($images as $image) {
            $json = json_decode(file_get_contents($image->manifest_url));
            $json_image = json_decode(file_get_contents($image->image_url));
            $iiif_image = $json_image->{'@id'};

            $list[] = array(
                'id' => $image->id,
                'manifest_url' => $image->manifest_url,
                'image_url' => $image->image_url,
                'organization' => $json->label,
                'book_name' => $json->metadata[0]->value,
                'image_file' =>  basename($json_image->{'@id'})
            );
        }
        
        header('Content-type: application/json');
        echo json_encode($list, JSON_UNESCAPED_UNICODE);
    }

    //清書リスト
    public function finalize_list()
    {
        //完了したタスクと画像データを抽出
        $tasks_finished = Task::with('image')
        ->where('user_id', '!=', null)
        ->where('task_close', '!=', null)
        ->orderBy('task_close', 'asc')
        ->paginate(KuzushijiConst::PAGENATION);

        return view('final_list', compact('tasks_finished'));
    }

    //清書チェックフラグ　完了
    public function finalize_checked(Request $request) {
        //annotationテーブルのfinalized_atに日時書込み

        $tasks_finished = Task::with('image')
            ->where('user_id', '!=', null)
            ->where('task_close', '!=', null)
            ->orderBy('task_close', 'asc')
            ->paginate(KuzushijiConst::PAGENATION);

        //$message = "清書が完了しました";
        return view('final_list', compact('tasks_finished'));
    }
}
