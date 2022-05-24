<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';
// 現在の日付の取得
$ymd = date('Y-m-d');
// 初期化
$title = '';
$due_date = '';
$errors = [];
// リクエストメゾットの判定
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = filter_input(INPUT_POST, 'title');
    $due_date = filter_input(INPUT_POST, 'due_date');
    // バリテーション
    $errors = insert_validate($title, $due_date);
    // エラーチェック
    if (empty($errors)) {
        // タスク登録処理の実行
        insert_task($title, $due_date);
    }
}
// 未達成エリア
$incomplete_tasks = find_incomplete_tasks();
// 達成エリア
$complete_tasks = find_complete_tasks();
?>
<!DOCTYPE html>
<html lang='ja'>
    <?php include_once __DIR__ . '/_head.html' ?>
<body>
    <div class="wrapper">
        <h1 class="title">学習管理アプリ</h1>
        <div class="form-area">
            <!-- エラーが発生した場合、エラーメッセージを出力 -->
            <?php if ($errors) echo (create_err_msg($errors)) ?>
            <form action="" method="post">
                <label for="title">学習内容</label>
                <input type="text" name="title">
                <label for="due_date">期限日</label>
                <input type="date" name="due_date">
                <input type="submit" class="btn submit-btn" value="追加">
            </form>
        </div>
        <div class="incomplete-area">
            <h2 class="sub-title">未達成</h2>
            <!-- 表エリア(未達成) -->
            <table class="plan-list">
                <thead>
                    <tr>
                        <th class="plan-title">学習内容</th>
                        <th class="plan-due-date">完了期限</th>
                        <th class="done-link-area"></th>
                        <th class="edit-link-area"></th>
                        <th class="delete-link-area"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($incomplete_tasks as $task): ?>
                        <tr>
                            <td><?=h($task['title'])?></td>
                            <!-- 現在の日付と完了期限日の比較 -->
                            <?php if($ymd >= $task['due_date']): ?>
                                <td class="expired"><?=h(date('Y/m/d', strtotime($task['due_date'])))?></td>
                            <?php else: ?>
                                <td><?=h(date('Y/m/d', strtotime($task['due_date'])))?></td>
                            <?php endif; ?>
                            <td><a href="done.php?id=<?=h($task['id'])?>" class="btn done-btn">完了</a></td>
                            <td><a href="edit.php?id=<?=h($task['id'])?>" class="btn edit-btn">編集</a></td>
                            <td><a href="delete.php?id=<?=h($task['id'])?>" class="btn delete-btn">削除</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- 表エリア(完了) -->
        <div class="complete-area">
            <h2 class="sub-title">完了</h2>
            <table class="plan-list">
                <thead>
                    <tr>
                        <th class="plan-title">学習内容</th>
                        <th class="plan-completion-date">完了日</th>
                        <th class="done-link-area"></th>
                        <th class="edit-link-area"></th>
                        <th class="delete-link-area"></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- 完了済のデータを表示 -->
                    <?php foreach($complete_tasks as $task): ?>
                        <tr>
                            <td><?=h($task['title'])?></td>
                            <td><?=h(date('Y/m/d', strtotime($task['completion_date'])))?></td>
                            <td><a href="done_cancel.php?id=<?=h($task['id'])?>" class="btn incom-btn">未完了</a></td>
                            <td><a href="edit.php?id=<?=h($task['id'])?>" class="btn edit-btn">編集</a></td>
                            <td><a href="delete.php?id=<?=h($task['id'])?>" class="btn delete-btn">削除</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>