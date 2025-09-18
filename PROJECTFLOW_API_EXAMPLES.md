# ProjectFlow API Examples

This document provides practical examples for using the ProjectFlow CRM API. All examples use the live demo URL: [https://hrm.inventiko.com/](https://hrm.inventiko.com/)

## Table of Contents

1. [Authentication Examples](#authentication-examples)
2. [Lead Management Examples](#lead-management-examples)
3. [Project Management Examples](#project-management-examples)
4. [Task Management Examples](#task-management-examples)
5. [Client Management Examples](#client-management-examples)
6. [Attendance Management Examples](#attendance-management-examples)
7. [Leave Management Examples](#leave-management-examples)
8. [Settings Management Examples](#settings-management-examples)
9. [Error Handling Examples](#error-handling-examples)

## Authentication Examples

### Login and Get Token

```bash
# Login to get authentication token
curl -X POST https://hrm.inventiko.com/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@example.com",
    "password": "password"
  }'
```

**Response:**
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "Admin User",
            "email": "admin@example.com",
            "role": "admin"
        },
        "token": "1|abc123def456ghi789jkl012mno345pqr678stu901vwx234yz"
    }
}
```

### Using Token in Subsequent Requests

```bash
# Set your token as a variable
TOKEN="1|abc123def456ghi789jkl012mno345pqr678stu901vwx234yz"

# Use token in API requests
curl -X GET https://hrm.inventiko.com/api/leads \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json"
```

## Lead Management Examples

### Create a New Lead

```bash
curl -X POST https://hrm.inventiko.com/api/leads \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Smith",
    "mobile": "+1-555-0123",
    "email": "john.smith@techcorp.com",
    "product_type": "Custom Web Application",
    "budget": "$15,000 - $25,000",
    "start": "Q2 2024"
  }'
```

### Get All Leads with Pagination

```bash
curl -X GET "https://hrm.inventiko.com/api/leads?per_page=20&search=john" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json"
```

### Get Single Lead with Remarks

```bash
curl -X GET https://hrm.inventiko.com/api/leads/1 \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json"
```

### Update Lead Status

```bash
curl -X POST https://hrm.inventiko.com/api/leads/1/status \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "status": "in_progress",
    "description": "Initial contact made, waiting for project requirements"
  }'
```

### Add Lead Remark

```bash
curl -X POST https://hrm.inventiko.com/api/leads/1/remarks \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "remark": "Client is very interested in our services. Follow-up meeting scheduled for next week."
  }'
```

### Convert Lead to Client

```bash
curl -X POST https://hrm.inventiko.com/api/leads/1/convert-to-client \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "company_name": "TechCorp Solutions",
    "description": "Leading technology consulting firm specializing in digital transformation"
  }'
```

## Project Management Examples

### Create a New Project

```bash
curl -X POST https://hrm.inventiko.com/api/projects \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "E-commerce Platform Development",
    "description": "Complete e-commerce platform with admin dashboard, payment integration, and mobile app",
    "client_id": 1,
    "project_lead_id": 2,
    "priority": "high",
    "status": "planning",
    "budget": 75000,
    "estimated_start_date": "2024-02-01",
    "estimated_end_date": "2024-06-30"
  }'
```

### Get All Projects with Filters

```bash
curl -X GET "https://hrm.inventiko.com/api/projects?status=active&priority=high&per_page=10" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json"
```

### Update Project Status

```bash
curl -X PUT https://hrm.inventiko.com/api/projects/1 \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "status": "active",
    "priority": "critical"
  }'
```

## Task Management Examples

### Create a New Task

```bash
curl -X POST https://hrm.inventiko.com/api/tasks \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Design User Interface Mockups",
    "description": "Create wireframes and mockups for the main user interface",
    "project_id": 1,
    "assigned_to": 3,
    "priority": "high",
    "status": "pending",
    "start_date": "2024-02-01",
    "end_date": "2024-02-15"
  }'
```

### Get Tasks with Advanced Filtering

```bash
curl -X GET "https://hrm.inventiko.com/api/tasks?assigned_to=3&status=pending&priority=high&overdue=false" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json"
```

### Add Task Comment

```bash
curl -X POST https://hrm.inventiko.com/api/tasks/1/comments \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "comment": "Started working on the wireframes. Initial concepts look good, will have first draft ready by tomorrow."
  }'
