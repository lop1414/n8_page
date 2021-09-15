<?php
include "./function.php";
// 跳快应用
$logidUrl = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$ip = getIp();
$ua = $_SERVER["HTTP_USER_AGENT"];


$reportUrl = 'https://n8-adv-bd.7788zongni.com/front/forward_click?';
$param = [
    'sign'=> '87a47565be4714701a8bc2354cbaea36',
	'ip' => $ip,
	'ua' => $ua,
	'ts' => time() .'000',
	'link' => $logidUrl
];

$reportUrl .= http_build_query($param);
$ret = file_get_contents($reportUrl);


$url = urldecode($_GET['url']);
header("Location: {$url}");
