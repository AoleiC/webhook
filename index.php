<?php

error_reporting(E_ALL & ~E_NOTICE);  //error_reporting(0);

/*
* 输出到文件
* param string $data 字符串
*/
function console($data) {
	if(!$data) return;
    $myfile = fopen("console.log", "a") or die("Unable to open file!");
    fwrite($myfile, date('Y-m-d H:i:s  ') . "\n");
    fwrite($myfile, $data . "\n");
    fclose($myfile);
}

function end_line() {
	$myfile = fopen("console.log", "a") or die("Unable to open file!");
    fwrite($myfile, "-------------------↑↑ end ↑↑---------------------------\n\n");
    fclose($myfile);
	exit();
}

$token = $_REQUEST['token'];
$type = $_REQUEST['type'];

console(json_encode($_SERVER));

// 配置执行的 shell 脚本
$config = [
    'code' => 'sh test.sh',
    'docker' => 'cd /data/shell && sh docker.sh'
];

// 简单 token 验证，根据需要修改
if ($token !== '7b6a7a9c8066859f69ee5019b3675869') {
    console('error token ' . $token);
	echo date('Y-m-d H:i:s') + ' error token';
	end_line();
}

if (!$type || !$config[$type]) {
    console('error type ' . $type);
	echo date('Y-m-d H:i:s') + ' error type';
	end_line();
}

if (function_exists('shell_exec')) {
    $output = shell_exec($config[$type]);
    console($output);
    console($_SERVER['REMOTE_ADDR'] . ":" . $_SERVER['REMOTE_PORT'] . " " . $_SERVER['REQUEST_URI']);
	echo date('Y-m-d H:i:s') + ' success';
	end_line();
}

