<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'Admin', 'slug' => 'admin']);
        Role::create(['name' => 'Customer', 'slug' => 'customer']);
        Role::create(['name' => 'Vendor', 'slug' => 'vendor']);
        Role::create(['name' => 'Guest', 'slug' => 'guest']);
        Role::create(['name' => 'Super Admin', 'slug' => 'super-admin']);
        Role::create(['name' => 'Support', 'slug' => 'support']);
        Role::create(['name' => 'Manager', 'slug' => 'manager']);
        Role::create(['name' => 'Editor', 'slug' => 'editor']);
        Role::create(['name' => 'Subscriber', 'slug' => 'subscriber']);
        Role::create(['name' => 'Moderator', 'slug' => 'moderator']);
        Role::create(['name' => 'Contributor', 'slug' => 'contributor']);
        Role::create(['name' => 'Analyst', 'slug' => 'analyst']);
        Role::create(['name' => 'Developer', 'slug' => 'developer']);
        Role::create(['name' => 'Designer', 'slug' => 'designer']);
        Role::create(['name' => 'Tester', 'slug' => 'tester']);
        Role::create(['name' => 'Sales', 'slug' => 'sales']);
        Role::create(['name' => 'Marketing', 'slug' => 'marketing']);
        Role::create(['name' => 'HR', 'slug' => 'hr']);
        Role::create(['name' => 'Finance', 'slug' => 'finance']);
        Role::create(['name' => 'Legal', 'slug' => 'legal']);
        Role::create(['name' => 'Operations', 'slug' => 'operations']);
        Role::create(['name' => 'Support Staff', 'slug' => 'support-staff']);
        Role::create(['name' => 'Content Creator', 'slug' => 'content-creator']);
        Role::create(['name' => 'Community Manager', 'slug' => 'community-manager']);
        Role::create(['name' => 'Product Manager', 'slug' => 'product-manager']);
        Role::create(['name' => 'Project Manager', 'slug' => 'project-manager']);
        Role::create(['name' => 'System Administrator', 'slug' => 'system-administrator']);
        Role::create(['name' => 'Network Administrator', 'slug' => 'network-administrator']);
        Role::create(['name' => 'Database Administrator', 'slug' => 'database-administrator']);
        Role::create(['name' => 'Security Analyst', 'slug' => 'security-analyst']);
        Role::create(['name' => 'Data Scientist', 'slug' => 'data-scientist']);
        Role::create(['name' => 'Business Analyst', 'slug' => 'business-analyst']);
        Role::create(['name' => 'Quality Assurance', 'slug' => 'quality-assurance']);
        Role::create(['name' => 'Customer Support', 'slug' => 'customer-support']);
        Role::create(['name' => 'Content Manager', 'slug' => 'content-manager']);
        Role::create(['name' => 'Social Media Manager', 'slug' => 'social-media-manager']);
        Role::create(['name' => 'Training Specialist', 'slug' => 'training-specialist']);
        Role::create(['name' => 'Compliance Officer', 'slug' => 'compliance-officer']);
        Role::create(['name' => 'Research Scientist', 'slug' => 'research-scientist']);
        Role::create(['name' => 'IT Support', 'slug' => 'it-support']);
        Role::create(['name' => 'Business Development', 'slug' => 'business-development']);
    }
}
