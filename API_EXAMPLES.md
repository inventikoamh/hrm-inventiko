# ProjectFlow Lead API - Quick Examples

## Quick Start Examples

### 1. Create a Lead (cURL)

```bash
# Create lead with current timestamp
curl -X POST http://localhost:8000/api/leads \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "mobile": "+1234567890",
    "email": "john.doe@example.com",
    "product_type": "3D Modeling Services",
    "budget": "$5000 - $10000",
    "start": "Q1 2024"
  }'

# Create lead with custom timestamp
curl -X POST http://localhost:8000/api/leads \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Jane Smith",
    "mobile": "+0987654321",
    "email": "jane@example.com",
    "product_type": "Product Animation",
    "budget": "$2000 - $5000",
    "start": "Q2 2024",
    "created_at": "2024-01-15T10:30:00Z"
  }'
```

### 2. Get All Leads (cURL)

```bash
curl -X GET "http://localhost:8000/api/leads?per_page=25&search=john"
```

### 3. Get Single Lead (cURL)

```bash
curl -X GET http://localhost:8000/api/leads/1
```

### 4. Convert Lead to Client (cURL)

```bash
curl -X POST http://localhost:8000/api/leads/1/convert-to-client \
  -H "Content-Type: application/json" \
  -d '{
    "company_name": "Acme Corporation",
    "description": "Leading provider of innovative solutions"
  }'
```

## JavaScript Examples

### Using Fetch API

```javascript
// Create Lead
async function createLead(leadData) {
    const response = await fetch('http://localhost:8000/api/leads', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(leadData)
    });
    
    return await response.json();
}

// Get Leads
async function getLeads(search = '', perPage = 10) {
    const url = new URL('http://localhost:8000/api/leads');
    if (search) url.searchParams.append('search', search);
    if (perPage) url.searchParams.append('per_page', perPage);
    
    const response = await fetch(url);
    return await response.json();
}

// Usage
// Create lead with current timestamp
createLead({
    name: "Jane Smith",
    mobile: "+0987654321",
    email: "jane@example.com",
    product_type: "Product Animation",
    budget: "$2000 - $5000",
    start: "Q2 2024"
}).then(result => {
    console.log('Lead created:', result);
});

// Create lead with custom timestamp
createLead({
    name: "John Doe",
    mobile: "+1234567890",
    email: "john.doe@example.com",
    product_type: "3D Modeling Services",
    budget: "$5000 - $10000",
    start: "Q1 2024",
    created_at: "2024-01-15T10:30:00Z"
}).then(result => {
    console.log('Lead created with custom timestamp:', result);
});

getLeads('jane', 25).then(result => {
    console.log('Leads found:', result.data);
});
```

### Using Axios

```javascript
import axios from 'axios';

const api = axios.create({
    baseURL: 'http://localhost:8000/api',
    headers: {
        'Content-Type': 'application/json',
    }
});

// Create Lead
const createLead = async (leadData) => {
    try {
        const response = await api.post('/leads', leadData);
        return response.data;
    } catch (error) {
        console.error('Error creating lead:', error.response.data);
        throw error;
    }
};

// Get Leads
const getLeads = async (search = '', perPage = 10) => {
    try {
        const response = await api.get('/leads', {
            params: { search, per_page: perPage }
        });
        return response.data;
    } catch (error) {
        console.error('Error fetching leads:', error.response.data);
        throw error;
    }
};

// Usage
createLead({
    name: "Mike Johnson",
    mobile: "+1122334455",
    email: "mike@example.com",
    product_type: "Architectural Visualization",
    budget: "$8000 - $15000",
    start: "Q3 2024"
});
```

## PHP Examples

### Using Guzzle HTTP

