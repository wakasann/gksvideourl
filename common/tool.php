<?php

class Tool{

    private $firstFilterStr = 'window.VUE_MODEL_INIT_STATE.shortVideoComment={"work":';
    private $secondFilterStr = '"comment"';

    public function setFirstFilterStr($firstFilterStr){
        $this->firstFilterStr = $firstFilterStr;
    }

    public function setSecondFilterStr($secondFilterStr){
        $this->secondFilterStr = $secondFilterStr;
    }

    public function getPlayUrl($htmlContent){
        $firstIndex = strpos($htmlContent,$this->firstFilterStr);
        try{
            if($firstIndex !== false){
                $deleteBeforeContent = substr($htmlContent,$firstIndex+strlen($this->firstFilterStr));
                var_dump( $deleteBeforeContent);
                $commentIndex = strpos($deleteBeforeContent,$this->secondFilterStr);
                if($commentIndex !== false){
                    $listContent = substr($deleteBeforeContent,0,$commentIndex-1);
                    $list = json_decode($listContent);
                    if($list !== false){
                        return $list->list[0]->playUrl;
                    }
                }
            }
        }catch (\Exception $e){

        }
        return "";
    }

}