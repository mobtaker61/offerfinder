<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => '<h2><strong>OfferFinder – A Smarter Way to Discover the Best Deals in the UAE!</strong></h2><p>In today\'s fast-moving world, with countless products and services around, finding the best deals can sometimes be overwhelming.<br>  That\'s where <strong>OfferFinder</strong> comes in — to make the process simpler, faster, and smarter.</p><p>OfferFinder is a comprehensive and constantly updated platform that gathers the latest promotions, special offers, and discounts from trusted brands, supermarkets, chain stores, and even local businesses across the UAE.<br>  Users can select their area or use their current location to explore all offers nearby — so they never miss a great deal again.</p><p>Whether you\'re looking for discounts at your local grocery store or seasonal deals from major brands, OfferFinder is always there for you.</p><p><strong>What\'s our mission?</strong><br>  We aim to bridge the gap between businesses and consumers — helping brands get discovered and empowering customers to make smarter, more economical choices.</p><p>            </p><p><strong>With OfferFinder, every purchase becomes a smart decision.</strong><br>  Join the OfferFinder community and be the first to catch the hottest deals around you!</p>',
                'meta_title' => 'About Us - Offer Finder',
                'meta_description' => 'Navigate through our website structure with our sitemap.',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'title' => 'Offer Submission',
                'slug' => 'offer-submission',
                'content' => '<h2><strong>Last updated: March 2025</strong></h2><p>Thank you for choosing to publish your offer on OfferFinder!<br>  To ensure the quality and credibility of our platform, please follow these important rules when submitting your offers:</p><hr><h3>1. Accuracy of Information</h3><p>All details in the submitted offer (title, description, price, discount rate, start/end date, etc.) must be accurate, truthful, and verifiable. False information may result in offer removal or account suspension.</p><h3>2. Clarity and Transparency</h3><p>Offers must be clearly described and should include any special terms and conditions (such as minimum purchase, product limitations, duration, etc.).</p><h3>3. No Misleading Advertising</h3><p>Offers that include vague terms, fake pricing, or unrealistic claims are strictly prohibited. Such offers will be removed without notice.</p><h3>4. Prohibited Items</h3><p>Offers related to restricted or regulated goods in the UAE (e.g., tobacco, pharmaceuticals, crypto assets, gambling, etc.) must be accompanied by proper legal authorization.</p><h3>5. Compliance with Local Laws</h3><p>All offers must comply with the laws and regulations of the United Arab Emirates. The business owner is solely responsible for any legal implications.</p><h3>6. Media & Visuals</h3><p>If using images, videos, or banners, the content must be of good quality, non-offensive, and directly relevant to the offer.</p><h3>7. Offer Duration</h3><p>Offers must have a clear and reasonable validity period. Expired offers will be automatically removed from the platform.</p><h3>8. Customer Responsibility</h3><p>The business must respond to customer inquiries related to the offer and fulfill the deal as described.</p><hr><h3>📌 Policy Violations</h3><p>Any breach of these rules may result in immediate removal of the offer. Repeated violations may lead to permanent account suspension.</p><h3>📞 Contact Support</h3><p>If you have questions or need help with the offer submission process, please contact our support team:</p><p>                                                </p><p>📧 Email: <a>support@offerfinder.ae</a><br>  📞 Phone: +971562858133</p>',
                'meta_title' => 'Offer Submission - Offer Finder',
                'meta_description' => 'Learn how to collaborate with us and become a partner.',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'title' => 'FAQs',
                'slug' => 'faqs',
                'content' => '<section class="faq">
    <h2>📌 <strong>[❓] What is OfferFinder?</strong></h2>
    <p><strong>OfferFinder</strong> is an online platform that helps you discover the latest deals, discounts, and promotions from stores, brands, and local businesses across the UAE.<br>  By selecting your location, you can browse all nearby offers instantly.</p>
    <hr>
    <h3>💸 <strong>[🆓] Is OfferFinder free to use?</strong></h3>
    <p>Yes! Browsing and viewing offers is completely free for all users.<br>  You don\'t even need to register to start exploring deals.</p>
    <hr>
    <h3>📍 <strong>[📡] How can I find offers near me?</strong></h3>
    <p>Simply allow location access or manually choose your preferred area.<br>  We\'ll show you the most relevant deals around you based on your location.</p>
    <hr>
    <h3>✅ <strong>[🔍] Are the offers real and valid?</strong></h3>
    <p>All offers are submitted by real businesses and reviewed before being published.<br>  However, the business is fully responsible for the accuracy and availability of the offer.</p>
    <hr>
    <h3>🛒 <strong>[🏬] Does OfferFinder sell products directly?</strong></h3>
    <p>No. OfferFinder is not a store. We do not sell or deliver any products directly.<br>  We only help you discover active promotions by third-party businesses.</p>
    <hr>
    <h3>🧾 <strong>[📝] How can I submit an offer as a business?</strong></h3>
    <p>If you own a business, simply register via our business panel and submit your offer.<br>  Our team will review and publish it after a quick verification process.</p>
    <hr>
    <h3>📊 <strong>[💼] Is it free to list an offer as a business?</strong></h3>
    <p>We offer both <strong>free</strong> and <strong>premium</strong> plans for businesses.<br>  Check our "Submit an Offer" page or contact us for full pricing and features.</p>
    <hr>
    <h3>🔔 <strong>[📲] How can I stay updated with new offers?</strong></h3>
    <p>You can subscribe to our newsletter or enable app notifications<br>  to receive the latest deals near your area instantly.</p>
    <hr>
    <h3>💖 <strong>[⭐] Can I save favorite offers?</strong></h3>
    <p>Yes! If you\'re a registered user, you can mark offers as "Favorites"<br>  and revisit them anytime from your profile.</p>
    <hr>
    <h3>📞 <strong>[👥] How do I contact OfferFinder support?</strong></h3>
    <p>For any questions or help, feel free to reach out to us:</p>
    <p>📧 Email: <a>support@offerfinder.ae</a><br>  📞 Phone: +971562858133</p>
