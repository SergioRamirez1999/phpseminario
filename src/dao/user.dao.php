<?php

interface UserDao {
    public function findById($id);
    public function findByUsername($username);
    public function findUserByUsernameAndPassword($username, $password);
    public function save($user);
    public function update($user);
    public function delete($id);
    public function getFollowings($id);
    public function getFollowers($id);
    public function getMessages($id);
}

?>