=== Soonify - Coming Soon ===
Contributors: edrisranjbar
Donate link: https://edrisranjbar.ir/donation
Tags: coming soon, maintenance mode, under construction, persian, rtl, farsi, landing page
Requires at least: 5.0
Tested up to: 6.9
Stable tag: 1.0.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A clean, lightweight WordPress Coming Soon plugin with Persian (RTL) support and local Vazir font integration.

== Description ==

Soonify is a professional and lightweight WordPress plugin that creates a beautiful "Coming Soon" page for your website. Specially designed for Persian and RTL websites with full Vazir font integration.

### ✨ Key Features

* **Full Persian (RTL) Support** - Optimized for Persian, Arabic, and other RTL languages
* **Local Vazir Font Integration** - No external dependencies, fast loading with multiple font weights
* **Clean & Modern Design** - Beautiful animated coming soon page with CSS3 animations
* **Easy One-Click Toggle** - Simple activation/deactivation from WordPress admin panel
* **Fully Customizable** - Change title, description, and background color to match your brand
* **Admin Access Allowed** - Logged-in administrators can still access and work on the site
* **SEO Friendly** - Proper HTTP 503 status code and noindex meta tags
* **Fully Responsive** - Looks perfect on desktop, tablet, and mobile devices
* **Lightweight** - Minimal code with maximum performance, no bloat
* **Translation Ready** - Prepared for multilingual support with proper text domain

### 🎯 Perfect For

* Web developers building client websites
* Website redesigns and rebranding
* Pre-launch landing pages
* Maintenance mode announcements
* Temporary offline pages
* Iranian and Persian language websites

== Installation ==

1. Upload the `soonify` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Download Vazir font files from [Vazir Font Repository](https://github.com/rastikerdar/vazir-font/releases)
4. Place the following font files in `/wp-content/plugins/soonify/assets/fonts/`:
   * `Vazir-Thin.woff2`
   * `Vazir-Light.woff2`
   * `Vazir.woff2`
   * `Vazir-Medium.woff2`
   * `Vazir-Bold.woff2`
5. Go to the 'Soonify' menu in your WordPress admin sidebar
6. Configure your settings and activate the coming soon mode

== Frequently Asked Questions ==

= How do I activate the coming soon mode? =

Go to the Soonify settings page in your WordPress admin panel and toggle the "فعال‌سازی حالت به زودی" (Activate Coming Soon Mode) switch. Don't forget to save your changes.

= Can administrators still access the site? =

Yes! When coming soon mode is active, all logged-in users (typically administrators) can still access and work on the site normally. Only non-logged-in visitors will see the coming soon page.

= Will this affect my SEO? =

No, the plugin uses proper HTTP 503 (Service Temporarily Unavailable) headers and includes noindex meta tags, which tells search engines that this is a temporary state. This is the proper way to handle coming soon pages for SEO.

= Can I customize the coming soon page design? =

Yes, you can customize the title, description, and background color from the admin settings. For more advanced styling, you can modify the template file at `soonify/templates/coming-soon.php`.

= What if the Vazir font files are missing? =

The plugin includes a fallback to system fonts (Tahoma, Arial) if Vazir font files are not present. However, for the best experience, we recommend installing the font files.

= Does this plugin work with caching plugins? =

The plugin sends proper no-cache headers. However, if you're using a caching plugin, you may need to clear your cache after activating coming soon mode.

= Can I use this on a multisite network? =

Yes, Soonify works on WordPress multisite installations. Each site can have its own coming soon settings.

== Screenshots ==

1. Admin settings page with toggle switch and customization options
2. Coming soon page displayed on desktop computers
3. Coming soon page displayed on mobile devices (responsive design)
4. Plugin activation in WordPress plugins list

== Changelog ==

= 1.0.0 =
* Initial release
* Basic coming soon functionality with toggle activation
* Admin settings panel with customization options
* Vazir font integration with 5 font weights
* Customizable title, description, and background color
* Full RTL and Persian language support
* Responsive design for all devices
* Proper HTTP 503 headers for SEO
* Animated clock icon and loading dots
* Admin user bypass functionality

== Upgrade Notice ==

= 1.0.0 =
Initial release. Install and activate to create a beautiful coming soon page for your Persian website.

== Credits ==

* **Vazir Font** by [Saber Rastikerdar](https://github.com/rastikerdar) - Beautiful Persian font used in the plugin
* Built with ❤️ for the Persian WordPress community
