<!--CSRFトークン対策-->
<meta name="csrf-token" content="{{ csrf_token() }}">

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-800 leading-tight">
            {{ __('Search for Images') }}
        </h2>
    </x-slot>

    {{-- フラッシュメッセージ --}}
    <x-flash />

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="search" >
                        @csrf
                        <input id="keywords" name="keywords" type="text" placeholder="検索キーワード" class="mr-8 text-black" />
                        作業状態
                        <input type="radio" name="anno_condition[]" value="all" checked />全て
                        <input type="radio" name="anno_condition[]" value="finished" />完了
                        <input type="radio" name="anno_condition[]" value="unfinished" />未完了
                        <button id="search_button" type="button" class="ml-8">検索</button>
                    </form>
                </div>
            </div>

            <h3 class="ml-8 mb-1 font-semibold text-xl text-cyan-400 leading-tight">
                選択した画像 枚／全画像 {{ count($all_images) }} 枚
            </h3>
            <hr class="ml-8 mr-8 border-cyan-400 border-solid border-2">

            <div id="results"></div>
            @php print_r($_POST); @endphp;

            {{-- 画像リスト --}}
            <div class="flex flex-wrap px-6">
                @if (count($all_images) < 1)
                    <div class="items-center border-cyan-800 bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-1/2">
                            検索可能な画像はありません
                        </div>
                    </div>
                @else
                    @php $count = 0; @endphp
                    @foreach ($all_images as $all_image)
                    @php //manifestから基本情報取得
                        $json = json_decode(file_get_contents($all_image->manifest_url));
                        $json_image = json_decode(file_get_contents($all_image->image_url));
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
                                        <input type="hidden" name="image_id" value="{{ $all_image->id }}" />
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
        </div>
    </div>
    
    <script type="text/javascript">
    function delay(callback, ms) {
        let timer = 0;
        return function() {
        let context = this,
            args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function() {
            callback.apply(context, args);
        }, ms || 0);
        };
    }

    document.addEventListener('DOMContentLoaded', function() {
        keywords.addEventListener('input', delay(function() {
            let formData = new FormData();
            formData.set('keywords', document.getElementById('keywords').value);

            fetch('search', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            }).then((response) => {
                // console.log(response);
                return response.text();
            }).then((data) => {
                text = data.split(']')[0] + ']';
                // console.log(JSON.parse(text));
                //各データを埋め込む
                let results = JSON.parse(text);
                document.getElementById('results').innerHTML = results;
            });
        
        }, 1000)); //遅延
    });
    </script>
</x-app-layout>
