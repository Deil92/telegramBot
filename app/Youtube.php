<?php 
namespace app;

class Youtube {
    private $token = "Youtube_token";
    public $url;
    public $maxresult = 20;
    public $videoListByNone;
    public $videoListByDate;
    public function __construct(){
        $this->url = "https://www.googleapis.com/youtube/v3/videos?key=" . $this->token . "&part=snippet&maxResults=" . $this->maxresult . "&chart=mostPopular";
        $this->videoListByNone = json_decode(file_get_contents($this->url));
        return $videoList;
        $this->videoListByDate = json_decode(file_get_contents($this->url . "&order=date"));
    }
    /*public function orderByViewCount(){
        $urlByViewCount = $this->url . "&order=viewCount";
        return $this->preparedVideoList($this->videoList($urlByViewCount));
    }*/
    public function manager($sort , array $tags = 0){
        if($tags == 0){
            
        }
        switch($sort){
            case 0 : 
                return preparedVideoList($this->videoListByNone);
                break;
            case 1 :
                return preparedVideoList($this->videoListByDate);
                break;
            case 2 : 
                return preparedVideoListbyTags($this->videoListByNone);
        }
    }
    
    public function preparedVideoList($video){
        $videoMassive;
        for($i = 0; $i < 20 ; $i++){
            $videoMassive[$i]["name"] = $video->items[$i]->snippet->title;
            $videoMassive[$i]["url"] = "https://www.youtube.com/watch?v=" . $video->items[$i]->id;
        }
        return $videoMassive;
    }
}