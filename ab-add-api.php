<?php
require __DIR__ . '/parts/connect-db.php';
header('Content-Type: application/json');

$output = [
    'success' => false,         //預設沒有新增成功
    'postData' => $_POST,       //把前端丟到後端的資料再丟回來
    'code' => 0,                //用來除錯的(自訂)
    'error' => ''
];

// TODO: 欄位檢查, 後端的檢查
if (empty($_POST['name'])) {
    $output['error'] = '沒有姓名資料';                      //沒有填姓名的話直接結束
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

//先處理過變數，姓名必填，其他若沒給的話就給''，生日可以是空值，若為空值就拿NULL 不是的話就拿填入的值
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
// TODO: 其他欄位檢查


$sql = "INSERT INTO `address_book`(
    `name`, `email`, `mobile`, 
    `birthday`, `address`, `create-at`
    ) VALUES (
        ?, ?, ?,
        ?, ?, NOW()
    )";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $name,
    $email,
    $mobile,
    $birthday,
    $address,
]);


if ($stmt->rowCount() == 1) {
    $output['success'] = true;
    // 最近新增資料的 primery key
    $output['lastInsertId'] = $pdo->lastInsertId();
} else {
    $output['error'] = '資料無法新增';
}
// isset() vs empty()


echo json_encode($output, JSON_UNESCAPED_UNICODE);
