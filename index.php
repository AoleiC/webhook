<?php

error_reporting(E_ALL & ~E_NOTICE);  //error_reporting(0);

/*
* 输出到文件
* param string $data 字符串
*/
function console($data)
{
    $myfile = fopen("console.log", "a") or die("Unable to open file!");
    fwrite($myfile, date('Y-m-d H:i:s  ') . "\n");
    fwrite($myfile, $data . "\n");
    fclose($myfile);
}

$token = $_REQUEST['token'];
$type = $_REQUEST['type'];

// 配置执行的 shell 脚本
$config = [
    'code' => 'sh code.sh',
    'docker' => 'cd /data/shell && sh docker.sh'
];

// 简单 token 验证，根据需要修改
if ($token !== '7b6a7a9c8066859f69ee5019b3675869') {
    console('error token');
    exit();
}

if (!$type || !$config[$type]) {
    console('error type' . $type);
    exit();
}

if (function_exists('shell_exec')) {
    $output = shell_exec($config[$type]);
    console($output);
    console($_SERVER['REMOTE_ADDR'] . ":" . $_SERVER['REMOTE_PORT'] . " " . $_SERVER['REQUEST_URI']);
    echo 'success';
}

