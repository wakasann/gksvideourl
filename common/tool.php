<?php

class Tool{

    private $firstFilterStr = 'window.VUE_MODEL_INIT_STATE.shortVideoComment={"work":';
    private $secondFilterStr = '"comment"';

    private $splitRulesIndex = 0;
    private $splitRules = array();

    public function __construct(){
        $this->splitRules = array(
        array(
            'firstFilter' => 'window.VUE_MODEL_INIT_STATE.shortVideoComment={"work":',
            'secondFilter' => '"comment"',
            'secondEndIndex' => function($index){
                return $index-1;
            },
            'playUrl' => function($list){
                return $list->list[0]->playUrl;
            }
        ),
        array(
            'firstFilter' => 'window.VUE_MODEL_INIT_STATE.profileGallery=',
            'secondFilter' => '"replyToUserName":""}};',
            'secondEndIndex' => function($index){
                return $index+strlen('"replyToUserName":""}};')-1;
            },
            'playUrl' => function($list){
                return $list->work->currentWork->playUrl;
            }
        ),
        array(
            'firstFilter' => 'window.VUE_MODEL_INIT_STATE[\'profileGallery\']=',
            'secondFilter' => '账号封禁"};',
            'secondEndIndex' => function($index){
                return $index+strlen('账号封禁"};')-1;
            },
            'playUrl' => function($list){
                return $list->work->currentWork->playUrl;
            }
        )
    );
    }

    public function setFirstFilterStr($firstFilterStr){
        $this->firstFilterStr = $firstFilterStr;
    }

    public function setSecondFilterStr($secondFilterStr){
        $this->secondFilterStr = $secondFilterStr;
    }

    public function setSplitRules($ruleIndex){
        if(!array_key_exists($ruleIndex, $this->splitRules)){
            //使用最后一个
            $ruleIndex = count($this->splitRules) - 1;
        }
        $this->splitRulesIndex = $ruleIndex;
        $this->setFirstFilterStr($this->splitRules[$ruleIndex]['firstFilter']);
        $this->setSecondFilterStr($this->splitRules[$ruleIndex]['secondFilter']);
    }

    public function getPlayUrl($htmlContent){
        $firstIndex = strpos($htmlContent,$this->firstFilterStr);
        try{
            if($firstIndex !== false){
                $deleteBeforeContent = substr($htmlContent,$firstIndex+strlen($this->firstFilterStr));
                $commentIndex = strpos($deleteBeforeContent,$this->secondFilterStr);
                if($commentIndex !== false){
                    $endIndex = $this->splitRules[$this->splitRulesIndex]['secondEndIndex']($commentIndex);
                    $listContent = substr($deleteBeforeContent,0,$endIndex);
                    $list = json_decode($listContent);
                    if($list !== false && !empty($list)){
                        return $this->splitRules[$this->splitRulesIndex]['playUrl']($list);
                        //return $list->list[0]->playUrl;
                    }
                }
            }
        }catch (\Exception $e){
            return "";
        }
        return "";
    }

    public function getPlayUrlByPregMatch($htmlContent){
        $videoRegex = "/<video .*? id=\"video-player\".*?>.*?<\/video>/ism"; 
        $videoSrcRegex = "/<video (.*?) src=\"(.+?)\".*?>/ism"; 
        // preg_match($videoSrcRegex,$htmlContent, $matcheVideo2);
        // echo "<pre>";
        // print_r($matcheVideo2);
        // echo "</pre>";
        if(preg_match($videoRegex, $htmlContent, $matcheVideo)){
           if(!isset($matches[0])){
                preg_match($videoSrcRegex, $matcheVideo[0], $videoSrc);
                $count = count($videoSrc)-1;
                $videoValue = $videoSrc[$count];
                if(!empty($videoValue)){
                    return trim($videoValue);
                }else{
                    return '';
                }
           }else{
            return '';
           }
        }else{  
           return '';  
        }
    }

}