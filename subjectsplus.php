<?php
/*
Plugin Name: Subjectsplus Shortcode
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A demonstration of the subjectsplus api using Wordpress shortcodes
Version: 0.1
Author: James Little
Author URI: http://URI_Of_The_Plugin_Author
License: 
*/


include('subjectsplusclass.php');

/* Staff */

function get_staff( $atts ){

extract( shortcode_atts( array(
		'email' => '',
		'department' => '', 
		'limit' => '99',


	), $atts ) );

$subjectsplus = new subjectsplus_info();
$subjectsplus->set_sp_url("http://subjectsplus.com/spum/api/");
$subjectsplus->set_sp_key("key/tPEd9gxW8inwcBj4mNq7");

if ("{$email}" != '') {
	$subjectsplus->set_sp_query("staff/email/{$email}/");
	return $subjectsplus->do_sp_staff_query();
}

if ("{$department}" != '') {
	$subjectsplus->set_sp_query("staff/{$department}/{$limit}/");
	return $subjectsplus->do_sp_staff_query();

}
	



}

add_shortcode( 'staff', 'get_staff' );


function get_database( $atts ){

extract( shortcode_atts( array(
		'letter' => '',
		'limit' => '99',
		'search' => '',
		'subject_id' => '',
		'type' => ''


	), $atts ) );

$subjectsplus = new subjectsplus_info();
$subjectsplus->set_sp_url("http://subjectsplus.com/spum/api/");
$subjectsplus->set_sp_key("key/tPEd9gxW8inwcBj4mNq7");

if ("{$letter}" != '') {
	$subjectsplus->set_sp_query("database/letter/{$letter}/");
	return $subjectsplus->do_sp_database_query();
}

if ("{$search}" != '') {
	$subjectsplus->set_sp_query("database/search/{$search}/");
	return $subjectsplus->do_sp_database_query();
}

if ("{$subject_id}" != '') {
	$subjectsplus->set_sp_query("database/subject_id/{$subject_id}/");
	return $subjectsplus->do_sp_database_query();
}


if ("{$type}" != '') {
	$subjectsplus->set_sp_query("database/type/{$type}/");
	return $subjectsplus->do_sp_database_query();
}

}

add_shortcode( 'database', 'get_database' );








?>