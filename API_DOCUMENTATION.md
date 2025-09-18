# ProjectFlow Lead Management API Documentation

## Overview

The ProjectFlow Lead Management API provides endpoints for managing leads in the system. This API allows you to create, retrieve, and manage lead information programmatically.

## Base URL

```
http://your-domain.com/api
```

## Authentication

Currently, the API endpoints are public. For production use, consider implementing proper authentication mechanisms such as API tokens or OAuth.

## Endpoints

### 1. Create Lead

Create a new lead in the system.

**Endpoint:** `POST /api/leads`

**Request Body:**
```json
{
    "name": "John Doe",
    "mobile": "+1234567890",
    "email": "john.doe@example.com",
    "product_type": "3D Modeling Services",
    "budget": "$5000 - $10000",
    "start": "Q1 2024",
    "created_at": "2024-01-15T10:30:00Z"
}
```

**Required Fields:**
- `name` (string, max: 255) - Lead's full name
- `mobile` (string, max: 20) - Mobile phone number
- `email` (string, email format, max: 255) - Email address
- `product_type` (string, max: 255) - Type of product/service
- `budget` (string, max: 255) - Budget range or amount
- `start` (string, max: 255) - Start timeline or information

**Optional Fields:**
- `created_at` (string, date format) - Custom creation timestamp (ISO 8601 format)

**Date Format Handling:**
The API accepts various date formats for the `created_at` field:
- ISO 8601: `2024-01-15T10:30:00Z`
- ISO 8601 with timezone: `2024-01-15T10:30:00+00:00`
- Standard format: `2024-01-15 10:30:00`
- Date only: `2024-01-15` (time defaults to 00:00:00)

If `created_at` is not provided, the current timestamp will be used.

**Success Response (201 Created):**
```json
{
    "success": true,
    "message": "Lead created successfully",
    "data": {
        "id": 1,
        "name": "John Doe",
        "mobile": "+1234567890",
        "email": "john.doe@example.com",
        "product_type": "3D Modeling Services",
        "budget": "$5000 - $10000",
        "start": "Q1 2024",
        "created_at": "2024-01-15T10:30:00.000000Z",
        "updated_at": "2024-01-15T10:30:00.000000Z"
    }
}
```

**Validation Error Response (422 Unprocessable Entity):**
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "email": [
            "The email field is required."
        ],
        "name": [
            "The name field is required."
        ]
    }
}
```

**Error Response (500 Internal Server Error):**
```json
{
    "success": false,
    "message": "An error occurred while creating the lead",
    "error": "Database connection failed"
}
```

### 2. Get All Leads

Retrieve a paginated list of all leads.

**Endpoint:** `GET /api/leads`

**Query Parameters:**
- `per_page` (optional, integer, default: 10) - Number of leads per page
- `search` (optional, string) - Search term to filter leads by name, email, mobile, or product type

**Example Request:**
```
GET /api/leads?per_page=25&search=john
```

**Success Response (200 OK):**
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
            "created_at": "2024-01-15T10:30:00.000000Z",
            "updated_at": "2024-01-15T10:30:00.000000Z"
        },
        {
            "id": 2,
            "name": "Jane Smith",
            "mobile": "+0987654321",
            "email": "jane.smith@example.com",
            "product_type": "Product Animation",
            "budget": "$2000 - $5000",
            "start": "Q2 2024",
            "created_at": "2024-01-16T14:20:00.000000Z",
            "updated_at": "2024-01-16T14:20:00.000000Z"
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

### 3. Get Single Lead

Retrieve detailed information about a specific lead including remarks.

**Endpoint:** `GET /api/leads/{id}`

**Path Parameters:**
- `id` (integer, required) - Lead ID

**Example Request:**
```
GET /api/leads/1
```

### 4. Convert Lead to Client

Convert a lead to a client by providing additional client information.

**Endpoint:** `POST /api/leads/{id}/convert-to-client`

**Path Parameters:**
- `id` (integer, required) - Lead ID

**Request Body:**
```json
{
    "company_name": "Acme Corporation",
    "description": "Leading provider of innovative solutions"
}
```

**Required Fields:**
- `company_name` (string, max: 255) - Company name for the client
- `description` (string, optional) - Client description

**Success Response (200 OK):**
```json
{
    "success": true,
    "message": "Lead converted to client successfully",
    "data": {
        "lead_id": 1,
        "client_id": 5,
        "client_name": "John Doe",
        "company_name": "Acme Corporation"
    }
}
```

**Already Converted Response (400 Bad Request):**
```json
{
    "success": false,
    "message": "Lead has already been converted to a client"
}
```

**Success Response (200 OK):**
```json
{
    "success": true,
    "message": "Lead retrieved successfully",
    "data": {
        "id": 1,
        "name": "John Doe",
        "mobile": "+1234567890",
        "email": "john.doe@example.com",
        "product_type": "3D Modeling Services",
        "budget": "$5000 - $10000",
        "start": "Q1 2024",
        "created_at": "2024-01-15T10:30:00.000000Z",
        "updated_at": "2024-01-15T10:30:00.000000Z",
        "remarks": [
            {
                "id": 1,
                "remark": "Initial contact made. Client is interested in architectural visualization.",
                "user": {
                    "id": 1,
                    "name": "Admin User",
                    "email": "admin@example.com"
                },
                "created_at": "2024-01-15T11:00:00.000000Z"
            },
            {
                "id": 2,
                "remark": "Follow-up call scheduled for next week.",
                "user": {
                    "id": 2,
                    "name": "Sales Manager",
                    "email": "sales@example.com"
                },
                "created_at": "2024-01-15T15:30:00.000000Z"
            }
        ]
    }
}
```

**Not Found Response (404 Not Found):**
```json
{
    "success": false,
    "message": "Lead not found",
    "error": "No lead found with the given ID"
}
```

## Error Handling

The API uses standard HTTP status codes and returns consistent error responses:

### Status Codes

- `200 OK` - Request successful
- `201 Created` - Resource created successfully
- `404 Not Found` - Resource not found
- `422 Unprocessable Entity` - Validation errors
- `500 Internal Server Error` - Server error

### Error Response Format

All error responses follow this format:

```json
{
    "success": false,
    "message": "Error description",
    "error": "Detailed error message (optional)",
    "errors": {
        "field_name": [
            "Validation error message"
        ]
    }
}
```

## Rate Limiting

Currently, no rate limiting is implemented. For production use, consider implementing rate limiting to prevent abuse.

## CORS

The API supports Cross-Origin Resource Sharing (CORS) for web applications. Configure allowed origins in your Laravel CORS settings.

## Examples

### cURL Examples

#### Create a Lead
```bash
curl -X POST http://your-domain.com/api/leads \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "mobile": "+1234567890",
    "email": "john.doe@example.com",
    "product_type": "3D Modeling Services",
    "budget": "$5000 - $10000",
    "start": "Q1 2024"
  }'
