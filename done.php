<?php
require_once __DIR__ . '/functions.php';
// index.php からidを受け取る
$id = filter_input(INPUT_GET, 'id');
// update_date_to_finish関数の処理
update_date_to_finish($id);
header('Location: index.php');
exit;
?>