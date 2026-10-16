# Project Management Toolkit

A WordPress plugin for managing projects, project details, categories, technologies, and project-related data through the WordPress administration dashboard, shortcode, and REST API.

## Features

- **Project Management:** Create, edit, and manage project entries in WordPress.
- **Custom Post Type:** Registers a dedicated post type for projects.
- **Project Categories:** Organize projects into categories.
- **Project Technologies:** Associate technologies with projects.
- **Custom Project Fields:** Store additional project information.
- **REST API:** Retrieve published project data through a public REST endpoint.
- **Shortcode Support:** Display project information using `[pmt_project]`.
- **Admin Settings:** Configure plugin-related settings through the WordPress dashboard.
- **Database Support:** Includes project-view tracking and database functionality.
- **Activation and Deactivation:** Handles plugin activation and deactivation routines.
- **Uninstall Support:** Includes an uninstall handler.
- **Automated Tests:** PHPUnit tests for selected plugin functionality.

## Requirements

- WordPress
- PHP compatible with your WordPress installation
- MySQL or MariaDB supported by WordPress
- Composer and PHPUnit for development and testing

## Installation

### Method 1: Manual Installation

1. Copy the `project-management-toolkit` folder into:

   ```text
   wp-content/plugins/
   ```

2. Confirm that the main plugin file exists:

   ```text
   wp-content/plugins/project-management-toolkit/project-management-toolkit.php
   ```

3. Log in to your WordPress administration dashboard.

4. Navigate to **Plugins → Installed Plugins**.

5. Find **Project Management Toolkit**.

6. Click **Activate**.

### Method 2: Using the Combined Repository

In the TechNovz Solutions combined repository, the plugin is located at:

```text
wp-content/plugins/project-management-toolkit/
```

Copy the plugin folder into your WordPress installation's `wp-content/plugins/` directory if it is not already there.

## Project Structure

```text
project-management-toolkit/
├── includes/
│   ├── class-pmt-activator.php
│   └── class-pmt-deactivator.php
├── src/
│   ├── Admin/
│   │   └── class-settings.php
│   ├── Database/
│   │   └── class-projectviews.php
│   ├── PostTypes/
│   │   ├── class-projectfields.php
│   │   └── class-projectposttype.php
│   ├── Rest/
│   │   └── class-projectrestcontroller.php
│   ├── Shortcodes/
│   │   └── class-projectshortcode.php
│   ├── Taxonomies/
│   │   ├── class-projectcategory.php
│   │   └── class-projecttechnology.php
│   └── class-plugin.php
├── tests/
│   ├── SettingsTest.php
│   └── ProjectViewsTest.php
├── project-management-toolkit.php
├── README.md
└── uninstall.php
```

This tree describes the active source files and tests discussed for this plugin. Local backup files and development dependencies are not included.

## Main Components

### 1. Main Plugin File

**File:** `project-management-toolkit.php`

The main entry point for the plugin. It contains the WordPress plugin header, defines plugin constants, loads activation and deactivation handlers, and initializes the plugin.

It also provides the autoloading mechanism for classes in the `TechNovz\PMT` namespace.

### 2. Plugin Bootstrap

**File:** `src/class-plugin.php`

Initializes the plugin's components, including:

- Project post type
- Project categories and technologies
- Project fields
- Admin settings
- REST API controller
- Project shortcode
- Project-view tracking

### 3. Project Post Type

**File:** `src/PostTypes/class-projectposttype.php`

Registers the custom post type used to store and manage project entries.

### 4. Project Fields

**File:** `src/PostTypes/class-projectfields.php`

Handles additional project fields and their associated WordPress functionality.

### 5. Project Categories

**File:** `src/Taxonomies/class-projectcategory.php`

Registers the taxonomy used to organize projects into categories.

### 6. Project Technologies

**File:** `src/Taxonomies/class-projecttechnology.php`

Registers the taxonomy used to associate technologies with projects.

### 7. Admin Settings

**File:** `src/Admin/class-settings.php`

Provides administration settings and dashboard functionality.

### 8. REST API Controller

**File:** `src/Rest/class-projectrestcontroller.php`

Registers the REST API route and handles requests for published projects.

### 9. Project Shortcode

**File:** `src/Shortcodes/class-projectshortcode.php`

Registers and renders the `[pmt_project]` shortcode.

### 10. Database and Project Views

**File:** `src/Database/class-projectviews.php`

Handles project-view tracking and database queries for project view counts.

### 11. Activation and Deactivation

Files:

- `includes/class-pmt-activator.php`
- `includes/class-pmt-deactivator.php`

Contain the plugin's activation and deactivation routines.

### 12. Uninstall Handler

**File:** `uninstall.php`

Contains the plugin's uninstall handling logic.

## WordPress Hooks

The plugin uses WordPress hooks to register and initialize its functionality.

