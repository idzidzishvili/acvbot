<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Model
{
   
   public function getUsers()
	{
		return $this->db->select('*')->from('users')->order_by('admin', 'DESC')->get()->result();
	}

	public function getUserdataById($id)
	{
		return $this->db->select('*')->from('users')->where('id', $id)->get()->row();
	}

	public function getUserByUsername($username)
	{
		return $this->db->select('*')->from('users')->where('username', $username)->get()->row();
	}

	public function addUser($fullname, $email, $password, $role)
	{
		$this->db->insert('users', [
			'username' => $fullname,
			'email' 	  => $email,
			'password' => $password,
			'admin' 	  => $role
		]);
		return $this->db->insert_id();
	}

	public function updateUser($id, $username, $email, $password, $role)
	{
		return $this->db->where('id', $id)->update('users', array('username' => $username, 'email' => $email, 'password' => $password, 'admin' => $role));
	}

	public function updatePassword($id, $password)
	{
		return $this->db->where('id', $id)->update('users', array('password' => $password));
	}
	
	public function updateStatus($id, $status)
	{
		return $this->db->where('id', $id)->update('users', array('status' => $status));
	}





}
