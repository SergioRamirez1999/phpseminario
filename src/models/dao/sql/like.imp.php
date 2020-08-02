<?php

require_once ROOT_DIR."/models/dao/like.dao.php";

require_once ROOT_DIR."/models/dao/factory/connection.factory.php";

require_once ROOT_DIR."/models/entities/like.entity.php";


class LikeDaoImp implements LikeDao {

    const LIKES_TABLENAME = "me_gusta";

    public function findById($id){
        $connectionFactory = new ConnectionFactory();
        $connection = $connectionFactory->createConnection("MYSQL")->getConnection();
        $stmt = $connection->prepare("SELECT * FROM ".self::LIKES_TABLENAME." `l` WHERE `l`.`id` = :likeId");

        $stmt -> bindParam(":likeId", $id, PDO::PARAM_INT);


        try {
            $stmt -> execute();
        } catch (PDOException $e) {
            CustomLogger::getLogger()->error($e->getFile().": {$e->getMessage()}");
            return null;
        }

        while($temp = $stmt->fetch()){
            $like = new Like($temp["id"],$temp["usuarios_id"],$temp["id_message_fk"]);
        }

        CustomLogger::getLogger()->info(__FILE__.": query executed [{$stmt->queryString}]");

        return $like;

        $stmt -> close();

        $stmt = null;
    }

    public function save(Like $like){

        $connectionFactory = new ConnectionFactory();
        $connection = $connectionFactory->createConnection("MYSQL")->getConnection();
        $stmt = $connection->prepare("INSERT INTO ".self::LIKES_TABLENAME." (`usuarios_id`, `mensaje_id`) VALUES (:id_user_fk, :id_message_fk)");

        $stmt -> bindValue(":id_user_fk", $like->getIdUserFk(), PDO::PARAM_INT);
        $stmt -> bindValue(":id_message_fk", $like->getIdMessageFk(), PDO::PARAM_INT);


        try {
            $stmt -> execute();
        } catch (PDOException $e) {
            CustomLogger::getLogger()->error($e->getFile().": {$e->getMessage()}");
            return null;
        }

        CustomLogger::getLogger()->info(__FILE__.": query executed [{$stmt->queryString}]");

        return $like;

        $stmt -> close();

        $stmt = null;

    }

    public function update(Like $like){
        $connectionFactory = new ConnectionFactory();
        $connection = $connectionFactory->createConnection("MYSQL")->getConnection();
        $stmt = $connection->prepare("UPDATE ".self::LIKES_TABLENAME." SET `usuarios_id`=:id_user_fk, `mensaje_id`=:id_message_fk WHERE `id` = :id_like");

        $stmt -> bindValue(":id_user_fk", $like->getIdUserFk(), PDO::PARAM_INT);
        $stmt -> bindValue(":id_message_fk", $like->getIdMessageFk(), PDO::PARAM_INT);
        $stmt -> bindValue(":id_like", $like->getId(), PDO::PARAM_INT);
       

        try {
            $stmt -> execute();
        } catch (PDOException $e) {
            CustomLogger::getLogger()->error($e->getFile().": {$e->getMessage()}");
            return null;
        }

        CustomLogger::getLogger()->info(__FILE__.": query executed [{$stmt->queryString}]");

        return $like;

        $stmt -> close();

        $stmt = null;
    }

    public function delete($id){
        $connectionFactory = new ConnectionFactory();
        $connection = $connectionFactory->createConnection("MYSQL")->getConnection();
        $stmt = $connection->prepare(
            "DELETE FROM ".self::LIKES_TABLENAME." WHERE `id` = :id_like");

        $stmt -> bindParam(":id_like", $id, PDO::PARAM_INT);

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

    public function deleteByFks($id_user, $id_message){
        $connectionFactory = new ConnectionFactory();
        $connection = $connectionFactory->createConnection("MYSQL")->getConnection();
        $stmt = $connection->prepare(
            "DELETE FROM ".self::LIKES_TABLENAME." WHERE `usuarios_id` = :id_user AND `mensaje_id` = :id_message");

        $stmt -> bindParam(":id_user", $id_user, PDO::PARAM_INT);
        $stmt -> bindParam(":id_message", $id_message, PDO::PARAM_INT);

        try {
            $stmt -> execute();
        } catch (PDOException $e) {
            CustomLogger::getLogger()->error($e->getFile().": {$e->getMessage()}");
            return null;
        }

        CustomLogger::getLogger()->info(__FILE__.": query executed [{$stmt->queryString}]");

        return array("id_user" => $id_user, "id_message" => $id_message);

        $stmt -> close();

        $stmt = null;
    }

    public function deleteByMessageId($id_message){
        $connectionFactory = new ConnectionFactory();
        $connection = $connectionFactory->createConnection("MYSQL")->getConnection();
        $stmt = $connection->prepare(
            "DELETE FROM ".self::LIKES_TABLENAME." WHERE `mensaje_id` = :id_message");

        $stmt -> bindParam(":id_message", $id_message, PDO::PARAM_INT);

        try {
            $stmt -> execute();
        } catch (PDOException $e) {
            CustomLogger::getLogger()->error($e->getFile().": {$e->getMessage()}");
            return null;
        }

        CustomLogger::getLogger()->info(__FILE__.": query executed [{$stmt->queryString}]");

        return $id_message;

        $stmt -> close();

        $stmt = null;
    }

    public function isLiked($id_user, $id_message){
        $connectionFactory = new ConnectionFactory();
        $connection = $connectionFactory->createConnection("MYSQL")->getConnection();
        $stmt = $connection->prepare("SELECT * FROM ".self::LIKES_TABLENAME." `l` WHERE `l`.`usuarios_id` = :id_user_fk AND `l`.`mensaje_id` = :id_message_fk");

        $stmt -> bindParam(":id_user_fk", $id_user, PDO::PARAM_INT);
        $stmt -> bindParam(":id_message_fk", $id_message, PDO::PARAM_INT);


        try {
            $stmt -> execute();
        } catch (PDOException $e) {
            CustomLogger::getLogger()->error($e->getFile().": {$e->getMessage()}");
            return null;
        }

        $like = null;

        while($temp = $stmt->fetch()){
            $like = new Like($temp["id"],$temp["usuarios_id"],$temp["mensaje_id"]);
        }

        CustomLogger::getLogger()->info(__FILE__.": query executed [{$stmt->queryString}]");

        return $like;

        $stmt -> close();

        $stmt = null;
    }

}