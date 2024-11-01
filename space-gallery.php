<?php
/*
Plugin Name: Space gallery
Plugin URI: http://www.gopiplus.com/work/2010/08/14/space-gallery/
Description: Want to display images as a slideshow in the page or post? Then use space gallery WordPress plugin. Its just another image slideshow show gallery. Click on the below images to see it in action. Back up your existing gallery XML files before update this plugin.
Author: Gopi Ramasamy
Version: 8.0
Author URI: http://www.gopiplus.com/work/2010/08/14/space-gallery/
Donate link: http://www.gopiplus.com/work/2010/08/14/space-gallery/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: space-gallery
Domain Path: /languages
*/

function space_show( $atts ) 
{
	$arr = array();
	$arr["directory"] = $atts;
	echo space_show_shortcode($arr);
}

function space_show_shortcode( $atts ) 
{
	$space_pp = "";
	$space_package = "";
	
	//[space-gallery directory="dir1"]
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	$directory = $atts['directory'];
	
	$directory = strtoupper($directory);
	switch ($directory) 
	{
		case "DIR1":
			$location = get_option('space_dir_1');
			break;
		case "DIR2":
			$location = get_option('space_dir_2');
			break;
		case "DIR3":
			$location = get_option('space_dir_3');
			break;
		case "DIR4":
			$location = get_option('space_dir_4');
			break;
		default:
			$location = get_option('space_dir_1');
			break;
	}

	if(is_dir($location))
	{
		$siteurl = get_option('siteurl');
		if(substr($siteurl, -1) !== '/')
		{
			$siteurl = $siteurl . "/";
		}
		
		$f_dirHandle = opendir($location);
		while ($f_file = readdir($f_dirHandle)) 
		{
			$f_file_sm = $f_file;
			$f_file = strtoupper($f_file);
			if(!is_dir($f_file) && (strpos($f_file, '.JPG')>0 or strpos($f_file, '.GIF')>0 or strpos($f_file, '.PNG')>0)) 
			{
				$path =  $siteurl . $location . $f_file_sm;
				$space_package = $space_package .'<img src="'.$path.'" alt="" />';
			}
		}
		$space_pp = $space_pp . '<div id="myGallery" class="spacegallery">';
			$space_pp = $space_pp . $space_package;
		$space_pp = $space_pp . '</div>';
		$space_pp = $space_pp . '<script>';
			$space_pp = $space_pp . "jQuery('#myGallery').spacegallery({loadingClass: 'loading'});";
		$space_pp = $space_pp . '</script>';
	}
	else
	{
		$space_pp = "Directory not exists (". $location.")";
	}
	return $space_pp;
}

function space_install() 
{
	add_option('space_dir_1', "wp-content/plugins/space-gallery/gallery1/");
	add_option('space_dir_2', "wp-content/plugins/space-gallery/gallery2/");
	add_option('space_dir_3', "wp-content/plugins/space-gallery/gallery1/");
	add_option('space_dir_4', "wp-content/plugins/space-gallery/gallery2/");
}

