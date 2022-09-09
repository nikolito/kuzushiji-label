<?php

namespace App\Consts;

class KuzushijiConst {

  const DASHBOARD_LIMIT = 20;
  const ACTIVE_TASK_MAX = 3;

  const RECOGNITION_NONE = 0;
  const RECOGNITION_KURONET = 1;
  const RECOGNITION_KOGUMANET = 2;
  const RECOGNITION_LIST = [
    0 => self::RECOGNITION_NONE,
    1 => self::RECOGNITION_KURONET,
    2 => self::RECOGNITION_KOGUMANET
  ];

}