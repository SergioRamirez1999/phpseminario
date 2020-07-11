<?php
interface LikeDao {
    public function findById($id);
    public function save(Like $like);
    public function update(Like $like);
    public function delete($id);
    public function deleteByFks($id_user, $id_message);
    public function deleteByMessageId($id_message);
    public function isLiked($id_user, $id_message);
}
?>

