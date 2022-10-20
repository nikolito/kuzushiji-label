<?php

namespace App\Consts;

class KuzushijiConst {

  const DASHBOARD_LIMIT = 8; //選択できる画像
  const ACTIVE_TASK_MAX = 3; //進捗画面で作業する画像の上限
  const TASK_DAY_LIMIT = 7; //作業期間
  const ANNO_SAVE_INTERVAL = 30000; //アノテーションの自動保存用時間間隔
  const TASK_FINISHED = 12; //ダッシュボードでの完了画像表示用

  // const RECOGNITION_NONE = 0;
  // const RECOGNITION_KURONET = 1;
  // const RECOGNITION_KOGUMANET = 2;
  // const RECOGNITION_LIST = [
  //   0 => self::RECOGNITION_NONE,
  //   1 => self::RECOGNITION_KURONET,
  //   2 => self::RECOGNITION_KOGUMANET
  // ];

}