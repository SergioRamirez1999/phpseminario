<?php
interface LikeDao {
    public function findById($id);
    public function save($like);
    public function update($like);
    public function delete($id);
    public function isLiked($id_user, $id_message);
}
?>

