<?php require __DIR__ . '/parts/connect-db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (!empty($sid)) {                                             // 如果是空字串就不做，不是的話做刪除動作
    $pdo->query("DELETE FROM `address_book` WHERE sid=$sid");
}

$come_from = 'ab-list.php';                                     // REFERER會告訴server端，現在拜訪的是透過哪個頁面連過來的(預設一個變數回第一個列表頁)
if (!empty($_SERVER['HTTP_REFERER'])) {
    $come_from = $_SERVER['HTTP_REFERER'];
}

header("Location: $come_from");                                 // 從哪來從哪回去