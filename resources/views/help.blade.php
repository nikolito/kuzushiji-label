<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-800 leading-tight">
            {{ __('Help') }}
        </h2>
    </x-slot>

    {{-- フラッシュメッセージ --}}
    <x-flash />

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="ml-8 mb-1 font-semibold text-xl text-cyan-400 leading-tight">
                1. ダッシュボードで担当する画像を選ぶ
            </h3>
            <hr class="ml-8 mr-8 border-cyan-400 border-solid border-2">

            <div class="ml-8 mr-8 mt-4">
                <h3 class="text-lg font-bold m-4">
                    アノテーションする画像の選択
                </h3>
                <p class="m-4">
                    ブラウザ画面からログインすると、選択できる画像が表示されています。<br>
                    「選択」ボタンを押してください。<br>
                    画像のプレビューが出てくるので、「作業を始める」または「止める」ボタンを押してください。<br>
                    作業は<span class="text-orange-500 font-bold"> {{ KuzushijiConst::TASK_DAY_LIMIT }} 日以内</span>に完了してください。<br>
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

                <h3 class="text-lg font-bold m-4">
                    アノテーションが「完了」した画像を参考にする
                </h3>
                <p class="m-4">
                    ダッシュボードの画面下部に、アノテーションが完了した画像の一覧が表示されます。具体的なアノテーションの例としてご活用ください。
                </p>
            </div>

            <h3 class="ml-8 mb-1 mt-8 font-semibold text-xl text-cyan-400 leading-tight">
                2. 進捗で担当画像の一覧や有効期限を確認してアノテーションする作業画面を開く
            </h3>
            <hr class="ml-8 mr-8 border-cyan-400 border-solid border-2">

            <div class="ml-8 mr-8 mt-4">
                <h3 class="text-lg font-bold m-4">
                    一度に担当できる画像の上限
                </h3>
                <p class="m-4">
                    ダッシュボードで画像を選択すると、進捗の画面で担当状況を確認できます。<br>
                    担当状況は、進捗の画面に最大 {{ KuzushijiConst::ACTIVE_TASK_MAX }} つまでです。<br>
                    担当作業を完了したり解除したりして空きをつくることで、新しい画像を担当できるようになります。
                </p>
                <h3 class="text-lg font-bold m-4">
                    作業の完了
                </h3>
                <p class="m-4">
                    作業は進捗画面の各担当画像に付いている「完了する」ボタンを押して、作業完了となります。<br>
                    完了した作業は、進捗に表示されます。<br>
                    作業量は画像の文字を数えて換算します。
                </p>
            </div>

            <h3 class="ml-8 mb-1 mt-8 font-semibold text-xl text-cyan-400 leading-tight">
                3. アノテーション作業を進める（保存状態と有効期限に注意！）
            </h3>
            <hr class="ml-8 mr-8 border-cyan-400 border-solid border-2">

            <div class="ml-8 mr-8 mt-4 mb-8">
                <h3 class="text-lg font-bold m-4">
                    手動・自動保存
                </h3>
                <p class="m-4">
                    アノテーション（＝囲みに文字を当てる作業）画面では<span class="text-orange-500 font-bold">{{ (KuzushijiConst::ANNO_SAVE_INTERVAL) / 1000 }}秒に1度</span>、作業データをサーバ上に自動で保存します。<br>
                    <span class="text-orange-500 font-bold">インターネットに常時接続できる環境での作業をお願いします。</span><br>
                    保存ボタンを押しても同様にサーバ上に保存できます。
                </p>

                <h3 class="text-lg font-bold m-4">
                    アノテーションを始める前に
                </h3>
                <p class="m-4">
                    ブラウザの動作を確認するため、試しに1文字ほどデータを変更し、保存ボタンを押して「保存しました👍」の表示が画面上部に現れてから、一旦別のページに戻り、その後アノテーションのページに戻って<span class="text-orange-500 font-bold">作業したデータの保存状態を確認してください。</span>保存するタイミングの前に別のページに行くと、変更したデータが修正されないことがあります。
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
                    編集したい囲みを選んで、ダイアログボックスを出します。「Add tag...」という欄をクリックすると文字を入力できます。文字を入力してリターンキーを押すと、付箋のようになります。<br>
                    確定する場合はOk、取り消す場合はCancelボタンを押してください。<br>
                    付箋（タグ）になった文字を消したい時は、付箋をクリックで選び×印をクリックしてください。付箋が消えます。この操作を確定する時はOk、取り消す時はCancelボタンを入力します。<br>
                    なお、付箋になった文字は複数入力できますが、最初の1文字が囲みの真横に表示されます。<br>
                    作業を仕上げる時に、1文字だけ残してください。
                </p>
                <p class="m-4">
                    旧字体での表記は<span class="text-orange-500 font-bold">新字体</span>でラベリングしてください。<br>
                    例えば、「舊（旧の旧字体）」は「旧」でお願いします。
                </p>
            </div>

            <h3 class="ml-8 mb-1 mt-8 font-semibold text-xl text-cyan-400 leading-tight">
                4. そのほか
            </h3>
            <hr class="ml-8 mr-8 border-cyan-400 border-solid border-2">

            <div class="ml-8 mr-8 mt-4 mb-8">
                <h3 class="text-lg font-bold m-4">
                    エラー画面が出た場合・わからないことなどがある時
                </h3>
                <p class="m-4">
                    <a href="{{ route('message') }}" class="text-orange-500 font-bold">連絡のページ</a>から管理者に連絡してください。
                </p>
            </div>
        </div>
    </div>

</x-app-layout>
