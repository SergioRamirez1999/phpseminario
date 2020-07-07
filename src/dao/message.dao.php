<?php

interface MessageDao {
    public function findById($id);
    public function save($message);
    public function update($message);
    public function delete($id);
    public function getCountLikes($id);
}

?>