function space_admin_option() 
{
	echo "<div class='wrap'>";
	echo "<h2>"; 
	_e('Space Gallery', 'space-gallery');
	echo "</h2>";
    
	$space_dir_1 = get_option('space_dir_1');
	$space_dir_2 = get_option('space_dir_2');
	$space_dir_3 = get_option('space_dir_3');
	$space_dir_4 = get_option('space_dir_4');
	
	if (isset($_POST['space_submit'])) 
	{
		$space_dir_1 = stripslashes(sanitize_text_field($_POST['space_dir_1']));
		$space_dir_2 = stripslashes(sanitize_text_field($_POST['space_dir_2']));
		$space_dir_3 = stripslashes(sanitize_text_field($_POST['space_dir_3']));
		$space_dir_4 = stripslashes(sanitize_text_field($_POST['space_dir_4']));
		
		update_option('space_dir_1', $space_dir_1 );
		update_option('space_dir_2', $space_dir_2 );
		update_option('space_dir_3', $space_dir_3 );
		update_option('space_dir_4', $space_dir_4 );
		
		?>
		<div class="updated fade">
			<p><strong><?php _e('Details successfully updated.', 'space-gallery'); ?></strong></p>
		</div>
		<?php
	}
	?>
	<form name="space_form" method="post" action="">
	<table width="100%" border="0" cellspacing="0" cellpadding="3"><tr><td align="left">
	<?php
	echo '<p>'.__('Image directory 1', 'space-gallery').' (dir1):<br><input  style="width: 650px;" type="text" value="';
	echo $space_dir_1 . '" name="space_dir_1" id="space_dir_1" /><br>'.__('Short Code:', 'space-gallery').' [space-gallery directory="dir1"]</p>';
	
	echo '<p>'.__('Image directory 2', 'space-gallery').' (dir2):<br><input  style="width: 650px;" type="text" value="';
	echo $space_dir_2 . '" name="space_dir_2" id="space_dir_2" /><br>'.__('Short Code:', 'space-gallery').' [space-gallery directory="dir2"]</p>';
	
	echo '<p>'.__('Image directory 3', 'space-gallery').' (dir3):<br><input  style="width: 650px;" type="text" value="';
	echo $space_dir_3 . '" name="space_dir_3" id="space_dir_3" /><br>'.__('Short Code:', 'space-gallery').' [space-gallery directory="dir3"]</p>';
	
	echo '<p>'.__('Image directory 4', 'space-gallery').' (dir4):<br><input  style="width: 650px;" type="text" value="';
	echo $space_dir_4 . '" name="space_dir_4" id="space_dir_4" /><br>'.__('Short Code:', 'space-gallery').' [space-gallery directory="dir4"]</p>';
	
	echo '<input name="space_submit" id="space_submit" class="button-primary" value="Submit" type="submit" />';
	?>
	</td><td align="left" valign="top">  </td></tr></table>
	</form>
	<br />
	<h3><?php _e('Plugin configuration', 'space-gallery'); ?></h3>
	<ol>
		<li><?php _e('Paste the available PHP code to your desired template location', 'space-gallery'); ?></li>
		<li><?php _e('Use plugin short code in posts and pages', 'space-gallery'); ?></li>
	</ol>
	<p><?php _e('Check official website for live demo and more information', 'space-gallery'); ?> 
	<a target="_blank" href="http://www.gopiplus.com/work/2010/08/14/space-gallery/"><?php _e('click here', 'space-gallery'); ?></a></p>
	<p>Note: Dont upload your original images into plugin folder. if you upload the images into plugin folder, you may lose the images when you update the plugin to next version. Thus upload your images in "wp-content/uploads/your-folder/" folder and use the folder path as per the example in "Image Directory" text box.</p>
	<?php
	echo "</div>";
}

function space_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_style( 'spacegallery', plugins_url().'/space-gallery/css/spacegallery.css','','','screen');
		wp_enqueue_style( 'spacegallery-custom', plugins_url().'/space-gallery/css/custom.css','','','screen');
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'spacegallery-eye', plugins_url().'/space-gallery/js/eye.js');
		wp_enqueue_script( 'spacegallery-utils', plugins_url().'/space-gallery/js/utils.js');
		wp_enqueue_script( 'spacegallery', plugins_url().'/space-gallery/js/spacegallery.js');
	}	
}

function space_add_to_menu() 
{
	add_options_page('Space gallery', __('Space gallery', 'space-gallery'), 'manage_options', __FILE__, 'space_admin_option' );
}

function space_textdomain()
{
	  load_plugin_textdomain( 'space-gallery', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action('plugins_loaded', 'space_textdomain');
add_shortcode( 'space-gallery', 'space_show_shortcode' );
add_action('init', 'space_add_javascript_files');
add_action('admin_menu', 'space_add_to_menu');
register_activation_hook(__FILE__, 'space_install');
?>