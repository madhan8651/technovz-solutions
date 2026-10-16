# Project Management Toolkit

A WordPress plugin for managing projects, organizing project categories and technologies, displaying project listings with React, and tracking project views. It includes a public REST API, AJAX-powered pagination, administrative settings, and dashboard integration.

## Features

- **Project Management:** Create and manage projects using a custom post type.
- **Project Categories:** Organize projects by category.
- **Project Technologies:** Classify projects by the technologies they use.
- **React Project Listing:** Display projects through the `[pmt_react_projects]` shortcode.
- **REST API:** Retrieve published projects through a paginated JSON endpoint.
- **AJAX Load More:** Load additional projects without refreshing the page.
- **Project View Tracking:** Record views of published project pages in a custom database table.
- **View Count Caching:** Cache aggregated project view counts using the WordPress Transients API.
- **Admin Settings:** Configure a dashboard message and enable or disable its display.
- **Dashboard Widget:** Display the configured message on the WordPress dashboard.
- **Security:** Includes input validation, sanitization, output escaping, nonce verification, and capability checks in reviewed components.

## Requirements

- WordPress
- PHP version compatible with your WordPress installation and the plugin dependencies
- MySQL or MariaDB
- A WordPress theme
- JavaScript support for the React-powered project listing

## Installation

### Local installation using XAMPP

1. Copy or clone the plugin into:

   `wp-content/plugins/project-management-toolkit/`

2. Open your WordPress administration dashboard.
3. Navigate to **Plugins → Installed Plugins**.
4. Find **Project Management Toolkit** and click **Activate**.
5. Add projects through the plugin's project management interface.
6. Configure the dashboard message under **Settings → Project Management Toolkit**.

The plugin activation routine creates the custom project views database table.

## Usage

### React project listing

Add the following shortcode to a WordPress page:

```text
[pmt_react_projects]
```

The listing initially retrieves two projects from the REST API. Visitors can use the **Load More Projects** button to retrieve subsequent projects through WordPress AJAX.

### Project categories and technologies

Use the registered project categories and technology taxonomies to organize projects and make their information easier to manage.

### Dashboard message

Navigate to:

**WordPress Admin → Settings → Project Management Toolkit**

You can configure the dashboard message and enable or disable its display.

## REST API

### Endpoint

```http
GET /wp-json/pmt/v1/projects
```

For a local XAMPP installation, the endpoint may be:

```text
http://localhost/wordpress/wp-json/pmt/v1/projects
```

The endpoint returns published projects and supports pagination.

### Query parameters

| Parameter | Default | Allowed values |
|---|---:|---|
| `page` | `1` | Positive integer |
| `per_page` | `10` | Integer from 1 to 50 |

### Example requests

Retrieve projects using the default settings:

```http
GET /wp-json/pmt/v1/projects
```

Retrieve the first two projects:

```http
GET /wp-json/pmt/v1/projects?page=1&per_page=2
```

Retrieve the second page:

```http
GET /wp-json/pmt/v1/projects?page=2&per_page=2
```

### Example response

```json
{
  "success": true,
  "data": [
    {
      "id": 408,
      "title": "E-Commerce Platform",
      "description": "A user-friendly online store.",
      "category": ["Web Development"],
      "image_url": "http://localhost/wordpress/wp-content/uploads/example.png",
      "project_url": "http://localhost/wordpress/projects/e-commerce-platform/"
    }
  ],
  "pagination": {
    "current_page": 1,
    "per_page": 2,
    "total_items": 4,
    "total_pages": 2
  }
}
```

The example response is illustrative. Actual project data, URLs, and pagination values depend on the installed WordPress site.

### Error handling

Invalid pagination values return a WordPress REST API error response. Examples include:

- `page=0`
- `page=abc`
- `per_page=100`

Check the HTTP status code as well as the JSON response when testing.

## AJAX Pagination

The React listing uses the WordPress AJAX action:

```text
pmt_load_more_projects
```

The AJAX handler:

- Verifies the request nonce.
- Validates the requested page.
- Retrieves published projects only.
- Returns project data and pagination information.
- Rejects invalid or unavailable page requests.

The AJAX handler supports both logged-in and public visitors because the project listing is intended to be public.

## Project View Tracking

The plugin records views of published project pages in the database table:

```text
wp_pmt_project_views
```

The table contains:

| Column | Purpose |
|---|---|
| `id` | Unique view record |
| `project_id` | ID of the viewed project |
| `viewed_at` | Date and time of the view |

The table name uses the WordPress database prefix, so it may differ from `wp_` on another installation.

Aggregated view counts can be cached using the WordPress Transients API. The cache is invalidated when a new view record is successfully inserted.

## Security Measures

The reviewed plugin components include measures such as:

- Sanitizing and validating incoming settings and request parameters.
- Escaping displayed text and URLs.
- Verifying nonces for protected AJAX and metadata operations.
- Checking user capabilities for administrative settings.
- Using `$wpdb->prepare()` for SQL queries with dynamic values.
- Using WordPress database APIs for inserts.
- Restricting project listing queries to published projects.
- Validating project metadata, including URLs, dates, and allowed status values.

Security should be assessed across the complete plugin and deployment environment. The measures above describe the reviewed components and do not constitute a full security audit.

## Testing

The following REST API scenarios were tested during development:

| Test | Expected result |
|---|---|
| Default API request | Returns published projects |
| `page=1&per_page=2` | Returns the first page |
| `page=2&per_page=2` | Returns the next page |
| `page=0` | Rejects invalid pagination |
| `page=abc` | Rejects invalid pagination |
| `per_page=100` | Rejects values above the limit |

The AJAX listing was also tested to confirm that additional projects could be loaded through the browser's Network panel.

## Project Structure

```text
project-management-toolkit/
├── assets/
│   ├── css/
│   │   └── react-projects.css
│   └── js/
│       └── react-projects.js
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
│   ├── Frontend/
│   │   └── ReactProjects.php
│   └── Rest/
│       └── ProjectRestController.php
├── project-management-toolkit.php
└── README.md
```

This is a partial overview of the reviewed files. Other source files may be present in the installed plugin.

## Development

The plugin uses WordPress APIs, PHP, JavaScript, and the WordPress React-compatible `wp.element` package.

For local development, install WordPress using a suitable local environment such as XAMPP, activate the plugin, and test the REST API and project listing.

## License

The plugin's license should be specified according to the license chosen for this project. Confirm the applicable license before distributing the plugin publicly.