```

### Update Task Status

```bash
curl -X PUT https://hrm.inventiko.com/api/tasks/1 \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "status": "in_progress",
    "priority": "critical"
  }'
```

## Client Management Examples

### Create a New Client

```bash
curl -X POST https://hrm.inventiko.com/api/clients \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "client_name": "Sarah Johnson",
    "company_name": "InnovateTech Solutions",
    "email": "sarah@innovatetech.com",
    "mobile": "+1-555-0456",
    "description": "Fast-growing startup focused on AI and machine learning solutions"
  }'
```

### Get All Clients

```bash
curl -X GET https://hrm.inventiko.com/api/clients \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json"
```

### Update Client Information

```bash
curl -X PUT https://hrm.inventiko.com/api/clients/1 \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "company_name": "InnovateTech Solutions Inc.",
    "description": "Fast-growing startup focused on AI and machine learning solutions. Recently raised Series A funding."
  }'
```

## Attendance Management Examples

### Clock In

```bash
curl -X POST https://hrm.inventiko.com/api/attendance/clock-in \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "location": "Main Office",
    "notes": "Starting work day"
  }'
```

### Clock Out

```bash
curl -X POST https://hrm.inventiko.com/api/attendance/clock-out \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "notes": "Ending work day"
  }'
```

### Get Today's Attendance

```bash
curl -X GET https://hrm.inventiko.com/api/attendance/today \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json"
```

### Get Attendance History

```bash
curl -X GET "https://hrm.inventiko.com/api/attendance/history?date_from=2024-01-01&date_to=2024-01-31" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json"
```

## Leave Management Examples

### Create Leave Request

```bash
curl -X POST https://hrm.inventiko.com/api/leave-requests \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "type": "sick_leave",
    "start_date": "2024-02-15",
    "end_date": "2024-02-16",
    "reason": "Medical appointment and recovery"
  }'
```

### Get Leave Requests

```bash
curl -X GET https://hrm.inventiko.com/api/leave-requests \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json"
```

### Approve Leave Request

```bash
curl -X POST https://hrm.inventiko.com/api/leave-requests/1/status \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "status": "approved",
    "notes": "Approved for medical reasons"
  }'
```

## Settings Management Examples

### Get Application Settings

```bash
curl -X GET https://hrm.inventiko.com/api/settings \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json"
```

### Update Settings

```bash
curl -X POST https://hrm.inventiko.com/api/settings \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "app_name": "ProjectFlow Pro",
    "theme_color": "#8B5CF6",
    "late_clock_in_time": "10:00",
    "auto_clock_out_time": "22:00"
  }'
```

### Get Enum Values

```bash
curl -X GET https://hrm.inventiko.com/api/settings/enums/task_priority \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json"
```

### Get Enum Colors

```bash
curl -X GET https://hrm.inventiko.com/api/settings/colors/task_priority \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json"
```

## JavaScript Examples

### Complete Lead Management Workflow

```javascript
class ProjectFlowAPI {
    constructor(baseURL, token) {
        this.baseURL = baseURL;
        this.token = token;
    }

    async request(endpoint, options = {}) {
        const url = `${this.baseURL}${endpoint}`;
        const config = {
            headers: {
                'Authorization': `Bearer ${this.token}`,
                'Content-Type': 'application/json',
                ...options.headers
            },
            ...options
        };

        try {
            const response = await fetch(url, config);
            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'API request failed');
            }
            