- `plugins_loaded`: Loads and initializes the plugin.
- `init`: Initializes plugin functionality and registers the project post type and taxonomies.
- `admin_menu`: Adds the administration menu.
- `admin_init`: Initializes administration settings.
- `wp_dashboard_setup`: Registers dashboard functionality.
- `rest_api_init`: Registers the REST API route.
- `wp_enqueue_scripts`: Handles shortcode-related frontend styling.
- `template_redirect`: Supports project-view tracking.
- `register_activation_hook()`: Registers the activation handler.
- `register_deactivation_hook()`: Registers the deactivation handler.

The implementation details are maintained in the relevant PHP classes.

## Shortcode Usage

### Display the Latest Projects

Add this shortcode to a WordPress page or post:

```text
[pmt_project]
```

When no project ID is specified, the shortcode displays up to 10 published projects, ordered by publication date.

### Display a Specific Project

```text
[pmt_project id="123"]
```

Replace `123` with the actual WordPress post ID of a published project.

If the specified project does not exist, is not a project post, or is not published, the shortcode displays a **No projects found** message.

## REST API

The plugin provides a public, read-only endpoint for retrieving published projects.

### Endpoint

```http
GET /wp-json/pmt/v1/projects
```

For a local WordPress site at `http://localhost/wordpress`, use:

```text
http://localhost/wordpress/wp-json/pmt/v1/projects
```

### Query Parameters

| Parameter  | Default | Description                                                  |
| ---------- | ------: | ------------------------------------------------------------ |
| `page`     |     `1` | Page number; must be an integer greater than or equal to 1   |
| `per_page` |    `10` | Number of projects per page; must be an integer from 1 to 50 |

### Example Request

```text
http://localhost/wordpress/wp-json/pmt/v1/projects?page=1&per_page=10
```

### Response Data

A successful response includes a success indicator, project data, and pagination information.

Each project contains:

- `id`: WordPress post ID.
- `title`: Project title.
- `description`: Project description.
- `category`: Project category information.
- `image_url`: Project image URL, or `null` if unavailable.
- `project_url`: Project URL.

The pagination information contains:

- `current_page`
- `per_page`
- `total_items`
- `total_pages`

### Validation and Errors

The controller validates the `page` and `per_page` parameters.

- Invalid `page` values return an `invalid_page` error with HTTP status `400`.
- Invalid `per_page` values return an `invalid_per_page` error with HTTP status `400`.

The endpoint is publicly readable and uses a public permission callback.

## Development

The plugin is organized into PHP classes grouped by responsibility.

When modifying the plugin:

1. Keep project post type functionality in `src/PostTypes/`.
2. Keep taxonomy functionality in `src/Taxonomies/`.
3. Keep admin settings in `src/Admin/`.
4. Keep REST API logic in `src/Rest/`.
5. Keep shortcode logic in `src/Shortcodes/`.
6. Keep project-view functionality in `src/Database/`.
7. Keep component initialization in `src/class-plugin.php`.
8. Update this README when public functionality or API behavior changes.
9. Review Git changes before staging and committing.

## Composer and PHPUnit

The combined repository contains the Composer configuration and PHPUnit setup.

Run the following commands from the **combined repository root** (`technovz-combined`).

### Install Dependencies

```powershell
& "D:\xampp\php\php.exe" ".\composer.phar" install
```

### Run Settings Tests

```powershell
& "D:\xampp\php\php.exe" ".\vendor\bin\phpunit" ".\wp-content\plugins\project-management-toolkit\tests\SettingsTest.php"
```

### Run Project-View Tests

```powershell
& "D:\xampp\php\php.exe" ".\vendor\bin\phpunit" ".\wp-content\plugins\project-management-toolkit\tests\ProjectViewsTest.php"
```

### Run the Full Test Suite

```powershell
& "D:\xampp\php\php.exe" ".\vendor\bin\phpunit"
```

The project-view tests verify selected query-building and view-count behavior using a test database mock. They are not a full integration test against a live WordPress database.

## Testing Checklist

After installing or updating the plugin, verify the following:

- [x] The plugin activates without PHP errors.
- [x] Projects can be created and managed in WordPress.
- [x] Project categories and technologies register correctly.
- [x] Project custom fields behave as expected.
- [x] Admin settings work correctly.
- [x] The `[pmt_project]` shortcode displays projects.
- [x] The REST API returns project data and pagination details.
- [x] Invalid REST API parameters return the expected errors.
- [x] PHPUnit tests pass.
- [x] No new plugin-related errors appear in the WordPress debug log.

## Troubleshooting

### Plugin Activation Fails

Confirm that the plugin files exist in the expected directory. Check the PHP error log and WordPress debug log for errors.

### Projects Are Not Appearing

Verify that published projects exist and that the project custom post type is registered correctly.

### The Shortcode Displays No Projects

Confirm that published projects are available. If using the `id` attribute, check that the ID belongs to a published project.

### The REST API Returns an Error

Verify the endpoint URL and query parameters. Ensure that `page` is at least `1` and `per_page` is between `1` and `50`.

### PHPUnit Cannot Run

Run Composer installation from the combined repository root. Confirm that `vendor/autoload.php` and the PHPUnit executable exist.
