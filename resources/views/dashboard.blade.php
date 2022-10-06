<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- フラッシュメッセージ --}}
    <x-flash />

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="mb-4">
                        <span
                            class="inline-flex items-center justify-center px-2 py-1 mr-2 text-sm font-bold leading-none text-red-100 bg-red-600 rounded-full">
                            お知らせ
                        </span>
                        しばらくの間、開発と運用を同時に進めます。動作に不具合が起きることがありますがご了承ください🙏
                    </p>
                    <hr width="50%" class="mx-auto border-dotted border-cyan-400">
                    <p class="mt-4">取り組みたい文書画面を選んでください。「進捗」ページに登録できる画像は最大 {{ KuzushijiConst::ACTIVE_TASK_MAX }} 枚までです。<br>
                    作業が完了すると新しい画像を選べます。</p>
                </div>
            </div>

            <h3 class="ml-8 mb-1 font-semibold text-xl text-cyan-400 leading-tight">
                選択できる画像 {{ count($free_images) }} 枚　総画像 {{ count($all_images) }} 枚
            </h3>
            <hr class="ml-8 mr-8 border-cyan-400 border-solid border-2">

            {{-- タスク実行可能なIIIFのリスト --}}
            <div class="flex flex-wrap px-6">
                @if (count($free_images) < 1)
                    <div class="items-center border-cyan-800 bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-1/2">
                            現在取り組み可能な文書画像はありません
                        </div>
                    </div>
                @else
                    @php $count = 0; @endphp
                    @foreach ($free_images as $free_image)
                    @php //manifestから基本情報取得
                        $json = json_decode(file_get_contents($free_image->manifest_url));
                        $json_image = json_decode(file_get_contents($free_image->image_url));
                        $iiif_image = $json_image->{'@id'};
                        $count = $count + 1;
                    @endphp
                    <div class="p-1 lg:w-1/5 md:w-1/5 w-full m-2">
                        <div class="h-full border-cyan-400 border-2 p-4 rounded-lg">
                            <p class="font-bold text-center text-cyan-400 text-sm mb-4">{{ $json->attribution }}</p>
                            <div class="flex justify-center gap-x-4">
                                <div class="self-center">
                                    <h2 class="text-white title-font text-sm">{{ $json->label }}</h2>
                                    <h3 class="font-bold text-white">{{ $json->metadata[0]->value }}</h3>
                                    <p class="font-bold text-white text-lg">
                                        {{ basename($json_image->{'@id'}) }}
                                    </p>
                                </div>
                                <div class="self-end py-4">
                                    <a data-micromodal-trigger="modal-preview-{{ $count }}" href='javascript:;' class="p-2 text-gray-800 rounded whitespace-nowrap bg-blue-400 hover:bg-blue-100 font-bold">選択</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- プレビューモーダル --}}
                    <div class="modal micromodal-slide" id="modal-preview-{{ $count }}" aria-hidden="true">
                        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
                            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                                <header class="modal__header">
                                    <h2 class="modal__title" id="modal-1-title">
                                        画像のプレビュー
                                    </h2>
                                    <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                                </header>
                                <main class="modal__content" id="modal-1-content">
                                    <div>
                                        <img src="{{ $iiif_image }}/full/full/0/default.jpg" class="rounded" style="width: 80vw;" />
                                    </div>
                                    <p>
                                        画像一枚の作業は<span class="text-red-600 font-bold text-lg">{{ KuzushijiConst::TASK_DAY_LIMIT }}</span>日以内に完了させてください。
                                    </p>
                                </main>
                                <footer class="modal__footer flex gap-x-4">
                                    <form method="POST" action="{{ route('working_new') }}">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="image_id" value="{{ $free_image->id }}" />
                                        <button class="modal__btn modal__btn-primary">作業を始める</button>
                                    </form>
                                    <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">止める</button>
                                </footer>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>

            <h3 class="mt-8 ml-8 mb-1 font-semibold text-xl text-cyan-400 leading-tight">
                作業完了した画像 {{ count($tasks_finished) }} 枚（最新の{{ KuzushijiConst::TASK_FINISHED }}枚を表示）
            </h3>
            <hr class="ml-8 mr-8 border-cyan-400 border-solid border-2">

            <div class="flex flex-wrap px-6">
                @if (count($tasks_finished) < 1)
                    <div class="m-8 border-blue-800 bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-1/2">
                            完了した作業はありません。
                        </div>
                    </div>
                @else
                    @php $count2 = 0; @endphp
                    @foreach ($tasks_finished as $task_finished)
                    @php //manifestから基本情報取得
                        $json_finished = json_decode(file_get_contents($task_finished->image->manifest_url));
                        $json_image_finished = json_decode(file_get_contents($task_finished->image->image_url));
                        $iiif_image_finished = $json_image_finished->{'@id'};
                        $count2 = $count2 + 1;
                        if ($count2 > KuzushijiConst::TASK_FINISHED) break;
                    @endphp
                    <div class="p-1 lg:w-1/4 md:w-1/5 w-full m-2">
                        <div class="h-full border-blue-400 border-2 p-4 rounded-lg">
                            <div class="flex">
                                @if (Auth::user()->user_level === 1)
                                    <a data-micromodal-trigger="modal-confirm-{{ $task_finished->id }}" href='javascript:;' alt="完了取り消し" class="text-gray-400 text-sm text-right">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                @endif
                                <div class="text-sm text-red-200 p-1">
                                    作業完了　{{ $task_finished->task_close }} 
                                </div>
                            </div>

                            <p class="font-bold text-center text-blue-400 text-sm mb-4">{{ $json_finished->attribution }}</p>
                            <div class="flex justify-center gap-x-4">
                                <div class="self-center">
                                    <h2 class="text-white title-font text-sm">{{ $json_finished->label }}</h2>
                                    <h3 class="font-bold text-white">{{ $json_finished->metadata[0]->value }}</h3>
                                    <p class="font-bold text-white text-lg">
                                        {{ basename($json_image_finished->{'@id'}) }}
                                    </p>
                                </div>
                                <div class="self-end py-4">
                                    <a class="p-2 text-gray-800 rounded whitespace-nowrap bg-blue-400 hover:bg-blue-100 font-bold" href="{{ route('view', ['task_id' => $task_finished->id]) }}">見る</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 完了解除モーダル（user_level=1のみ） --}}
                    @if (Auth::user()->user_level === 1)
                        <div class="modal micromodal-slide" id="modal-confirm-{{ $task_finished->id }}" aria-hidden="true">
                            <div class="modal__overlay" tabindex="-1" data-micromodal-close>
                                <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                                    <header class="modal__header">
                                        <h2 class="modal__title" id="modal-1-title">
                                            この作業の完了状態を取り消します。
                                        </h2>
                                        <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                                    </header>
                                    <main class="modal__content" id="modal-1-content">
                                        <div>
                                            <ul>
                                                <li>task_id: {{ $task_finished->id }}</li>
                                                <li>user_id: {{ $task_finished->user_id }} {{ $task_finished->user->name }}</li>
                                                <li>image_id: {{ $task_finished->image_id }}</li>
                                                <li>task_close: {{ $task_finished->task_close }}</li>
                                            </ul>
                                        </div>
                                    </main>
                                    <footer class="modal__footer flex gap-x-4">
                                        <form method="POST" action="{{ route('working_reopen') }}">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="id" value="{{ $task_finished->id }}" />
                                            <input type="hidden" name="user_id" value="{{ $task_finished->user_id }}" />
                                            <button class="modal__btn modal__btn-primary">本当に取り消す</button>
                                        </form>
                                        <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">キャンセル</button>
                                    </footer>
                                </div>
                            </div>
                        </div>
                    @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>


</x-app-layout>
