<?php

require_once "./dao/user.dao.php";

require_once "./models/connection.php";

require_once "./models/user.entity.php";

require_once "./models/message.entity.php";


class UserDaoImp implements UserDao {

    const USERS_TABLENAME = "usuarios";
    const MESSAGES_TABLENAME = "mensaje";
    const FOLLOWINGS_TABLENAME = "siguiendo";
    const LIKES_TABLENAME = "me_gusta";


    public function findById($id, $full){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("SELECT * FROM ".self::USERS_TABLENAME." `u` WHERE `u`.`id` = :id ");

        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        while($temp = $stmt->fetch()){
            $user = new User($temp["id"],$temp["nombre"],$temp["apellido"],$temp["email"],$temp["nombreusuario"],$temp["contrasenia"],$temp["foto_contenido"],$temp["foto_tipo"]);
        }

        if($full){
            $user->setFollowings($this->getFollowings($user->getId()));
            $user->setFollowers($this->getFollowers($user->getId()));
            $user->setMessages($this->getAllMessages($user->getId()));
        }

        return $user;

        $stmt -> close();

        $stmt = null;
    }

    public function findByUsername($username, $full){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("SELECT * FROM ".self::USERS_TABLENAME." `u` WHERE `u`.`nombreusuario` = :username ");

        $stmt -> bindParam(":username", $username, PDO::PARAM_STR);


        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        while($temp = $stmt->fetch()){
            $user = new User($temp["id"],$temp["nombre"],$temp["apellido"],$temp["email"],$temp["nombreusuario"],$temp["contrasenia"],$temp["foto_contenido"],$temp["foto_tipo"]);
        }

        if($full){
            $user->setFollowings($this->getFollowings($user->getId()));
            $user->setFollowers($this->getFollowers($user->getId()));
            $user->setMessages($this->getAllMessages($user->getId()));
        }

        return $user;

        $stmt -> close();

        $stmt = null;
        
    }

    public function findByUsernameAndPassword($username, $password, $full){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("SELECT * FROM ".self::USERS_TABLENAME." `u` WHERE `u`.`nombreusuario` = :username AND `u`.`contrasenia` = :password");

        $stmt -> bindParam(":username", $username, PDO::PARAM_STR);
        $stmt -> bindParam(":password", $password, PDO::PARAM_STR);


        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        while($temp = $stmt->fetch()){
            $user = new User($temp["id"],$temp["nombre"],$temp["apellido"],$temp["email"],$temp["nombreusuario"],$temp["contrasenia"],$temp["foto_contenido"],$temp["foto_tipo"]);
        }

        if($full){
            $user->setFollowings($this->getFollowings($user->getId()));
            $user->setFollowers($this->getFollowers($user->getId()));
            $user->setMessages($this->getAllMessages($user->getId()));
        }

        $stmt -> close();

        $stmt = null;
    }

    public function save($user){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("INSERT INTO ".self::USERS_TABLENAME." (`apellido`, `nombre`, `email`, `nombreusuario`, `contrasenia`, `foto_contenido`, `foto_tipo`) VALUES (:userLastname, :userName, :userEmail, :userUsername, :userPassword, :userImageContent, :userImageType)");

        $stmt -> bindParam(":userLastname", $user->lastname, PDO::PARAM_STR);
        $stmt -> bindParam(":userName", $user->name, PDO::PARAM_STR);
        $stmt -> bindParam(":userEmail", $user->email, PDO::PARAM_STR);
        $stmt -> bindParam(":userUsername", $user->username, PDO::PARAM_STR);
        $stmt -> bindParam(":userPassword", $user->password, PDO::PARAM_STR);
        $stmt -> bindParam(":userImageContent", $user->image_content, PDO::PARAM_STR);
        $stmt -> bindParam(":userImageType", $user->image_type, PDO::PARAM_STR);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $user;

        $stmt -> close();

        $stmt = null;
    }

    public function update($id, $field, $value){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("UPDATE ".self::USERS_TABLENAME." SET `".$field."`=:value WHERE `id` = :userId");

        $stmt -> bindParam(":userId", $id, PDO::PARAM_INT);
        $stmt -> bindParam(":value", $value, PDO::PARAM_STR);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $user;

        $stmt -> close();

        $stmt = null;
    }

