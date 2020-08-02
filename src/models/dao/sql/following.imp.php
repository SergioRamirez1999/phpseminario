<?php

require_once ROOT_DIR."/models/dao/following.dao.php";

require_once ROOT_DIR."/models/dao/factory/connection.factory.php";

require_once ROOT_DIR."/models/entities/following.entity.php";

require_once ROOT_DIR."/config/logger.php";


class FollowingDaoImp implements FollowingDao {

    const FOLLOWINGS_TABLENAME = "siguiendo";

    public function findById($id){
        $connectionFactory = new ConnectionFactory();
        $connection = $connectionFactory->createConnection("MYSQL")->getConnection();
        $stmt = $connection->prepare("SELECT * FROM ".self::FOLLOWINGS_TABLENAME." `f` WHERE `f`.`id` = :followingId");

        $stmt -> bindParam(":followingId", $id, PDO::PARAM_INT);


        try {
            $stmt -> execute();
        } catch (PDOException $e) {
            CustomLogger::getLogger()->error($e->getFile().": {$e->getMessage()}");
            return null;
        }

        while($temp = $stmt->fetch()){
            $following = new Following($temp["id"],$temp["usuarios_id"],$temp["usuarioseguido_id"]);
        }

        CustomLogger::getLogger()->info(__FILE__.": query executed [{$stmt->queryString}]");

        return $following;

        $stmt -> close();

        $stmt = null;
    }

    public function save(Following $following){

        $connectionFactory = new ConnectionFactory();
        $connection = $connectionFactory->createConnection("MYSQL")->getConnection();
        $stmt = $connection->prepare("INSERT INTO ".self::FOLLOWINGS_TABLENAME." (`usuarios_id`, `usuarioseguido_id`) VALUES (:id_user_fk, :id_user_following_fk)");

        $stmt -> bindValue(":id_user_fk", $following->getIdUserFk(), PDO::PARAM_INT);
        $stmt -> bindValue(":id_user_following_fk", $following->getIdUserFollowingFk(), PDO::PARAM_INT);


        try {
            $stmt -> execute();
        } catch (PDOException $e) {
            CustomLogger::getLogger()->error($e->getFile().": {$e->getMessage()}");
            return null;
        }

        CustomLogger::getLogger()->info(__FILE__.": query executed [{$stmt->queryString}]");

        return $following;

        $stmt -> close();

        $stmt = null;

    }

    public function update(Following $following){
        $connectionFactory = new ConnectionFactory();
        $connection = $connectionFactory->createConnection("MYSQL")->getConnection();
        $stmt = $connection->prepare("UPDATE ".self::FOLLOWINGS_TABLENAME." SET `usuarios_id`=:id_user_fk, `usuarioseguido_id`=:id_user_following_fk WHERE `id` = :id_following");

        $stmt -> bindValue(":id_user_fk", $following->id_user_fk, PDO::PARAM_INT);
        $stmt -> bindValue(":id_user_following_fk", $following->id_user_following_fk, PDO::PARAM_INT);
        $stmt -> bindValue(":id_following", $following->id, PDO::PARAM_INT);
       

        try {
            $stmt -> execute();
        } catch (PDOException $e) {
            CustomLogger::getLogger()->error($e->getFile().": {$e->getMessage()}");
            return null;
        }

        CustomLogger::getLogger()->info(__FILE__.": query executed [{$stmt->queryString}]");

        return $following;

        $stmt -> close();

        $stmt = null;
    }

    public function delete($id){
        $connectionFactory = new ConnectionFactory();
        $connection = $connectionFactory->createConnection("MYSQL")->getConnection();
        $stmt = $connection->prepare(
            "DELETE FROM ".self::FOLLOWINGS_TABLENAME." WHERE id = :id_following");

        $stmt -> bindParam(":id_following", $id, PDO::PARAM_INT);

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

    public function deleteByFks($id_user, $id_user_following_fk){
        $connectionFactory = new ConnectionFactory();
        $connection = $connectionFactory->createConnection("MYSQL")->getConnection();
        $stmt = $connection->prepare(
            "DELETE FROM ".self::FOLLOWINGS_TABLENAME." WHERE `usuarios_id` = :id_user AND `usuarioseguido_id` = :id_user_following_fk");

        $stmt -> bindParam(":id_user", $id_user, PDO::PARAM_INT);
        $stmt -> bindParam(":id_user_following_fk", $id_user_following_fk, PDO::PARAM_INT);

        try {
            $stmt -> execute();
        } catch (PDOException $e) {
            CustomLogger::getLogger()->error($e->getFile().": {$e->getMessage()}");
            return null;
        }

        CustomLogger::getLogger()->info(__FILE__.": query executed [{$stmt->queryString}]");

        return $id_user;

        $stmt -> close();

        $stmt = null;
    }

    public function isFollowing($id_user, $id_user_following_fk){
        $connectionFactory = new ConnectionFactory();
        $connection = $connectionFactory->createConnection("MYSQL")->getConnection();
        $stmt = $connection->prepare("SELECT * FROM ".self::FOLLOWINGS_TABLENAME." `f` WHERE `f`.`usuarios_id` = :id_user_fk AND `f`.`usuarioseguido_id` = :id_user_following_fk");

        $stmt -> bindParam(":id_user_fk", $id_user, PDO::PARAM_INT);
        $stmt -> bindParam(":id_user_following_fk", $id_user_following_fk, PDO::PARAM_INT);


        try {
            $stmt -> execute();
        } catch (PDOException $e) {
            CustomLogger::getLogger()->error($e->getFile().": {$e->getMessage()}");
            return null;
        }

        CustomLogger::getLogger()->info(__FILE__.": query executed [{$stmt->queryString}]");

        $following = null;

        while($temp = $stmt->fetch()){
            $following = new Following($temp["id"],$temp["usuarios_id"],$temp["usuarioseguido_id"]);
        }

        return $following;

        $stmt -> close();

        $stmt = null;
    }

}