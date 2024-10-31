<?php
/*
Plugin Name: Race Maps
Plugin URI: http://tools.race-calendar.com/wordpress-plugins/race-maps-wordpress-plugin/
Description: This plugin allows the quick creation and display of regional or global Race Maps - maps which display future running events as pins on a live Google Map. Race details are added and moderated at Race-Calendar.com, and races are removed from maps once they take place, so that race information is always live and up-to-date. If runners access your WordPress webiste, this can enhance their experience, increase pageloads, and lengthen visit length of their visits!
Version: 1.0
Author: Robin Scott
Author URI: http://silicondales.com/
License: GPL2
*/
/*  Copyright 2012 Robin J.E. Scott  (email : rob@race-calendar.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
add_action( 'admin_menu', 'race_maps_menu' );
// Add settings link on plugin page
function race_maps_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=race-maps-settings-page">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'race_maps_settings_link' );
function race_maps_menu() {
	add_options_page( 'Race Maps Settings', 'Race Maps', 'manage_options', 'race-maps-settings-page', 'race_maps_options' );
}

function race_maps_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    // variables for the field and option names 
    $opt_name = 'race-maps_country';
    $hidden_field_name = 'race-maps_submit_hidden';
    $data_field_name = 'race-maps_country';

    // Read in existing option value from database
    $opt_val = get_option( $opt_name );

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $opt_val = $_POST[ $data_field_name ];

        // Save the posted value in the database
        update_option( $opt_name, $opt_val );

        // Put an settings updated message on the screen

?>
<div class="updated"><p><strong><?php _e('settings saved.', 'race-maps' ); ?></strong></p></div>
<?php

    }

    // Now display the settings editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'Race Maps 1.0 Plugin Settings', 'race-maps' ) . "</h2>";

    // settings form
    
    ?>
<p>At present, it is possible to embed Race Maps from <a href="http://race-calendar.com/" title="Race-Calendar.com - love2run? Find your next race!" target="_blank">Race-Calendar.com</a> by country. In future upgrades, we hope to provide you with regional or combined maps that suit your specific needs. Please <a href="http://race-calendar.com/contact/" target="_blank">contact us</a> if you have any questions or requests about this plugin. 
<h3>Select Your Race Map</h3>
<p>Your Current Race Map is: <strong><?php echo $opt_val;?></strong></p>
<p><form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<?php _e("Select Race Map Country:", 'race-maps' ); ?> 
<select name="<?php echo $data_field_name; ?>">
<option <?php echo ($opt_val == 'Global Map' ? 'selected="selected"' :''); ?> value="Global Map">Global Map</option>
<option <?php echo ($opt_val == 'United States' ? 'selected="selected"' :''); ?> value="United States">United States</option>
<option <?php echo ($opt_val == 'United Kingdom' ? 'selected="selected"' :''); ?> value="United Kingdom">United Kingdom</option>
<option <?php echo ($opt_val == 'Australia' ? 'selected="selected"' :''); ?> value="Australia">Australia</option>
<option <?php echo ($opt_val == 'New Zealand' ? 'selected="selected"' :''); ?> value="New Zealand">New Zealand</option>
</select>
</p>
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</form>
<?php if ( $opt_val == 'Global Map' ) : ?>
<h3>Use Shortcode [racemap] to add your Global Map to a WordPress post</h3>
<p>To use your map in a WordPress post or page, simply enter the shortcode "<strong>[racemap]</strong>" (without quotes) where you would like the Race Map to display. More settings will be made available in future versions of this plugin!</p>
<?php endif; ?>
<?php if ( $opt_val == 'United States' ) : ?>
<h3>Use Shortcode [racemapusa] to add your United States Map to a WordPress post</h3>
<p>To use your map in a WordPress post or page, simply enter the shortcode "<strong>[racemapusa]</strong>" (without quotes) where you would like the United States Race Map to display. More settings will be made available in future versions of this plugin!</p>
<?php endif; ?>
<?php if ( $opt_val == 'United Kingdom' ) : ?>
<h3>Use Shortcode [racemapuk] to add your United Kingdom Map to a WordPress post</h3>
<p>To use your map in a WordPress post or page, simply enter the shortcode "<strong>[racemapuk]</strong>" (without quotes) where you would like the United Kingdom Race Map to display. More settings will be made available in future versions of this plugin!</p>
<?php endif; ?>
<?php if ( $opt_val == 'Australia' ) : ?>
<h3>Use Shortcode [racemapaus] to add your Australia Map to a WordPress post</h3>
<p>To use your map in a WordPress post or page, simply enter the shortcode "<strong>[racemapaus]</strong>" (without quotes) where you would like the Australia Race Map to display. More settings will be made available in future versions of this plugin!</p>
<?php endif; ?>
<?php if ( $opt_val == 'New Zealand' ) : ?>
<h3>Use Shortcode [racemapnz] to add your New Zealand Map to a WordPress post</h3>
<p>To use your map in a WordPress post or page, simply enter the shortcode "<strong>[racemapnz]</strong>" (without quotes) where you would like the New Zealand Race Map to display. More settings will be made available in future versions of this plugin!</p>
<?php endif; ?>
<hr />
</div>

<?php
}
//[racemap]
function racemap_func( $atts ){
 return "<iframe src='http://race-calendar.com/embed/?output=embed' frameborder='0' marginwidth='0' marginheight='0' scrolling='no' width='100%' height='400'></iframe>Courtesy of <a href='http://race-calendar.com/'>Race-Calendar.com</a>. <a href='http://race-calendar.com/add-race/'>Add a race</a>. <a href='http://news.race-calendar.com/embeddable-maps-of-races/'>Embed this Map</a>.";
}
add_shortcode( 'racemap', 'racemap_func' );
//[racemapusa]
function racemapusa_func( $atts ){
 return "<iframe name='race-calendar-map' src='http://race-calendar.com/embed/?map_cat=75' height='400' width='100%' marginheight='0' marginwidth='0' scrolling='no' frameborder='0'></iframe><a href='http://race-calendar.com/races/north-america/united-states/'>Races in USA</a> courtesy of <a href='http://race-calendar.com/'>Race-Calendar.com</a>. <a href='http://racemanagement.race-calendar.com/get-a-free-listing/'>Add a race</a>. <a href='http://tools.race-calendar.com/race-maps/'>Embed Map</a>.";
}
add_shortcode( 'racemapusa', 'racemapusa_func' );
//[racemapuk]
function racemapuk_func( $atts ){
 return "<iframe name='race-calendar-map' src='http://race-calendar.com/embed/?map_cat=278' height='400' width='100%' marginheight='0' marginwidth='0' scrolling='no' frameborder='0'></iframe><a href='http://race-calendar.com/races/europe/uk/'>Races in UK</a> courtesy of <a href='http://race-calendar.com/'>Race-Calendar.com</a>. <a href='http://racemanagement.race-calendar.com/get-a-free-listing/'>Add a race</a>. <a href='http://tools.race-calendar.com/race-maps/'>Embed Map</a>.";
}
add_shortcode( 'racemapuk', 'racemapuk_func' );
//[racemapaus]
function racemapaus_func( $atts ){
 return "<iframe name='race-calendar-map' src='http://race-calendar.com/embed/?map_cat=270' frameborder='0' marginwidth='0' marginheight='0' scrolling='no' width='100%' height='400'></iframe><a href='http://race-calendar.com/races/oceania/australia'>Races in USA</a> courtesy of <a href='http://race-calendar.com/'>Race-Calendar.com</a>. <a href='http://racemanagement.race-calendar.com/get-a-free-listing/'>Add a race</a>. <a href='http://tools.race-calendar.com/race-maps/'>Embed Map</a>.";
}
add_shortcode( 'racemapaus', 'racemapaus_func' );
//[racemapnz]
function racemapnz_func( $atts ){
 return "<iframe name='race-calendar-map' src='http://race-calendar.com/embed/?map_cat=1188' frameborder='0' marginwidth='0' marginheight='0' scrolling='no' width='100%' height='400'></iframe><a href='http://race-calendar.com/races/oceania/new-zealand'>Races in New Zealand</a> courtesy of <a href='http://race-calendar.com/'>Race-Calendar.com</a>. <a href='http://racemanagement.race-calendar.com/get-a-free-listing/'>Add a race</a>. <a href='http://tools.race-calendar.com/race-maps/'>Embed Map</a>.";
}
add_shortcode( 'racemapnz', 'racemapnz_func' );
?>