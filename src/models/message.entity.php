<?php

class Message {

    private $id;
    private $text_content;
    private $image_content;
    private $image_type;
    private $id_user_fk;
    private $create_at;
    private $likes;


    public function __construct($id, $text_content, $id_user_fk, $create_at){
        $this->id = $id;
        $this->text_content = $text_content;
        $this->id_user_fk = $id_user_fk;
        $this->create_at = $create_at;
    }


    public function __construct1($id, $text_content, $image_content, $image_type, $id_user_fk, $create_at){
        $this->__construct($id, $text_content, $id_user_fk, $create_at);
        $this->image_content = $image_content;
        $this->image_type = $image_type;
    }

    public function __construct2($id, $text_content, $image_content, $image_type, $id_user_fk, $create_at, $likes){
        $this->__construct1($id, $text_content, $image_content, $image_type, $id_user_fk, $create_at);
        $this->likes = $likes;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getText(){
        return $this->text_content;
    }

    public function setText($text_content){
        $this->id = $text_content;
    }

    public function getImageContent(){
        return $this->image_content;
    }

    public function setImageContent($image_content){
        $this->id = $image_content;
    }

    public function getImageType(){
        return $this->image_type;
    }

    public function setImageType($image_type){
        $this->id = $image_type;
    }

    public function getIdUserFk(){
        return $this->id_user_fk;
    }

    public function setIdUserFk($id_user_fk){
        $this->id = $id_user_fk;
    }

    public function getCreateAt(){
        return $this->create_at;
    }

    public function setCreateAT($create_at){
        $this->id = $create_at;
    }

    public function getLikes(){
        return $this->likes;
    }

    public function setLikes($likes){
        $this->id = $likes;
    }

   
    public function __toString(){
        return '['.'id='.$this->id.', text_content='.$this->text_content.', image_content='.$this->image_content.', image_type='.$this->image_type.', id_user_fk='.$this->id_user_fk.', create_at='.$this->create_at.', likes='.$this->likes.']';
    }
    
}

?>