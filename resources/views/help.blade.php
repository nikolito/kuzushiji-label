<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-800 leading-tight">
            {{ __('Help') }}
        </h2>
    </x-slot>

    {{-- フラッシュメッセージ --}}
    <x-flash />

    <h3 class="ml-8 mb-1 mt-4 font-semibold text-xl text-cyan-400 leading-tight">
        ダッシュボード
    </h3>
    <hr class="ml-8 mr-8 border-cyan-400 border-solid border-2">

    <div class="ml-8 mr-8 mt-4">
        <h3 class="text-lg font-bold m-4">
            自動保存
        </h3>
        <p class="m-4">
            ブラウザ画面からログインすると、選択できる画像が表示されています。<br>
            「選択」ボタンを押してください。<br>
            画像のプレビューが出てくるので、「作業を始める」または「止める」ボタンを押してください。<br>
            作業は()日以内に完了してください。<br>
            期限内に「進捗」メニューで担当画像に対し、「完了」ボタンが押されていないときは、自動的にダッシュボードに再表示され、他の人が担当できるようになります。
        </p>

        <h3 class="text-lg font-bold m-4">
            担当している画像の作業期限
        </h3>
        <p class="m-4">
            期限内に「進捗」メニューで担当画像に対し、「完了」ボタンが押されていないときは、自動的にダッシュボードに再表示され、他の人が担当できるようになります。<br>
            期限切れになっても、続けて作業したい場合は直ぐにダッシュボードで選択すれば、引き続き自分の作成したデータを使って編集できます。<br>
            他の人が引き受けた場合は、別の人が作成したデータを引き継ぐことはなく、一からアノテーションを開始することになります。
            サーバには一つの画像に対し、各人が作成したデータが残ります。そのうち<span class="text-orange-500 font-bold">「完了」とされたデータが正解データ（候補）として採用されます。</span><br>
            したがって、<span class="text-orange-500 font-bold">画像に対するアノテーションが全て終わったら、必ず「完了」ボタンを押してください。</span>
        </p>
    </div>

    <h3 class="ml-8 mb-8 mt-8 font-semibold text-xl text-cyan-400 leading-tight">
        進捗
    </h3>
    <hr class="ml-8 mr-8 border-cyan-400 border-solid border-2">

    <h3 class="ml-8 mb-8 mt-8 font-semibold text-xl text-cyan-400 leading-tight">
        アノテーション
    </h3>
    <hr class="ml-8 mr-8 border-cyan-400 border-solid border-2">

    <div class="ml-8 mr-8 mt-4">
        <h3 class="text-lg font-bold m-4">
            自動保存
        </h3>
        <p class="m-4">
            アノテーション（＝囲みに文字を当てる作業）画面では<span class="text-orange-500 font-bold">1分に1度</span>、作業データを自動で保存します。<br>
            <span class="text-orange-500 font-bold">インターネットに常時接続できる環境での作業をお願いします。</span>
        </p>

        <h3 class="text-lg font-bold m-4">
            囲みの編集
        </h3>
        <p class="m-4">
            囲みの位置や大きさを変える：囲みを直接クリックし、赤丸ハンドルをドラッグします。また、囲みの中身をクリックして動かします。<br>
            囲みを消す：囲みをクリックし、ダイアログを出して、ゴミ箱アイコンをクリックしてください。<br>
            新しい囲みを作る：<span class="text-orange-500 font-bold">シフトキーを押しながら</span>、囲みたい文字の左上から右下にドラッグすると新しい囲みができます。<br>
        </p>

        <h3 class="text-lg font-bold m-4">
            1文字当ての編集
        </h3>
        <p class="m-4">
            編集したい囲みを選んで、ダイアログボックスを出します。上段に「Add tag...」という欄をクリックすると文字を入力できます。文字を入力してリターンキーを押すと、付箋のようになります。<br>
            確定する場合はOk、取り消す場合はCancelボタンを押してください。<br>
            付箋（タグ）になった文字を消したい時は、付箋を選び×印をクリックしてください。付箋が消えます。この操作を確定する時はOk、取り消す時はCancelボタンを入力します。<br>
            なお、付箋になった文字は複数入力できますが、最初の1文字が囲みの真横に表示されます。<br>
            作業を仕上げる時に、1文字だけ残してください。
        </p>
    </div>

</x-app-layout>