            return data;
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    }

    // Lead Management
    async createLead(leadData) {
        return this.request('/leads', {
            method: 'POST',
            body: JSON.stringify(leadData)
        });
    }

    async getLeads(filters = {}) {
        const params = new URLSearchParams(filters);
        return this.request(`/leads?${params}`);
    }

    async getLead(id) {
        return this.request(`/leads/${id}`);
    }

    async updateLeadStatus(id, status, description) {
        return this.request(`/leads/${id}/status`, {
            method: 'POST',
            body: JSON.stringify({ status, description })
        });
    }

    async addLeadRemark(id, remark) {
        return this.request(`/leads/${id}/remarks`, {
            method: 'POST',
            body: JSON.stringify({ remark })
        });
    }

    async convertLeadToClient(id, companyName, description) {
        return this.request(`/leads/${id}/convert-to-client`, {
            method: 'POST',
            body: JSON.stringify({ company_name: companyName, description })
        });
    }

    // Task Management
    async createTask(taskData) {
        return this.request('/tasks', {
            method: 'POST',
            body: JSON.stringify(taskData)
        });
    }

    async getTasks(filters = {}) {
        const params = new URLSearchParams(filters);
        return this.request(`/tasks?${params}`);
    }

    async addTaskComment(id, comment) {
        return this.request(`/tasks/${id}/comments`, {
            method: 'POST',
            body: JSON.stringify({ comment })
        });
    }

    // Attendance Management
    async clockIn(location, notes) {
        return this.request('/attendance/clock-in', {
            method: 'POST',
            body: JSON.stringify({ location, notes })
        });
    }

    async clockOut(notes) {
        return this.request('/attendance/clock-out', {
            method: 'POST',
            body: JSON.stringify({ notes })
        });
    }

    async getTodayAttendance() {
        return this.request('/attendance/today');
    }
}

// Usage Example
const api = new ProjectFlowAPI('https://hrm.inventiko.com/api', 'your-token-here');

// Complete lead management workflow
async function manageLead() {
    try {
        // 1. Create a new lead
        const newLead = await api.createLead({
            name: 'Alice Johnson',
            email: 'alice@example.com',
            mobile: '+1-555-0789',
            product_type: 'Mobile App Development',
            budget: '$20,000 - $30,000',
            start: 'Q2 2024'
        });

        console.log('Lead created:', newLead.data);

        // 2. Add a remark
        await api.addLeadRemark(newLead.data.id, 'Initial contact made via website form');

        // 3. Update status
        await api.updateLeadStatus(newLead.data.id, 'in_progress', 'Qualifying requirements');

        // 4. Convert to client
        const client = await api.convertLeadToClient(
            newLead.data.id,
            'Alice Tech Solutions',
            'Growing tech startup'
        );

        console.log('Lead converted to client:', client.data);

    } catch (error) {
        console.error('Error managing lead:', error);
    }
}

// Task management workflow
async function manageTasks() {
    try {
        // Create a task
        const task = await api.createTask({
            title: 'API Integration',
            description: 'Integrate third-party payment API',
            project_id: 1,
            assigned_to: 2,
            priority: 'high',
            status: 'pending',
            start_date: '2024-02-01',
            end_date: '2024-02-10'
        });

        console.log('Task created:', task.data);

        // Add comment
        await api.addTaskComment(task.data.id, 'Starting API research and documentation review');

    } catch (error) {
        console.error('Error managing tasks:', error);
    }
}

// Run examples
manageLead();
manageTasks();
```

## Python Examples

```python
import requests
import json
from datetime import datetime

class ProjectFlowAPI:
    def __init__(self, base_url, token):
        self.base_url = base_url
        self.token = token
        self.headers = {
            'Authorization': f'Bearer {token}',
            'Content-Type': 'application/json'
        }

    def request(self, method, endpoint, data=None, params=None):
        url = f"{self.base_url}{endpoint}"
        
        try:
            response = requests.request(
                method=method,
                url=url,
                headers=self.headers,
                json=data,
                params=params
            )
            response.raise_for_status()
            return response.json()
        except requests.exceptions.RequestException as e:
            print(f"API Error: {e}")
            raise

    # Lead Management
    def create_lead(self, lead_data):
        return self.request('POST', '/leads', data=lead_data)

    def get_leads(self, filters=None):
        return self.request('GET', '/leads', params=filters)

    def get_lead(self, lead_id):
        return self.request('GET', f'/leads/{lead_id}')

    def update_lead_status(self, lead_id, status, description):
        return self.request('POST', f'/leads/{lead_id}/status', 
                           data={'status': status, 'description': description})

    def add_lead_remark(self, lead_id, remark):
        return self.request('POST', f'/leads/{lead_id}/remarks', 
                           data={'remark': remark})

    def convert_lead_to_client(self, lead_id, company_name, description):
        return self.request('POST', f'/leads/{lead_id}/convert-to-client',
                           data={'company_name': company_name, 'description': description})

    # Task Management
    def create_task(self, task_data):
        return self.request('POST', '/tasks', data=task_data)

    def get_tasks(self, filters=None):
        return self.request('GET', '/tasks', params=filters)

    def add_task_comment(self, task_id, comment):
        return self.request('POST', f'/tasks/{task_id}/comments', 
                           data={'comment': comment})

    # Attendance Management
    def clock_in(self, location, notes):
        return self.request('POST', '/attendance/clock-in',
                           data={'location': location, 'notes': notes})

    def clock_out(self, notes):
        return self.request('POST', '/attendance/clock-out',
                           data={'notes': notes})

    def get_today_attendance(self):
        return self.request('GET', '/attendance/today')

