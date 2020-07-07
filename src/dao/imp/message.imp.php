<?php

require_once "./dao/message.dao.php";

require_once "./models/connection.php";

require_once "./models/message.entity.php";


class MessageDaoImp implements MessageDao {

    const USERS_TABLENAME = "usuarios";
    const MESSAGES_TABLENAME = "mensaje";
    const FOLLOWINGS_TABLENAME = "siguiendo";
    const LIKES_TABLENAME = "me_gusta";

    public function findById($id){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("SELECT * FROM ".self::MESSAGES_TABLENAME." `m` WHERE `m`.`id` = :messageId ");

        $stmt -> bindParam(":messageId", $id, PDO::PARAM_INT);


        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        while($temp = $stmt->fetch()){
            $message = new Message($temp["id"],$temp["texto"],$temp["imagen_contenido"],$temp["imagen_tipo"],$temp["usuarios_id"],$temp["fechayhora"]);
        }

        $message->setLikes($this->getCountLikes($message->getId()));

        return $message;

        $stmt -> close();

        $stmt = null;
    }

    public function save($message){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("INSERT INTO ".self::MESSAGES_TABLENAME." (`texto`, `imagen_contenido`, `imagen_tipo`, `usuarios_id`, `fechayhora`) VALUES (:text, :imageContent, :imageType, :userIdFk, :createAt)");

        $stmt -> bindParam(":text", $message->text_content, PDO::PARAM_STR);
        if($message->image_content == null && $message->image_type == null){
            $stmt -> bindParam(":imageContent", $message->image_content, PDO::PARAM_NULL);
            $stmt -> bindParam(":imageType", $message->image_type, PDO::PARAM_NULL);
        }else {
            $stmt -> bindParam(":imageContent", $message->image_content, PDO::PARAM_STR);
            $stmt -> bindParam(":imageType", $message->image_type, PDO::PARAM_STR);
        }
        $stmt -> bindParam(":userIdFk", $message->id_user_fk, PDO::PARAM_STR);
        $stmt -> bindParam(":createAt", $message->create_at, PDO::PARAM_STR);


        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $message;

        $stmt -> close();

        $stmt = null;
    }

    public function update($message){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("UPDATE ".self::MESSAGES_TABLENAME." SET `texto`=:newText, `imagen_contenido`=:newImageContent, `imagen_tipo`=:newImageType, `usuarios_id`=:newUserIdFk, `fechayhora`=:newCreateAt WHERE `id` = :messageId");

        $stmt -> bindParam(":newText", $message->text_content, PDO::PARAM_STR);
        $stmt -> bindParam(":imagen_contenido", $message->image_content, PDO::PARAM_STR);
        $stmt -> bindParam(":imagen_tipo", $message->image_type, PDO::PARAM_STR);
        $stmt -> bindParam(":usuarios_id", $message->id_user_fk, PDO::PARAM_STR);
        $stmt -> bindParam(":fechayhora", $message->create_at, PDO::PARAM_STR);
       

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
            "DELETE FROM ".self::MESSAGES_TABLENAME." WHERE id = :messageId");

        $stmt -> bindParam(":messageId", $id, PDO::PARAM_INT);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $id;

        $stmt -> close();

        $stmt = null;
    }


    public function getCountLikes($id){
        $stmt = DatabaseConnection::getConnection()->prepare(
            "SELECT COUNT(DISTINCT `usuarios_id`) AS `likes` FROM ".self::LIKES_TABLENAME." `mg` WHERE `mg`.`mensaje_id` = :idMensaje");

        $stmt -> bindParam(":idMensaje", $id, PDO::PARAM_INT);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        $likes = $stmt->fetch();
         
        return $likes["likes"];

        $stmt -> close();

        $stmt = null;
    }

}

?>