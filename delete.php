<?php
require_once __DIR__ . '/functions.php';
// id を受け取る
$id = filter_input(INPUT_GET, 'id');
//delete_tasks関数
delete_tasks($id);
// リダイレクト
header('Location: index.php');
exit;