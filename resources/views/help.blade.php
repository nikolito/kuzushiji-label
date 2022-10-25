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
                <span class="text-3xl font-bold">1.</span> ダッシュボードで担当する画像を選ぶ
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
                <span class="text-3xl font-bold">2.</span> 進捗で担当画像の一覧や有効期限を確認してアノテーションする作業画面を開く
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
                <span class="text-3xl font-bold">3.</span> アノテーション作業を進める（保存状態と有効期限に注意！）
            </h3>
            <hr class="ml-8 mr-8 border-cyan-400 border-solid border-2">

            <div class="ml-8 mr-8 mt-4 mb-8">
                <h3 class="text-lg font-bold m-4">
                    <span
                        class="inline-flex items-center justify-center px-2 py-1 mr-2 text-md font-bold leading-none text-red-100 bg-red-600 rounded-full">
                        重要
                    </span>
                    アノテーションを始める前に
                </h3>
                <p class="m-4">
                    通信状態とブラウザの動作を確認するため、試しに1文字ほどデータを変更し、保存ボタンを押して「保存しました👍」の表示が画面上部に現れてから、一旦別のページに戻り、その後アノテーションのページに戻って<span class="text-orange-500 font-bold">作業したデータの保存状態を確認してください。</span><br>
                    変更前の文字に戻ってしまう場合は、ブラウザのキャッシュを消去して、画面を再読み込みしてください。<br>
                    それでもうまくいかない場合は<a href="{{ route('message') }}" class="text-orange-500 font-bold">管理者に連絡</a>してください。
                </p>

                <h3 class="text-lg font-bold m-4">
                    手動・自動保存
                </h3>
                <p class="m-4">
                    アノテーション（＝囲みに文字を当てる作業）画面では<span class="text-orange-500 font-bold">{{ (KuzushijiConst::ANNO_SAVE_INTERVAL) / 1000 }}秒に1度</span>、作業データをサーバ上に自動で保存します。<br>
                    <span class="text-orange-500 font-bold">インターネットに常時接続できる環境での作業をお願いします。</span><br>
                    保存ボタンを押しても同様にサーバ上に保存できます。
                </p>

                <h3 class="text-lg font-bold m-4">
                    自動ログアウト・アノテーション画面の自動リロード
                </h3>
                <p class="m-4">
                    異なるブラウザやコンピュータをお使いの場合は、使用しない画面を閉じてから、新しい画面で作業を始めてください。<br>
                    データの整合性を保つため、元の画面を開いたまま、別の端末やブラウザでログインすると、最後に開いた画面を除いた全ての画面はログアウト状態になります。<br>
                    また、アノテーション画面も同様の理由で<span class="text-orange-500 font-bold">10分に1度</span>自動でリロードしてログアウト状態かどうか確認します。<br>
                </p>

                <h3 class="text-lg font-bold m-4">
                    <span
                        class="inline-flex items-center justify-center px-2 py-1 mr-2 text-md font-bold leading-none text-red-600 bg-red-100 rounded-full">
                        TIPS
                    </span>
                    アノテーションするときはリンク先のデータベースをフル活用してください
                </h3>
                <p class="m-4">
                    画像にアノテーションする画面では、リンク集がメニューに現れます。
                    リンク先のデータベース機能を使うと、作業が捗ります。<br>
                    <b>例）</b>小城藩日記データベースで、アノテーションに含まれていそうなキーワードを入力して似た記事文がないか探します。
                    似た文章を見つけたら、記事文の後に付いている<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="w-6 h-6 inline text-cyan-400">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>マークをクリックして、各記事文の詳細を表示する小窓を出してください。
                    探している記事の前後にもアノテーションに使える記事文が並んでいることがよくあります。
                </p>

                <h3 class="text-lg font-bold m-4">
                    囲みの編集
                </h3>
                <p class="m-4">
                    <b>囲みの位置や大きさを変える</b>：囲みを直接クリックし、赤丸ハンドルをドラッグします。また、囲みの中身をクリックして動かします。<br>
                    <b>囲みを消す</b>：囲みをクリックし、ダイアログを出して、ゴミ箱アイコンをクリックしてください。<br>
                    <b>新しい囲みを作る</b>：<span class="text-orange-500 font-bold">シフトキーを押しながら</span>、囲みたい文字の左上から右下にドラッグすると新しい囲みができます。<br>
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
                    旧字体や異体字での表記は<span class="text-orange-500 font-bold">新字体</span>でラベリングしてください。<br>
                    例えば、「舊（旧の旧字体）」は「旧」でお願いします。
                </p>
                <p class="m-4">
                    なるべく囲みは他の文字の一部に重ならないようにしてください。
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
                    エラーページが出た場合は、ロゴ<img src="{{ asset('logo.png') }}" class="inline w-8 align-middle">をクリックしてください。ホーム画面に移ります。
                </p>
                <p class="m-4">
                    わからないことがある・翻刻自体が間違っていると思う時は、<a href="{{ route('message') }}" class="text-orange-500 font-bold">連絡のページ</a>から管理者に連絡してください。説明はなるべく具体的にお願いします。
                </p>
                <p class="m-4">
                    ログアウトの下にある「ローカルストレージを消去」は、このサイトのアノテーション用に作られる一時的なデータを一括して消去するために使います。
                </p>
            </div>

            <h3 class="ml-8 mb-1 mt-8 font-semibold text-xl text-cyan-400 leading-tight">
                5. 謝辞およびサイト制作・管理について
            </h3>
            <hr class="ml-8 mr-8 border-cyan-400 border-solid border-2">

            <div class="ml-8 mr-8 mt-4 mb-8">
                </h3>
                <p class="m-4">
                    自動翻刻には、学習モデルとしてGoogle合同会社のカラーヌワット・タリン氏制作のKuroNet（学習データはCODH・国文学研究資料館など）、自動翻刻実行環境の構築に国立民族歴史博物館の橋本雄太氏にご協力いただいています。<br>
                    本サイトシステム制作・管理は佐賀大学地域学歴史文化研究センターの吉賀夏子が科研費<a href="https://kaken.nii.ac.jp/ja/grant/KAKENHI-PROJECT-22K18149/" target="_blank">22K18149</a>を基に行なっています。
                </p>
            </div>
        </div>
    </div>

</x-app-layout>
