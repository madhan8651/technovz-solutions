# TechNovz Solutions — WordPress Theme & Plugin

A combined WordPress development repository containing the TechNovz Solutions child theme and the Project Management Toolkit plugin.

## Project Overview

This repository keeps the website theme and custom plugin in one Git repository while maintaining their code in separate directories.

### WordPress Theme

**Location:** `wp-content/themes/technovz-solutions/`

The TechNovz Solutions theme provides the website presentation, templates, responsive styling, navigation, footer, and reusable template parts.

### Project Management Toolkit

**Location:** `wp-content/plugins/project-management-toolkit/`

The plugin provides project management functionality within WordPress.

Its current components include:

- Custom project post type
- Project categories and technologies
- Additional project fields
- Project-related database and view functionality
- REST API integration
- Shortcode functionality
- Administrative settings
- Activation, deactivation, and uninstall handlers

See the [plugin README](wp-content/plugins/project-management-toolkit/README.md) for component details and testing guidance.

## Technology Stack

- WordPress
- PHP
- MySQL or MariaDB
- HTML5 and CSS3
- JavaScript
- Git and GitHub
- XAMPP for local development
- Composer and PHP development tools where configured

## Repository Structure

```text
technovz-combined/
├── wp-content/
│   ├── themes/
│   │   └── technovz-solutions/
│   └── plugins/
│       └── project-management-toolkit/
├── README.md
└── .gitignore
```

The theme and plugin each have their own README and supporting files.

## Local Installation

### Requirements

- A working WordPress installation
- PHP compatible with the installed WordPress version and plugin
- MySQL or MariaDB
- A local web server such as XAMPP

### Setup

1. Start Apache and MySQL from the XAMPP Control Panel.
2. Create or configure a working WordPress installation.
3. Copy `wp-content/themes/technovz-solutions/` into the WordPress themes directory.
4. Copy `wp-content/plugins/project-management-toolkit/` into the WordPress plugins directory.
5. Open the WordPress administration dashboard.
6. Activate the TechNovz Solutions child theme under **Appearance → Themes**.
7. Activate Project Management Toolkit under **Plugins → Installed Plugins**.
8. Create project entries and configure the site as required.

**Important:** Install the theme's required parent theme before activating the child theme.

## Development Workflow

The repository uses Git for version control.

Check your current branch and working-tree changes before making updates:

```powershell
git status -sb
git branch -vv
```

Run PHP syntax checks on modified PHP files:

```powershell
php -l path/to/file.php
```

Run the configured WordPress Core coding-standard checks when the development dependencies are installed:

```powershell
.\vendor\bin\phpcs.bat --standard=WordPress-Core -s --extensions=php .\wp-content\themes\technovz-solutions
```

```powershell
.\vendor\bin\phpcs.bat --standard=WordPress-Core -s --extensions=php .\wp-content\plugins\project-management-toolkit
```

Review changes before staging or committing:

```powershell
git diff
git diff --check
git status --short
```

Stage only the files intended for a commit. Avoid `git add -A` when unrelated changes or deletions are present.

## Testing Checklist

After making changes, verify the following as applicable:

- [ ] The WordPress dashboard loads without PHP fatal errors.
- [ ] The theme activates and the website renders correctly.
- [ ] Project pages and individual project details work.
- [ ] The plugin activates without errors.
- [ ] Project management, categories, technologies, and fields work as expected.
- [ ] REST API and shortcode behavior match their implementations.
- [ ] PHP syntax checks pass.
- [ ] Coding-standard checks pass.
- [ ] Git changes are reviewed before committing.

## Documentation

- [Theme documentation](wp-content/themes/technovz-solutions/README.md)
- [Plugin documentation](wp-content/plugins/project-management-toolkit/README.md)

For API routes, parameters, and response details, consult the plugin's REST API documentation when available.

## Maintainer

GitHub: [@madhan8651](https://github.com/madhan8651)
