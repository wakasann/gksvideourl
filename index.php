<!DOCTYPE html>
<html>
<head>
	<title>快手分享视频解析</title>
	<meta charset="utf-8">
	<meta keyword="快手视频解析,wakasann">
	<meta name="description" content="获取快手分享之后的MP4视频链接，如果想保存，使用解析之后的该Mp4链接下载即可">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
	<link href="https://cdn.bootcss.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">

  <nav class="navbar navbar-light bg-light">
    <span class="navbar-text">
     获取快手分享之后的短链接MP4的链接,<a href="https://github.com/wakasann/gksvideourl" target="_blank">在Github中的地址</a>
    </span>
  </nav>

  <form method="post" action="./">
	  <div class="form-group">
	    <label for="share_url">分享链接</label>
	    <input type="text" name="share_url" class="form-control" id="share_url" aria-describedby="urlHelp" placeholder="http://www.gifshow.com/s/2ZRF0mcz">
	    <small id="urlHelp" class="form-text text-muted">是在快手中点击分享，复制链接之后的地址哦^-^</small>
	  </div>
	  <button type="submit" class="btn btn-primary">送出</button>
	</form>
	<?php if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST) && !empty($_POST['share_url'])){
		$shareUrl = $_POST['share_url'];
		$index = strpos($shareUrl, 'http://www.gifshow.com/s/');
		if($index === 0){
			require_once 'common/tool.php';
			require_once 'common/whttp.php';
			$tool = new Tool();
			$httpClient = new WHttp();
			$rules = $tool->setSplitRules(2);
			$response = $httpClient->getFound($shareUrl);
			$stringBody = (string) $response;
			$playUrl = $tool->getPlayUrlByPregMatch($stringBody);
			if(strpos($playUrl, 'http') === 0){
				echo "<br/>";
				echo '<a href="'.$playUrl.'" target="_blank" title="视频链接">'.$playUrl.'</a>';
				?>
				<br/>
				<br/>
				<video src="<?php echo $playUrl; ?>" controls="controls" style="max-width: 100%;">
				您的浏览器不支持 video 标签。
				</video>
			<?php
				
				
			}else{
				echo '抱歉，解析失败T_T';
			}
		}else{
			echo '不是快手分享链接，解析失败咯';
		}

	}else if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)){
		echo "胸弟，你还没有填地址就送出啦，这很不友好呀！";
	}?>

	<div></div>
</div>


</body>
</html>
