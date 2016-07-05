<?php

//if uninstall not called from WordPress exit

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ){ 
    exit();
}

global $wpdb;

$option_name = 'BuilderUX_database_version';

delete_option( $option_name );

//$table_name = $wpdb->prefix ."rico";

$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}builderUXWarranty_BuilderUXInhouse" );
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}builderUXWarranty_BuilderUXInhousedata" );
$wpdb->query( "DELETE FROM `wp_posts` WHERE `post_title` = 'Builderux Warranty Request'");
$wpdb->query("DELETE FROM `wp_options` WHERE `option_name` = 'builderux-warranty-request'");
$wpdb->query( "DELETE FROM `wp_usermeta` WHERE `meta_value` =  'BuilderUXWarranty'");
$wpdb->query( "DELETE FROM `wp_users` WHERE `user_nicename` = 'BuilderUXWarranty'");

?>