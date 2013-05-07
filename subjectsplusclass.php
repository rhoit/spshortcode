<?php 

class subjectsplus_info {

	public function __construct() {
	}

	private $sp_key;
	private $sp_url;
	private $sp_output_xml;
	private $sp_staff; 
	private $sp_query;

	// Getter and setter for the API key
	public function set_sp_key($sp_key) {
		$this->sp_key = $sp_key;
	}

	public function get_sp_key() {
		return $this->sp_key;
	}

	// Getter and setter for the API base URL
	public function set_sp_url($sp_url) {
		$this->sp_url = $sp_url;
	}

	public function get_sp_url() {
		return $this->sp_url;
	}

	// Getter and setter for the SP query

	public function set_sp_query($sp_query) {
		$this->sp_query = $sp_query;
	}

	public function get_sp_query() {
		return $this->sp_query;
	}

	// Function to perform a staff query

	public function do_sp_staff_query($sp_display) {

		$query = $this->sp_url . $this->sp_query . $this->sp_key;

		$response = wp_remote_get( $query );
			if( is_wp_error( $response ) ) {
   				$error_message = $response->get_error_message();
   				echo "Something went wrong: $error_message";
			} else {


			   $staff_info = json_decode($response[body], true);

			   if($sp_display == 'plain') {
			   foreach ($staff_info['staff-member'] as $staff) {

			   		echo $staff['fname'];
			   		
			   		echo $staff['lname'];
			   		
			   		echo $staff['title'];
			   		
			   		echo $staff['tel'];
			   		
			   		echo $staff['email'];
			   		
			   		echo $staff['bio'];
			   		

			   }

			}


			if($sp_display == 'table') {
				echo '<table width="98%" class="item_listing" cellspacing="0" cellpadding="3">
				<tbody><tr><th>Name</th><th>Title</th><th>Phone</th><th>Email</th></tr>';

			  foreach ($staff_info['staff-member'] as $staff) {
			  		echo "<tr>";
			   		echo td($staff['fname']);
			   		echo td($staff['lname']);
			   		echo td($staff['title']);
			   		echo td($staff['tel']);
			   		echo td($staff['email']);
			   		echo "</tr>";
			   }
			   echo '</tbody></table>';


			}

			}

	}

	// Function to perform a database service query 

	public function do_sp_database_query() {

		$query = $this->sp_url . $this->sp_query . $this->sp_key;

		$response = wp_remote_get( $query );
			if( is_wp_error( $response ) ) {
   				$error_message = $response->get_error_message();
   				echo "Something went wrong: $error_message";
			} else {


			   $database_info = json_decode($response[body], true);


			   foreach ($database_info['database'] as $database) {
			   		echo a_link($database['location'], $database['title']);
			   		echo br($database['description']);
			   	
			   		
			   	
			   }


			}
	}



	public function do_sp_guide_query() {

		$query = $this->sp_url . $this->sp_query . $this->sp_key;

	
		$response = wp_remote_get( $query );
			if( is_wp_error( $response ) ) {
   				$error_message = $response->get_error_message();
   				echo "Something went wrong: $error_message";

			} else {


			   $database_info = json_decode($response[body], true);


			   foreach ($database_info['database'] as $database) {
			   		echo a_link($database["location"], $database["link"]);
			   		echo br_print($database['description']);
			 
			   		
			   	
			   }


			}
	
	}


	// This function determines what kind of query to make based on shortcode input.
	public function setup_sp_query($atts) {
		$sp_type = $atts['service'];
		$sp_display = $atts['display'];

		if ($sp_type != '') {

			if($sp_type == 'staff') {

				if (array_key_exists('email', $atts)) {
					$this->sp_query = "$sp_type/email/$atts[email]/";
					$query = $this->sp_url . $this->sp_query . $this->sp_key;
				return $this->do_sp_staff_query($sp_display);
				}


				if (array_key_exists('department', $atts)) {
					$this->sp_query = "$sp_type/department/$atts[department]/";
					$query = $this->sp_url . $this->sp_query . $this->sp_key;
				return $this->do_sp_staff_query($sp_display);
				}

			}

			if($sp_type == 'database') {

				if (array_key_exists('letter', $atts)) {
					$this->sp_query = "$sp_type/letter/$atts[letter]/";
					$query = $this->sp_url . $this->sp_query . $this->sp_key;

				return $this->do_sp_database_query($sp_display);
				}

				if (array_key_exists('search', $atts)) {
					$this->sp_query = "$sp_type/search/$atts[search]/";
					$query = $this->sp_url . $this->sp_query . $this->sp_key;
				return $this->do_sp_database_query($sp_display);
				}

				if (array_key_exists('subject_id', $atts)) {
					$this->sp_query = "$sp_type/subject_id/$atts[subject_id]/";
					$query = $this->sp_url . $this->sp_query . $this->sp_key;
				return $this->do_sp_database_query($sp_display);
				}

				if (array_key_exists('type', $atts)) {
					$this->sp_query = "$sp_type/type/$atts[type]/";
					$query = $this->sp_url . $this->sp_query . $this->sp_key;
				return $this->do_sp_database_query($sp_display);
				}


			}

		}


		

	}


}

?>