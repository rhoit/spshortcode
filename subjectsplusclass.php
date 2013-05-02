<?php 
class subjectsplus_info {
	private $sp_key;
	private $sp_url;
	private $sp_output_xml;
	private $sp_staff; 
	private $sp_query;

	public function set_sp_key($sp_key) {
		$this->sp_key = $sp_key;
	}

	public function get_sp_key() {
		return $this->sp_key;
	}

	public function set_sp_url($sp_url) {
		$this->sp_url = $sp_url;
	}

	public function get_sp_url() {
		return $this->sp_url;
	}

	public function set_sp_output_xml($sp_output_xml) {
		$this->sp_output_xml = $sp_output_xml;
	}

	public function get_sp_output_xml() {
		return $this->sp_output_xml;
	}


	public function set_sp_staff($sp_staff) {
		$this->sp_staff = $sp_staff;
	}


	public function get_sp_staff() {
		return $this->sp_staff;
	}

	public function set_sp_query($sp_query) {
		$this->sp_query = $sp_query;
	}

	public function get_sp_query() {
		return $this->sp_query;
	}

	public function do_sp_staff_query() {

		$query = $this->sp_url . $this->sp_query . $this->sp_key;

	

		$response = wp_remote_get( $query );
			if( is_wp_error( $response ) ) {
   				$error_message = $response->get_error_message();
   				echo "Something went wrong: $error_message";
			} else {


			   $staff_info = json_decode($response[body], true);

			   foreach ($staff_info['staff-member'] as $staff) {

			   		echo $staff['fname'];
			   		echo ' ';
			   		echo $staff['lname'];
			   		echo '<br/>';
			   		echo $staff['title'];
			   		echo '<br/>';
			   		echo $staff['tel'];
			   		echo '<br/>';
			   		echo $staff['email'];
			   		echo '<br/>';
			   		echo $staff['bio'];
			   		echo '<br/>';

			   }


			}
		
		

	}

	public function do_sp_database_query() {

		$query = $this->sp_url . $this->sp_query . $this->sp_key;

	

		$response = wp_remote_get( $query );
			if( is_wp_error( $response ) ) {
   				$error_message = $response->get_error_message();
   				echo "Something went wrong: $error_message";
			} else {


			   $database_info = json_decode($response[body], true);

			   foreach ($database_info['database'] as $database) {
			   		echo "<a href='{$database["location"]}'/>";

			   		echo $database['title'];
			   		echo "</a>";
			   		echo ' ';
			   		echo $database['description'];
			   		echo '<br/>';
			   		echo $database['location'];
			   		echo '<br/>';
			   	
			   }


			}
		
		

	}

	

}







?>