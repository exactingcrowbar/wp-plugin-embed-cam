<?php
/*
Plugin Name: WP Embed Cam
Description: Add streaming cam feed to bottom of Home page & Posts.  Turn the cam on/off in Settings > Embed Cam.
Plugin URI: https://github.com/exactingcrowbar/wp-plugin-embed-cam
Author: rkgreen - BluestreamCode
Author URI: https://bluestreamcode.com
Version: 1.0
*/

//************** ADMIN SETTINGS PAGE *******************
add_action('admin_menu', function() {
	add_options_page( 'Streaming Cam Settings', 'Embed Cam', 'manage_options', 'bsc-embed-cam-plugin', 'embed_cam_settings_page' );
});


add_action( 'admin_init', function() {
 	register_setting( 'bsc-embed-cam-settings', 'bsc-embed-cam-settings' );
});


function embed_cam_settings_page() {
	$bsc_embed_cam_settings = get_option( 'bsc-embed-cam-settings' );
  ?>
    <div class="wrap">
    <h2><strong>WP Embedded Cam</strong></h2>
    <h3><i>Settings</i></h3>
    <hr />
	  <form action="options.php" method="post">

	    <?php
	      settings_fields( 'bsc-embed-cam-settings' );
	      do_settings_sections( 'bsc-embed-cam-settings' );
	    ?>
	    <table>
	    	
	    	<tr>
	    		<th style="text-align:right;">Check to turn the cam on/off:</th>
	    		<td>
	    			<label>
	    				<input type="checkbox" name="bsc-embed-cam-settings[bsc_cam_on_off]" <?php echo esc_attr( $bsc_embed_cam_settings['bsc_cam_on_off'] ) == 'on' ? 'checked="checked"' : ''; ?> />
	    			</label>
	    		</td>
	    	</tr>

	    	<tr>
	    		<th style="text-align:right;">Heading displayed above the cam:</th>
	    		<td><input type="text" placeholder="enter a heading" name="bsc-embed-cam-settings[bsc_cam_heading]" value="<?php echo esc_attr( $bsc_embed_cam_settings['bsc_cam_heading'] ); ?>" size="30" /></td>
	    	</tr>
	    	<tr>
	    		<th style="text-align:right;">The link (iframe) for the cam:<br /><i>Good size is: </i>width="640" height="360"</th>
	    		<td><textarea placeholder="enter the '<iframe>...etc' link" name="bsc-embed-cam-settings[bsc_cam_link]" rows="5" cols="50"><?php echo esc_attr( $bsc_embed_cam_settings['bsc_cam_link'] ); ?></textarea></td>
	    	</tr>

	    	<tr>
	    		<td><?php submit_button(); ?></td>
	    	</tr>

	    </table>

	  </form>
    </div>
  <?php
}

// ************* EMBED THE CAM ********************
add_action( 'get_footer', 'bsc_embed_cam' );

function bsc_embed_cam() {

	$bsc_embed_cam_settings = get_option( 'bsc-embed-cam-settings' );

	$showCam = $bsc_embed_cam_settings['bsc_cam_on_off'];

	if ( $showCam ) {
		if ( get_post_type() == 'post' ) {
			echo '<b class="content-area">', esc_attr( $bsc_embed_cam_settings['bsc_cam_heading'] ), '</b>';
			echo '<div class="content-area">', $bsc_embed_cam_settings['bsc_cam_link'], '</div>';
		}
	}
	
}

?>
