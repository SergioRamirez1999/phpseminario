<?php

interface UserDao {
    public function findById($id, $full);
    public function findByUsername($username, $full);
    public function findByCriteria($keyword);
    public function save(User $user);
    public function update($user, $field, $value);
    public function uploadImage($id, $image_content, $image_type);
    public function delete($id);
    public function getFollowings($id);
    public function getFollowers($id);
    public function getPaginationMessages($id, $origin, $rows, $imagesMandatory);
    public function getAllMessages($id);
    public function findTrending($rows, $full);
}