<?php

require_once ROOT_DIR."/dao/message.dao.php";

require_once ROOT_DIR."/models/connection.php";

require_once ROOT_DIR."/models/message.entity.php";


class MessageDaoImp implements MessageDao {

    const USERS_TABLENAME = "usuarios";
    const MESSAGES_TABLENAME = "mensaje";
    const FOLLOWINGS_TABLENAME = "siguiendo";
    const LIKES_TABLENAME = "me_gusta";

    public function findById($id){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("SELECT * FROM ".self::MESSAGES_TABLENAME." `m` WHERE `m`.`id` = :messageId");

        $stmt -> bindParam(":messageId", $id, PDO::PARAM_INT);


        try {
            $stmt -> execute();
        } catch (PDOException $e) {
            CustomLogger::getLogger()->error($e->getFile().": {$e->getMessage()}");
            return null;
        }

        while($temp = $stmt->fetch()){
            $message = new Message($temp["id"],$temp["texto"],$temp["imagen_contenido"],$temp["imagen_tipo"],$temp["usuarios_id"],$temp["fechayhora"]);
        }

        $message->setLikes($this->getCountLikes($message->getId()));

        CustomLogger::getLogger()->info(__FILE__.": query executed [{$stmt->queryString}]");

        return $message;

        $stmt -> close();

        $stmt = null;
    }

    public function save(Message $message){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("INSERT INTO ".self::MESSAGES_TABLENAME." (`texto`, `imagen_contenido`, `imagen_tipo`, `usuarios_id`, `fechayhora`) VALUES (:text, :imageContent, :imageType, :userIdFk, :createAt)");

        $stmt -> bindValue(":text", $message->getText(), PDO::PARAM_STR);
        if($message->getImageContent() == null && $message->getImageType() == null){
            $stmt -> bindValue(":imageContent", $message->getImageContent(), PDO::PARAM_NULL);
            $stmt -> bindValue(":imageType", $message->getImageType(), PDO::PARAM_NULL);
        }else {
            $stmt -> bindValue(":imageContent", $message->getImageContent(), PDO::PARAM_STR);
            $stmt -> bindValue(":imageType", $message->getImageType(), PDO::PARAM_STR);
        }
        $stmt -> bindValue(":userIdFk", $message->getIdUserFk(), PDO::PARAM_INT);
        $stmt -> bindValue(":createAt", $message->getCreateAt(), PDO::PARAM_STR);


        try {
            $stmt -> execute();
        } catch (PDOException $e) {
            CustomLogger::getLogger()->error($e->getFile().": {$e->getMessage()}");
            return null;
        }

        CustomLogger::getLogger()->info(__FILE__.": query executed [{$stmt->queryString}]");

        return $message;

        $stmt -> close();

        $stmt = null;
    }

    public function update(Message $message){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("UPDATE ".self::MESSAGES_TABLENAME." SET `texto`=:newText, `imagen_contenido`=:newImageContent, `imagen_tipo`=:newImageType, `usuarios_id`=:newUserIdFk, `fechayhora`=:newCreateAt WHERE `id` = :messageId");

        $stmt -> bindParam(":newText", $message->getText(), PDO::PARAM_STR);
        $stmt -> bindParam(":imagen_contenido", $message->getImageContent(), PDO::PARAM_STR);
        $stmt -> bindParam(":imagen_tipo", $message->getImageType(), PDO::PARAM_STR);
        $stmt -> bindParam(":usuarios_id", $message->getIdUserFk(), PDO::PARAM_INT);
        $stmt -> bindParam(":fechayhora", $message->getCreateAt(), PDO::PARAM_STR);
       

        try {
            $stmt -> execute();
        } catch (PDOException $e) {
            CustomLogger::getLogger()->error($e->getFile().": {$e->getMessage()}");
            return null;
        }

        CustomLogger::getLogger()->info(__FILE__.": query executed [{$stmt->queryString}]");

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

        try {
            $stmt -> execute();
        } catch (PDOException $e) {
            CustomLogger::getLogger()->error($e->getFile().": {$e->getMessage()}");
            return null;
        }

        CustomLogger::getLogger()->info(__FILE__.": query executed [{$stmt->queryString}]");

        return $id;

        $stmt -> close();

        $stmt = null;
    }


