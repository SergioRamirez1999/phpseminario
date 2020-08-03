<?php
require_once ROOT_DIR."/models/dao/mysql/sqldao.factory.php";
require_once ROOT_DIR."/models/dao/mysql/following.imp.php";

class FollowingController {

    private $followingDao;

    public function __construct(){
        $daoFactory = new SqlDaoFactory();
        $this->followingDao = $daoFactory->createFollowingDao();
    }

    public function getById($id){
        $response = $this->followingDao->findById($id);
        return $response;
    }

    public function save($following){
        $response = $this->followingDao->save($following);
        return $response;
    }

    public function update($following){
        $response = $this->followingDao->update($following);
        return $response;
    }

    public function delete($id){
        $response = $this->followingDao->delete($id);
        return $response;
    }

    public function deleteByFks($id_user, $id_user_following_fk){
        $response = $this->followingDao->deleteByFks($id_user, $id_user_following_fk);
        return $response;
    }

    public function isFollowing($id_user, $id_user_following_fk){
        $response = $this->followingDao->isFollowing($id_user, $id_user_following_fk);
        return $response;
    }
}