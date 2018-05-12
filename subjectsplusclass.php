<?php

class subjectsplus_info {
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


	public function do_sp_staff_query($sp_display) {
        // Function to perform a staff query

		$query = $this->sp_url . $this->sp_query . 'key/' . $this->sp_key;

		// Send a get request to the SP API with the wordpress remote function
		$response = wp_remote_get( $query );
        if( is_wp_error( $response ) ) {
            $error_message = $response->get_error_message();
            echo "Error: $error_message";
        } else {
            $staff_info = json_decode($response[body], true);

            if($sp_display == 'plain') {
                foreach ($staff_info['staff-member'] as $staff) {
			   		echo p_print($staff['fname'] . ' '  . $staff['lname']);
			   		echo p_print($staff['title']);
			   		echo p_print($staff['tel']);
			   		echo p_print($staff['email']);
                }
			}

			if($sp_display == 'table') {
				echo '<table width="98%" class="item_listing" cellspacing="0" cellpadding="0">';
                echo '<thead><tr>';
                echo '<th>Name</th>';

                echo '<th>Title</th>';
                echo '<th>Phone</th>';
                echo '<th>Email</th>';
                echo '</tr></thead><tbody>';

                foreach ($staff_info['staff-member'] as $staff) {
			  		echo "<tr>";
			   		echo td($staff['fname'] . ' ' . $staff['lname']);
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
                echo p_print($database['description']);



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

            $guide_info = json_decode($response[body], true);

            foreach ($guide_info['guide'] as $guide) {

                echo a_link($guide['url'],$guide['title']);


            }


        }

	}

	// This function determines what kind of query to make based on shortcode input.
	public function setup_sp_query($atts) {
		$sp_type = sanitize_string($atts['service']);
		$sp_display = sanitize_string($atts['display']);


		// Set a default max if max attribute isn't used
		if ($atts[max] == 0) {
			$atts[max] = '99';
		}

		switch($sp_type) {
        case 'staff':
            if (array_key_exists('email', $atts)) {
                $sp_email = sanitize_string($atts['email']);
                $sp_max = sanitize_string($atts['max']);
                $this->sp_query = "$sp_type/email/$sp_email/max/$sp_max/";
                $query = $this->sp_url . $this->sp_query . $this->sp_key;
				return $this->do_sp_staff_query($sp_display);
            }


            if (array_key_exists('department', $atts)) {
                $sp_department = sanitize_string($atts['department']);
                $this->sp_query = "$sp_type/department/$sp_department/max/$atts[max]/";
                $query = $this->sp_url . $this->sp_query . $this->sp_key;
				return $this->do_sp_staff_query($sp_display);
            }

            $this->sp_query = "$sp_type/";
            $query = $this->sp_url . $this->sp_query . $this->sp_key;
            return $this->do_sp_staff_query($sp_display);
			break;

        case 'database':

            if (array_key_exists('letter', $atts)) {
                $this->sp_query = "$sp_type/letter/$atts[letter]/max/$atts[max]/";
                $query = $this->sp_url . $this->sp_query . $this->sp_key;

				return $this->do_sp_database_query($sp_display);
            }

            if (array_key_exists('search', $atts)) {
                $sp_search = sanitize_string($atts[search]);

                $this->sp_query = "$sp_type/search/$sp_search/max/$atts[max]/";
                $query = $this->sp_url . $this->sp_query . $this->sp_key;
				return $this->do_sp_database_query($sp_display);
            }

            if (array_key_exists('subject_id', $atts)) {
                $this->sp_query = "$sp_type/subject_id/$atts[subject_id]/max/$atts[max]/";
                $query = $this->sp_url . $this->sp_query . $this->sp_key;
				return $this->do_sp_database_query($sp_display);
            }

            if (array_key_exists('type', $atts)) {
                $this->sp_query = "$sp_type/type/$atts[type]/max/$atts[max]/";
                $query = $this->sp_url . $this->sp_query . $this->sp_key;
				return $this->do_sp_database_query($sp_display);
            }
			break;

        case 'guides':

            if (array_key_exists('shortform', $atts)) {
                $sp_search = sanitize_string($atts[search]);

                $this->sp_query = "$sp_type/shortform/$sp_search/max/$atts[max]/";
                $query = $this->sp_url . $this->sp_query . $this->sp_key;
				return $this->do_sp_guide_query($sp_display);
            }

            if (array_key_exists('subject_id', $atts)) {
                $this->sp_query = "$sp_type/subject_id/$atts[subject_id]/max/$atts[max]/";
                $query = $this->sp_url . $this->sp_query . $this->sp_key;
				return $this->do_sp_guide_query($sp_display);
            }

            if (array_key_exists('type', $atts)) {
                $this->sp_query = "$sp_type/type/$atts[type]/max/$atts[max]/";
                $query = $this->sp_url . $this->sp_query . $this->sp_key;
				return $this->do_sp_guide_query($sp_display);
            }
			break;

		}
	}
}





// Some functions to make html easier to work with in the code

function p_print($content) {

	return "<p class='sp_content'>" . $content . "</p>";
}

function a_link($url, $link) {

	return "<a href=$url>$link</a>" ;
}


function td($content) {

	return "<td>$content</td>";
}

function sanitize_string($string) {
	return urlencode(filter_var($string, FILTER_SANITIZE_STRING));
}


?>
