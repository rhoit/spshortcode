<?php
/*
  Plugin Name: Subjectsplus Shortcodes
  Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
  Description: A demonstration of the subjectsplus api using Wordpress shortcodes
  Version: 0.1
  Author: James Little
  Author URI: http://URI_Of_The_Plugin_Author
  License: 
*/


include('subjectsplusclass.php');

function get_sp( $atts ){

  extract( shortcode_atts( array(
				 // Misc attributes
				 'service' => '',
				 'display' => 'plain',

				 //Staff attributes 

				 'email' => '',
				 'department' => '', 
				 'limit' => '99',
				 //Database attributes
				 'letter' => '',
				 'limit' => '99',
				 'search' => '',
				 'subject_id' => '',
				 'type' => ''
				 ), $atts ) );



  $subjectsplus = new subjectsplus_info();
  $subjectsplus->set_sp_url("http://subjectsplus.com/spum/api/");
  $subjectsplus->set_sp_key("key/tPEd9gxW8inwcBj4mNq7");
  $subjectsplus->setup_sp_query($atts);

}

add_shortcode( 'sp', 'get_sp' );
?>


