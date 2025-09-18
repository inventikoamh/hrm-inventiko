# ProjectFlow CRM API Documentation

## Overview

ProjectFlow is a comprehensive Customer Relationship Management (CRM) and Project Management system developed by Inventiko. This API provides programmatic access to all major features including lead management, project tracking, task management, attendance monitoring, and more.

**Live Demo:** [https://hrm.inventiko.com/](https://hrm.inventiko.com/)

## Base URL

```
https://hrm.inventiko.com/api
```

## Authentication

The API uses Laravel Sanctum for authentication. Include the Bearer token in the Authorization header:

```
Authorization: Bearer {your-token}
```

## Features Overview

- **Lead Management** - Create, track, and convert leads to clients
- **Project Management** - Manage projects with status tracking and priority levels
- **Task Management** - Create and assign tasks with comments and status updates
- **Client Management** - Manage client information and relationships
- **Attendance Tracking** - Monitor employee attendance and work hours
- **Leave Management** - Handle leave requests and approvals
- **User Management** - Manage users, roles, and permissions
- **Settings Management** - Configure application settings and themes

## API Endpoints

### Authentication

#### Login
```http
POST /api/auth/login
```

**Request Body:**
```json
{
    "email": "user@example.com",
    "password": "password"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "user@example.com",
            "role": "admin"
        },
        "token": "1|abc123..."
    }
}
```

#### Logout
```http
POST /api/auth/logout
```

**Headers:**
```
Authorization: Bearer {token}
```

### Lead Management

#### Get All Leads
```http
GET /api/leads
```

**Query Parameters:**
- `per_page` (optional, integer, default: 10) - Number of leads per page
- `search` (optional, string) - Search term to filter leads
- `status` (optional, string) - Filter by lead status
- `created_by` (optional, integer) - Filter by creator ID

**Response:**
```json
{
    "success": true,
    "message": "Leads retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "John Doe",
            "mobile": "+1234567890",
            "email": "john.doe@example.com",
            "product_type": "3D Modeling Services",
            "budget": "$5000 - $10000",
            "start": "Q1 2024",
            "status": "new_lead",
            "created_at": "2024-01-15T10:30:00.000000Z",
            "updated_at": "2024-01-15T10:30:00.000000Z"
        }
    ],
    "pagination": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 10,
        "total": 47,
        "from": 1,
        "to": 10
    }
}
```

#### Create Lead
```http
POST /api/leads
```

**Request Body:**
```json
{
    "name": "John Doe",
    "mobile": "+1234567890",
    "email": "john.doe@example.com",
    "product_type": "3D Modeling Services",
    "budget": "$5000 - $10000",
    "start": "Q1 2024"
}
```

#### Get Single Lead
```http
GET /api/leads/{id}
```

#### Convert Lead to Client
```http
POST /api/leads/{id}/convert-to-client
```

**Request Body:**
```json
{
    "company_name": "Acme Corporation",
    "description": "Leading provider of innovative solutions"
}
```

#### Update Lead Status
```http
POST /api/leads/{id}/status
```

**Request Body:**
```json
{
    "status": "in_progress",
    "description": "Status update description"
}
```

#### Add Lead Remark
```http
POST /api/leads/{id}/remarks
```

**Request Body:**
```json
{
    "remark": "Follow-up call completed successfully"
}
```

### Project Management

#### Get All Projects
```http
GET /api/projects
```

**Query Parameters:**
- `per_page` (optional, integer, default: 10)
- `search` (optional, string)
- `status` (optional, string)
- `priority` (optional, string)
- `client_id` (optional, integer)

#### Create Project
```http
POST /api/projects
```

**Request Body:**
```json
{
    "title": "Website Redesign",
    "description": "Complete website redesign project",
    "client_id": 1,
    "project_lead_id": 2,
    "priority": "high",
    "status": "planning",
    "budget": 50000,
    "estimated_start_date": "2024-02-01",
    "estimated_end_date": "2024-04-30"
}
```

#### Get Single Project
```http
GET /api/projects/{id}
```

#### Update Project
```http
PUT /api/projects/{id}
```

#### Delete Project
```http
DELETE /api/projects/{id}
```

### Task Management

#### Get All Tasks
```http
GET /api/tasks
```

**Query Parameters:**
- `per_page` (optional, integer, default: 10)
- `search` (optional, string)
- `status` (optional, string)
- `priority` (optional, string)
- `assigned_to` (optional, integer)
- `project_id` (optional, integer)
- `created_by` (optional, integer)
- `overdue` (optional, boolean)

#### Create Task
```http
POST /api/tasks
```

**Request Body:**
```json
{
    "title": "Design Homepage",
    "description": "Create new homepage design",
    "project_id": 1,
    "assigned_to": 2,
    "priority": "high",
    "status": "pending",
    "start_date": "2024-02-01",
    "end_date": "2024-02-15"
}
```

#### Get Single Task
```http
GET /api/tasks/{id}
```

#### Update Task
```http
PUT /api/tasks/{id}
```

#### Delete Task
```http
DELETE /api/tasks/{id}
```

#### Add Task Comment
```http
POST /api/tasks/{id}/comments
```

**Request Body:**
```json
{
    "comment": "Task is progressing well"
}
```

### Client Management

#### Get All Clients
```http
GET /api/clients
```

#### Create Client
```http
POST /api/clients
```

**Request Body:**
```json
{
    "client_name": "John Doe",
    "company_name": "Acme Corporation",
    "email": "john@acme.com",
    "mobile": "+1234567890",
    "description": "Leading technology company"
}
```

#### Get Single Client
```http
GET /api/clients/{id}
```

#### Update Client
```http
PUT /api/clients/{id}
```

#### Delete Client
```http
DELETE /api/clients/{id}
```

### Attendance Management

#### Clock In
```http
POST /api/attendance/clock-in
```

**Request Body:**
```json
{
    "location": "Office",
    "notes": "Starting work day"
}
```

#### Clock Out
```http
POST /api/attendance/clock-out
```

**Request Body:**
```json
{
    "notes": "Ending work day"
}
```

#### Get Attendance History
```http
GET /api/attendance/history
```

**Query Parameters:**
- `date_from` (optional, date)
- `date_to` (optional, date)
- `user_id` (optional, integer)

#### Get Today's Attendance
```http
GET /api/attendance/today
```

### Leave Management

#### Get Leave Requests
```http
GET /api/leave-requests
```

#### Create Leave Request
```http
POST /api/leave-requests
```

**Request Body:**
```json
{
    "type": "sick_leave",
    "start_date": "2024-02-15",
    "end_date": "2024-02-16",
    "reason": "Medical appointment"
}
```

#### Approve/Reject Leave Request
```http
POST /api/leave-requests/{id}/status
```

**Request Body:**
```json
{
    "status": "approved",
    "notes": "Approved for medical reasons"
}
```

### User Management

#### Get All Users
```http
GET /api/users
```

#### Create User
```http
POST /api/users
```

**Request Body:**
```json
{
    "name": "Jane Smith",
    "email": "jane@example.com",
    "password": "password123",
    "role": "employee"
}
```

#### Get Single User
```http
GET /api/users/{id}
```

#### Update User
```http
PUT /api/users/{id}
```

#### Delete User
```http
DELETE /api/users/{id}
```

### Settings Management

#### Get Settings
```http
GET /api/settings
```

#### Update Settings
```http
POST /api/settings
```

**Request Body:**
```json
{
    "app_name": "ProjectFlow",
    "theme_color": "#3B82F6",
    "late_clock_in_time": "11:30",
    "auto_clock_out_time": "23:59"
}
```

#### Get Enum Values
```http
GET /api/settings/enums/{type}
```

**Example:**
```http
GET /api/settings/enums/task_priority
```

**Response:**
```json
{
    "success": true,
    "data": ["Low", "Medium", "High", "Critical"]
}
```

#### Get Enum Colors
```http
GET /api/settings/colors/{type}
```

**Example:**
```http
GET /api/settings/colors/task_priority
```

**Response:**
```json
{
    "success": true,
    "data": {
        "Low": "#22C55E",
        "Medium": "#F59E0B",
        "High": "#F97316",
        "Critical": "#DC2626"
    }
}
```

## Response Format

All API responses follow a consistent format:

### Success Response
```json
{
    "success": true,
    "message": "Operation completed successfully",
    "data": {
        // Response data
    }
}
```

### Error Response
```json
{
    "success": false,
    "message": "Error description",
    "error": "Detailed error message",
    "errors": {
        "field_name": [
            "Validation error message"
        ]
    }
}
```

## Status Codes

- `200 OK` - Request successful
- `201 Created` - Resource created successfully
- `400 Bad Request` - Invalid request
- `401 Unauthorized` - Authentication required
- `403 Forbidden` - Insufficient permissions
- `404 Not Found` - Resource not found
- `422 Unprocessable Entity` - Validation errors
- `500 Internal Server Error` - Server error

## Pagination

List endpoints support pagination with the following parameters:

- `per_page` - Number of items per page (default: 10, max: 100)
- `page` - Page number (default: 1)

Pagination response includes:
```json
{
    "pagination": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 10,
        "total": 47,
        "from": 1,
        "to": 10,
        "has_more_pages": true
    }
}
```

## Filtering and Search

Most list endpoints support filtering and search:

- `search` - Search across relevant text fields
- `status` - Filter by status
- `priority` - Filter by priority
- `date_from` / `date_to` - Date range filtering
- `user_id` - Filter by user
- `project_id` - Filter by project

## Rate Limiting

API requests are rate limited to prevent abuse:
- 1000 requests per hour per authenticated user
- 100 requests per hour for unauthenticated requests

Rate limit headers are included in responses:
```
X-RateLimit-Limit: 1000
X-RateLimit-Remaining: 999
X-RateLimit-Reset: 1640995200
```

## Error Handling

The API provides detailed error information:

### Validation Errors
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "email": [
            "The email field is required.",
            "The email must be a valid email address."
        ],
        "name": [
            "The name field is required."
        ]
    }
}
```

### Permission Errors
```json
{
    "success": false,
    "message": "You do not have permission to perform this action"
}
```

## SDKs and Examples

### JavaScript/Node.js

```javascript
// Install: npm install axios
const axios = require('axios');

