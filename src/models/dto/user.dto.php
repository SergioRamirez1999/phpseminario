<?php

class UserDto implements JsonSerializable {
    private $id;
    private $name;
    private $lastname;
    private $email;
    private $username;

    public function __construct($user){
        $this->id = $user->getId();
        $this->name = $user->getName();
        $this->lastname = $user->getLastname();
        $this->email = $user->getEmail();
        $this->username = $user->getUsername();
    }

    public function jsonSerialize(){
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'lastname' => $this->getLastname(),
            'email' => $this->getEmail(),
            'username' => $this->getUsername()
        ];
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
        $this->name = $name;
    }

    public function getLastname(){
        return $this->lastname;
    }

    public function setLastname($lastname){
        $this->lastname = $lastname;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getUsername(){
        return $this->username;
    }

    public function setUsername($username){
        $this->username = $username;
    }
}