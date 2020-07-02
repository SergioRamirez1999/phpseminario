<?php

require_once "connection.php";

define("USERS_TABLENAME", "usuarios");
define("MESSAGES_TABLENAME", "mensaje");
define("FOLLOWINGS_TABLENAME", "siguiendo");
define("LIKES_TABLENAME", "me_gusta");


class UserModel {

    static public function findUserByUsername($username){
        
        $stmt = DatabaseConnection::getConnection()->prepare("SELECT * FROM ".USERS_TABLENAME." `u` WHERE `u`.`nombreusuario` = :username ");

        $stmt -> bindParam(":username", $username, PDO::PARAM_STR);


        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $stmt -> fetch(PDO::FETCH_ASSOC);

        $stmt -> close();

        $stmt = null;
    }

    static public function findUserById($id){
        
        $stmt = DatabaseConnection::getConnection()->prepare("SELECT * FROM ".USERS_TABLENAME." `u` WHERE `u`.`id` = :id ");

        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);


        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $stmt -> fetch(PDO::FETCH_ASSOC);

        $stmt -> close();

        $stmt = null;
    }

    static public function findMessageById($id){
        
        $stmt = DatabaseConnection::getConnection()->prepare("SELECT * FROM ".MESSAGES_TABLENAME." `m` WHERE `m`.`id` = :messageId ");

        $stmt -> bindParam(":messageId", $id, PDO::PARAM_INT);


        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $stmt -> fetch(PDO::FETCH_ASSOC);

        $stmt -> close();

        $stmt = null;
    }

    static public function findFollowingsPostsById($id){
        $stmt = DatabaseConnection::getConnection()->prepare(
            "SELECT * FROM (SELECT `u`.`id` AS `id_user`, `u`.`nombreusuario` AS `nombreusuario_user`, `u`.`nombre` AS `nombre_user`, `u`.`apellido` AS `apellido_user`, `u`.`foto_contenido` AS `foto_contenido_user`, `u`.`foto_tipo` AS `foto_tipo_user`,`m`.`id` AS `id_mensaje`, `m`.`texto` AS `texto_mensaje`, `m`.`imagen_contenido` AS `imagen_contenido_mensaje`, `m`.`imagen_tipo` AS `imagen_tipo_mensaje`, DATE_FORMAT(`m`.`fechayhora`, '%d/%m/%Y') AS `fechayhora_mensaje` FROM ".USERS_TABLENAME." `u` INNER JOIN ".MESSAGES_TABLENAME." `m` ON(`u`.`id` = `m`.`usuarios_id`) WHERE `u`.`id` IN (SELECT `fl`.`usuarioseguido_id` FROM ".FOLLOWINGS_TABLENAME." `fl` WHERE `fl`.`usuarios_id` = :userid)) `data` ORDER BY `data`.`fechayhora_mensaje` ASC");

        $stmt -> bindParam(":userid", $id, PDO::PARAM_INT);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $stmt -> fetchall(PDO::FETCH_ASSOC);

        $stmt -> close();

        $stmt = null;
    }

    static public function putUser($user){
        $stmt = DatabaseConnection::getConnection()->prepare(
            "INSERT INTO ".USERS_TABLENAME." (`apellido`, `nombre`, `email`, `nombreusuario`, `contrasenia`, `foto_contenido`, `foto_tipo`) VALUES (:userLastname, :userName, :userEmail, :userUsername, :userPassword, :userImageContent, :userImageType)");

        $stmt -> bindParam(":userName", $user["name"], PDO::PARAM_STR);
        $stmt -> bindParam(":userLastname", $user["lastname"], PDO::PARAM_STR);
        $stmt -> bindParam(":userUsername", $user["username"], PDO::PARAM_STR);
        $stmt -> bindParam(":userEmail", $user["email"], PDO::PARAM_STR);
        $stmt -> bindParam(":userPassword", $user["password"], PDO::PARAM_STR);
        $stmt -> bindParam(":userImageContent", $user["imageContent"], PDO::PARAM_STR);
        $stmt -> bindParam(":userImageType", $user["imageType"], PDO::PARAM_STR);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $user;

        $stmt -> close();

        $stmt = null;
    }

    static public function putMessage($message){
        $stmt = DatabaseConnection::getConnection()->prepare(
            "INSERT INTO ".MESSAGES_TABLENAME." (`texto`, `imagen_contenido`, `imagen_tipo`, `usuarios_id`, `fechayhora`) VALUES (:text, :imageContent, :imageType, :userIdFk, :createAt)");

        $stmt -> bindParam(":text", $message["text"], PDO::PARAM_STR);
        if($message["image_content"] == null && $message["image_type"] == null){
            $stmt -> bindParam(":imageContent", $message["image_content"], PDO::PARAM_NULL);
            $stmt -> bindParam(":imageType", $message["image_type"], PDO::PARAM_NULL);
        }else {
            $stmt -> bindParam(":imageContent", $message["image_content"], PDO::PARAM_STR);
            $stmt -> bindParam(":imageType", $message["image_type"], PDO::PARAM_STR);
        }
        $stmt -> bindParam(":userIdFk", $message["user_id_fk"], PDO::PARAM_STR);
        $stmt -> bindParam(":createAt", $message["create_at"], PDO::PARAM_STR);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $message;

        $stmt -> close();

        $stmt = null;
    }

    static public function findFollowingsById($id){

        $stmt = DatabaseConnection::getConnection()->prepare(
            "SELECT `u`.`id`, `u`.`apellido`, `u`.`nombre`, `u`.`email`, `u`.`nombreusuario`, `u`.`foto_contenido`, `u`.`foto_tipo` FROM ".USERS_TABLENAME." `u`
	        INNER JOIN ".FOLLOWINGS_TABLENAME." `s` ON(`s`.`usuarioseguido_id` = `u`.`id`)
            WHERE `s`.`usuarios_id` = :userId");

        $stmt -> bindParam(":userId", $id, PDO::PARAM_INT);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $stmt -> fetchall(PDO::FETCH_ASSOC);

        $stmt -> close();

        $stmt = null;

    }

    static public function findFollowersById($id){

        $stmt = DatabaseConnection::getConnection()->prepare(
            "SELECT `u`.`id`, `u`.`apellido`, `u`.`nombre`, `u`.`email`, `u`.`nombreusuario`, `u`.`foto_contenido`, `u`.`foto_tipo` FROM ".USERS_TABLENAME." `u`
	        INNER JOIN ".FOLLOWINGS_TABLENAME." `s` ON(`s`.`usuarios_id` = `u`.`id`)
            WHERE `s`.`usuarioseguido_id` = :userId");

        $stmt -> bindParam(":userId", $id, PDO::PARAM_INT);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $stmt -> fetchall(PDO::FETCH_ASSOC);

        $stmt -> close();

        $stmt = null;

    }

    static public function findPostsById($id){

        $stmt = DatabaseConnection::getConnection()->prepare(
            "SELECT `m`.`id`, `m`.`texto`, `m`.`imagen_contenido`, `m`.`imagen_tipo`, `m`.`usuarios_id`, DATE_FORMAT(`m`.`fechayhora`, '%d/%m/%Y %H:%m') AS `fechayhora` FROM `mensaje` `m` WHERE `m`.`usuarios_id` = :userId ORDER BY `m`.`fechayhora` ASC");

        $stmt -> bindParam(":userId", $id, PDO::PARAM_INT);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $stmt -> fetchall(PDO::FETCH_ASSOC);

        $stmt -> close();

        $stmt = null;

    }

    static public function putFollowById($id_owner, $id_host){
        $stmt = DatabaseConnection::getConnection()->prepare(
            "INSERT INTO ".FOLLOWINGS_TABLENAME." (`usuarios_id`, `usuarioseguido_id`) VALUES (:ownerId, :hostId)");

        $stmt -> bindParam(":ownerId", $id_owner, PDO::PARAM_INT);
        $stmt -> bindParam(":hostId", $id_host, PDO::PARAM_INT);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $id_owner;

        $stmt -> close();

        $stmt = null;
    }

    static public function removeFollowById($id_owner, $id_host){
        $stmt = DatabaseConnection::getConnection()->prepare(
            "DELETE FROM ".FOLLOWINGS_TABLENAME." WHERE `usuarios_id` = :ownerId AND `usuarioseguido_id` = :hostId");

        $stmt -> bindParam(":ownerId", $id_owner, PDO::PARAM_INT);
        $stmt -> bindParam(":hostId", $id_host, PDO::PARAM_INT);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $id_owner;

        $stmt -> close();

        $stmt = null;
    }


    static public function findUsersByCriteria($keyword){
        $stmt = DatabaseConnection::getConnection()->prepare(
            "SELECT `u`.`id`, `u`.`apellido`, `u`.`nombre`, `u`.`email`, `u`.`nombreusuario`, `u`.`foto_contenido`, `u`.`foto_tipo` FROM ".USERS_TABLENAME." `u` WHERE `u`.`nombre` LIKE :keyword OR `u`.`apellido` LIKE :keyword OR `u`.`nombreusuario` LIKE :keyword");

        $stmt -> bindParam(":keyword", $keyword, PDO::PARAM_STR);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $stmt -> fetchAll(PDO::FETCH_ASSOC);

        $stmt -> close();

        $stmt = null;
    }

    static public function deletePostById($id){
        $stmt = DatabaseConnection::getConnection()->prepare(
            "DELETE FROM ".MESSAGES_TABLENAME." WHERE id = :messageId");

        $stmt -> bindParam(":messageId", $id, PDO::PARAM_INT);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $id;

        $stmt -> close();

        $stmt = null;
    }

    static public function updateUserById($id, $field, $value){
        $stmt = DatabaseConnection::getConnection()->prepare(
            "UPDATE ".USERS_TABLENAME." SET `".$field."`=:value WHERE `id` = :userId");

        $stmt -> bindParam(":userId", $id, PDO::PARAM_INT);
        $stmt -> bindParam(":value", $value, PDO::PARAM_STR);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $id;

        $stmt -> close();

        $stmt = null;
    }

    static public function uploadUserImage($id, $image_content, $image_type){
        $stmt = DatabaseConnection::getConnection()->prepare(
            "UPDATE ".USERS_TABLENAME." SET `foto_contenido` = :imageContent, `foto_tipo` = :imageType WHERE `id` = :userId");

        $stmt -> bindParam(":userId", $id, PDO::PARAM_INT);
        $stmt -> bindParam(":imageContent", $image_content, PDO::PARAM_STR);
        $stmt -> bindParam(":imageType", $image_type, PDO::PARAM_STR);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $id;

        $stmt -> close();

        $stmt = null;
    }

    static public function findLikesByPostId($id){
        $stmt = DatabaseConnection::getConnection()->prepare(
            "SELECT `mg`.`id`, `mg`.`usuarios_id`, `mg`.`mensaje_id` FROM ".LIKES_TABLENAME." `mg` WHERE `mg`.`mensaje_id` = :idMensaje");

        $stmt -> bindParam(":idMensaje", $id, PDO::PARAM_INT);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $stmt -> fetchAll(PDO::FETCH_ASSOC);

        $stmt -> close();

        $stmt = null;
    }

    static public function putLike($id_user, $id_post){
        $stmt = DatabaseConnection::getConnection()->prepare(
            "INSERT INTO ".LIKES_TABLENAME." (`usuarios_id`, `mensaje_id`) VALUES (:idUser, :idPost)");

        $stmt -> bindParam(":idUser", $id_user, PDO::PARAM_INT);
        $stmt -> bindParam(":idPost", $id_post, PDO::PARAM_INT);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $id_user;

        $stmt -> close();

        $stmt = null;
    }

    static public function deleteLike($id_user, $id_post){
        $stmt = DatabaseConnection::getConnection()->prepare(
            "DELETE FROM ".LIKES_TABLENAME." WHERE `usuarios_id` = :idUser AND `mensaje_id` = :idPost");

        $stmt -> bindParam(":idUser", $id_user, PDO::PARAM_INT);
        $stmt -> bindParam(":idPost", $id_post, PDO::PARAM_INT);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $id_user;

        $stmt -> close();

        $stmt = null;
    }


}

?>