    public function delete($id){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("DELETE FROM ".self::USERS_TABLENAME." WHERE `id` = :userId");

        $stmt -> bindParam(":userId", $id, PDO::PARAM_INT);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        return $id;

        $stmt -> close();

        $stmt = null;
    }

    public function getFollowings($id){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("SELECT `u`.`id`, `u`.`apellido`, `u`.`nombre`, `u`.`email`, `u`.`nombreusuario`, `u`.`foto_contenido`, `u`.`foto_tipo` FROM ".self::USERS_TABLENAME." `u`
	        INNER JOIN ".self::FOLLOWINGS_TABLENAME." `s` ON(`s`.`usuarioseguido_id` = `u`.`id`)
            WHERE `s`.`usuarios_id` = :userId");

        $stmt -> bindParam(":userId", $id, PDO::PARAM_INT);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        foreach($stmt->fetchAll() as $key => $temp){
            $users[$key] = new User($temp["id"],$temp["nombre"],$temp["apellido"],$temp["email"],$temp["nombreusuario"],$temp["foto_contenido"],$temp["foto_tipo"]);
        }

        return $users;

        $stmt -> close();

        $stmt = null;
    }

    public function getFollowers($id){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("SELECT `u`.`id`, `u`.`apellido`, `u`.`nombre`, `u`.`email`, `u`.`nombreusuario`, `u`.`foto_contenido`, `u`.`foto_tipo` FROM ".self::USERS_TABLENAME." `u`
	        INNER JOIN ".self::FOLLOWINGS_TABLENAME." `s` ON(`s`.`usuarios_id` = `u`.`id`)
            WHERE `s`.`usuarioseguido_id` = :userId");

        $stmt -> bindParam(":userId", $id, PDO::PARAM_INT);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        foreach($stmt->fetchAll() as $key => $temp){
            $users[$key] = new User($temp["id"],$temp["nombre"],$temp["apellido"],$temp["email"],$temp["nombreusuario"],$temp["foto_contenido"],$temp["foto_tipo"]);
        }

        return $users;

        $stmt -> close();

        $stmt = null;
    }

    public function getPaginationMessages($id, $origin=0, $rows=10){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("SELECT `m`.`id`, `m`.`texto`, `m`.`imagen_contenido`, `m`.`imagen_tipo`, `m`.`usuarios_id`, DATE_FORMAT(`m`.`fechayhora`, '%d/%m/%Y %H:%m') AS `fechayhora` FROM ".self::MESSAGES_TABLENAME." `m` WHERE `m`.`usuarios_id` = :userId ORDER BY `m`.`fechayhora` DESC LIMIT :origin, :rows");

        $stmt -> bindParam(":userId", $id, PDO::PARAM_INT);
        $stmt -> bindParam(":origin", $origin, PDO::PARAM_INT);
        $stmt -> bindParam(":rows", $rows, PDO::PARAM_INT);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        foreach($stmt->fetchAll() as $key => $temp){
            $messages[$key] = new Message($temp["id"],$temp["texto"],$temp["imagen_contenido"],$temp["imagen_tipo"],$temp["usuarios_id"],$temp["fechayhora"]);
        }

        return $messages;

        $stmt -> close();

        $stmt = null;
    }

    public function getAllMessages($id){
        $db = new DatabaseConnection();
        $connection = $db->getConnection();
        $stmt = $connection->prepare("SELECT `m`.`id`, `m`.`texto`, `m`.`imagen_contenido`, `m`.`imagen_tipo`, `m`.`usuarios_id`, DATE_FORMAT(`m`.`fechayhora`, '%d/%m/%Y %H:%m') AS `fechayhora` FROM ".self::MESSAGES_TABLENAME." `m` WHERE `m`.`usuarios_id` = :userId ORDER BY `m`.`fechayhora` DESC");

        $stmt -> bindParam(":userId", $id, PDO::PARAM_INT);

        if(!$stmt -> execute()) {
            print_r(DatabaseConnection::getConnection()->errorInfo());
            return null;
        }

        foreach($stmt->fetchAll() as $key => $temp){
            $messages[$key] = new Message($temp["id"],$temp["texto"],$temp["imagen_contenido"],$temp["imagen_tipo"],$temp["usuarios_id"],$temp["fechayhora"]);
        }

        return $messages;

        $stmt -> close();

        $stmt = null;
    }

}

?>