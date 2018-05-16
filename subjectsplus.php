<?php
  /*
    Plugin Name: Subjectsplus Shortcodes
    Plugin URI: https://github.com/rhoit/spshortcode
    Description: A demonstration of the subjectsplus api using Wordpress shortcodes
    Version: 0.1
    Author: James Little
    License:
  */


include('subjectsplusclass.php');

function get_sp($atts) {
    extract(
        shortcode_atts(
            array(
                // Misc attributes
                'service' => '',
                'display' => 'plain',
                'max' => '',
                //Staff attributes
                'email' => '',
                'department' => '',
                'limit' => '99',

                //Database attributes
                'letter' => '',
                'limit' => '99',
                'search' => '',
                'subject_id' => '',
                'type' => ''),
            $atts));

    $subjectsplus = new subjectsplus_info();
    $subjectsplus->set_sp_url("http://localhost/sp/api/");
    $subjectsplus->set_sp_key("18Oc4qyugxyykBwhDlCl");
    $subjectsplus->setup_sp_query($atts);
}

add_shortcode( 'sp', 'get_sp' );
?>
