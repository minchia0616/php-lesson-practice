<?php
require __DIR__ . '/parts/connect-db.php';
header('Content-Type: application/json');

$output = [
    'success' => false,
    'postData' => $_POST,
    'code' => 0,
    'error' => ''
];

$sid = isset($_POST['sid']) ? intval($_POST['sid']) : 0;

// TODO: 欄位檢查, 後端的檢查
if (empty($sid) or empty($_POST['name'])) {             //姓名必填
    $output['error'] = '沒有姓名資料';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$name = $_POST['name'];
$email = $_POST['email'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$birthday = empty($_POST['birthday']) ? NULL : $_POST['birthday'];
$address = $_POST['address'] ?? '';

if (!empty($email) and filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    $output['error'] = 'email 格式錯誤';
    $output['code'] = 405;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}


// 修改的sql語法
$sql = "UPDATE `address_book` SET `name`=?, `email`=?, `mobile`=?, `birthday`=?, `address`=? WHERE `sid`=$sid ";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $name,
    $email,
    $mobile,
    $birthday,
    $address,
]);

// rowCount()檢視有沒有修改，sql會執行，但都沒有修改的話rowCount會拿到0(沒有欄位變更)
if ($stmt->rowCount() == 1) {
    $output['success'] = true;
} else {
    $output['error'] = '資料沒有修改';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
