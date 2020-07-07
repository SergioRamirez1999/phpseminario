<?php

require_once "./dao/imp/user.imp.php";

class UserController {

    private $userDao;

    public function __construct(){
        $this->userDao = new UserDaoImp();
    }

    public function getById($id, $full=false){
        $response = $this->userDao->findById($id,$full);
        return $response;
    }

    public function getByUsername($username, $full=false){
        $response = $this->userDao->findByUsername($username, $full);
        return $response;
    }

    public function getByUsernameAndPassword($username, $password, $full=false){
        $response = $this->userDao->findByUsernameAndPassword($username, $password, $full);
        return $response;
    }

    public function save($user){
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

    public function getFollowings($id){
        $response = $this->userDao->getFollowings($id);
        return $response;
    }

    public function getFollowers($id){
        $response = $this->userDao->getFollowers($id);
        return $response;
    }

    public function getPaginationMessages($id, $origin=0, $rows=10){
        $response = $this->userDao->getPaginationMessages($id, $origin, $rows);
        return $response;
    }

    public function getAllMessages($id, $origin=0, $rows=10){
        $response = $this->userDao->getAllMessages($id, $origin, $rows);
        return $response;
    }
   
}
?>