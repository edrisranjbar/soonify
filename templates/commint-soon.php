<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

$bg_color = get_option('soonify_bg_color', '#f8f9fa');
$title = get_option('soonify_title', 'به زودی...');
$description = get_option('soonify_description', 'ما در حال آماده‌سازی سایت هستیم. به زودی با خدمات جدید بازمی‌گردیم.');
$site_name = get_bloginfo('name');
$logo_url = has_custom_logo() ? wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full')[0] : '';
?>
<!DOCTYPE html>
<html dir="rtl" lang="fa-IR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo esc_html($site_name . ' - ' . $title); ?></title>
    
    <!-- Load Vazir Font from local -->
    <style>
        @font-face {
            font-family: 'Vazir';
            src: url('<?php echo esc_url(SOONIFY_PLUGIN_URL . 'assets/fonts/Vazir-Thin.woff2'); ?>') format('woff2');
            font-weight: 100;
            font-style: normal;
        }
        @font-face {
            font-family: 'Vazir';
            src: url('<?php echo esc_url(SOONIFY_PLUGIN_URL . 'assets/fonts/Vazir-Light.woff2'); ?>') format('woff2');
            font-weight: 300;
            font-style: normal;
        }
        @font-face {
            font-family: 'Vazir';
            src: url('<?php echo esc_url(SOONIFY_PLUGIN_URL . 'assets/fonts/Vazir-Regular.woff2'); ?>') format('woff2');
            font-weight: 400;
            font-style: normal;
        }
        @font-face {
            font-family: 'Vazir';
            src: url('<?php echo esc_url(SOONIFY_PLUGIN_URL . 'assets/fonts/Vazir-Medium.woff2'); ?>') format('woff2');
            font-weight: 500;
            font-style: normal;
        }
        @font-face {
            font-family: 'Vazir';
            src: url('<?php echo esc_url(SOONIFY_PLUGIN_URL . 'assets/fonts/Vazir-Bold.woff2'); ?>') format('woff2');
            font-weight: 700;
            font-style: normal;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Vazir', Tahoma, Arial, sans-serif;
            background-color: <?php echo esc_attr($bg_color); ?>;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            color: #333;
            line-height: 1.8;
        }
        
        .soonify-container {
            text-align: center;
            max-width: 600px;
            width: 100%;
            animation: fadeIn 1s ease-in-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .soonify-logo {
            width: 120px;
            height: 120px;
            margin: 0 auto 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            animation: pulse 2s ease-in-out infinite;
        }
        
        .soonify-logo svg {
            width: 60px;
            height: 60px;
            fill: white;
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }
        
        .soonify-title {
            font-size: 42px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 20px;
            letter-spacing: -1px;
        }
        
        .soonify-description {
            font-size: 18px;
            color: #718096;
            margin-bottom: 40px;
            font-weight: 300;
        }
        
        .soonify-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 30px;
        }
        
        .soonify-dot {
            width: 12px;
            height: 12px;
            background-color: #667eea;
            border-radius: 50%;
            animation: bounce 1.4s ease-in-out infinite;
        }
        
        .soonify-dot:nth-child(1) {
            animation-delay: 0s;
        }
        
        .soonify-dot:nth-child(2) {
            animation-delay: 0.2s;
        }
        
        .soonify-dot:nth-child(3) {
            animation-delay: 0.4s;
        }
        
        @keyframes bounce {
            0%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-15px);
            }
        }
        
        .soonify-footer {
            margin-top: 60px;
            color: #a0aec0;
            font-size: 14px;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .soonify-title {
                font-size: 32px;
            }
            
            .soonify-description {
                font-size: 16px;
            }
            
            .soonify-logo {
                width: 100px;
                height: 100px;
            }
        }
    </style>
</head>
<body>
    <div class="soonify-container">
        <div class="soonify-logo">
            <svg viewBox="0 0 24 24">
                <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm0 18c-4.4 0-8-3.6-8-8s3.6-8 8-8 8 3.6 8 8-3.6 8-8 8zm.5-13H11v6l5.2 3.2.8-1.3-4.5-2.7V7z"/>
            </svg>
        </div>
        
        <h1 class="soonify-title"><?php echo esc_html($title); ?></h1>
        <p class="soonify-description"><?php echo esc_html($description); ?></p>
        
        <div class="soonify-dots">
            <div class="soonify-dot"></div>
            <div class="soonify-dot"></div>
            <div class="soonify-dot"></div>
        </div>
        
        <div class="soonify-footer">
            <p>&copy; <?php echo date('Y'); ?> <?php echo esc_html($site_name); ?> - تمامی حقوق محفوظ است.</p>
        </div>
    </div>
</body>
</html>