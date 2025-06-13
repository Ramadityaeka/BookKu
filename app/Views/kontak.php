<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - BookKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .map-container {
            height: 450px;
        }
        .faq-item {
            transition: all 0.5s ease-out;
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php include(APPPATH . 'Views/template/header.php'); ?>

    <main class="container mx-auto px-4 py-12">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Contact Information</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Get in touch with us for any questions about book availability, pickup locations, or your orders. Our team is ready to help!</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-16">
            <fieldset class="bg-white p-6 rounded-lg shadow-md border-t-4 border-indigo-500 transition-all duration-300 ease-in-out hover:shadow-xl">
                <legend class="px-4 py-2 text-xl font-semibold bg-indigo-500 text-white rounded-full shadow-md flex items-center gap-3">
                    <i class="fas fa-phone-alt"></i>
                    Admin Phone
                </legend>
                <div class="pt-4">
                    <p class="text-gray-600 mb-3">For quick questions about book availability or pickup locations:</p>
                    <div class="bg-gray-100 p-3 rounded">
                        <p class="text-gray-800 font-medium">
                            <i class="fas fa-user mr-2 text-indigo-600"></i> Main Admin
                            <span class="block mt-1 text-lg"><i class="fas fa-mobile-alt mr-2"></i> +62 123 4567 8910</span>
                        </p>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Available 9 AM - 5 PM, Monday to Friday</p>
                </div>
            </fieldset>

            <fieldset class="bg-white p-6 rounded-lg shadow-md border-t-4 border-green-500 transition-all duration-300 ease-in-out hover:shadow-xl">
                <legend class="px-4 py-2 text-xl font-semibold bg-green-500 text-white rounded-full shadow-md flex items-center gap-3">
                    <i class="fas fa-map-marker-alt"></i>
                    Pickup Locations
                </legend>
                <div class="pt-4">
                    <p class="text-gray-600 mb-3">Visit us to collect your ordered books at these locations:</p>
                    <div class="space-y-2">
                        <p class="flex items-start text-gray-800">
                            <i class="fas fa-store mr-2 mt-1 text-green-600"></i> Main Store: Jl. Buku No. 123, Jakarta
                        </p>
                        <p class="flex items-start text-gray-800">
                            <i class="fas fa-store mr-2 mt-1 text-green-600"></i> Branch 2: Mall BookTown, Lantai 3, Surabaya
                        </p>
                        <p class="flex items-start text-gray-800">
                            <i class="fas fa-store mr-2 mt-1 text-green-600"></i> Branch 3: Plaza Literasi, Bandung
                        </p>
                    </div>
                    <p class="text-sm text-green-600 mt-3"><i class="fas fa-info-circle mr-1"></i> Please bring your order confirmation</p>
                </div>
            </fieldset>

            <fieldset class="bg-white p-6 rounded-lg shadow-md border-t-4 border-blue-500 transition-all duration-300 ease-in-out hover:shadow-xl">
                <legend class="px-4 py-2 text-xl font-semibold bg-blue-500 text-white rounded-full shadow-md flex items-center gap-3">
                    <i class="fas fa-envelope"></i>
                    Email Support
                </legend>
                <div class="pt-4">
                    <p class="text-gray-600 mb-3">For detailed inquiries or support:</p>
                    <div class="bg-gray-100 p-3 rounded">
                        <p class="text-gray-800 font-medium">
                            <i class="fas fa-users mr-2 text-blue-600"></i> Support Team
                            <a href="mailto:support@bookhub.com" class="block mt-1 text-lg hover:underline"><i class="fas fa-at mr-2"></i> support@bookhub.com</a>
                        </p>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Response time: within 24 hours</p>
                </div>
            </fieldset>
        </div>

        <div class="mb-16">
            <h3 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Our Main Pickup Location</h3>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <div class="map-container rounded-lg overflow-hidden">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.476722514867!2d106.82496417500356!3d-6.200805993786782!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x5371bf0fdad7e1ac!2sMonumen%20Nasional!5e0!3m2!1sen!2sid!4v1686828362835!5m2!1sen!2sid" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="mt-4 p-3 bg-indigo-50 rounded">
                    <h4 class="font-semibold text-indigo-800 mb-2">
                        <i class="fas fa-info-circle mr-2"></i> Pickup Instructions
                    </h4>
                    <ul class="list-disc pl-5 text-gray-700 space-y-1">
                        <li>Bring your order confirmation (digital or printed)</li>
                        <li>The pickup desk is located on the right side of the entrance</li>
                        <li>Opening hours: 8 AM - 8 PM daily</li>
                        <li>Parking available in the basement level</li>
                    </ul>
                </div>
            </div>
        </div>

        </main>

    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-4">
            <h3 class="text-3xl font-bold text-gray-800 mb-8 text-center">Frequently Asked Questions</h3>
            <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                <div class="faq-item bg-white p-6 rounded-lg shadow-sm opacity-0 -translate-y-2">
                    <div class="flex items-start">
                        <div class="bg-indigo-100 p-2 rounded-full mr-4 mt-1 flex-shrink-0">
                            <i class="fas fa-question text-indigo-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-lg text-gray-800 mb-2">Where can I pick up my ordered books?</h4>
                            <p class="text-gray-600">You can pick up your books at any of our three locations: Main Store in Jakarta, Branch 2 in Surabaya, or Branch 3 in Bandung. Please specify your preferred pickup location when ordering.</p>
                        </div>
                    </div>
                </div>
                <div class="faq-item bg-white p-6 rounded-lg shadow-sm opacity-0 -translate-y-2">
                    <div class="flex items-start">
                        <div class="bg-indigo-100 p-2 rounded-full mr-4 mt-1 flex-shrink-0">
                            <i class="fas fa-question text-indigo-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-lg text-gray-800 mb-2">What do I need to bring for pickup?</h4>
                            <p class="text-gray-600">Please bring your order confirmation number and a valid ID. For someone else to pick up, they'll need a written authorization from you.</p>
                        </div>
                    </div>
                </div>
                <div class="faq-item bg-white p-6 rounded-lg shadow-sm opacity-0 -translate-y-2">
                    <div class="flex items-start">
                        <div class="bg-indigo-100 p-2 rounded-full mr-4 mt-1 flex-shrink-0">
                            <i class="fas fa-question text-indigo-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-lg text-gray-800 mb-2">How long do you hold books for pickup?</h4>
                            <p class="text-gray-600">We hold books for 7 days from the date of order confirmation. If you need more time, please contact our admin to make arrangements.</p>
                        </div>
                    </div>
                </div>
                <div class="faq-item bg-white p-6 rounded-lg shadow-sm opacity-0 -translate-y-2">
                    <div class="flex items-start">
                        <div class="bg-indigo-100 p-2 rounded-full mr-4 mt-1 flex-shrink-0">
                            <i class="fas fa-question text-indigo-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-lg text-gray-800 mb-2">Can I get help choosing the right book?</h4>
                            <p class="text-gray-600">Absolutely! Our admin can assist with recommendations. Call our helpline or visit our pickup locations where our staff will gladly help you find the perfect book.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', () => {

        // --- FAQ Animation Logic ---
        // Logika ini tetap dipertahankan untuk menganimasikan item FAQ
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.remove('opacity-0', '-translate-y-2');
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        
        document.querySelectorAll('.faq-item').forEach(item => {
            observer.observe(item);
        });

        // --- Mobile Menu Toggle ---
        const mobileMenuButton = document.getElementById('mobileMenuButton');
    });
    </script>
</body>
</html>
    <script>
    // --- SCRIPT ANIMASI FAQ ---
    document.addEventListener('DOMContentLoaded', () => {
        const faqItems = document.querySelectorAll('.faq-item');
        faqItems.forEach(item => {
            item.classList.add('opacity-0', '-translate-y-2');
            item.style.transition = 'all 0.5s ease-out';
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.remove('opacity-0', '-translate-y-2');
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        faqItems.forEach(item => observer.observe(item));
    });
    </script>