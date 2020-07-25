<?php
interface MessageDao {
    public function findById($id);
    public function save(Message $message);
    public function update(Message $message);
    public function delete($id);
    public function getCountLikes($id);
    public function findTrending($rows);
    public function getPaginationFromFollowings($id_user, $origin, $rows);
    public function getPaginationLiked($id_user, $origin, $rows);
}