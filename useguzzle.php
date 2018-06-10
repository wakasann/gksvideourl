<?php
//如果可以运行 composer install,可以重命名该文件名为index.php
require 'vendor/autoload.php';
require_once 'common/tool.php';
use GuzzleHttp\Client;

$tool = new Tool();


function debugShow($content,$title = ''){
    echo "{$title}{$content}<br/>";
}

$videoUrl = 'http://www.gifshow.com/s/okV1-SYD'; //test link

$client = new Client([
    // You can set any number of default request options.
    'timeout'  => 2.0,
]);
$response = $client->request('GET',$videoUrl);
$code = $response->getStatusCode(); // 200
$reason = $response->getReasonPhrase(); // OK

$body = $response->getBody();
$stringBody = (string) $body;
$playUrl = $tool->getPlayUrl($stringBody);
debugShow($playUrl);

//$log_file = 'request.log2';
//Analog::handler (Analog\Handler\File::init ($log_file));
//Analog::log ($stringBody, Analog::WARNING);
// Implicitly cast the body to a string and echo it
//debugShow($body,'Body');
// Explicitly cast the body to a string
//$stringBody = (string) $body;
// Read 10 bytes from the body
//$tenBytes = $body->read(10);
// Read the remaining contents of the body as a string
//$remainingBytes = $body->getContents();