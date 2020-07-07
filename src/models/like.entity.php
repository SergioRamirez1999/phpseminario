<?php
class Like {

    private $id;
    private $id_user_fk;
    private $id_message_fk;


    public function __construct(){
        $params = func_get_args();
		$num_params = func_num_args();
		$funcion_constructor ='__construct'.$num_params;
		if (method_exists($this,$funcion_constructor)) {
			call_user_func_array(array($this,$funcion_constructor),$params);
		}
    }

    public function __construct3($id, $id_user_fk, $id_message_fk){
        $this->id = $id;    
        $this->id_user_fk = $id_user_fk;
        $this->id_message_fk = $id_message_fk;
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
        $this->id_user_fk = $id_user_fk;
    }

    public function getIdMessageFk(){
        return $this->id_message_fk;
    }

    public function setIdMessageFk($id_message_fk){
        $this->id_message_fk = $id_message_fk;
    }

    public function __toString(){
        return '['.'id='.$this->id.', id_user_fk='.$this->id_user_fk.', id_message_fk='.$this->id_message_fk.']';
    }
}
?>