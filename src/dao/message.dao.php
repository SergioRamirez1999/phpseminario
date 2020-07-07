<?php

interface MessageDao {
    public function findById($id);
    public function save($message);
    public function update($message);
    public function delete($id);
    public function getPagination($id_owner, $origin, $rows);
    public function getLikesMessage($id);
}

?>