# Usage Example
api = ProjectFlowAPI('https://hrm.inventiko.com/api', 'your-token-here')

# Create and manage a lead
lead_data = {
    'name': 'Bob Wilson',
    'email': 'bob@example.com',
    'mobile': '+1-555-0321',
    'product_type': 'E-commerce Platform',
    'budget': '$50,000 - $75,000',
    'start': 'Q3 2024'
}

try:
    # Create lead
    lead = api.create_lead(lead_data)
    print(f"Lead created: {lead['data']['name']}")

    # Add remark
    api.add_lead_remark(lead['data']['id'], 'Contacted via referral from existing client')

    # Update status
    api.update_lead_status(lead['data']['id'], 'in_progress', 'Scheduling discovery call')

    # Convert to client
    client = api.convert_lead_to_client(
        lead['data']['id'],
        'Wilson Enterprises',
        'Established retail company expanding online'
    )
    print(f"Converted to client: {client['data']['company_name']}")

except Exception as e:
    print(f"Error: {e}")
```

## Error Handling Examples

### Handling Validation Errors

```javascript
async function createLeadWithErrorHandling(leadData) {
    try {
        const response = await api.createLead(leadData);
        return response;
    } catch (error) {
        if (error.response && error.response.status === 422) {
            // Validation errors
            const errors = error.response.data.errors;
            console.log('Validation errors:', errors);
            
            // Handle specific field errors
            if (errors.email) {
                console.log('Email error:', errors.email[0]);
            }
            if (errors.name) {
                console.log('Name error:', errors.name[0]);
            }
        } else if (error.response && error.response.status === 401) {
            console.log('Authentication error: Please check your token');
        } else if (error.response && error.response.status === 403) {
            console.log('Permission error: You do not have permission to perform this action');
        } else {
            console.log('Unexpected error:', error.message);
        }
        throw error;
    }
}
```

### Retry Logic for Failed Requests

```javascript
async function apiRequestWithRetry(endpoint, options, maxRetries = 3) {
    for (let attempt = 1; attempt <= maxRetries; attempt++) {
        try {
            return await api.request(endpoint, options);
        } catch (error) {
            if (attempt === maxRetries) {
                throw error;
            }
            
            // Wait before retry (exponential backoff)
            const delay = Math.pow(2, attempt) * 1000;
            console.log(`Attempt ${attempt} failed, retrying in ${delay}ms...`);
            await new Promise(resolve => setTimeout(resolve, delay));
        }
    }
}
```

## Rate Limiting Examples

### Handling Rate Limits

```javascript
class RateLimitedAPI extends ProjectFlowAPI {
    constructor(baseURL, token) {
        super(baseURL, token);
        this.rateLimitInfo = {
            limit: 1000,
            remaining: 1000,
            reset: null
        };
    }

    async request(endpoint, options = {}) {
        // Check rate limit before making request
        if (this.rateLimitInfo.remaining <= 0) {
            const waitTime = this.rateLimitInfo.reset - Date.now();
            console.log(`Rate limit exceeded. Waiting ${waitTime}ms...`);
            await new Promise(resolve => setTimeout(resolve, waitTime));
        }

        const response = await super.request(endpoint, options);
        
        // Update rate limit info from response headers
        if (response.headers) {
            this.rateLimitInfo.limit = parseInt(response.headers['x-ratelimit-limit']) || 1000;
            this.rateLimitInfo.remaining = parseInt(response.headers['x-ratelimit-remaining']) || 0;
            this.rateLimitInfo.reset = parseInt(response.headers['x-ratelimit-reset']) * 1000 || Date.now() + 3600000;
        }

        return response;
    }
}
```

This comprehensive API documentation and examples should help developers integrate with your ProjectFlow CRM system effectively!
