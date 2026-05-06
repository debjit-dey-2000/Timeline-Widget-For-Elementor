<?php
/**
 * Plugin Name: Timeline Widget for Elementor Page Builder
 * Description: A beautiful, fully responsive, and animated vertical timeline widget for Elementor page builder. Create stunning timelines for company history, project roadmaps, milestones, achievements, events, process flows, and storytelling sections with ease. Designed with smooth animations, modern UI styles, and flexible customization options, this widget helps you build engaging timeline layouts without writing a single line of code.
 * Version: 1.2.1
 * Author: Debjit Dey
 * Text Domain: timeline-widget-elementor
 * Requires at least: 5.6
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'TWE_VERSION', '1.0.0' );
define( 'TWE_PATH', plugin_dir_path( __FILE__ ) );
define( 'TWE_URL', plugin_dir_url( __FILE__ ) );

/**
 * Check if Elementor is active before loading the plugin.
 */
final class Timeline_Widget_Elementor {

    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        add_action( 'plugins_loaded', [ $this, 'init' ] );
    }

    public function init() {
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_elementor' ] );
            return;
        }

        add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'enqueue_styles' ] );
        add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_styles' ] );
    }

    public function register_widgets( $widgets_manager ) {
        require_once TWE_PATH . 'widgets/timeline-widget.php';
        $widgets_manager->register( new \TWE_Timeline_Widget() );
    }

    public function enqueue_styles() {
        wp_enqueue_style(
            'twe-timeline',
            TWE_URL . 'assets/css/timeline.css',
            [],
            TWE_VERSION
        );
    }

    public function enqueue_scripts() {
        wp_enqueue_script(
            'twe-timeline',
            TWE_URL . 'assets/js/timeline.js',
            [ 'jquery' ],
            TWE_VERSION,
            true
        );
    }

    public function admin_notice_missing_elementor() {
        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'timeline-widget-elementor' ),
            '<strong>' . esc_html__( 'Timeline Widget for Elementor', 'timeline-widget-elementor' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'timeline-widget-elementor' ) . '</strong>'
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }
}

Timeline_Widget_Elementor::instance();



/**
 * Add "Visit plugin site" link in plugin meta row
 */
add_filter( 'plugin_row_meta', 'twfe_plugin_meta_links', 10, 2 );

function twfe_plugin_meta_links( $links, $file ) {

    if ( plugin_basename( __FILE__ ) === $file ) {

        $links[] = '<a href="https://github.com/debjit-dey-2000/Timeline-Widget-For-Elementor.git" target="_blank" >Visit plugin site</a>';
    }

    return $links;
}
