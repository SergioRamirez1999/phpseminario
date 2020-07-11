<?php

class User implements JsonSerializable {

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

    public function __construct(){
        //obtengo un array con los parámetros enviados a la función
        $params = func_get_args();
		//saco el número de parámetros que estoy recibiendo
		$num_params = func_num_args();
		//cada constructor de un número dado de parámtros tendrá un nombre de
		//atendiendo al siguiente modelo __construct1() __construct2()...
		$funcion_constructor ='__construct'.$num_params;
		//compruebo si hay un constructor con ese número de parámetros
		if (method_exists($this,$funcion_constructor)) {
			//si existía esa función, la invoco, reenviando los parámetros que recibí en el constructor original
			call_user_func_array(array($this,$funcion_constructor),$params);
		}
    }

    public function __construct5($id, $name, $lastname, $email, $username){
        $this->id = $id;
        $this->name = $name;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->username = $username;
    }

    public function __construct6($id, $name, $lastname, $email, $username, $password){
        $this->__construct5($id, $name, $lastname, $email, $username);
        $this->password = $password;
    }

    public function __construct7($id, $name, $lastname, $email, $username, $photo_content, $photo_type){
        $this->__construct5($id, $name, $lastname, $email, $username);
        $this->photo_content = $photo_content;
        $this->photo_type = $photo_type;
    }

    public function __construct8($id, $name, $lastname, $email, $username, $password, $photo_content, $photo_type){
        $this->__construct6($id, $name, $lastname, $email, $username, $password);
        $this->photo_content = $photo_content;
        $this->photo_type = $photo_type;
    }

    public function __construct11($id, $name, $lastname, $email, $username, $password, $photo_content, $photo_type, $followers, $followings, $messages){
        $this->__construct8($id, $name, $lastname, $email, $username, $password, $photo_content, $photo_type);
        $this->followers = $followers;
        $this->followings = $followings;
        $this->messages = $messages;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'username' => $this->username,
            'password' => $this->password,
            'photo_content' => base64_encode($this->photo_content),
            'photo_type' => $this->photo_type,
            'followers' => $this->followers,
            'followings' => $this->followings,
            'messages' => $this->messages
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

    public function getPassword(){
        return $this->password;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getPhotoContent(){
        return $this->photo_content;
    }

    public function setPhotoContent($photo_content){
        $this->photo_content = $photo_content;
    }

    public function getPhotoType(){
        return $this->photo_type;
    }

    public function setPhotoType($photo_type){
        $this->photo_type = $photo_type;
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