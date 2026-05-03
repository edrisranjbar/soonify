<?php
/**
 * Plugin Name: Soonify - Persian Coming Soon
 * Plugin URI: https://github.com/edrisranjbar/soonify
 * Description: یک افزونه ساده و زیبا برای حالت "به زودی" سایت
 * Version: 1.0.0
 * Author: Edris Ranjbar
 * Author URI: mailto:edris.qeshm2@gmail.com
 * Text Domain: soonify
 * Domain Path: /languages
 * License: GPL2.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('SOONIFY_VERSION', '1.0.0');
define('SOONIFY_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SOONIFY_PLUGIN_URL', plugin_dir_url(__FILE__));

// Main plugin class
final class Soonify {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        $this->init_hooks();
    }
    
    private function init_hooks() {
        add_action('init', array($this, 'init'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        
        // Check if coming soon mode is active
        if (get_option('soonify_active', false) && !is_admin() && !is_user_logged_in()) {
            add_action('template_redirect', array($this, 'show_coming_soon'));
        }
        
        // Enqueue admin styles
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
    }
    
    public function init() {
        load_plugin_textdomain('soonify', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }
    
    public function add_admin_menu() {
        add_menu_page(
            'Soonify',
            'Soonify',
            'manage_options',
            'soonify',
            array($this, 'settings_page'),
            'dashicons-clock',
            100
        );
    }
    
    public function register_settings() {
        register_setting('soonify_settings', 'soonify_active', array(
            'type' => 'boolean',
            'default' => false,
            'sanitize_callback' => 'rest_sanitize_boolean'
        ));
        
        register_setting('soonify_settings', 'soonify_title', array(
            'type' => 'string',
            'default' => 'به زودی...',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        
        register_setting('soonify_settings', 'soonify_description', array(
            'type' => 'string',
            'default' => 'ما در حال آماده‌سازی سایت هستیم. به زودی با خدمات جدید بازمی‌گردیم.',
            'sanitize_callback' => 'wp_kses_post'
        ));
        
        register_setting('soonify_settings', 'soonify_bg_color', array(
            'type' => 'string',
            'default' => '#f8f9fa',
            'sanitize_callback' => 'sanitize_hex_color'
        ));
    }
    
    public function enqueue_admin_styles($hook) {
        if ('toplevel_page_soonify' !== $hook) {
            return;
        }
        
        wp_enqueue_style(
            'soonify-admin',
            SOONIFY_PLUGIN_URL . 'assets/css/admin-style.css',
            array(),
            SOONIFY_VERSION
        );
    }
    
    public function settings_page() {
        ?>
        <div class="wrap soonify-admin-wrap">
            <h1><?php echo esc_html__('تنظیمات Soonify', 'soonify'); ?></h1>
            <div class="soonify-admin-card">
                <form method="post" action="options.php">
                    <?php settings_fields('soonify_settings'); ?>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="soonify_active"><?php echo esc_html__('فعال‌سازی حالت به زودی', 'soonify'); ?></label>
                            </th>
                            <td>
                                <label class="soonify-toggle">
                                    <input type="checkbox" 
                                           id="soonify_active" 
                                           name="soonify_active" 
                                           value="1" 
                                           <?php checked(1, get_option('soonify_active', false)); ?>>
                                    <span class="soonify-toggle-slider"></span>
                                </label>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="soonify_title"><?php echo esc_html__('عنوان', 'soonify'); ?></label>
                            </th>
                            <td>
                                <input type="text" 
                                       id="soonify_title" 
                                       name="soonify_title" 
                                       value="<?php echo esc_attr(get_option('soonify_title', 'به زودی...')); ?>" 
                                       class="regular-text soonify-input" 
                                       dir="rtl">
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="soonify_description"><?php echo esc_html__('توضیحات', 'soonify'); ?></label>
                            </th>
                            <td>
                                <textarea id="soonify_description" 
                                          name="soonify_description" 
                                          rows="4" 
                                          class="large-text soonify-input" 
                                          dir="rtl"><?php echo esc_textarea(get_option('soonify_description', 'ما در حال آماده‌سازی سایت هستیم. به زودی با خدمات جدید بازمی‌گردیم.')); ?></textarea>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="soonify_bg_color"><?php echo esc_html__('رنگ پس‌زمینه', 'soonify'); ?></label>
                            </th>
                            <td>
                                <input type="color" 
                                       id="soonify_bg_color" 
                                       name="soonify_bg_color" 
                                       value="<?php echo esc_attr(get_option('soonify_bg_color', '#f8f9fa')); ?>" 
                                       class="soonify-color-picker">
                            </td>
                        </tr>
                    </table>
                    
                    <?php submit_button(__('ذخیره تنظیمات', 'soonify')); ?>
                </form>
            </div>
        </div>
        <?php
    }
    
    public function show_coming_soon() {
        // Set appropriate headers
        header('HTTP/1.1 503 Service Temporarily Unavailable');
        header('Retry-After: 86400'); // 24 hours
        
        // Include the coming soon template
        include SOONIFY_PLUGIN_DIR . 'templates/coming-soon.php';
        exit();
    }
}

// Initialize the plugin
Soonify::get_instance();