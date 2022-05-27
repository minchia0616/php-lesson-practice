<?php require __DIR__ . '/parts/connect-db.php';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (!empty($sid)) {                                             //如果是空字串就不做，不是的話做刪除動作
    $pdo->query("DELETE FROM `address_book` WHERE sid=$sid");
}

header("Location: ab-list.php");
