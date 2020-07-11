<?php

require_once ROOT_DIR."/dao/imp/message.imp.php";

class MessageController {

    private $messageDao;

    public function __construct(){
        $this->messageDao = new MessageDaoImp();
    }

    public function getById($id){
        $response = $this->messageDao->findById($id);
        return $response;
    }

    public function save($message){
        $response = $this->messageDao->save($message);
        return $response;
    }

    public function update($message){
        $response = $this->messageDao->update($message);
        return $response;
    }

    public function delete($id){
        $response = $this->messageDao->delete($id);
        return $response;
    }

    public function getCountLikes($id){
        $response = $this->messageDao->getCountLikes($id);
        return $response;
    }

    public function getPaginationFromFollowings($id, $origin=0, $rows=10){
        $response = $this->messageDao->getPaginationFromFollowings($id, $origin, $rows);
        return $response;
    }

}

?>