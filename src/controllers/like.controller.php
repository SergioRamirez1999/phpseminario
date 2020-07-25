<?php
require_once ROOT_DIR."/dao/imp/like.imp.php";

class LikeController {

    private $likeDao;

    public function __construct(){
        $this->likeDao = new LikeDaoImp();
    }

    public function getById($id){
        $response = $this->likeDao->findById($id);
        return $response;
    }

    public function save($like){
        $response = $this->likeDao->save($like);
        return $response;
    }

    public function update($like){
        $response = $this->likeDao->update($like);
        return $response;
    }

    public function delete($id){
        $response = $this->likeDao->delete($id);
        return $response;
    }

    public function deleteByFks($id_user, $id_message){
        $response = $this->likeDao->deleteByFks($id_user, $id_message);
        return $response;
    }

    public function deleteByMessageId($id_message){
        $response = $this->likeDao->deleteByMessageId($id_message);
        return $response;
    }

    public function isLiked($id_user, $id_message){
        $response = $this->likeDao->isLiked($id_user, $id_message);
        return $response;
    }
}