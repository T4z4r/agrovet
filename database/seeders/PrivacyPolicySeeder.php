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
        // Ensure only one active privacy policy
        PrivacyPolicy::where('is_active', true)->update(['is_active' => false]);

        PrivacyPolicy::create([
            'title' => 'Privacy Policy',
            'content' => '<h1>Privacy Policy</h1>

<p><strong>Last updated: January 11, 2026</strong></p>

<p>This Privacy Policy describes how Apex ("we", "us", or "our") collects, uses, and protects your information when you use our mobile application (the "App").</p>

<h2>Information We Collect</h2>

<h3>Personal Information</h3>
<ul>
<li><strong>Account Information</strong>: Email address, name, and password when you register or log in</li>
<li><strong>User Profile</strong>: Role information (owner or seller) and account preferences</li>
</ul>

<h3>Business Data</h3>
<ul>
<li><strong>Product Information</strong>: Product names, categories, pricing, stock levels, and barcodes</li>
<li><strong>Sales Data</strong>: Transaction details, customer information, and sales records</li>
<li><strong>Inventory Data</strong>: Stock transactions, supplier information, and inventory movements</li>
<li><strong>Financial Data</strong>: Expense records and financial reporting data</li>
</ul>

<h3>Technical Information</h3>
<ul>
<li><strong>Device Information</strong>: Device type, operating system, and app version</li>
<li><strong>Usage Data</strong>: App usage patterns and feature interactions</li>
<li><strong>Authentication Tokens</strong>: Secure tokens stored locally for session management</li>
</ul>

<h3>Permissions</h3>
<ul>
<li><strong>Camera Access</strong>: Used for barcode scanning functionality (optional feature)</li>
</ul>

<h2>How We Use Your Information</h2>

<h3>To Provide Our Services</h3>
<ul>
<li>Authenticate users and maintain secure access to accounts</li>
<li>Process and store business transactions and data</li>
<li>Generate reports and analytics for business management</li>
<li>Enable barcode scanning for product identification</li>
</ul>

<h3>To Improve Our Services</h3>
<ul>
<li>Analyze usage patterns to improve app functionality</li>
<li>Troubleshoot technical issues and provide customer support</li>
<li>Develop new features based on user needs</li>
</ul>

<h3>Legal and Security Purposes</h3>
<ul>
<li>Ensure compliance with applicable laws and regulations</li>
<li>Protect against fraud and unauthorized access</li>
<li>Maintain data security and integrity</li>
</ul>

<h2>Data Storage and Security</h2>

<h3>Local Storage</h3>
<ul>
<li>Authentication tokens and basic user preferences are stored locally on your device using secure storage mechanisms</li>
<li>No sensitive business data is permanently stored on your device</li>
</ul>

<h3>Server Storage</h3>
<ul>
<li>All business data is stored on our secure servers</li>
<li>Data is encrypted in transit and at rest</li>
<li>Regular security audits and updates are performed</li>
</ul>

<h3>Data Retention</h3>
<ul>
<li>Account data is retained as long as your account is active</li>
<li>Business data is retained based on your business needs and legal requirements</li>
<li>You can request data deletion at any time</li>
</ul>

<h2>Data Sharing and Disclosure</h2>

<p>We do not sell, trade, or rent your personal information to third parties. We may share your information only in the following circumstances:</p>

<ul>
<li><strong>With Your Consent</strong>: When you explicitly agree to share data</li>
<li><strong>Service Providers</strong>: With trusted third-party service providers who assist in operating our app (under strict confidentiality agreements)</li>
<li><strong>Legal Requirements</strong>: When required by law or to protect our rights and safety</li>
<li><strong>Business Transfers</strong>: In connection with a merger, acquisition, or sale of assets</li>
</ul>

<h2>Your Rights</h2>

<p>You have the following rights regarding your data:</p>

<ul>
<li><strong>Access</strong>: Request a copy of the personal information we hold about you</li>
<li><strong>Correction</strong>: Request correction of inaccurate or incomplete data</li>
<li><strong>Deletion</strong>: Request deletion of your personal information</li>
<li><strong>Portability</strong>: Request transfer of your data in a structured format</li>
<li><strong>Restriction</strong>: Request limitation of processing in certain circumstances</li>
</ul>

<h2>Children\'s Privacy</h2>

<p>Our app is not intended for children under 13 years of age. We do not knowingly collect personal information from children under 13.</p>

<h2>International Data Transfers</h2>

<p>Your data may be transferred to and processed in countries other than your own. We ensure appropriate safeguards are in place to protect your data during such transfers.</p>

<h2>Changes to This Privacy Policy</h2>

<p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy in the app and updating the "Last updated" date.</p>

<h2>Contact Us</h2>

<p>If you have any questions about this Privacy Policy or our data practices, please contact us:</p>

<ul>
<li><strong>Email</strong>: tazarchriss@gmail.com</li>
<li><strong>App Support</strong>: Through the app\'s support features</li>
</ul>

<p>By using Apex, you agree to the collection and use of information in accordance with this Privacy Policy.</p>',
            'is_active' => true,
        ]);
    }
}
