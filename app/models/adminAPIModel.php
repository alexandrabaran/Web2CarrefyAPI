<?php

class adminAPIModel extends APIModel {
 
    public function getUserByEmail($email) {    
        $query = $this->db->prepare("SELECT * FROM admins WHERE email = ?"); //corregir, tabla vacia
        $query->execute([$email]);
    
        $user = $query->fetch(PDO::FETCH_OBJ);
    
        return $user;
    }
}
