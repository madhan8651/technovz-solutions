# TechNovz Solutions — WordPress Theme & Plugin

A WordPress development project containing the **TechNovz Solutions theme** and the **Project Management Toolkit plugin**, maintained together in one repository.

## 📁 Project Structure

```text
technovz-combined/
├── wp-content/
│   ├── themes/
│   │   └── technovz-solutions/
│   └── plugins/
│       └── project-management-toolkit/
├── .gitignore
└── README.md
```

## 🎨 WordPress Theme

**Location:** `wp-content/themes/technovz-solutions/`

The TechNovz Solutions theme provides the website's presentation and layout.

Features depend on the current theme implementation and include its templates, styles, and WordPress theme integration.

## 🧩 Project Management Toolkit Plugin

**Location:** `wp-content/plugins/project-management-toolkit/`

The plugin provides project management and project display functionality within WordPress.

Current functionality includes:

- Project post type and project data management
- Project categories and technologies
- Project fields and project views
- Project display through the `[pmt_project]` shortcode
- WordPress REST API integration

## 🛠️ Development Environment

- WordPress
- PHP
- MySQL / MariaDB
- HTML and CSS
- JavaScript
- Git and GitHub
- XAMPP for local development

## 🚀 Local Installation

1. Install and start Apache and MySQL using XAMPP.
2. Set up a local WordPress installation.
3. Copy the theme into `wp-content/themes/`.
4. Copy the plugin into `wp-content/plugins/`.
5. Activate the TechNovz Solutions theme from the WordPress dashboard.
6. Activate the Project Management Toolkit plugin.
7. Configure the website and create projects as required.

## 🌿 Repository Structure

The theme and plugin are maintained in separate directories within this repository to keep their code organized and easier to maintain.

## 🔐 Security Implementation Checklist

- [x] Sanitize incoming data and validate expected formats.
- [x] Escape output using `esc_html()`, `esc_attr()`, and `esc_url()`.
- [x] Use and verify nonces for protected form submissions.
- [x] Enforce permissions using `current_user_can()`.
- [x] Use prepared SQL queries to reduce SQL injection risks.
- [x] Protect forms and administrative actions against CSRF.
- [x] Configure suitable user roles and permissions.
- [x] Validate file uploads and restrict allowed file types.
- [x] Avoid exposing sensitive configuration details.
- [x] Keep WordPress core, themes, and plugins updated.
- [x] Configure a backup plugin and create a backup.

## 💾 Backup Demonstration

The UpdraftPlus backup plugin was used to create a WordPress backup.

- **Backup date shown:** October 13, 2026, at 12:50
- **Reported backup size:** 126.2 MB
- **Components listed:** Database, Plugins, Themes, Uploads, Must-use plugins, and Other files
- **Log result:** The backup log reported, “The backup succeeded and is now complete.”
- **Remote upload:** The log reported that the database archive was uploaded to Google Drive and that there were no upload errors.

## 📌 Future Improvements

- React-based project display using Vite and React Hooks
- Dynamic project loading with a Load More button
- Further improvements to project presentation and responsiveness

---

**TechNovz Solutions**  
WordPress Theme and Plugin Development Project
