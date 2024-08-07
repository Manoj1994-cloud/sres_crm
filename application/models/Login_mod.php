<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login_mod extends CI_Model{

	public function CheckLogin($str){
		$this->db->where(array('username'=>$str['username'],'password'=>$str['password']));
		$query=$this->db->get('users');
        return $query->result();
        // print_r($query);
        // die;
	}
    
    public function create_user($data)
    {
        if (isset($data['username']) && isset($data['password']) && isset($data['email'])) {
            return $this->db->insert('users', $data);
        }
        return FALSE;
    }
}
?>
