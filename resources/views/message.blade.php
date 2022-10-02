<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-800 leading-tight">
            {{ __('Message') }}
        </h2>
    </x-slot>

    {{-- フラッシュメッセージ --}}
    <x-flash />

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="ml-8 mb-1 font-semibold text-xl text-cyan-400 leading-tight">
                サイト管理者への質問・ご意見
            </h3>
            <hr class="ml-8 mr-8 border-cyan-400 border-solid border-2">

            <div class="ml-8 mr-8 mt-4 h-12">
                <form action="{{ route('contact') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="flex">
                        <div>送信者</div>
                        <div class="ml-8">{{ Auth::user()->name }} ({{Auth::user()->email }}）</div>
                    </div>
                    <div class="flex">
                        <div>受信者</div>
                        <div class="ml-8">本サイト管理者のメールアドレス</div>
                    </div>
                    <div class="flex mt-4">
                        <div>質問内容</div>
                        <textarea class="ml-4 text-black" name="questions" rows="8" cols="40">{{ old('questions') }}</textarea>
                    </div>
                    <div>
                        <input type="hidden" name="id" value="{{ Auth::id() }}" />
                    </div>
                    <div class="flex">
                        <button class="mt-4 shadow-lg bg-cyan-400 shadow-cyan-500/50 text-slate-700 font-bold rounded px-2 py-1" type="submit">
                            質問を送る
                        </button>
                        <p class="p-4 text-sm text-cyan-300 font-bold">（確認画面は出さずにすぐに送信します。内容をよく確認してください。）</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
