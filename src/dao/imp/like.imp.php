<?php

require_once "./dao/like.dao.php";

require_once "./models/connection.php";

require_once "./models/like.entity.php";


class LikeDaoImp implements LikeDao {

    const USERS_TABLENAME = "usuarios";
    const MESSAGES_TABLENAME = "mensaje";
    const FOLLOWINGS_TABLENAME = "siguiendo";
    const LIKES_TABLENAME = "me_gusta";

    public function findById($id){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("SELECT * FROM ".self::LIKES_TABLENAME." `l` WHERE `l`.`id` = :likeId");

        $stmt -> bindParam(":likeId", $id, PDO::PARAM_INT);


        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        while($temp = $stmt->fetch()){
            $like = new Like($temp["id"],$temp["usuarios_id"],$temp["id_message_fk"]);
        }

        return $like;

        $stmt -> close();

        $stmt = null;
    }

    public function save($like){

        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("INSERT INTO ".self::LIKES_TABLENAME." (`usuarios_id`, `mensaje_id`) VALUES (:id_user_fk, :id_message_fk)");

        $stmt -> bindParam(":id_user_fk", $like->id_user_fk, PDO::PARAM_INT);
        $stmt -> bindParam(":id_message_fk", $like->id_message_fk, PDO::PARAM_INT);


        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $message;

        $stmt -> close();

        $stmt = null;

    }

    public function update($like){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("UPDATE ".self::LIKES_TABLENAME." SET `usuarios_id`=:id_user_fk, `mensaje_id`=:id_message_fk WHERE `id` = :id_like");

        $stmt -> bindParam(":id_user_fk", $like->id_user_fk, PDO::PARAM_INT);
        $stmt -> bindParam(":id_message_fk", $like->id_message_fk, PDO::PARAM_INT);
        $stmt -> bindParam(":id_like", $like->id, PDO::PARAM_INT);
       

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $message;

        $stmt -> close();

        $stmt = null;
    }

    public function delete($id){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare(
            "DELETE FROM ".self::LIKES_TABLENAME." WHERE id = :id_like");

        $stmt -> bindParam(":id_like", $id, PDO::PARAM_INT);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $id;

        $stmt -> close();

        $stmt = null;
    }

    public function isLiked($id_user, $id_message){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("SELECT * FROM ".self::LIKES_TABLENAME." `l` WHERE `l`.`usuarios_id` = :id_user_fk AND `l`.`mensaje_id` = :id_message_fk");

        $stmt -> bindParam(":id_user_fk", $id_user, PDO::PARAM_INT);
        $stmt -> bindParam(":id_message_fk", $id_message, PDO::PARAM_INT);


        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        while($temp = $stmt->fetch()){
            $like = new Like($temp["id"],$temp["usuarios_id"],$temp["id_message_fk"]);
        }

        return $like;

        $stmt -> close();

        $stmt = null;
    }

}

?>