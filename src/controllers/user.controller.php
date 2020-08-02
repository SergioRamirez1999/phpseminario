<?php
require_once ROOT_DIR."/models/dao/sql/sqldao.factory.php";
require_once ROOT_DIR."/models/dao/sql/user.imp.php";

class UserController {

    private $userDao;

    public function __construct(){
        $daoFactory = new SqlDaoFactory();
        $this->userDao = $daoFactory->createUserDao();
    }

    public function getById($id, $full=false){
        $response = $this->userDao->findById($id,$full);
        return $response;
    }

    public function getByUsername($username, $full=false){
        $response = $this->userDao->findByUsername($username, $full);
        return $response;
    }

    public function getByCriteria($keyword){
        $keyword = '%'.$keyword.'%';
        $response = $this->userDao->findByCriteria($keyword);
        return $response;
    }

    public function save(User $user){
        $response = $this->userDao->save($user);
        return $response;
    }

    public function update($user, $field, $value){
        $response = $this->userDao->update($user, $field, $value);
        return $response;
    }

    public function delete($id){
        $response = $this->userDao->delete($id);
        return $response;
    }

    public function uploadImage($id, $image_content, $image_type){
        $response = $this->userDao->uploadImage($id, $image_content, $image_type);
        return $response;
    }

    public function getFollowings($id){
        $response = $this->userDao->getFollowings($id);
        return $response;
    }

    public function getFollowers($id){
        $response = $this->userDao->getFollowers($id);
        return $response;
    }

    public function getPaginationMessages($id, $origin=0, $rows=10, $imagesMandatory=false){
        $response = $this->userDao->getPaginationMessages($id, $origin, $rows, $imagesMandatory);
        return $response;
    }

    public function getAllMessages($id){
        $response = $this->userDao->getAllMessages($id);
        return $response;
    }

    public function getTrending($rows=3, $full=false){
        $response = $this->userDao->findTrending($rows, $full);
        return $response;
    }
   
}