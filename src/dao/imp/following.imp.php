<?php

require_once "./dao/following.dao.php";

require_once "./models/connection.php";

require_once "./models/following.entity.php";


class FollowingDaoImp implements FollowingDao {

    const USERS_TABLENAME = "usuarios";
    const MESSAGES_TABLENAME = "mensaje";
    const FOLLOWINGS_TABLENAME = "siguiendo";
    const LIKES_TABLENAME = "me_gusta";


    public function findById($id){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("SELECT * FROM ".self::FOLLOWINGS_TABLENAME." `f` WHERE `f`.`id` = :followingId");

        $stmt -> bindParam(":followingId", $id, PDO::PARAM_INT);


        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        while($temp = $stmt->fetch()){
            $following = new Following($temp["id"],$temp["usuarios_id"],$temp["usuarioseguido_id"]);
        }

        return $following;

        $stmt -> close();

        $stmt = null;
    }

    public function save($following){

        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("INSERT INTO ".self::FOLLOWINGS_TABLENAME." (`usuarios_id`, `usuarioseguido_id`) VALUES (:id_user_fk, :id_user_following_fk)");

        $stmt -> bindParam(":id_user_fk", $following->id_user_fk, PDO::PARAM_INT);
        $stmt -> bindParam(":id_user_following_fk", $following->id_user_following_fk, PDO::PARAM_INT);


        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $following;

        $stmt -> close();

        $stmt = null;

    }

    public function update($following){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("UPDATE ".self::FOLLOWINGS_TABLENAME." SET `usuarios_id`=:id_user_fk, `usuarioseguido_id`=:id_user_following_fk WHERE `id` = :id_following");

        $stmt -> bindParam(":id_user_fk", $following->id_user_fk, PDO::PARAM_INT);
        $stmt -> bindParam(":id_user_following_fk", $following->id_user_following_fk, PDO::PARAM_INT);
        $stmt -> bindParam(":id_following", $following->id, PDO::PARAM_INT);
       

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
            "DELETE FROM ".self::FOLLOWINGS_TABLENAME." WHERE id = :id_following");

        $stmt -> bindParam(":id_following", $id, PDO::PARAM_INT);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $id;

        $stmt -> close();

        $stmt = null;
    }

    public function isFollowing($id_user, $id_user_following_fk){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("SELECT * FROM ".self::FOLLOWINGS_TABLENAME." `f` WHERE `f`.`usuarios_id` = :id_user_fk AND `f`.`usuarioseguido_id` = :id_user_following_fk");

        $stmt -> bindParam(":id_user_fk", $id_user, PDO::PARAM_INT);
        $stmt -> bindParam(":id_user_following_fk", $id_user_following_fk, PDO::PARAM_INT);


        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        while($temp = $stmt->fetch()){
            $following = new Following($temp["id"],$temp["usuarios_id"],$temp["usuarioseguido_id"]);
        }

        return $following;

        $stmt -> close();

        $stmt = null;
    }

}

?>