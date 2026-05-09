<?php
/**
 * Plugin Name: Soonify - Coming Soon
 * Plugin URI: https://github.com/edrisranjbar/soonify
 * Description: یک افزونه ساده و زیبا برای حالت "به زودی" سایت
 * Version: 1.0.0
 * Author: Edris Ranjbar
 * Author URI: https://edrisranjbar.ir
 * Domain Path: /languages
 * License: GPL2.0
 * Requires at least: 5.0
 * Requires PHP: 7.4
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
        // Initialize hooks
        $this->init_hooks();
        $this->init();
    }
    
    public function init() {
        load_plugin_textdomain(
            'soonify',
            false,
            dirname(plugin_basename(__FILE__)) . '/languages'
        );
    }

    private function init_hooks() {
        // Admin hooks
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        
        // Check coming soon mode
        add_action('template_redirect', array($this, 'check_coming_soon'));
    }
    
    public function check_coming_soon() {
        // Check if coming soon mode is active and user is not logged in and not in admin
        if (get_option('soonify_active', false) && !is_admin() && !is_user_logged_in()) {
            $this->show_coming_soon();
        }
    }
    
    public function add_admin_menu() {
        add_menu_page(
            __('Soonify Settings', 'soonify'),     // Page title
            __('Soonify', 'soonify'),              // Menu title
            'manage_options',                       // Capability
            'soonify-settings',                     // Menu slug
            array($this, 'settings_page'),          // Callback function
            'dashicons-clock',                      // Icon
            30                                      // Position
        );
    }
    
    public function register_settings() {
        register_setting('soonify_settings_group', 'soonify_active', array(
            'type' => 'boolean',
            'default' => false,
            'sanitize_callback' => 'rest_sanitize_boolean'
        ));
        
        register_setting('soonify_settings_group', 'soonify_bg_type', array(
            'type' => 'string',
            'default' => 'color',
            'sanitize_callback' => function($value) {
                return in_array($value, ['color', 'image']) ? $value : 'color';
            }
        ));
        
        register_setting('soonify_settings_group', 'soonify_bg_color', array(
            'type' => 'string',
            'default' => '#f8f9fa',
            'sanitize_callback' => 'sanitize_hex_color'
        ));
        
        register_setting('soonify_settings_group', 'soonify_bg_image', array(
            'type' => 'integer',
            'default' => 0,
            'sanitize_callback' => 'absint'
        ));
        
        register_setting('soonify_settings_group', 'soonify_logo_image', array(
            'type' => 'integer',
            'default' => 0,
            'sanitize_callback' => 'absint'
        ));
        
        register_setting('soonify_settings_group', 'soonify_title', array(
            'type' => 'string',
            'default' => 'به زودی...',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        
        register_setting('soonify_settings_group', 'soonify_description', array(
            'type' => 'string',
            'default' => 'ما در حال آماده‌سازی سایت هستیم. به زودی با خدمات جدید بازمی‌گردیم.',
            'sanitize_callback' => 'wp_kses_post'
        ));
    }
    
    public function enqueue_admin_assets($hook) {
        if ('toplevel_page_soonify-settings' !== $hook) {
            return;
        }
        
        wp_enqueue_style(
            'soonify-admin',
            SOONIFY_PLUGIN_URL . 'assets/css/admin-style.css',
            array(),
            SOONIFY_VERSION
        );
        
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_media();
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_script(
            'soonify-admin-js',
            SOONIFY_PLUGIN_URL . 'assets/js/admin-script.js',
            array('jquery', 'wp-color-picker'),
            SOONIFY_VERSION,
            true
        );
    }
    
    public function settings_page() {
        // Check user capabilities
        if (!current_user_can('manage_options')) {
            return;
        }
        
        // Save settings message
        if (isset($_GET['settings-updated'])) {
            add_settings_error(
                'soonify_messages',
                'soonify_message',
                __('تنظیمات با موفقیت ذخیره شد.', 'soonify'),
                'updated'
            );
        }
        
        // Show success message
        settings_errors('soonify_messages');
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            
            <div class="soonify-admin-card">
                <form method="post" action="options.php">
                    <?php
                    // Output security fields
                    settings_fields('soonify_settings_group');
                    
                    // Output setting sections and fields
                    do_settings_sections('soonify-settings');
                    ?>
                    
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
                                <p class="description"><?php echo esc_html__('با فعال کردن این گزینه، سایت شما برای بازدیدکنندگان در حالت به زودی نمایش داده می‌شود.', 'soonify'); ?></p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label><?php echo esc_html__('نوع پس‌زمینه', 'soonify'); ?></label>
                            </th>
                            <td>
                                <label>
                                    <input type="radio" name="soonify_bg_type" value="color" <?php checked(get_option('soonify_bg_type', 'color'), 'color'); ?>>
                                    <?php echo esc_html__('رنگ', 'soonify'); ?>
                                </label>
                                <label>
                                    <input type="radio" name="soonify_bg_type" value="image" <?php checked(get_option('soonify_bg_type', 'image'), 'image'); ?>>
                                    <?php echo esc_html__('تصویر', 'soonify'); ?>
                                </label>
                            </td>
                        </tr>
                        
                        <tr class="soonify-bg-color-field">
                            <th scope="row">
                                <label for="soonify_bg_color"><?php echo esc_html__('رنگ پس‌زمینه', 'soonify'); ?></label>
                            </th>
                            <td>
                                <input type="text" 
                                       id="soonify_bg_color" 
                                       name="soonify_bg_color" 
                                       value="<?php echo esc_attr(get_option('soonify_bg_color', '#f8f9fa')); ?>" 
                                       class="soonify-color-picker">
                            </td>
                        </tr>
                        
                        <tr class="soonify-bg-image-field" style="display:none;">
                            <th scope="row">
                                <label for="soonify_bg_image"><?php echo esc_html__('تصویر پس‌زمینه', 'soonify'); ?></label>
                            </th>
                            <td>
                                <input type="hidden" id="soonify_bg_image" name="soonify_bg_image" value="<?php echo esc_attr(get_option('soonify_bg_image', 0)); ?>">
                                <button type="button" class="button soonify-upload-btn" data-target="soonify_bg_image"><?php echo esc_html__('انتخاب تصویر', 'soonify'); ?></button>
                                <button type="button" class="button soonify-remove-btn" data-target="soonify_bg_image" style="display:none;"><?php echo esc_html__('حذف تصویر', 'soonify'); ?></button>
                                <div class="soonify-image-preview" id="soonify_bg_image_preview"></div>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="soonify_logo_image"><?php echo esc_html__('تصویر لوگو (اختیاری)', 'soonify'); ?></label>
                            </th>
                            <td>
                                <input type="hidden" id="soonify_logo_image" name="soonify_logo_image" value="<?php echo esc_attr(get_option('soonify_logo_image', 0)); ?>">
                                <button type="button" class="button soonify-upload-btn" data-target="soonify_logo_image"><?php echo esc_html__('انتخاب لوگو', 'soonify'); ?></button>
                                <button type="button" class="button soonify-remove-btn" data-target="soonify_logo_image" style="display:none;"><?php echo esc_html__('حذف لوگو', 'soonify'); ?></button>
                                <div class="soonify-image-preview" id="soonify_logo_image_preview"></div>
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
                                       class="regular-text" 
                                       dir="rtl"
                                       required>
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
                                          class="large-text" 
                                          dir="rtl"><?php echo esc_textarea(get_option('soonify_description', '')); ?></textarea>
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
function soonify_init() {
    return Soonify::get_instance();
}
add_action('plugins_loaded', 'soonify_init');
