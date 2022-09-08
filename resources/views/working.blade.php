<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-800 leading-tight">
            {{ __('Working') }}
        </h2>
    </x-slot>

    {{-- フラッシュメッセージ --}}
    <x-flash />

    <h3 class="ml-8 mb-1 font-semibold text-xl text-green-400 leading-tight">
        作業中 {{ count($tasks) }} 件　<span class="text-sm">（有効期限切れの作業はダッシュボードに移動します。）</span>
    </h3>
    <hr class="ml-8 mr-8 border-green-400 border-solid border-2">

    <div class="flex flex-wrap px-6">
        @if (count($tasks) < 1)
            <div class="m-8 border-green-800 bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-1/2">
                    進行中の作業はありません。
                </div>
            </div>
        @else
            @php $count = 0; @endphp
            @foreach ($tasks as $task)
            @php //manifestから基本情報取得
                $json = json_decode(file_get_contents($task->image->manifest_url));
                $json_image = json_decode(file_get_contents($task->image->image_url));
                $iiif_image = $json_image->{'@id'};
                $count = $count + 1;

                //有効期限チェック
                $background_alert_color = '';
                $button_disabled = '';
                if ($task->task_expire < date('Y-m-d H:i:s')) {
                    $background_alert_color = 'bg-red-300 bg-opacity-20';
                    $button_disabled = 'disabled:opacity-25';
                }
            @endphp
            <div class="p-1 lg:w-1/4 md:w-1/5 w-full m-2">
                <div class="h-full border-green-400 border-2 p-4 rounded-lg {{ $background_alert_color }}">
                    <div class="flex">
                        <a data-micromodal-trigger="modal-confirm-{{ $count }}" href='javascript:;' alt="担当解除する" class="text-gray-400 text-sm text-right">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <div class="text-sm text-red-200 p-1">
                            有効期限　{{ $task->task_expire }}
                        </div>
                    </div>

                    <p class="font-bold text-center text-green-400 text-sm mb-4">{{ $json->attribution }}</p>
                    <div class="flex justify-center gap-x-4">
                        <div class="self-center">
                            <h2 class="text-white title-font text-sm">{{ $json->label }}</h2>
                            <h3 class="font-bold text-white">{{ $json->metadata[0]->value }}</h3>
                            <p class="font-bold text-white text-lg">
                                {{ basename($json_image->{'@id'}) }}
                            </p>
                        </div>
                        <div class="self-end my-4">
                            <a class="p-2 text-gray-800 rounded whitespace-nowrap bg-green-400 hover:bg-blue-100 font-bold">開く</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 削除確認モーダル --}}
            <div class="modal micromodal-slide" id="modal-confirm-{{ $count }}" aria-hidden="true">
                <div class="modal__overlay" tabindex="-1" data-micromodal-close>
                    <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                        <header class="modal__header">
                            <h2 class="modal__title" id="modal-1-title">
                                この画像の担当を解除します。
                            </h2>
                            <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                        </header>
                        <main class="modal__content" id="modal-1-content">
                            <div>
                                <img src="{{ $iiif_image }}/full/full/0/default.jpg" class="rounded" style="width: 80vw;" />
                            </div>
                            <p>
                                担当を解除すると、ダッシュボードで他の人が担当できるようになります。担当を完了せずに解除した場合は、作業を担当したことになりません。間違えた時は、速やかにダッシュボードで作業画像を選択し直してください。
                            </p>
                        </main>
                        <footer class="modal__footer flex gap-x-4">
                            <form method="POST" action="{{ route('working_delete') }}">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="id" value="{{ $task->image_id }}" />
                                <button class="modal__btn modal__btn-primary">本当に解除する</button>
                            </form>
                            <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">キャンセル</button>
                        </footer>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>

    <h3 class="ml-8 mb-1 mt-8 font-semibold text-xl text-blue-400 leading-tight">
       作業完了 {{ count($tasks_finished) }} 件
    </h3>
    <hr class="ml-8 mr-8 border-blue-400 border-solid border-2">

    <div class="flex flex-wrap px-6">
        @if (count($tasks_finished) < 1)
            <div class="m-8 border-blue-800 bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-1/2">
                    進行中の作業はありません。
                </div>
            </div>
        @else
            @php $count = 0; @endphp
            @foreach ($tasks_finished as $task_finished)
            @php //manifestから基本情報取得
                $json_finished = json_decode(file_get_contents($task_finished->image->manifest_url));
                $json_image_finished = json_decode(file_get_contents($task_finished->image->image_url));
                $iiif_image_finished = $json_image_finished->{'@id'};
                $count = $count + 1;
            @endphp
            <div class="p-1 lg:w-1/4 md:w-1/5 w-full m-2">
                <div class="h-full border-blue-400 border-2 p-4 rounded-lg">
                    <div class="flex">
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
                            <a class="p-2 text-gray-800 rounded whitespace-nowrap bg-blue-400 hover:bg-blue-100 font-bold">開く</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>

</x-app-layout>
