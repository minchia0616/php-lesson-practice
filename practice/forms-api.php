<?php

$output = [
    'postData' => $_POST,
];

$json = json_encode($output, JSON_UNESCAPED_UNICODE);
file_put_contents('./a20220526-02-forms-api.json', $json);  // JSON 字串存成檔案

echo $json;
