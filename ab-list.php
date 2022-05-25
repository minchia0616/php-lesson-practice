<?php require __DIR__ . '/parts/connect-db.php';

$perPage = 20;  // 設定每一頁的資料數

// 用戶要看第幾頁
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;       //表單沒特別設定就是$_GET的方法，有設定就轉換成整數，沒有就從1開始
if ($page < 1) {
    header('Location: ?page=1');                                //頁數小於1的話還是導向第一頁
    exit;
}

$t_sql = "SELECT COUNT(1) FROM `address_book`";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$totalPages = ceil($totalRows / $perPage);                      //總共幾筆除以一頁20筆，無條件進位得到總共有幾頁

$rows = [];                                                     //給定預設值

if( $totalRows > 0){
    if( $page > $totalPages ){                                  //若頁碼超過總頁數，導向最後一頁
        header("Location: ?page=$totalPages");
        exit;
    }

    $sql = sprintf("SELECT * FROM address_book LIMIT %s, %s", ($page - 1) * $perPage, $perPage);    //索引,幾筆 第二頁的索引從20開始，第三頁40開始...每頁取20筆資料
    $rows = $pdo->query($sql)->fetchAll();                      //索引式陣列
}


?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>

<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?= $page==1 ? 'disable' : '' ?>">                 
                        <a class="page-link" href="?page=1">
                            <i class="fa-solid fa-angles-left"></i>
                        </a>
                    </li>
                    <li class="page-item $page==1 ? 'disable' : '' ?> ">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">
                            <i class="fa-solid fa-angle-left"></i>
                        </a>
                    </li>

                    <?php for( $i = $page-5  ; $i <= $page + 5 ; $i++ ):                    //只顯示往前和往後的5頁
                        if ($i >= 1 and $i <= $totalPages) : ?>
                            <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"> <?= $i  ?></a>
                            </li>
                        <?php endif; 
                    endfor; ?>

                    
                    <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">
                            <i class="fa-solid fa-angle-right"></i>
                        </a>
                    </li>
                    <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $totalPages ?>">
                            <i class="fa-solid fa-angles-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>


    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th scope="col"><i class="fa-solid fa-trash-can"></i></th>
                <th scope="col">#</th>
                <th scope="col">姓名</th>
                <th scope="col">手機</th>
                <th scope="col">信箱</th>
                <th scope="col">生日</th>
                <th scope="col">地址</th>
                <th scope="col"><i class="fa-solid fa-pen-to-square"></i></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr>
                    <td>
                        <a href="#"><i class="fa-solid fa-trash-can"></i></a>
                    </td>
                    <td><?= $r['sid'] ?></td>
                    <td><?= $r['name'] ?></td>
                    <td><?= $r['mobile'] ?></td>
                    <td><?= $r['email'] ?></td>
                    <td><?= $r['birthday'] ?></td>
                    <td><?= $r['address'] ?></td>
                    <td>
                        <a href="#"><i class="fa-solid fa-pen-to-square"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<?php include __DIR__ . '/parts/scripts.php' ?>
<?php include __DIR__ . '/parts/html-foot.php' ?>