const api = axios.create({
    baseURL: 'https://hrm.inventiko.com/api',
    headers: {
        'Authorization': 'Bearer ' + token,
        'Content-Type': 'application/json'
    }
});

// Create a lead
const createLead = async (leadData) => {
    try {
        const response = await api.post('/leads', leadData);
        return response.data;
    } catch (error) {
        console.error('Error creating lead:', error.response.data);
        throw error;
    }
};

// Get all tasks
const getTasks = async (filters = {}) => {
    try {
        const response = await api.get('/tasks', { params: filters });
        return response.data;
    } catch (error) {
        console.error('Error fetching tasks:', error.response.data);
        throw error;
    }
};
```

### PHP

```php
<?php
// Install: composer require guzzlehttp/guzzle
use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => 'https://hrm.inventiko.com/api/',
    'headers' => [
        'Authorization' => 'Bearer ' . $token,
        'Content-Type' => 'application/json'
    ]
]);

// Create a lead
$response = $client->post('leads', [
    'json' => [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'mobile' => '+1234567890',
        'product_type' => 'Web Development',
        'budget' => '$5000 - $10000',
        'start' => 'Q1 2024'
    ]
]);

$result = json_decode($response->getBody(), true);
?>
```

### Python

```python
import requests

# Configure API client
API_BASE = 'https://hrm.inventiko.com/api'
headers = {
    'Authorization': f'Bearer {token}',
    'Content-Type': 'application/json'
}

