<?php
require_once ROOT_DIR."/models/dao/sql/sqldao.factory.php";
require_once ROOT_DIR."/models/dao/sql/message.imp.php";

class MessageController {

    private $messageDao;

    public function __construct(){
        $daoFactory = new SqlDaoFactory();
        $this->messageDao = $daoFactory->createMessageDao();
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

    public function getPaginationFromFollowings($id_user, $origin=0, $rows=10){
        $response = $this->messageDao->getPaginationFromFollowings($id_user, $origin, $rows);
        return $response;
    }

    public function getPaginationLiked($id_user, $origin=0, $rows=10){
        $response = $this->messageDao->getPaginationLiked($id_user, $origin, $rows);
        return $response;
    }


    public function getTrending($rows=3){
        $response = $this->messageDao->findTrending($rows);
        return $response;
    }

}