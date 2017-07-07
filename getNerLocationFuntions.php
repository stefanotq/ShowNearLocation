<?php
function NearLocationController(){
		
		$param = array();
		$lat = $this->uri->segment(3);
		$long = $this->uri->segment(4);
		
		
		$data = array();
		$data['latitud'] = $lat;
		$data['longitud'] = $long;
		
		$data['near'] = $this->NearLocationModel($param);
		
		$this->load->view('directions', $data);
		
	}
	
	
function NearLocationModel($lat, $long){
		
		$result = $this->db->query("sp_get_near_location_by_lat_long @latitude='$lat',  @longitude='$long'");
		
		$data= array();
		
		foreach($result->result() as $row){
				
				$info['name'] = $row->name;
				$info['directions'] = $row->directions;
				$info['lan'] = $row->lan;
				$info['long'] = $row->long;
				$info['place'] = $row->id_place;
								
				$data[] = $info;
		}
		
	
		return $data;
	}
	
?>	