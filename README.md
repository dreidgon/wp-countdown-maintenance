# WP Countdown Maintenance

A lightweight and easy-to-use WordPress maintenance mode plugin. Display a custom maintenance message, logo, and countdown timer while your site is under construction or undergoing updates.

---

## 🧩 Features

- Enable or disable maintenance mode from the WordPress admin
- Add a custom maintenance message
- Upload a custom logo
- Set a target date/time for a countdown (optional)
- Fully responsive and mobile-friendly

---

## ⚙️ Installation

1. Upload the plugin files to the `/wp-content/plugins/wp-countdown-maintenance` directory, or install via the WordPress Plugins screen.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Go to `Dashboard → SMP` to configure:
   - Enable maintenance mode
   - Add your custom message
   - Upload a logo
   - Set a countdown target date/time

---

## 🔧 How It Works

When **maintenance mode is enabled**, all non-logged-in users (visitors) will see a simple “Coming Soon” page with your custom content.

**Administrators** will still be able to access and work on the site normally.

---

## 📁 Folder Structure

wp-countdown-maintenance/  
│  
├── wp-countdown-maintenance.php ← main plugin file  
├── templates/  
│ └── coming-soon-template.php ← HTML template for front-end

---

## 📝 License

This plugin is licensed under the [GPL v2 or later](https://www.gnu.org/licenses/gpl-2.0.html).  
You are free to use, modify, and distribute it as you wish.

---

⚠️ **Disclaimer**

This plugin has **only been tested in local and development environments**.

You **must test it thoroughly on a local or staging site first** to ensure it works correctly, meets your needs, and is secure before using it on a live website.

**Always backup your entire website and database** before activating this plugin on a production environment.

The author **is not responsible** for any issues, data loss, downtime, or security problems that may arise from using this plugin.

## 🧪 Tested Environment

- **PHP:** 8.3.14
- **MySQL:** 9.1.0
- **WordPress:** Tested with WordPress 6.8.2

---

## 💖 Support This Plugin

If you find this plugin helpful and want to support its development, you can buy me a coffee:

[![Ko-fi](https://ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/dreidgon)
