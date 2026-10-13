# Project Management Toolkit

A WordPress plugin for managing projects, project details, categories, technologies, and project-related data through the WordPress admin dashboard and REST API.

## Features

- **Project Management:** Create, edit, and manage project entries in WordPress.
- **Custom Post Type:** Registers a dedicated post type for projects.
- **Project Categories:** Organize projects into categories.
- **Project Technologies:** Associate technologies with projects.
- **Custom Project Fields:** Store additional project information.
- **REST API:** Provides endpoints for retrieving and managing project data.
- **Shortcode Support:** Display project information using WordPress shortcodes.
- **Admin Settings:** Configure plugin-related settings from the WordPress dashboard.
- **Database Support:** Includes project view and database-related functionality.
- **Activation and Deactivation:** Handles plugin activation and deactivation routines.
- **Uninstall Support:** Includes an uninstall handler.

## Requirements

- WordPress
- PHP version compatible with your WordPress installation
- A MySQL or MariaDB database supported by WordPress

## Installation

### Method 1: Install Manually

1. Copy the `project-management-toolkit` folder into:

   ```text
   wp-content/plugins/
   ```

2. Confirm that the main plugin file exists:

   ```text
   wp-content/plugins/project-management-toolkit/project-management-toolkit.php
   ```

3. Log in to the WordPress admin dashboard.
4. Navigate to **Plugins → Installed Plugins**.
5. Find **Project Management Toolkit**.
6. Click **Activate**.

### Method 2: Using the Combined Repository

If you are using the Technovz Solutions combined repository, the plugin is located at:

```text
wp-content/plugins/project-management-toolkit/
```

Place the repository's `wp-content` directory into the corresponding location in your WordPress installation, or copy the plugin folder into the existing `wp-content/plugins/` directory.

## Project Structure

```text
project-management-toolkit/
├── assets/
│   └── (non-React plugin assets, if required)
├── docs/
│   └── rest-api-documentation.md
├── includes/
│   ├── activator.php
│   └── deactivator.php
├── src/
│   ├── Admin/
│   │   └── Settings.php
│   ├── Database/
│   │   └── ProjectViews.php
│   ├── PostTypes/
│   │   ├── ProjectFields.php
│   │   └── ProjectPostType.php
│   ├── Rest/
│   │   └── ProjectRestController.php
│   ├── Shortcodes/
│   │   └── ProjectShortcode.php
│   ├── Taxonomies/
│   │   ├── ProjectCategory.php
│   │   └── ProjectTechnology.php
│   └── Plugin.php
├── .gitignore
├── project-management-toolkit.php
├── README.md
└── uninstall.php
```

The `assets/` directory is reserved for any non-React assets the plugin still needs. The React frontend files have been removed.

## Main Components

### 1. Main Plugin File

**File:** `project-management-toolkit.php`

The main entry point for the plugin. It contains the WordPress plugin header and initializes the plugin functionality.

### 2. Plugin Bootstrap

**File:** `src/Plugin.php`

Coordinates the plugin's components and initialization.

### 3. Project Post Type

**File:** `src/PostTypes/ProjectPostType.php`

Registers the custom post type used to store projects.

### 4. Project Fields

**File:** `src/PostTypes/ProjectFields.php`

Defines additional project fields and their associated handling.

### 5. Project Categories

**File:** `src/Taxonomies/ProjectCategory.php`

Registers the taxonomy used to categorize projects.

### 6. Project Technologies

**File:** `src/Taxonomies/ProjectTechnology.php`

Registers the taxonomy used to associate technologies with projects.

### 7. Admin Settings

**File:** `src/Admin/Settings.php`

Provides plugin settings functionality in the WordPress administration area.

### 8. REST API Controller

**File:** `src/Rest/ProjectRestController.php`

Handles the plugin's project-related REST API functionality.

For available routes, request methods, parameters, and response formats, see:

[`docs/rest-api-documentation.md`](docs/rest-api-documentation.md)

### 9. Project Shortcode

**File:** `src/Shortcodes/ProjectShortcode.php`

Registers and handles the plugin's shortcode functionality.

Check the implementation for the supported shortcode name and attributes.

### 10. Database and Project Views

**File:** `src/Database/ProjectViews.php`

Contains database and project-view-related functionality.

### 11. Activation and Deactivation

Files:

- `includes/activator.php`
- `includes/deactivator.php`

Contain functionality associated with activating and deactivating the plugin.

### 12. Uninstall Handler

**File:** `uninstall.php`

Contains the plugin's uninstall handling logic.

## REST API

The plugin includes a REST API controller for project-related operations.

For the exact endpoint paths, supported HTTP methods, request parameters, authentication requirements, and response structures, refer to:

**[REST API Documentation](docs/rest-api-documentation.md)**

REST API access depends on the permissions and authentication implemented by the plugin and WordPress.

## Shortcodes

The plugin includes shortcode functionality through `src/Shortcodes/ProjectShortcode.php`.

Before using a shortcode, check the source file for its registered shortcode name and supported attributes. This README does not assume a shortcode name or parameters that have not been verified.

## Development

The plugin is organized into PHP classes grouped by responsibility.

When modifying the plugin:

1. Keep project post type functionality in `src/PostTypes/`.
2. Keep taxonomy functionality in `src/Taxonomies/`.
3. Keep admin settings in `src/Admin/`.
4. Keep REST API logic in `src/Rest/`.
5. Keep shortcode logic in `src/Shortcodes/`.
6. Keep initialization and component registration in `src/Plugin.php`.
7. Update the REST API documentation when endpoint behavior changes.

### React Frontend Removal

The React frontend has been removed from this plugin version.

The following files are no longer included:

- `assets/css/react-projects.css`
- `assets/js/react-projects.js`
- `src/Frontend/ReactProjects.php`

The plugin bootstrap should not import or initialize the removed `ReactProjects` class.

Other plugin functionality should be maintained independently of the removed frontend.

## Testing Checklist

After installing or updating the plugin, verify the following:

- [ ] The plugin activates without PHP errors.
- [ ] Projects can be created and managed in WordPress.
- [ ] Project categories and technologies register correctly.
- [ ] Project custom fields behave as expected.
- [ ] Admin settings load and save correctly.
- [ ] REST API routes behave according to the documentation.
- [ ] The shortcode behaves according to its implementation.
- [ ] No references to the removed React frontend remain in PHP code.
- [ ] The WordPress debug log contains no new plugin-related errors.

## Troubleshooting

### Plugin activation fails

Check the PHP error log and confirm that the plugin files are present in the expected directory.

### Projects are not appearing

Verify that the custom post type