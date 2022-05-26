<?php
$json = file_get_contents('./forms-api.json'); // 讀取檔案，第一個參數放檔名
$data = json_decode($json, true);              // 讀取到的是字串，轉換成原生類型，使用關聯式陣列所以參數給定true的話會得到陣列(false會是object)


$hobbies = [
    '3' => '游泳',
    '5' => '爬山',
    '6' => '畫圖',
    '9' => '慢跑',
];



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">

                <form name="form1" onsubmit="sendData();return false;">
                    <div class="mb-3">
                        <label for="" class="form-label">嗜好 1</label>
                        <!-- combobox -->
                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" data-multiple name="hobby1">
                            <option value="" selected disabled>-- 請選擇 --</option>

                            <!-- 使用後端的方式將資料呈現回頁面 -->
                            <?php foreach ($hobbies as $k => $v) : ?>
                                <option value="<?= $k ?>" <?= $data['postData']['hobby1'] == $k ? 'selected' : '' ?>><?= $v ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">嗜好 2</label>
                        <?php foreach ($hobbies as $k => $v) : ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="hobby2" id="hobby2-<?= $k ?>" value="<?= $k ?>" <?= $data['postData']['hobby2'] == $k ? 'checked' : '' ?>>
                                <label class="form-check-label" for="hobby2-<?= $k ?>">
                                    <?= $v ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">嗜好 3</label>
                        <?php foreach ($hobbies as $k => $v) : ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="hobby3[]" value="<?= $k ?>" id="hobby3-<?= $k ?>" <?= in_array($k, $data['postData']['hobby3']) ? 'checked' : '' ?>>  <!-- hobby3是陣列，用in_array判斷$k有沒有在陣列裡 -->
                                <label class="form-check-label" for="hobby3-<?= $k ?>">
                                    <?= $v ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!--
                    <button type="submit" class="btn btn-primary">Submit</button>
                        -->
                </form>
            </div>
        </div>



    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>