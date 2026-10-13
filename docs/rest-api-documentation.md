# Project Management Toolkit — REST API Documentation

## 1. Overview

This document describes the custom REST API implemented by the WordPress Project Management Toolkit plugin. The endpoint returns published projects as JSON and supports pagination.

- **Namespace:** `pmt/v1`
- **Route:** `/projects`
- **HTTP method:** `GET`
- **Local development URL:** `http://localhost/wordpress/wp-json/pmt/v1/projects`

The local URL works on the development computer running this WordPress site. Replace the host and WordPress path when deploying to another environment.

## 2. Endpoint

```http
GET /wp-json/pmt/v1/projects
```

The endpoint returns published posts of the custom post type `pmt_project`.

## 3. Request parameters

| Parameter | Required | Default | Allowed value | Description |
|---|---|---:|---|---|
| `page` | No | `1` | Integer greater than or equal to 1 | Page of results to return |
| `per_page` | No | `10` | Integer from 1 through 50 | Number of projects per page |

Examples:

```text
http://localhost/wordpress/wp-json/pmt/v1/projects
http://localhost/wordpress/wp-json/pmt/v1/projects?page=1&per_page=2
http://localhost/wordpress/wp-json/pmt/v1/projects?page=2&per_page=2
```

## 4. Successful response

**HTTP status:** `200 OK`

The response contains a success flag, an array of projects, and pagination metadata.

```json
{
  "success": true,
  "data": [
    {
      "id": 408,
      "title": "E-Commerce Platform",
      "description": "A user-friendly online store designed to provide a smooth product browsing and shopping experience.",
      "category": ["Web Development"],
      "image_url": "http://localhost/wordpress/wp-content/uploads/2026/10/E-Commerce-Website.png",
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

The example is illustrative; descriptions and image URLs may differ as project content changes.

### Response fields

| Field | Type | Description |
|---|---|---|
| `success` | Boolean | Indicates that the response was successful |
| `data` | Array | Projects returned for the requested page |
| `data[].id` | Integer | WordPress project post ID |
| `data[].title` | String | Project title |
| `data[].description` | String | Project excerpt used as the description |
| `data[].category` | Array of strings | Names of the project's categories |
| `data[].image_url` | String or `null` | Featured image URL, if available |
| `data[].project_url` | String | URL of the individual project page |
| `pagination.current_page` | Integer | Current page number |
| `pagination.per_page` | Integer | Requested page size |
| `pagination.total_items` | Integer | Total number of matching published projects |
| `pagination.total_pages` | Integer | Number of pages available |

## 5. Error responses

### Invalid page

Request:

```text
http://localhost/wordpress/wp-json/pmt/v1/projects?page=0
```

**HTTP status:** `400 Bad Request`

```json
{
  "code": "invalid_page",
  "message": "The page parameter must be at least 1.",
  "data": {
    "status": 400
  }
}
```

### Invalid page size

Request:

```text
http://localhost/wordpress/wp-json/pmt/v1/projects?per_page=100
```

**HTTP status:** `400 Bad Request`

```json
{
  "code": "invalid_per_page",
  "message": "The per_page parameter must be between 1 and 50.",
  "data": {
    "status": 400
  }
}
```

## 6. Permissions and data visibility

The endpoint uses a public permission callback because it returns only published projects. Draft and private projects are excluded by the query's `post_status: publish` setting. Do not add confidential information to fields exposed by this public endpoint.

## 7. Implementation

The endpoint is registered with WordPress's `register_rest_route()` function. The callback retrieves projects using `WP_Query`, reads category terms and the featured image, and returns the result through `rest_ensure_response()`.

Pagination parameters are sanitized and checked by the controller. Invalid page values or page sizes return a `WP_Error` response with HTTP status `400`.

## 8. React integration

The React listing is embedded using this WordPress shortcode:

```text
[pmt_react_projects]
```

The JavaScript requests project data from the REST endpoint and displays project cards with the image, title, category, description, and a **View Project** link.

## 9. AJAX Load More integration

The plugin registers these WordPress AJAX hooks:

- `wp_ajax_pmt_load_more_projects` — requests from logged-in users.
- `wp_ajax_nopriv_pmt_load_more_projects` — requests from visitors who are not logged in.

The AJAX action is `pmt_load_more_projects`. The request sends a WordPress nonce and the requested page to `admin-ajax.php`. The handler validates the nonce and page number, retrieves the next two published projects, and returns JSON using `wp_send_json_success()`.

The AJAX response includes project data and pagination metadata: `current_page`, `per_page`, `total_items`, `total_pages`, and `has_more`. The React component appends returned projects without reloading the whole page.

## 10. Testing record

The following tests were performed in the local WordPress environment:

| Test | Expected result | Observed result |
|---|---|---|
| Request the projects endpoint | JSON containing published projects | Passed |
| Request `page=1&per_page=2` | Two projects and pagination metadata | Passed |
| Request `page=0` | HTTP 400 with `invalid_page` | Passed |
| Request `per_page=100` | HTTP 400 with `invalid_per_page` | Passed |
| Request page 2 through AJAX | Remaining projects and `has_more: false` | Passed |
| Verify AJAX Network response | Successful JSON response from `admin-ajax.php` | Passed |

## 11. Notes

- This documentation describes the implementation and tests in the local development environment.
- The example response is illustrative; the live response reflects the current published projects.
- The REST endpoint is public and read-only. The AJAX Load More handler uses a nonce to verify the request.
