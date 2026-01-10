<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PrivacyPolicy;

class PrivacyPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PrivacyPolicy::create([
            'title' => 'Privacy Policy',
            'content' => '<h2>Introduction</h2>
<p>This Privacy Policy describes how AgroVet ("we," "us," or "our") collects, uses, and protects your personal information when you use our veterinary management system.</p>

<h2>Information We Collect</h2>
<p>We collect information you provide directly to us, such as:</p>
<ul>
<li>Name and contact information</li>
<li>Business information</li>
<li>Payment information</li>
<li>Usage data and analytics</li>
</ul>

<h2>How We Use Your Information</h2>
<p>We use the collected information to:</p>
<ul>
<li>Provide and maintain our services</li>
<li>Process transactions</li>
<li>Send administrative information</li>
<li>Improve our services</li>
<li>Comply with legal obligations</li>
</ul>

<h2>Information Sharing</h2>
<p>We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except as described in this policy.</p>

<h2>Data Security</h2>
<p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>

<h2>Your Rights</h2>
<p>You have the right to:</p>
<ul>
<li>Access your personal information</li>
<li>Correct inaccurate information</li>
<li>Request deletion of your information</li>
<li>Object to processing</li>
<li>Data portability</li>
</ul>

<h2>Contact Us</h2>
<p>If you have any questions about this Privacy Policy, please contact us at privacy@agrovet.com.</p>

<h2>Changes to This Policy</h2>
<p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new policy on this page.</p>',
            'is_active' => true,
        ]);
    }
}
