<?php
// Prevent direct access.
if (!defined('ABSPATH')) {
    exit;
}

$soonify_color = static function ($option, $default) {
    $value = sanitize_hex_color(get_option($option, $default));
    return $value ? $value : $default;
};

$bg_type        = get_option('soonify_bg_type', 'color');
$bg_color       = $soonify_color('soonify_bg_color', '#f8f9fa');
$accent_color   = $soonify_color('soonify_accent_color', '#6c63ff');
$title_color    = $soonify_color('soonify_title_color', '#172033');
$text_color     = $soonify_color('soonify_text_color', '#667085');
$card_color     = $soonify_color('soonify_card_color', '#ffffff');
$bg_image_id    = absint(get_option('soonify_bg_image', 0));
$bg_image       = $bg_image_id ? wp_get_attachment_image_src($bg_image_id, 'full') : false;
$bg_image_url   = $bg_image ? $bg_image[0] : '';
$logo_image_id  = absint(get_option('soonify_logo_image', 0));
$custom_logo_id = absint(get_theme_mod('custom_logo'));
$logo_image     = $logo_image_id ? wp_get_attachment_image_src($logo_image_id, 'full') : false;

if (!$logo_image && $custom_logo_id) {
    $logo_image = wp_get_attachment_image_src($custom_logo_id, 'full');
}

$logo_url    = $logo_image ? $logo_image[0] : '';
$title       = get_option('soonify_title', 'به زودی...');
$description = get_option('soonify_description', 'ما در حال آماده‌سازی سایت هستیم. به زودی با خدمات جدید بازمی‌گردیم.');
$site_name   = get_bloginfo('name');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="<?php echo esc_attr($accent_color); ?>">
    <title><?php echo esc_html($site_name . ' - ' . $title); ?></title>
    <style>
        @font-face { font-family:'Vazir'; src:url('<?php echo esc_url(SOONIFY_PLUGIN_URL . 'assets/fonts/Vazirmatn-Light.woff2'); ?>') format('woff2'); font-weight:300; font-display:swap; }
        @font-face { font-family:'Vazir'; src:url('<?php echo esc_url(SOONIFY_PLUGIN_URL . 'assets/fonts/Vazirmatn-Regular.woff2'); ?>') format('woff2'); font-weight:400; font-display:swap; }
        @font-face { font-family:'Vazir'; src:url('<?php echo esc_url(SOONIFY_PLUGIN_URL . 'assets/fonts/Vazirmatn-SemiBold.woff2'); ?>') format('woff2'); font-weight:600; font-display:swap; }
        @font-face { font-family:'Vazir'; src:url('<?php echo esc_url(SOONIFY_PLUGIN_URL . 'assets/fonts/Vazirmatn-Bold.woff2'); ?>') format('woff2'); font-weight:700; font-display:swap; }

        :root {
            --soonify-bg: <?php echo esc_attr($bg_color); ?>;
            --soonify-accent: <?php echo esc_attr($accent_color); ?>;
            --soonify-title: <?php echo esc_attr($title_color); ?>;
            --soonify-text: <?php echo esc_attr($text_color); ?>;
            --soonify-card: <?php echo esc_attr($card_color); ?>;
        }

        * { box-sizing:border-box; }
        html, body { min-height:100%; margin:0; }
        body {
            min-height:100vh;
            min-height:100svh;
            overflow-x:hidden;
            display:grid;
            place-items:center;
            padding:clamp(20px, 5vw, 64px);
            font-family:'Vazir', Tahoma, Arial, sans-serif;
            color:var(--soonify-text);
            background-color:var(--soonify-bg);
            <?php if ('image' === $bg_type && $bg_image_url) : ?>
            background-image:linear-gradient(135deg, rgba(10,15,30,.68), rgba(10,15,30,.32)), url('<?php echo esc_url($bg_image_url); ?>');
            background-size:cover;
            background-position:center;
            background-attachment:fixed;
            <?php endif; ?>
        }

        .soonify-scene { position:relative; width:min(100%, 760px); isolation:isolate; }
        .soonify-orb { position:absolute; z-index:-1; border-radius:999px; filter:blur(2px); opacity:.16; background:var(--soonify-accent); animation:soonify-float 9s ease-in-out infinite; }
        .soonify-orb--one { width:240px; height:240px; inset:-90px auto auto -100px; }
        .soonify-orb--two { width:170px; height:170px; inset:auto -70px -55px auto; animation-delay:-4s; }
        .soonify-card {
            position:relative;
            overflow:hidden;
            padding:clamp(34px, 8vw, 76px) clamp(24px, 7vw, 68px) clamp(28px, 6vw, 54px);
            text-align:center;
            background:var(--soonify-card);
            background:color-mix(in srgb, var(--soonify-card) 92%, transparent);
            border:1px solid rgba(255,255,255,.64);
            border-radius:clamp(24px, 5vw, 40px);
            box-shadow:0 32px 90px rgba(26,31,54,.15), inset 0 1px 0 rgba(255,255,255,.8);
            backdrop-filter:blur(18px);
            -webkit-backdrop-filter:blur(18px);
            animation:soonify-enter .8s cubic-bezier(.22,1,.36,1) both;
        }
        .soonify-card::before { content:''; position:absolute; inset:0 0 auto; height:5px; background:linear-gradient(90deg, transparent, var(--soonify-accent), transparent); }
        .soonify-logo {
            width:clamp(92px, 16vw, 124px);
            aspect-ratio:1;
            display:grid;
            place-items:center;
            margin:0 auto 30px;
            padding:18px;
            color:#fff;
            border-radius:32%;
            background:linear-gradient(145deg, var(--soonify-accent), var(--soonify-title));
            box-shadow:0 18px 44px color-mix(in srgb, var(--soonify-accent) 32%, transparent);
            transform:rotate(-3deg);
        }
        .soonify-logo img { width:100%; height:100%; object-fit:contain; border-radius:20%; transform:rotate(3deg); }
        .soonify-logo svg { width:58%; fill:currentColor; transform:rotate(3deg); }
        .soonify-title { max-width:620px; margin:0 auto 18px; color:var(--soonify-title); font-size:clamp(2.25rem, 7vw, 4.25rem); font-weight:700; line-height:1.2; letter-spacing:-.04em; }
        .soonify-description { max-width:570px; margin:0 auto; color:var(--soonify-text); font-size:clamp(1rem, 2.5vw, 1.2rem); font-weight:300; line-height:2; }
        .soonify-loader { display:flex; align-items:center; justify-content:center; gap:8px; margin:36px auto 0; }
        .soonify-loader span { width:8px; height:8px; border-radius:99px; background:var(--soonify-accent); animation:soonify-pulse 1.5s ease-in-out infinite; }
        .soonify-loader span:nth-child(2) { width:28px; animation-delay:.15s; }
        .soonify-loader span:nth-child(3) { animation-delay:.3s; }
        .soonify-footer { margin:34px 0 0; padding-top:24px; border-top:1px solid color-mix(in srgb, var(--soonify-text) 14%, transparent); color:var(--soonify-text); font-size:.82rem; opacity:.72; }

        @keyframes soonify-enter { from { opacity:0; transform:translateY(24px) scale(.98); } to { opacity:1; transform:none; } }
        @keyframes soonify-float { 50% { transform:translate3d(12px, -18px, 0) scale(1.05); } }
        @keyframes soonify-pulse { 0%, 100% { opacity:.28; transform:scale(.8); } 50% { opacity:1; transform:scale(1); } }
        @media (prefers-reduced-motion:reduce) { *, *::before, *::after { animation-duration:.01ms !important; animation-iteration-count:1 !important; } }
        @media (max-width:480px) { .soonify-card { border-radius:24px; } .soonify-footer { margin-top:28px; } }
    </style>
