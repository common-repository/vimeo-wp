<?php
/*
Plugin Name: Vimeo WP
Plugin URI: http://plugins.wp-themes.ws/vimeo-wp/
Description: Displays your recent vimeo videos as a widget.
Version: 1.0.3
Author: WP-Themes.ws
Author URI: http://wp-themes.ws
*/

/*  Copyright 2010 WP-Themes.ws - support@wp-themes.ws

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Hook for adding admin menus
add_action('admin_menu', 'vimeo_wp_add_pages');

// action function for above hook
function vimeo_wp_add_pages() {
    add_options_page('Vimeo WP', 'Vimeo WP', 'administrator', 'vimeo_wp', 'vimeo_wp_options_page');
}

// vimeo_wp_options_page() displays the page content for the Test Options submenu
function vimeo_wp_options_page() {

    // variables for the field and option names 
    $opt_name = 'mt_vimeo_account';
    $opt_name_2 = 'mt_vimeo_limit';
	$opt_name_3 = 'mt_vimeo_query';
	$opt_name_4 = 'mt_vimeo_title2';
    $opt_name_5 = 'mt_vimeo_plugin_support';
    $opt_name_6 = 'mt_vimeo_title';
    $opt_name_9 = 'mt_vimeo_cache';
    $hidden_field_name = 'mt_vimeo_submit_hidden';
    $data_field_name = 'mt_vimeo_account';
    $data_field_name_2 = 'mt_vimeo_limit';
	$data_field_name_3 = 'mt_vimeo_query';
	$data_field_name_4 = 'mt_vimeo_title2';
    $data_field_name_5 = 'mt_vimeo_plugin_support';
    $data_field_name_6 = 'mt_vimeo_title';
    $data_field_name_9 = 'mt_vimeo_cache';

    // Read in existing option value from database
    $opt_val = get_option( $opt_name );
    $opt_val_2 = get_option($opt_name_2);
	$opt_val_3 = get_option($opt_name_3);
	$opt_val_4 = get_option($opt_name_4);
    $opt_val_5 = get_option($opt_name_5);
    $opt_val_6 = get_option($opt_name_6);
    $opt_val_9 = get_option($opt_name_9);

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $opt_val = $_POST[ $data_field_name ];
        $opt_val_2 = $_POST[$data_field_name_2];
		$opt_val_3 = $_POST[$data_field_name_3];
		$opt_val_4 = $_POST[$data_field_name_4];
        $opt_val_5 = $_POST[$data_field_name_5];
        $opt_val_6 = $_POST[$data_field_name_6];
        $opt_val_9 = $_POST[$data_field_name_9];

        // Save the posted value in the database
        update_option( $opt_name, $opt_val );
        update_option( $opt_name_2, $opt_val_2 );
		update_option( $opt_name_3, $opt_val_3 );
		update_option( $opt_name_4, $opt_val_4 );
        update_option( $opt_name_5, $opt_val_5 );
        update_option( $opt_name_6, $opt_val_6 ); 
        update_option( $opt_name_9, $opt_val_9 );

        // Put an options updated message on the screen

?>
<div class="updated"><p><strong><?php _e('Options saved.', 'mt_trans_domain' ); ?></strong></p></div>
<?php

    }

    // Now display the options editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'Vimeo WP Plugin Options', 'mt_trans_domain' ) . "</h2>";

    // options form
   
    $change3 = get_option("mt_vimeo_plugin_support");
    $change6 = get_option("mt_vimeo_cache");

if ($change3=="Yes" || $change3=="") {
$change3="checked";
$change31="";
} else {
$change3="";
$change31="checked";
}

if ($change5=="user" || $change5=="") {
$change5="checked";
$change51="";
} else {
$change5="";
$change51="checked";
}

    ?>
<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p><?php _e("Vimeo Widget Title:", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name_6; ?>" value="<?php echo $opt_val_6; ?>" size="50">
</p><hr />

<p><?php _e("Vimeo Account Username:", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" size="20">
</p><hr />

<p><?php _e("Number of Video URLs to Show:", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name_2; ?>" value="<?php echo $opt_val_2; ?>" size="3">
</p><hr />

<p><?php _e("Support the Vimeo WP Plugin?", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_5; ?>" value="Yes" <?php echo $change3; ?>>Yes
<input type="radio" name="<?php echo $data_field_name_5; ?>" value="No" <?php echo $change31; ?>>No
</p><hr />

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'mt_trans_domain' ) ?>" />
</p><hr />

</form>
</div>
<?php
 
}
function curl_get($url) {
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	$return = curl_exec($curl);
	curl_close($curl);
	return $return;
}

function show_vimeo_user($args) {

extract($args);

  $widget_title = get_option("mt_vimeo_title"); 
  $max_tracks = get_option("mt_vimeo_limit");  
  $optionvimeo = get_option("mt_vimeo_account");
  $supportplugin = get_option("mt_vimeo_plugin_support"); 
  $optionvimeocache = get_option("mt_vimeo_cache");
  $vimeoquery = get_option("mt_vimeo_query");
  
if (!$optionvimeo=="") {

$widget_title=str_replace("%user%", $optionvimeo, $widget_title);

$docload='http://vimeo.com/api/v2/'.stripslashes($optionvimeo).'/videos.xml';
$videos=simplexml_load_string(curl_get($docload));
if($videos) {

  $i = 1;
  
$vimeodisp="";

  $vimeodisp .= $before_widget; 

  $vimeodisp .= $before_title.stripslashes($widget_title).$after_title."<br /><ul>";

  foreach ($videos->video as $video):
    $vimeodisp .= '<li><a href="'.$video->url.'" rel="nofollow">'.$video->title.'</a><br />'.$video->description.'</li>';
    if($i++ >= $max_tracks) break;
	endforeach;
  }

  $vimeodisp .= "</ul>";
  
if ($supportplugin=="Yes" || $supportplugin=="") {
$vimeodisp .= "<p style='font-size:x-small'>Vimeo Plugin made by <a href='http://www.r4carddirect.co.uk'>R4 Card</a></p>";
}

$vimeodisp .= $after_widget;

echo $vimeodisp;

}

}


function init_vimeo_widget() {
register_sidebar_widget("Vimeo WP User Videos", "show_vimeo_user");
}

add_action("plugins_loaded", "init_vimeo_widget");

?>
