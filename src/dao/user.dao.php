<?php

interface UserDao {
    public function findById($id, $full);
    public function findByUsername($username, $full);
    public function findByUsernameAndPassword($username, $password, $full);
    public function save($user);
    public function update($user, $field, $value);
    public function delete($id);
    public function getFollowings($id);
    public function getFollowers($id);
    public function getPaginationMessages($id, $origin, $rows);
    public function getAllMessages($id);
}

?>