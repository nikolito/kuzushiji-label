<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-800 leading-tight">
            {{ __('Intro') }}
        </h2>
    </x-slot>

    {{-- フラッシュメッセージ --}}
    <x-flash />

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="ml-8 mr-8 mt-4">
                <h3 class="text-lg font-bold m-4">
                    目的
                </h3>
                <p class="m-4">
                    このサイト kuzushiji.work（くずし字・ドット・ワーク）は、くずし字で書かれた文献から文字画像を切り出し、機械学習用のデータを作っていくサイトです。<br>
                    みんなでAI自動翻刻を実現させましょう⭐️
                </p>

                <h3 class="text-lg font-bold m-4">
                    課題
                </h3>
                <p class="m-4">
                    <a href="http://codh.rois.ac.jp/" target="_blank">CODH（人文学オープンデータ共同利用センター）</a>から提供中のAI技術をベースとしたくずし字データおよびOCRアプリ類は、これまでのくずし字の解読スタイルを大きく変えるものでした。<br>
                    しかし、現状のくずし字データは、日本文学（古典籍）やレシピなどの比較的ひらがな多めの本から採取したものです。<br>
                    そのため、公文書や書状などの改まった「書き言葉」に多用される漢字中心の文書に対してOCRを行うと、精度が大幅に低下します。<br>
                    そこで、本システムを通じて、<span
                        class="text-orange-500 font-bold">現状のAI用くずし字データを積極的に増やし、誰でもくずし字データを無償で使用できるようにしたいと思います。</span>
                </p>

                <h3 class="text-lg font-bold m-4">
                    「くずし字データ」とは
                </h3>
                <p class="m-4">
                    このサイトでは、くずし字1文字の画像＋対応する文字の表記や抽出元の画像での位置などの詳細な情報が入ったJSONデータ（アノテーションデータとも言います。）を「くずし字データ」と呼んでいます。
                </p>

                <h3 class="text-lg font-bold m-4">
                    面白そうだと思ったら...
                </h3>
                <p class="m-4">
                    メールアドレスとお名前（ニックネームOK）をサイトに登録して、ぜひお手伝いお願いします。<br>
                    メールアドレスは本サイトの管理者が責任を持って管理します。
                </p>
            </div>
        </div>
    </div>

</x-app-layout>