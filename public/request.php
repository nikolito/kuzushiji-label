<?php // index.phpからajaxでデータ入力
$data = json_decode($_POST['json_data']);
$file = $_POST['file_name'];
print $file . PHP_EOL;

if (!file_get_contents($file)) {
  print $file . 'がありません'.PHP_EOL;
}

if (!empty($data)) { 
  $result = file_put_contents('../storage/app/public/users_annos/'.basename($file), $data, LOCK_EX);
  print $_POST['users_info'];
}

?>