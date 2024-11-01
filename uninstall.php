<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

delete_option('space_dir_1');
delete_option('space_dir_2');
delete_option('space_dir_3');
delete_option('space_dir_4');
 
// for site options in Multisite
delete_site_option('space_dir_1');
delete_site_option('space_dir_2');
delete_site_option('space_dir_3');
delete_site_option('space_dir_4');