```php
<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client(['base_uri' => 'http://localhost:8000/api/']);

// Create Lead
try {
    $response = $client->post('leads', [
        'json' => [
            'name' => 'Sarah Wilson',
            'mobile' => '+5566778899',
            'email' => 'sarah@example.com',
            'product_type' => 'Medical Animation',
            'budget' => '$3000 - $7000',
            'start' => 'Q4 2024'
        ]
    ]);
    
    $result = json_decode($response->getBody(), true);
    echo "Lead created: " . $result['data']['name'] . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Get Leads
try {
    $response = $client->get('leads', [
        'query' => [
            'search' => 'sarah',
            'per_page' => 10
        ]
    ]);
    
    $result = json_decode($response->getBody(), true);
    echo "Found " . count($result['data']) . " leads\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```

### Using Laravel HTTP Client

```php
<?php
use Illuminate\Support\Facades\Http;

// Create Lead
$response = Http::post('http://localhost:8000/api/leads', [
    'name' => 'David Brown',
    'mobile' => '+9988776655',
    'email' => 'david@example.com',
    'product_type' => 'Product Rendering',
    'budget' => '$1500 - $3000',
    'start' => 'Immediate'
]);

if ($response->successful()) {
    $data = $response->json();
    echo "Lead created: " . $data['data']['name'];
} else {
    echo "Error: " . $response->body();
}

// Get Leads
$response = Http::get('http://localhost:8000/api/leads', [
    'search' => 'david',
    'per_page' => 25
]);

if ($response->successful()) {
    $data = $response->json();
    echo "Found " . count($data['data']) . " leads";
}
?>
```

## Python Examples

### Using Requests

```python
import requests
import json

base_url = "http://localhost:8000/api"

# Create Lead
def create_lead(lead_data):
    response = requests.post(f"{base_url}/leads", json=lead_data)
    return response.json()

# Get Leads
def get_leads(search="", per_page=10):
    params = {"search": search, "per_page": per_page}
    response = requests.get(f"{base_url}/leads", params=params)
    return response.json()

# Usage
lead_data = {
    "name": "Emily Davis",
    "mobile": "+4433221100",
    "email": "emily@example.com",
    "product_type": "Virtual Reality",
    "budget": "$10000 - $20000",
    "start": "Q1 2025"
}

result = create_lead(lead_data)
print(f"Lead created: {result['data']['name']}")

leads = get_leads("emily", 25)
print(f"Found {len(leads['data'])} leads")
```

## Response Examples

### Successful Lead Creation
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

### Validation Error
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "email": ["The email field is required."],
        "name": ["The name field is required."]
    }
}
```

### Lead List with Pagination
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
        }
    ],
    "pagination": {
        "current_page": 1,
        "last_page": 1,
        "per_page": 10,
        "total": 1,
        "from": 1,
        "to": 1
    }
}
```

## Testing with Postman

### Collection Setup
1. Create a new collection called "ProjectFlow Lead API"
2. Set base URL: `http://localhost:8000/api`
3. Add the following requests:

#### Create Lead Request
- **Method:** POST
- **URL:** `{{base_url}}/leads`
- **Headers:** `Content-Type: application/json`
- **Body (raw JSON):**
```json
{
    "name": "Test Lead",
    "mobile": "+1234567890",
    "email": "test@example.com",
    "product_type": "API Testing",
    "budget": "$1000 - $2000",
    "start": "Immediate"
}
```

#### Get All Leads Request
- **Method:** GET
- **URL:** `{{base_url}}/leads?per_page=10&search=test`

#### Get Single Lead Request
- **Method:** GET
- **URL:** `{{base_url}}/leads/1`

## Error Handling Best Practices

```javascript
async function handleApiCall(apiFunction) {
    try {
        const result = await apiFunction();
        
        if (result.success) {
            console.log('Success:', result.message);
            return result.data;
        } else {
            console.error('API Error:', result.message);
            if (result.errors) {
                console.error('Validation Errors:', result.errors);
            }
            return null;
        }
    } catch (error) {
        console.error('Network Error:', error.message);
        return null;
    }
}

// Usage
const lead = await handleApiCall(() => createLead(leadData));
if (lead) {
    console.log('Lead created successfully:', lead);
}
```

---

For complete API documentation, see [API_DOCUMENTATION.md](./API_DOCUMENTATION.md)
