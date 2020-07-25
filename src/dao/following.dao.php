<?php
interface FollowingDao {
    public function findById($id);
    public function save(Following $following);
    public function update(Following $following);
    public function delete($id);
    public function deleteByFks($id_user, $id_user_following_fk);
    public function isFollowing($id_user_owner, $id_user_host);
}