    public function getCountLikes($id){
        $stmt = DatabaseConnection::getConnection()->prepare(
            "SELECT COUNT(DISTINCT `usuarios_id`) AS `likes` FROM ".self::LIKES_TABLENAME." `mg` WHERE `mg`.`mensaje_id` = :idMensaje");

        $stmt -> bindParam(":idMensaje", $id, PDO::PARAM_INT);

        try {
            $stmt -> execute();
        } catch (PDOException $e) {
            CustomLogger::getLogger()->error($e->getFile().": {$e->getMessage()}");
            return null;
        }

        CustomLogger::getLogger()->info(__FILE__.": query executed [{$stmt->queryString}]");

        $likes = $stmt->fetch();
         
        return $likes["likes"];

        $stmt -> close();

        $stmt = null;
    }

    public function getPaginationFromFollowings($id, $origin=0, $rows=10){
        $stmt = DatabaseConnection::getConnection()->prepare(
            "SELECT * FROM (SELECT `u`.`id` AS `id_user`, `u`.`nombreusuario` AS `nombreusuario_user`, `u`.`nombre` AS `nombre_user`, `u`.`apellido` AS `apellido_user`, `u`.`foto_contenido` AS `foto_contenido_user`, `u`.`foto_tipo` AS `foto_tipo_user`,`m`.`id` AS `id_mensaje`, `m`.`texto` AS `texto_mensaje`, `m`.`imagen_contenido` AS `imagen_contenido_mensaje`, `m`.`imagen_tipo` AS `imagen_tipo_mensaje`, DATE_FORMAT(`m`.`fechayhora`, '%d/%m/%Y %H:%i') AS `fechayhora_mensaje` FROM ".self::USERS_TABLENAME." `u` INNER JOIN ".self::MESSAGES_TABLENAME." `m` ON(`u`.`id` = `m`.`usuarios_id`) WHERE `u`.`id` IN (SELECT `fl`.`usuarioseguido_id` FROM ".self::FOLLOWINGS_TABLENAME." `fl` WHERE `fl`.`usuarios_id` = :userid)) `data` ORDER BY `data`.`fechayhora_mensaje` DESC LIMIT :origin, :rows");

            $stmt -> bindParam(":userid", $id, PDO::PARAM_STR);
            $stmt -> bindParam(":origin", $origin, PDO::PARAM_INT);
            $stmt -> bindParam(":rows", $rows, PDO::PARAM_INT);

        try {
            $stmt -> execute();
        } catch (PDOException $e) {
            CustomLogger::getLogger()->error($e->getFile().": {$e->getMessage()}");
            return null;
        }

        CustomLogger::getLogger()->info(__FILE__.": query executed [{$stmt->queryString}]");

        return $stmt->fetchAll();

        $stmt -> close();

        $stmt = null;
    }

    public function findTrending($rows=3){
        $stmt = DatabaseConnection::getConnection()->prepare(
            "SELECT `m`.`id`, `m`.`texto`, `u`.`nombreusuario`, COUNT(`l`.`mensaje_id`) as `C_LIKES` 
            FROM ".self::MESSAGES_TABLENAME." `m` 
            LEFT JOIN ".self::LIKES_TABLENAME." `l` ON(`l`.`mensaje_id` = `m`.`id`)
            INNER JOIN ".self::USERS_TABLENAME." `u` ON(`u`.`id` = `m`.`usuarios_id`)
            GROUP BY `m`.`id` ORDER BY `C_LIKES` DESC LIMIT :rows");

        $stmt -> bindParam(":rows", $rows, PDO::PARAM_INT);

        try {
            $stmt -> execute();
        } catch (PDOException $e) {
            CustomLogger::getLogger()->error($e->getFile().": {$e->getMessage()}");
            return null;
        }

        CustomLogger::getLogger()->info(__FILE__.": query executed [{$stmt->queryString}]");
        
        return $stmt->fetchAll();

        $stmt -> close();

        $stmt = null;
    }

}

?>