# Create a lead
def create_lead(lead_data):
    response = requests.post(f'{API_BASE}/leads', json=lead_data, headers=headers)
    return response.json()

# Get all projects
def get_projects(filters=None):
    response = requests.get(f'{API_BASE}/projects', params=filters, headers=headers)
    return response.json()
```

## Webhooks

ProjectFlow supports webhooks for real-time notifications:

### Available Events
- `lead.created` - New lead created
- `lead.updated` - Lead updated
- `lead.converted` - Lead converted to client
- `task.created` - New task created
- `task.completed` - Task marked as completed
- `project.created` - New project created
- `attendance.clock_in` - User clocked in
- `attendance.clock_out` - User clocked out

### Webhook Configuration
```http
POST /api/webhooks
```

**Request Body:**
```json
{
    "url": "https://your-app.com/webhooks/projectflow",
    "events": ["lead.created", "task.completed"],
    "secret": "your-webhook-secret"
}
```

## Changelog

### Version 2.0.0 (2024-01-18)
- Added comprehensive task management
- Added project management with Gantt charts
- Added attendance tracking system
- Added leave management
- Added user management with roles and permissions
- Added settings management with theme customization
- Added enum color customization
- Improved API response format
- Added webhook support
- Enhanced error handling

### Version 1.0.0 (2024-01-15)
- Initial release
- Basic lead management
- Client conversion
- Authentication system

## Support

For API support, documentation updates, or feature requests:

- **Website:** [https://hrm.inventiko.com/](https://hrm.inventiko.com/)
- **Documentation:** This API documentation
- **Issues:** Contact the development team

## License

This API is part of the ProjectFlow application developed by Inventiko. All rights reserved.

---

**ProjectFlow CRM** - Streamline your business operations with our comprehensive project and customer relationship management solution.