```

#### Get All Leads
```bash
curl -X GET "http://your-domain.com/api/leads?per_page=25&search=john"
```

#### Get Single Lead
```bash
curl -X GET http://your-domain.com/api/leads/1
```

### JavaScript Examples

#### Create a Lead (Fetch API)
```javascript
const createLead = async (leadData) => {
    try {
        const response = await fetch('http://your-domain.com/api/leads', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(leadData)
        });
        
        const result = await response.json();
        
        if (result.success) {
            console.log('Lead created:', result.data);
        } else {
            console.error('Error:', result.message);
        }
    } catch (error) {
        console.error('Network error:', error);
    }
};

// Usage
createLead({
    name: "John Doe",
    mobile: "+1234567890",
    email: "john.doe@example.com",
    product_type: "3D Modeling Services",
    budget: "$5000 - $10000",
    start: "Q1 2024"
});
```

#### Get Leads with Search
```javascript
const getLeads = async (searchTerm = '', perPage = 10) => {
    try {
        const url = new URL('http://your-domain.com/api/leads');
        if (searchTerm) url.searchParams.append('search', searchTerm);
        if (perPage) url.searchParams.append('per_page', perPage);
        
        const response = await fetch(url);
        const result = await response.json();
        
        if (result.success) {
            console.log('Leads:', result.data);
            console.log('Pagination:', result.pagination);
        } else {
            console.error('Error:', result.message);
        }
    } catch (error) {
        console.error('Network error:', error);
    }
};

// Usage
getLeads('john', 25);
```

### PHP Examples

#### Create a Lead (Guzzle HTTP)
```php
<?php
use GuzzleHttp\Client;

$client = new Client();

try {
    $response = $client->post('http://your-domain.com/api/leads', [
        'json' => [
            'name' => 'John Doe',
            'mobile' => '+1234567890',
            'email' => 'john.doe@example.com',
            'product_type' => '3D Modeling Services',
            'budget' => '$5000 - $10000',
            'start' => 'Q1 2024'
        ]
    ]);
    
    $result = json_decode($response->getBody(), true);
    
    if ($result['success']) {
        echo "Lead created: " . $result['data']['name'];
    } else {
        echo "Error: " . $result['message'];
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
```

## Data Models

### Lead Model
```json
{
    "id": "integer",
    "name": "string (max: 255)",
    "mobile": "string (max: 20)",
    "email": "string (email format, max: 255)",
    "product_type": "string (max: 255)",
    "budget": "string (max: 255)",
    "start": "string (max: 255)",
    "created_at": "ISO 8601 datetime",
    "updated_at": "ISO 8601 datetime"
}
```

### Lead Remark Model
```json
{
    "id": "integer",
    "remark": "text",
    "user": {
        "id": "integer",
        "name": "string",
        "email": "string"
    },
    "created_at": "ISO 8601 datetime"
}
```

## Changelog

### Version 1.0.0 (2024-01-15)
- Initial release
- Create lead endpoint
- Get all leads endpoint with pagination and search
- Get single lead endpoint with remarks
- Comprehensive error handling
- API documentation

## Support

For API support or questions, please contact the development team or refer to the main application documentation.

---

**Note:** This API is part of the ProjectFlow application developed by Inventiko. For more information about ProjectFlow, visit the main application.