</head>
<body>
    <main class="soonify-scene">
        <span class="soonify-orb soonify-orb--one" aria-hidden="true"></span>
        <span class="soonify-orb soonify-orb--two" aria-hidden="true"></span>
        <section class="soonify-card" aria-labelledby="soonify-title">
            <div class="soonify-logo">
                <?php if ($logo_url) : ?>
                    <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($site_name); ?>">
                <?php else : ?>
                    <svg viewBox="0 0 24 24" role="img" aria-label="<?php echo esc_attr($site_name); ?>"><path d="M12 2a10 10 0 1 0 10 10A10.01 10.01 0 0 0 12 2Zm0 18a8 8 0 1 1 8-8 8.01 8.01 0 0 1-8 8Zm1-13h-2v6.55l5.45 3.27 1.03-1.71L13 12.42Z"/></svg>
                <?php endif; ?>
            </div>
            <h1 class="soonify-title" id="soonify-title"><?php echo esc_html($title); ?></h1>
            <div class="soonify-description"><?php echo wp_kses_post(wpautop($description)); ?></div>
            <div class="soonify-loader" aria-hidden="true"><span></span><span></span><span></span></div>
            <footer class="soonify-footer">
                &copy; <?php echo esc_html(date_i18n('Y')); ?> <?php echo esc_html($site_name); ?>
            </footer>
        </section>
    </main>
</body>
</html>
