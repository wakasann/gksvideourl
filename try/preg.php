<?php
$filePath = dirname(dirname(__FILE__));
$content = file_get_contents($filePath.'/request.log');
require $filePath.'/vendor/autoload.php';
$findStr = 'window.VUE_MODEL_INIT_STATE.shortVideoComment={"work":';
$commitFindStr = '"comment"';
$index = strpos($content,$findStr);
var_dump($index);
$afterContent = substr($content,$index+strlen($findStr));//去除掉 $findStr前面的内容
$commentIndex = strpos($afterContent,$commitFindStr);
var_dump($commentIndex);
$afterContent2 = substr($afterContent,0,$commentIndex-1);
$list = json_decode($afterContent2);
var_dump($list->list[0]->playUrl);

//$log_file = date('ymdHis').'.log';
//Analog::handler (Analog\Handler\File::init ($log_file));
//Analog::log ($afterContent, Analog::DEBUG);
//Analog::log ($afterContent2, Analog::DEBUG);


