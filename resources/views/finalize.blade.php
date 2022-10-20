@php 
  header('Expires: -1');
  header('Cache-Control: no-store, no-cache, must-revalidate');
  header('Cache-Control: post-check=0, pre-check=0', FALSE);
  header('Pragma: no-cache');
  use Illuminate\Support\Facades\Storage; 
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="600"><!--リロード-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Finalization') }}</title>
    <!-- CSS stylesheet -->
    <link rel="stylesheet" href="{{ asset('annotation_style.css') }}">
    <link rel="stylesheet" href="{{ asset('annotorious-openseadragon-2.7.7/annotorious.min.css') }}">
    <!-- JS -->
    <script src="{{ asset('openseadragon-bin-3.1.0/openseadragon.min.js') }}"></script>
    <script src="{{ asset('annotorious-openseadragon-2.7.7/openseadragon-annotorious.min.js') }}"></script>
    <!-- shape-labelsにはsafariとchrome対応のためソースを一部修正したものを使用しています。 -->
    <script src="{{ asset('annotorious-shape-labels.min.js') }}"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased text-slate-200 bg-slate-900">
    @include('layouts.annonavi_finalize')
    <div id="task-state" class="flex fixed z-10 p-4 top-0 left-1/2">
      <div id="message_saved" class="m-1 bg-black"></div>
    </div>
    <header id="header" class="z-20 fixed top-16 right-8 h-16 flex items-center">
        <div class="flex items-center">
            <button id="label_button" type="button" class="w-38 h-8 m-4 text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-bold rounded-lg text-md px-2 py-1 text-center">
                ラベルON/OFF
            </button>
            <button id="save_button" type="button" class="w-38 h-8 m-4 text-white bg-gradient-to-br from-green-400 to-blue-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800 font-bold rounded-lg text-md px-2 py-1 text-center">
                保存
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

    const base_annotation_file = '/storage/w3c_annos/' + this_file + '.json';
    const base_annotation_file_url = "{{ config('app.url') }}" + base_annotation_file;
    const user_annotation_file = '/storage/users_annos/' + this_file + '-u' + '{{ $target_task->user_id }}' + '.json'; //利用者が作成したデータ
    const user_annotation_file_url = "{{ config('app.url') }}" + user_annotation_file;

    // OpenSeadragon初期化
    window.onload = function() {
      var viewer = OpenSeadragon({
        id: "main",
        preserveViewport: true,
        disableEditor: false,
        handleRadius: 4,
        prefixUrl: "{{ asset('openseadragon-bin-3.1.0/images') }}/",
        sequenceMode: true,
        tileSources: [
          image_manifest_url,
        ]
      });

      // インスタンスの設定
      const config = {
        widgets: [
          'TAG',
          //'COMMENT',
        ],
        drawOnSingleClick: true,
        allowEmpty: true,
        locale: 'ja',
        formatter: Annotorious.ShapeLabelsFormatter(),
      }

      // Annotoriousプラグイン初期化
      var anno = OpenSeadragon.Annotorious(viewer, config);

      //urlファイル存在チェック関数
      async function file_get_contents(uri, callback) {
        let res = await fetch(uri),
            ret = await res.json(); 
        return callback ? callback(ret) : ret; // a Promise() actually.
      }

      // users_annosにデータがあれば最優先で使用する
      fetch(base_annotation_file_url)
        .then(response => {
          //失敗
          if(!response.ok) {
            console.log(response.statusText);
            throw new Error(response.statusText);
          }
          //成功
          anno.loadAnnotations(base_annotation_file_url); //これを優先
          console.log('base_annos file loaded');
        })
        .catch(error => {
          if (file_get_contents(user_annotation_file_url, console.log) != '') {
            anno.loadAnnotations(user_annotation_file_url);
            console.log('user_annos (finished) data loaded');
          }
        });

      // アノテーションデータ取得
      anno.on('createAnnotation', async (annotation) => {
        console.log(annotation);
        console.log('created');
      });

      anno.on('updateAnnotation', async (annotation) => {
        console.log(annotation);
        console.log('updated');
      });

      anno.on('deleteAnnotation', async (annotation) => {
        console.log(annotation);
        console.log('deleted');
      });

      // アノテーションデータ手動保存
      let saveBtn = document.getElementById('save_button');
      saveBtn.addEventListener('click', saveWorks);

      // アノテーションデータ自動保存
      let intervalId_1 = setInterval(saveWorks, {{ KuzushijiConst::ANNO_SAVE_INTERVAL }});

      var timerId;
      var mes = document.getElementById('message_saved');

      function setFlashMessage(text) {
        mes.innerHTML = text;
      }
        
      function startTimer(text) {
        setFlashMessage(text);
        timerId = setTimeout(abortTimer, 5000);
      }
        
      function abortTimer() {
        mes.innerHTML = '';
      }

      function saveWorks() {
        let all_data = anno.getAnnotations();
        localStorage.setItem(this_file, JSON.stringify(all_data));

        // 定期的にファイルにデータ保存
        let newest_data = JSON.stringify(localStorage.getItem(this_file));
        let base_data = base_annotation_file_url + 'を保存しました';

        // サーバにデータを投げる（TODO）
        const formData = new FormData();
        formData.append('file_name', base_annotation_file_url)
        formData.append('json_data', newest_data);
        formData.append('users_info', base_data);

        fetch("{{ config('app.url') }}/request_finalize.php", {
            method: 'POST',
            body: formData,
            credentials: 'same-origin',
          })
          .then(response => response.text())
          .then(res => { //サーバ側からの出力
            console.log(res);
            startTimer('保存しました👍');
          })
          .catch(error => {
            console.log(error);
            startTimer('!!保存できていません!!');
          })
      }

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