<?php

class User {

    private $id;
    private $name;
    private $lastname;
    private $email;
    private $username;
    private $password;
    private $photo_content;
    private $photo_type;
    private $followers;
    private $followings;
    private $messages;


    public function __construct($id, $name, $lastname, $email, $username, $password){
        $this->id = $id;
        $this->name = $name;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
    }


    public function __construct1($id, $name, $lastname, $email, $username, $password, $photo_content, $photo_type){
        $this->__construct($id, $name, $lastname, $email, $username, $password);
        $this->photo_content = $photo_content;
        $this->photo_type = $photo_type;
    }

    public function __construct2($id, $name, $lastname, $email, $username, $password, $photo_content, $photo_type, $followers, $followings, $messages){
        $this->__construct1($id, $name, $lastname, $email, $username, $password, $photo_content, $photo_type);
        $this->followers = $followers;
        $this->followings = $followings;
        $this->messages = $messages;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->id = $name;
    }

    public function getLastname(){
        return $this->lastname;
    }

    public function setLastname($lastname){
        $this->id = $lastname;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->id = $email;
    }

    public function getUsername(){
        return $this->username;
    }

    public function setUsername($username){
        $this->id = $username;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setPassword($password){
        $this->id = $password;
    }

    public function getPhotoContent(){
        return $this->photo_content;
    }

    public function setPhotoContent($photo_content){
        $this->id = $photo_content;
    }

    public function getPhotoType(){
        return $this->photo_type;
    }

    public function setPhotoType($photo_type){
        $this->id = $photo_type;
    }

    public function getFollowers(){
        return $this->followers;
    }

    public function setFollowers($followers){
        $this->followers = $followers;
    }

    public function getFollowings(){
        return $this->followings;
    }

    public function setFollowings($followings){
        $this->followings = $followings;
    }

    public function getMessages(){
        return $this->messages;
    }

    public function setMessages($messages){
        $this->messages = $messages;
    }

    public function __toString(){
        return '['.'id='.$this->id.', name='.$this->name.', lastname='.$this->lastname.', email='.$this->email.', username='.$this->username.', password='.$this->password.', photo_content='.$this->photo_content.', photo_type='.$this->photo_type.']';
    }
    
}

?>