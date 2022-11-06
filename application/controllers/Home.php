<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	private $headers = [
		'Cookie: _gcl_au=1.1.1835502260.1667234316; _ga=GA1.2.199016677.1667234319; _fbp=fb.1.1667234320766.2078968372; _hjSessionUser_1452095=eyJpZCI6IjhkNzIwYjAwLTQ0ZjctNWQ4Yy05YTRiLWE4NmZiM2M0Yjc5OSIsImNyZWF0ZWQiOjE2NjcyMzQzMjA1OTAsImV4aXN0aW5nIjp0cnVlfQ==; _fbc=fb.1.1667236002799.IwAR2ONyM-1vRlVv1-OWyZoN6EmnPaprMQhJEcCrKhTlWaOdsw5v8q8Chk0v4; mp_b1b70785d8261b9071651f48effc4f72_mixpanel=%7B%22distinct_id%22%3A%20%221842ee8bbf7117b-0bd70e27f3c85a-26021f51-1fa400-1842ee8bbf8f42%22%2C%22%24device_id%22%3A%20%221842ee8bbf7117b-0bd70e27f3c85a-26021f51-1fa400-1842ee8bbf8f42%22%2C%22%24initial_referrer%22%3A%20%22https%3A%2F%2Fwww.acvauctions.com%2F%22%2C%22%24initial_referring_domain%22%3A%20%22www.acvauctions.com%22%7D; _uetvid=78d0ff80593a11edb18e93ca78a53819; PHPSESSID=i49s8mq6udpg2lof3t1cefi40n'
	];

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('loggedin')) redirect('auth/login');
		$this->load->model('dbmodel');
	}

	public function index(){
		$data['states'] = $this->dbmodel->getStates();
		$this->load->view('home', $data);
	}

	public function getData()
	{
		
		// *** GET FILTERS
		$filterCount = null;
		if($this->input->post('pickupState')){
			$filterCount = count($this->input->post('pickupState'));
		}else{
			echo json_encode(['status' => 'error', 'message' => 'No filter provided']);
			return;
		}

		// convert serialized array to normal filters array
		$filters = [];
		for($i=0; $i<$filterCount; $i++){
			array_push($filters, [
				'pickupState' 	 => $this->input->post('pickupState')[$i],
				'pickupZip' 	 => $this->input->post('pickupZip')[$i],
				'deliveryState' => $this->input->post('deliveryState')[$i],
				'payout' 		 => $this->input->post('payout')[$i],
			]);
		}

		// $filters = [
		// 	[
		// 		'pickupState' => 'DE',
		// 		'deliveryState' => 'Any',
		// 		'pickupZip' => '',
		// 		'payout' => '',
		// 	]
		// ];


		// *** GET DATA

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'https://transport.acvauctions.com/jobs/available.php');
		curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($curl);
		curl_close($curl);

		$this->load->helper('simple_html_dom');
		$html = str_get_html($output);

		if(!$html){
			echo json_encode(['status' => 'error', 'message' => 'Could not get data from website']);
			return;
		}

		$data = [];
		foreach ($html->find('tr.rowheight') as $tr) {
			$row = [];
			foreach ($tr->find('td') as $td) 
				array_push($row, $td);
			
			array_push($data, [
				'orderId2' 		=> strip_tags($row[0]->find('input', 1)->value), 
				'orderId' 		=> strip_tags($row[1]), 
				// 'date' 			=> strip_tags($row[2]), 
				'vehicle'		=> strip_tags($row[3]),
				// 'pickupCity' 	=> strip_tags($row[7]), 
				'pickupState' 	=> strip_tags($row[8]), 
				'pickupZip'		=> strip_tags($row[9]), 
				// 'deliveryCity' => strip_tags($row[11]), 
				'deliveryState'=> strip_tags($row[12]),
				'deliveryZip'	=> strip_tags($row[13]), 
				// 'distance'		=> strip_tags($row[14]), 
				'payout'			=> trim(str_replace('$', '', strip_tags($row[15])))
			]);
		}


		$matchedArray = [];

		foreach($data as $d){
			foreach($filters as $f){
				if(
					(strtolower($f['pickupState']) == 'any' ? true : $d['pickupState'] == $f['pickupState']) && 
					(strtolower($f['deliveryState']) == 'any' ? true : $d['deliveryState'] == $f['deliveryState']) && 
					(strlen($f['pickupZip']) > 0 ? $d['pickupZip'] == $f['pickupZip'] : true) && 
					($f['payout'] > 0 ? $d['payout'] >= $f['payout'] : true)
				){
					array_push($matchedArray, [
						'orderId'	  => $d['orderId'],
						'orderId2'	  => $d['orderId2'], //used for staging
						'vehicle'	  => $d['vehicle'],
						'pickupState' => $d['pickupState'],
						'pickupZip'   => $d['pickupZip'],
						'deliveryState' => $d['deliveryState'],
						'payout'   	  => $d['payout'],
					]);
					break;
				}
			}
		}

		echo json_encode(['status' => 'success', 'data' => $matchedArray]);
		return;
	}



	public function stage(){
		$postfields=[
			'Submit' => 'Select Jobs',
			// 'selected[]' =>	845730,
			'selected[]' =>	849378
		];

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'https://transport.acvauctions.com/jobs/staged.php');
		curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($curl);
		curl_close($curl);

		echo $output;
	}
}