</section>',
                'meta_title' => 'FAQs - Offer Finder',
                'meta_description' => 'Find answers to frequently asked questions about our services.',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<h2><strong>Last updated: March 2025</strong></h2>
<p>At OfferFinder, your privacy and data security are extremely important to us. This Privacy Policy explains what information we collect, how we use it, and the measures we take to keep your data safe.</p>
<h3>1. Information We Collect:</h3>
<p>We may collect and store the following data:</p>
<ul>
    <li><p>Location data (via GPS or manual area selection)</p></li>
    <li><p>Device and technical information (device type, OS version, IP, browser)</p></li>
    <li><p>Account details (if you register: name, email, phone number)</p></li>
    <li><p>Usage data (clicks, searches, favorites)</p></li>
</ul>
<h3>2. How We Use Your Information:</h3>
<p>We use the collected information to:</p>
<ul>
    <li><p>Display relevant offers based on your location</p></li>
    <li><p>Improve user experience and provide personalized recommendations</p></li>
    <li><p>Notify you about new offers or service updates</p></li>
    <li><p>Analyze usage data to optimize our platform</p></li>
</ul>
<h3>3. Information Sharing:</h3>
<p>We do not share your personal data with third parties without your explicit consent, except:</p>
<ul>
    <li><p>When legally required by governmental authorities</p></li>
    <li><p>To trusted service providers under confidentiality agreements</p></li>
</ul>
<h3>4. Cookies:</h3>
<p>We may use cookies or similar technologies to enhance your experience. You can manage or disable cookies via your browser settings.</p>
<h3>5. Data Security:</h3>
<p>We apply industry-standard security measures to protect your data and prevent unauthorized access, leaks, or misuse.</p>
<h3>6. User Rights:</h3>
<p>You have the right to access, modify, or request deletion of your data. Please contact our support team to submit such requests.</p>
<h3>7. Changes to This Policy:</h3>
<p>This Privacy Policy may be updated occasionally. Any changes will be posted via our app or website.</p>
<h3>8. Contact Us:</h3>
<p>If you have any questions or concerns about this Privacy Policy, feel free to contact us:</p>
<p>📧 Email: <a>support@offerfinder.ae</a><br>📞 Phone: +971 56 285 8133</p>',
                'meta_title' => 'Privacy Policy - Offer Finder',
                'meta_description' => 'Our privacy policy explains how we collect, use, and protect your personal information.',
                'sort_order' => 4,
                'is_active' => true
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms-conditions',
                'content' => '<h2><strong>Last Updated: March 2025</strong></h2>
<p>By accessing or using the OfferFinder platform (via mobile app or website), you agree to the following terms and conditions. Please read them carefully.</p>
<h3>1. Acceptance of Terms</h3>
<p>Your use of OfferFinder constitutes your acceptance of these terms. If you do not agree, please refrain from using the platform.</p>
<h3>2. Our Services</h3>
<p>OfferFinder is an informational platform showcasing deals, discounts, and promotional offers by businesses across the UAE. We do not guarantee the accuracy, availability, or redemption of any offer displayed.</p>
<h3>3. User Accounts</h3>
<p>If you register for an account, you agree to provide accurate and updated information and are responsible for maintaining the confidentiality of your login credentials.</p>
<h3>4. Proper Use</h3>
<p>You agree to use the platform only for lawful purposes and to refrain from any behavior that may harm, disrupt, or misuse the system.</p>
<h3>5. Intellectual Property</h3>
<p>All intellectual property rights including design, logos, content, and media on the platform belong to OfferFinder. Unauthorized use is strictly prohibited.</p>
<h3>6. Modifications</h3>
<p>We reserve the right to modify or discontinue any aspect of the service at any time, with or without notice. Terms may also be updated periodically.</p>
<h3>7. Limitation of Liability</h3>
<p>OfferFinder shall not be held liable for any direct or indirect damage resulting from the use of the platform. Offers are submitted by third parties and their validity is the responsibility of the respective businesses.</p>
<h3>8. Contact Us</h3>
<p>If you have any questions or concerns, feel free to contact our support team:</p>
<p>📧 Email: <a>support@offerfinder.ae</a><br>📞 Phone: +971562858133</p>',
                'meta_title' => 'Terms & Conditions - Offer Finder',
                'meta_description' => 'Read our terms and conditions to understand your rights and responsibilities.',
                'sort_order' => 5,
                'is_active' => true
            ]
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
}
