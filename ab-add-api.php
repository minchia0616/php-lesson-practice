<?php
require __DIR__ . '/parts/connect-db.php';
header('Content-Type: application/json');

$output = [
    'success' => false,     //預設沒有新增成功
    'postData' => $_POST,   //把前端丟到後端的資料再丟回去
    'error' => ''
];

// TODO: 欄位檢查, 後端的檢查

$sql = "INSERT INTO `address_book`(
    `name`, `mobile`, `email`, 
    `birthday`, `address`, `created_at`
    ) VALUES (
        ?, ?, ?,
        ?, ?, NOW()
    )";

$stmt = $pdo->prepare($sql);

$stmt->execute([            //真正的執行新增資料
    $_POST['name'],
    $_POST['mobile'],
    $_POST['email'],
    empty($_POST['birthday']) ? NULL : $_POST['birthday'],
    $_POST['address'],
]);


if ($stmt->rowCount() == 1) {
    $output['success'] = true;          //成功新增
} else {
    $output['error'] = '資料無法新增';
}



echo json_encode($output, JSON_UNESCAPED_UNICODE);
