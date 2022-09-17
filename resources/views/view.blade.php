@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>参考アノテーション</title>
    <!-- CSS stylesheet -->
    <link rel="stylesheet" href="{{ asset('annotation_style.css') }}">
    <link rel="stylesheet" href="{{ asset('annotorious-openseadragon-2.7.7/annotorious.min.css') }}">
    <!-- JS -->
    <script src="{{ asset('openseadragon-bin-3.1.0/openseadragon.min.js') }}"></script>
    <script src="{{ asset('annotorious-openseadragon-2.7.7/openseadragon-annotorious.min.js') }}"></script>
    <!-- shape-labelsにはsafariとchrome対応のためソースを一部修正したものを使用しています。 -->
    <script src="{{ asset('annotorious-shape-labels.min.js') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body id="comp" class="antialiased text-slate-200" bg-indigo-900>
    @include('layouts.annonavi')
    <div id="task-state" class="z-10 absolute p-4 top-0 left-1/2">
        <div id="message_saved" class="m-1"></div>
    </div>
    <header id="header" class="z-20 fixed top-16 right-8 h-16 flex items-center">
        <div class="flex items-center">
            <button id="label_button" type="button" class="w-38 h-8 m-4 text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-bold rounded-lg text-md px-2 py-1 text-center">
                ラベルON/OFF
            </button>
        </div>
    </header>

    <div id="container">
        <div id="main" class="fixed top-16 left-0 right-0 bottom-0 h-auto w-auto m-auto"></div>
    </div>

    <script>
    // タスク対象URLの決定
    //https://www.dl.saga-u.ac.jp/view/N0100501901/0005.tif/info.json
    var image_manifest_url = "{{ $target_task->image->image_url }}";

    //一意になるようなファイル名をmanifestに合わせて作成
    const regex = /(https:\/\/)([\-_.a-zA-Z0-0]+)([\/][\-_.a-zA-Z0-0]+[\/])/;
    var manifest_base = image_manifest_url.match(regex)[0];
    var this_file = image_manifest_url.replace(manifest_base, '');
    this_file = this_file.replace('/', '-');
    this_file = this_file.replace('.tif/info.json', '');

    //作業完了したデータ
    const user_annotation_file = '/storage/users_annos/' + this_file + '-u' + '{{ $target_task->user_id }}' + '.json'; 
    const user_annotation_file_url = "{{ config('app.url') }}" + user_annotation_file;

    // OpenSeadragon初期化
    window.onload = function() {
      var viewer = OpenSeadragon({
        id: "main",
        preserveViewport: true,
        handleRadius: 4,
        prefixUrl: "{{ asset('openseadragon-bin-3.1.0/images') }}/",
        sequenceMode: true,
        tileSources: [
          image_manifest_url,
        ]
      });

      // インスタンスの設定
      const config = {
        disableEditor: true,
        disableSelect: true,
        allowEmpty: true,
        readOnly: true,
        locale: 'ja',
        formatter: Annotorious.ShapeLabelsFormatter(),
      }

      // Annotoriousプラグイン初期化
      var anno = OpenSeadragon.Annotorious(viewer, config);

      //urlファイル存在チェック関数
      async function file_get_contents(uri, callback) {
        let res = await fetch(uri),
            ret = await res.text(); 
        return callback ? callback(ret) : ret; // a Promise() actually.
      }

      // users_annosにデータがあれば最優先で使用する
      fetch(user_annotation_file_url)
        .then(response => {
          if (response.ok) {
            anno.loadAnnotations(user_annotation_file_url); //これを優先
            console.log('users_annos file loaded');
          } else {
            // user_annotation_fileがないとき
            // モーダルアラート・ログを出してダッシュボードに戻る
            
            console.log('Annotated data FAILED loading');
          }
        });
    }
    </script>

    <script>
        //label visibility
    const btn = document.getElementById("label_button");
    const labels = document.getElementsByTagName('foreignObject');
    const toggle_labels = () => {
      for (let i = 0; i < labels.length; i++) {
        labels[i].classList.toggle("hidden");
      }
    }

    btn.addEventListener('click', toggle_labels);
    </script>

</body>

</html>