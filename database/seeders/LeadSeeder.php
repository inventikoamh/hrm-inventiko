<?php

namespace Database\Seeders;

use App\Models\Lead;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    public function run(): void
    {
        $leads = [
            [
                'name' => 'John Smith',
                'mobile' => '+1-555-0123',
                'email' => 'john.smith@techcorp.com',
                'product_type' => '3D Product Visualization',
                'budget' => '$5,000 - $10,000',
                'start' => 'Q1 2024',
            ],
            [
                'name' => 'Sarah Johnson',
                'mobile' => '+1-555-0124',
                'email' => 'sarah.j@architectural.com',
                'product_type' => 'Architectural Rendering',
                'budget' => '$15,000 - $25,000',
                'start' => 'Q2 2024',
            ],
            [
                'name' => 'Michael Chen',
                'mobile' => '+1-555-0125',
                'email' => 'm.chen@automotive.com',
                'product_type' => 'Car Animation',
                'budget' => '$20,000 - $35,000',
                'start' => 'Immediate',
            ],
            [
                'name' => 'Emily Rodriguez',
                'mobile' => '+1-555-0126',
                'email' => 'emily.r@fashion.com',
                'product_type' => 'Fashion Product Shots',
                'budget' => '$3,000 - $7,000',
                'start' => 'Q3 2024',
            ],
            [
                'name' => 'David Wilson',
                'mobile' => '+1-555-0127',
                'email' => 'd.wilson@medical.com',
                'product_type' => 'Medical Device Animation',
                'budget' => '$12,000 - $18,000',
                'start' => 'Q1 2024',
            ],
            [
                'name' => 'Lisa Anderson',
                'mobile' => '+1-555-0128',
                'email' => 'lisa.a@realestate.com',
                'product_type' => 'Property Virtual Tour',
                'budget' => '$8,000 - $15,000',
                'start' => 'Q2 2024',
            ],
            [
                'name' => 'Robert Brown',
                'mobile' => '+1-555-0129',
                'email' => 'robert.b@electronics.com',
                'product_type' => 'Electronics Product Demo',
                'budget' => '$6,000 - $12,000',
                'start' => 'Q4 2024',
            ],
            [
                'name' => 'Jennifer Davis',
                'mobile' => '+1-555-0130',
                'email' => 'j.davis@furniture.com',
                'product_type' => 'Furniture 3D Modeling',
                'budget' => '$4,000 - $8,000',
                'start' => 'Q3 2024',
            ],
            [
                'name' => 'Christopher Lee',
                'mobile' => '+1-555-0131',
                'email' => 'chris.l@jewelry.com',
                'product_type' => 'Jewelry Visualization',
                'budget' => '$2,500 - $5,000',
                'start' => 'Q2 2024',
            ],
            [
                'name' => 'Amanda Taylor',
                'mobile' => '+1-555-0132',
                'email' => 'amanda.t@food.com',
                'product_type' => 'Food Product Photography',
                'budget' => '$1,500 - $3,500',
                'start' => 'Q1 2024',
            ],
        ];

        foreach ($leads as $leadData) {
            Lead::create($leadData);
        }
    }
}