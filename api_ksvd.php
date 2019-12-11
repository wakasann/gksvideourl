<?php 
header("Content-type:application/json;charset=utf-8");
header("Access-Control-Allow-Origin: * ");
$result = array(
	'state_code' => 0,
	'data' =>  array(),
	'message' => '默认错误消息'
);
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['share_url']) && !empty($_POST['share_url'])){
	$shareUrl = $_POST['share_url'];
	$share_pattern = '/https{0,1}:\/\/[A-Za-z0-9_.\/]+(\s?)/';
	preg_match($share_pattern,$shareUrl,$matches);
	
	//$index = strpos($shareUrl, 'http://www.gifshow.com/s/');
	if(is_array($matches) && count($matches) >0 && strpos($matches[0], 'http') === 0){
		$shareUrl = $matches[0];
		require_once 'common/tool.php';
		require_once 'common/whttp.php';
		$tool = new Tool();
		$httpClient = new WHttp();
		$rules = $tool->setSplitRules(2);
		$response = $httpClient->getFound($shareUrl);
		$stringBody = (string) $response;
		$playUrl = $tool->getPlayUrlByPregMatch($stringBody);
		if(strpos($playUrl, 'http') === 0){
			$result['state_code'] = 1;
			$result['data'] = array(
				'url' => $playUrl
			);
			$result['message'] = '解析成功,嘿嘿嘿~~';
		}else{
			$result['message'] =  '抱歉，解析失败T_T';
		}
	}else{
		$result['message'] =  '可能不是快手分享链接，解析失败咯';
	}
}else if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)){
	$result['message'] =  "无效的请求,嘿嘿嘿！";
}

echo json_encode($result);