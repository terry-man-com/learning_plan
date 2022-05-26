<?php
require_once __DIR__ . '/functions.php';
$id = filter_input(INPUT_GET, 'id');
// update_date_to_incomplete
update_date_to_incomplete($id);
header('Location: index.php');
exit;