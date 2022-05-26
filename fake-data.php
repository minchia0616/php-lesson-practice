<div>
    <?php require __DIR__ . '/parts/connect-db.php';
    echo microtime(true) . "<br>";

    $lname = ['陳', '林', '李', '吳', '王'];
    $fname = ['小黑', '小白', '冠宇', '怡君', '玥'];

    $sql = "INSERT INTO `address_book`(`name`, `email`, `mobile`, 
    `birthday`, `address`, `create-at`) VALUES (
        ?,?,?,
        ?,?,NOW()
    )";

    $stmt = $pdo->prepare($sql);

    for( $i = 0 ; $i < 500 ; $i++ ){
        shuffle($lname);                        // 打亂姓名排列
        shuffle($fname);
        $ts = rand(strtotime('1988-01-01'), strtotime('2000-12-31'));
        $stmt->execute([
            $lname[0] . $fname[0],              // 固定取隨機的第一筆          
            "ming{$i}@test.com",
            '0918' . rand(100000, 999999),      //6位數字隨機
            date('Y-m-d', $ts),
            '台北市',
        ]);

    }

    echo microtime(true) . "<br>";
    ?>
</div>