<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dbmodel extends CI_Model
{
	public function getStates()
	{
      return $this->db->select('*')->from('states')->get()->result();
   }

}