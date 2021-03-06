<?php 

/*  	
    Plugin Name: ScorpioTek Dynamic Dashboard
    Description: Displays Dashboard Widgets from PHP Foles
    @since  1.0
    Version: 1.1.180420
	Text Domain: scorpiotek.com
*/

function remove_dashboard_widgets() {
      // Remove All Dashboard Widgets.
      remove_action('welcome_panel', 'wp_welcome_panel');     
      remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
      remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );  
      remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' ); 
      remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );  
      remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );   
      remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );  
      remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );  
      remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
      remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
      remove_meta_box('logincust_subscribe_widget', 'dashboard', 'core');
      remove_meta_box('themeisle', 'dashboard', 'core');  
}
 
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

function add_custom_dashboard_widget_content() {
	
    $dir = __DIR__ . '/dashboard-widgets';
    // Get all files inside the directory that have a php extension
    $dashboard_files = glob( $dir . '/*.php');
    foreach ($dashboard_files as $dashboard_file) {
        // Extract the name + extension from the path of the file
        $widget_filename = basename($dashboard_file);
        // Widget Slug is just the filename without the php extension	
        $widget_slug = basename($dashboard_file, '.php');
        // Get rid of the dashes in the name  
        $widget_slug_no_dashes = str_replace('-', ' ', $widget_slug);
        // Capitalise each letter from the filename
        $capitalised_title = ucwords($widget_slug_no_dashes);
              
        $widget_title = str_replace('-', ' ', $capitalised_title);
        wp_add_dashboard_widget( $widget_id = $widget_slug,
                                 $widget_name = $widget_title,
                                 $callback = function($var, $args) {
                                    include ('dashboard-widgets/' . $args['args']);
                                 },
                                 $control_callback = null,
                                 $callback_args = basename($dashboard_file)
        );			
    }
}
add_action( 'wp_dashboard_setup', 'add_custom_dashboard_widget_content' );

?>