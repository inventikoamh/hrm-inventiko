<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // General Settings
        // Setting::set('app_name', 'ProjectFlow', 'string', 'general', 'Application Name', 'The display name of the application');
        
        // Branding Settings
        // Setting::set('logo', null, 'file', 'branding', 'Logo', 'Application logo');
        // Setting::set('favicon', null, 'file', 'branding', 'Favicon', 'Application favicon');
        // Setting::set('login_background', null, 'file', 'branding', 'Login Background', 'Background image for login page');
        
        // Theme Settings
        Setting::set('theme_color', '#3B82F6', 'string', 'theme', 'Theme Color', 'Primary color for the application theme');
        
        // Attendance Settings
        Setting::set('late_clock_in_time', '11:30', 'string', 'attendance', 'Late Clock In Time', 'Time after which clock in is considered late (24-hour format)');
        Setting::set('auto_clock_out_time', '23:59', 'string', 'attendance', 'Auto Clock Out Time', 'Time when users are automatically clocked out if not manually clocked out (24-hour format)');
        
        // Enum Settings
        Setting::setEnumValues('task_priority', ['Low', 'Medium', 'High', 'Critical']);
        Setting::setEnumValues('task_status', ['Pending', 'In Progress', 'Completed', 'On Hold', 'Cancelled']);
        Setting::setEnumValues('project_status', ['Planning', 'Active', 'On Hold', 'Completed', 'Cancelled']);
        Setting::setEnumValues('client_status', ['Active', 'Inactive', 'Suspended']);
        Setting::setEnumValues('leave_type', ['Sick Leave', 'Casual Leave', 'Festival Leave', 'Privilege Leave', 'Emergency Leave']);
        Setting::setEnumValues('attendance_status', ['Present', 'Absent', 'Late', 'Half Day', 'On Leave']);
        
        // Enum Color Settings
        Setting::set('task_priority_colors', [
            'Low' => '#22C55E',      // Light Green
            'Medium' => '#F59E0B',   // Amber
            'High' => '#F97316',     // Orange
            'Critical' => '#DC2626'  // Red
        ], 'json', 'theme', 'Task Priority Colors', 'Color mapping for task priority labels');
        
        Setting::set('task_status_colors', [
            'Pending' => '#6B7280',     // Gray
            'In Progress' => '#3B82F6', // Blue
            'Completed' => '#22C55E',   // Green
            'On Hold' => '#F59E0B',     // Amber
            'Cancelled' => '#DC2626'    // Red
        ], 'json', 'theme', 'Task Status Colors', 'Color mapping for task status labels');
        
        Setting::set('project_status_colors', [
            'Planning' => '#8B5CF6',    // Purple
            'Active' => '#3B82F6',      // Blue
            'On Hold' => '#F59E0B',     // Amber
            'Completed' => '#22C55E',   // Green
            'Cancelled' => '#DC2626'    // Red
        ], 'json', 'theme', 'Project Status Colors', 'Color mapping for project status labels');
        
        Setting::set('client_status_colors', [
            'Active' => '#22C55E',      // Light Green
            'Inactive' => '#6B7280',    // Gray
            'Suspended' => '#DC2626'    // Red
        ], 'json', 'theme', 'Client Status Colors', 'Color mapping for client status labels');
        
        Setting::set('leave_type_colors', [
            'Sick Leave' => '#DC2626',      // Red
            'Casual Leave' => '#3B82F6',    // Blue
            'Festival Leave' => '#8B5CF6',  // Purple
            'Privilege Leave' => '#22C55E', // Light Green
            'Emergency Leave' => '#F59E0B'  // Amber
        ], 'json', 'theme', 'Leave Type Colors', 'Color mapping for leave type labels');
        
        Setting::set('attendance_status_colors', [
            'Present' => '#22C55E',     // Light Green
            'Absent' => '#DC2626',      // Red
            'Late' => '#F59E0B',        // Amber
            'Half Day' => '#8B5CF6',    // Purple
            'On Leave' => '#3B82F6'     // Blue
        ], 'json', 'theme', 'Attendance Status Colors', 'Color mapping for attendance status labels');
    }
}