<?php

interface FollowingDao {
    public function findById($id);
    public function save($following);
    public function update($following);
    public function delete($id);
    public function isFollowing($id_user_owner, $id_user_host);
}

?>