<?php
class Following {
    private $id;
    private $id_user_fk;
    private $id_user_following_fk;

    public function __construct($id, $id_user_fk, $id_user_following_fk){
        $this->id = $id;    
        $this->id_user_fk = $id_user_fk;
        $this->id_user_following_fk = $id_user_following_fk;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getIdUserFk(){
        return $this->id_user_fk;
    }

    public function setIdUserFk($id_user_fk){
        $this->id = $id_user_fk;
    }

    public function getIdUserFollowingFk(){
        return $this->id_user_following_fk;
    }

    public function setIdUserFollowingFk($id_user_following_fk){
        $this->id = $id_user_following_fk;
    }

    public function __toString(){
        return '['.'id='.$this->id.', id_user_fk='.$this->id_user_fk.', id_user_following_fk='.$this->id_user_following_fk.']';
    }
}
?>