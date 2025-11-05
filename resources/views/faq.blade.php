<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICSIS FAQ - Frequently Asked Questions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .faq-toggle {
            transition: all 0.3s ease;
        }
        .faq-toggle:hover {
            background-color: #f3f4f6;
        }
        .rotate-180 {
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold text-gray-800">ICSIS</h1>
                    <span class="text-sm text-gray-600">Irosin Central School Information System</span>
                </div>
                <nav class="flex space-x-4">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">Login</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-medium">Register</a>
                </nav>
            </div>
        </div>
    </header>

    <section class="bg-white py-16">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-4xl font-bold text-center text-gray-800 mb-4">Frequently Asked Questions</h1>
            <p class="text-lg text-center text-gray-600 mb-12">Find answers to common questions about Irosin Central School Information System (ICSIS)</p>

            <div class="space-y-4" id="faqAccordion">

                <!-- FAQ 1 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">1. What is the Irosin Central School Information System (ICSIS)?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        ICSIS is an online platform designed to make school information and communication easier for students, parents, teachers, graduates, and school staff. It centralizes important features like school news, announcements, calendar events, community groups, and more—all in one secure place.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">2. Who can use ICSIS?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        ICSIS is accessible to:
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Students</strong> currently enrolled at Irosin Central School</li>
                            <li><strong>Parents or guardians</strong> of students</li>
                            <li><strong>Graduates</strong> who want to stay connected</li>
                            <li><strong>Teachers and school administrators</strong> who manage records and communications</li>
                        </ul>
                        Each user type has specific roles and permissions to ensure secure and appropriate access.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">3. How do I log in and create an account on ICSIS?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Students are pre-registered by the school administrator and will receive their login credentials directly.<br /><br />
                        Parents and graduates need to register themselves on the ICSIS registration page.<br />
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li>Parents must use the same contact number that the student has listed as the guardian's emergency contact to specify their relationship to the student for verification.</li>
                            <li>Graduates should provide their details as part of the registration process.</li>
                            <li>Both graduates and parents are required to submit a valid ID from Irosin Central School or another valid government-issued ID for verification by the school administrator.</li>
                        </ul>
                        After registering, check your email and complete the verification process to activate your account. This ensures your email address is valid and secures your access.<br /><br />
                        Keep your login details confidential to protect your personal information.
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">4. What kind of information can I find in the News, Announcements, and Calendar Events sections?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <strong>News:</strong> Latest school happenings, student achievements, program launches, and updates.
                        <br /><br />
                        <strong>Announcements:</strong> Official statements or reminders from school officials, such as schedule changes or policy updates.
                        <br /><br />
                        <strong>Calendar Events:</strong> Upcoming school events, holidays, exams, parent meetings, and other important dates to help you stay organized.
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">5. Can I interact with the news and announcements?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Yes! Users can react with emojis (like, love, etc.) and comment on posts to engage with the school community and share feedback.
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">6. Are there any rules or filters for commenting?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Yes. ICSIS uses an AI-powered moderation system that scans comments for rude, offensive, or inappropriate language. Violating comments may be removed and users may lose commenting privileges if issues persist.
                    </div>
                </div>

                <!-- FAQ 7 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">7. What are the groups in ICSIS, and how do they work?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Visit the About Us section on the ICSIS portal or the official school website to learn about the school's history, vision, mission, and more.
                    </div>
                </div>

                <!-- FAQ 8 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">8. How do I join or create a group?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Contact the ICSIS Help Desk or your school's IT coordinator. Their contact info is in the About Us section or on the login page. They can assist with account issues, technical problems, and general questions.
                    </div>
                </div>

                <!-- FAQ 9 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">9. How does ICSIS protect my personal information and keep interactions safe?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Visit the About Us section on the ICSIS portal or the official school website to learn about the school's history, vision, mission, and more.
                    </div>
                </div>

                <!-- FAQ 10 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">10. Can I access ICSIS on mobile devices?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Contact the ICSIS Help Desk or your school's IT coordinator. Their contact info is in the About Us section or on the login page. They can assist with account issues, technical problems, and general questions.
                    </div>
                </div>

                <!-- FAQ 11 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">11. What should I do if I forget my password?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Visit the About Us section on the ICSIS portal or the official school website to learn about the school's history, vision, mission, and more.
                    </div>
                </div>

                <!-- FAQ 12 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">12. What if I encounter technical problems or have questions about ICSIS?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Contact the ICSIS Help Desk or your school's IT coordinator. Their contact info is in the About Us section or on the login page. They can assist with account issues, technical problems, and general questions.
                    </div>
                </div>

                <!-- FAQ 13 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">13. Where can I learn more about Irosin Central School?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Visit the About Us section on the ICSIS portal or the official school website to learn about the school's history, vision, mission, and more.
                    </div>
                </div>

                <!-- FAQ 14 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">14. What if I encounter technical problems or have questions about ICSIS?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Contact the ICSIS Help Desk or your school's IT coordinator. Their contact info is in the About Us section or on the login page. They can assist with account issues, technical problems, and general questions.
                    </div>
                </div>

                <!-- FAQ 15 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">15. Where can I learn more about Irosin Central School?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Visit the About Us section on the ICSIS portal or the official school website to learn about the school's history, vision, mission, and more.
                    </div>
                </div>

                <!-- FAQ 16 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">16. Can I update my profile information?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Yes, users can update their profile information such as email, and other personal details. However, the name, and contact number field cannot be changed to prevent identity confusion and ensure the authenticity of user records. To request a change to your name or contact number, please file a formal request.
                    </div>
                </div>

                <!-- FAQ 17 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">17. Will I receive notifications for new updates?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Yes, users will receive notifications for new news posts, announcements, events, and other important updates. Notifications will appear within the portal and may also be sent via email or SMS, depending on your notification settings.
                    </div>
                </div>
                <!-- FAQ 18 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">18. What are the limitations of the ICSI System?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        While ICSIS provides a comprehensive platform for school communication and management, it has some limitations to consider:
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Internet Dependency:</strong> The system requires a stable internet connection for access and functionality.</li>
                            <li><strong>Device Requirements:</strong> Face detection during registration needs a device with a camera and a modern web browser (Chrome, Firefox, Safari, or Edge).</li>
                            <li><strong>Browser Compatibility:</strong> Older browsers or those without camera support may not fully support all features like face detection.</li>
                            <li><strong>AI Moderation Accuracy:</strong> The comment moderation system uses AI, which may occasionally flag appropriate content or miss inappropriate content.</li>
                            <li><strong>Notification Delivery:</strong> Notifications depend on user settings, network conditions, and may not reach users if email/SMS services are unavailable.</li>
                            <li><strong>Institution-Specific:</strong> The system is tailored for Irosin Central School and may require customization for other institutions.</li>
                            <li><strong>User Verification Time:</strong> Account approvals and verifications may take time depending on administrative review.</li>
                            <li><strong>No Offline Access:</strong> The platform does not support offline functionality.</li>
                            <li><strong>Mobile Experience:</strong> While responsive, it's web-based and not a native mobile app, which may limit some advanced mobile features.</li>
                            <li><strong>Data Retention:</strong> User data is subject to school policies and may be retained or deleted according to institutional guidelines.</li>
                        </ul>
                        We continuously work to improve the system and address these limitations where possible.
                    </div>
                </div>

                <!-- FAQ 18 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">18. Why are all members of the school displayed on the Irosin Central School Information System?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        All members of the school—students, parents, teachers, and alumni—are displayed on the system to promote transparency, foster community engagement, and ensure accurate record-keeping. This visibility helps users connect with their peers, access group-based features, and receive relevant updates. Only registered and logged-in users can view member information, and privacy measures are implemented to protect sensitive data.
                    </div>
                </div>

                <!-- FAQ 19 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">19. What is the face detection feature during registration and how does it work?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <strong>Face Detection</strong> is an advanced security feature used during user registration to capture and verify profile pictures. Here's how it works:<br><br>

                        <strong>Process:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Camera Access:</strong> Users grant camera permission to start the process</li>
                            <li><strong>Liveness Detection:</strong> The system performs three validation steps:
                                <ul class="list-disc list-inside ml-6 mt-1 space-y-1">
                                    <li>👤 <strong>Face Verification:</strong> Users must keep only one face in view</li>
                                    <li>😊 <strong>Smile Detection:</strong> Users must smile at the camera</li>
                                    <li>👁️ <strong>Blink Detection:</strong> Users must blink their eyes</li>
                                </ul>
                            </li>
                            <li><strong>Photo Capture:</strong> After successful validation, a profile picture is automatically captured</li>
                            <li><strong>ID Verification:</strong> The captured photo is compared with uploaded ID images to ensure they match</li>
                        </ul><br>

                        <strong>Why Face Detection?</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li>🔒 <strong>Security:</strong> Prevents fake accounts and ensures real user registration</li>
                            <li>🎯 <strong>Verification:</strong> Confirms the person registering matches their ID documents</li>
                            <li>🎤 <strong>Accessibility:</strong> Provides audio guidance throughout the process</li>
                            <li>📱 <strong>User-Friendly:</strong> Works on modern browsers with camera support</li>
                        </ul><br>

                        <strong>Technical Requirements:</strong>
                        <ul class="list-disc list-inside mt-1 space-y-1">
                            <li>Modern web browser (Chrome, Firefox, Safari, Edge)</li>
                            <li>Camera permission must be granted</li>
                            <li>HTTPS connection required for security</li>
                            <li>Stable internet connection for face detection models</li>
                        </ul><br>

                        <strong>Privacy & Security:</strong> All face detection happens locally in your browser. Images are only used for verification and are securely stored on our servers. No third-party services process your facial data.
                    </div>
                </div>

            </div>

            <!-- Navigation Links -->
            <div class="mt-12 text-center">
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Login to ICSIS
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Register Account
                    </a>
                    <a href="{{ route('about') }}" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        About Us
                    </a>
                </div>
            </div>
        </div>
    </section>
    @if (request()->routeIs('faq'))
        <script>
            location.href = '/view-faq';
        </script>
    @endif
    <script>
        document.querySelectorAll('.faq-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const content = button.nextElementSibling;
                const icon = button.querySelector('svg');

                const isOpen = !content.classList.contains('hidden');
                document.querySelectorAll('.faq-content').forEach(c => c.classList.add('hidden'));
                document.querySelectorAll('.faq-toggle svg').forEach(i => i.classList.remove('rotate-180'));

                if (!isOpen) {
                    content.classList.remove('hidden');
                    icon.classList.add('rotate-180');
                }
            });
        });
    </script>
</body>
</html>
            </div>

            <!-- Navigation Links -->
            <div class="mt-12 text-center">
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Login to ICSIS
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        Register Account
                    </a>
                    <a href="{{ route('about') }}" class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        About Us
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-cream-50 py-16">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Privacy Policies</h2>

            <div class="bg-brown-50 p-8 rounded-xl shadow hover:shadow-md transition">
                <div class="space-y-8">

                    <!-- Introduction -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Introduction</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            At Irosin Central School Information System (ICSIS), we are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy outlines how we collect, use, protect, and manage your data in compliance with applicable laws and regulations. By using ICSIS, you agree to the practices described in this policy.
                        </p>
                    </div>

                    <!-- Data Collection -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Data Collection</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            We collect personal information necessary to provide our services, including:
                        </p>
                        <ul class="list-disc list-inside mt-4 space-y-2 text-gray-600">
                            <li><strong>Registration Information:</strong> Name, email, contact number, and relationship details (for parents/guardians)</li>
                            <li><strong>Profile Pictures:</strong> Captured via face detection during registration for verification purposes</li>
                            <li><strong>Identification Documents:</strong> Government-issued IDs submitted for verification</li>
                            <li><strong>Usage Data:</strong> Login activity, interactions (comments, reactions), and group memberships</li>
                            <li><strong>Device Information:</strong> Browser type, IP address, and device details for security and analytics</li>
                        </ul>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            All data collection is performed with user consent and follows strict verification processes to ensure authenticity.
                        </p>
                    </div>

                    <!-- Data Usage -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Data Usage</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            Your personal information is used to:
                        </p>
                        <ul class="list-disc list-inside mt-4 space-y-2 text-gray-600">
                            <li>Provide access to ICSIS features and services</li>
                            <li>Verify user identities and maintain account security</li>
                            <li>Facilitate communication between students, parents, teachers, and alumni</li>
                            <li>Display member information for community engagement and transparency</li>
                            <li>Send notifications about news, announcements, and events</li>
                            <li>Moderate content and maintain a respectful community environment</li>
                            <li>Improve system functionality and user experience</li>
                        </ul>
                    </div>

                    <!-- Data Protection -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Data Protection and Security</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            We implement comprehensive security measures to protect your data:
                        </p>
                        <ul class="list-disc list-inside mt-4 space-y-2 text-gray-600">
                            <li><strong>Secure Login:</strong> Encrypted authentication and password protection</li>
                            <li><strong>Role-Based Access Control:</strong> Users can only access information appropriate to their role</li>
                            <li><strong>AI Comment Moderation:</strong> Automated filtering of inappropriate content</li>
                            <li><strong>Regular System Updates:</strong> Ongoing security patches and improvements</li>
                            <li><strong>Data Encryption:</strong> All sensitive data is encrypted in transit and at rest</li>
                            <li><strong>Access Restrictions:</strong> Only registered and logged-in users can view member information</li>
                        </ul>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            We regularly audit our systems and update our security practices to address emerging threats.
                        </p>
                    </div>

                    <!-- User Rights -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Your Rights and Choices</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            You have the following rights regarding your personal information:
                        </p>
                        <ul class="list-disc list-inside mt-4 space-y-2 text-gray-600">
                            <li><strong>Access and Update:</strong> You can view and update most profile information, except name and contact number which require formal requests</li>
                            <li><strong>Data Portability:</strong> Request a copy of your personal data in a structured format</li>
                            <li><strong>Data Deletion:</strong> Request deletion of your account and associated data, subject to legal and operational requirements</li>
                            <li><strong>Consent Withdrawal:</strong> Opt-out of non-essential communications and data processing</li>
                            <li><strong>Complaint Filing:</strong> Report privacy concerns to our data protection officer</li>
                        </ul>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            To exercise these rights or make changes to restricted fields, please contact the school administration or IT coordinator.
                        </p>
                    </div>

                    <!-- Face Detection Privacy -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Face Detection and Biometric Data</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            Our face detection feature is used solely for user verification during registration:
                        </p>
                        <ul class="list-disc list-inside mt-4 space-y-2 text-gray-600">
                            <li><strong>Local Processing:</strong> Face detection occurs entirely in your browser; no data is sent to external servers</li>
                            <li><strong>Limited Use:</strong> Facial data is only used for identity verification and profile picture capture</li>
                            <li><strong>No Third-Party Sharing:</strong> We do not share facial recognition data with any third-party services</li>
                            <li><strong>Data Retention:</strong> Facial images are securely stored and used only for account verification purposes</li>
                            <li><strong>Consent Required:</strong> Camera access and face detection require explicit user permission</li>
                        </ul>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            This feature enhances security by preventing fake accounts while maintaining user privacy.
                        </p>
                    </div>

                    <!-- Community Visibility -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Community Information Display</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            To foster transparency and community engagement, member information (students, parents, teachers, alumni) is displayed within ICSIS. This visibility:
                        </p>
                        <ul class="list-disc list-inside mt-4 space-y-2 text-gray-600">
                            <li>Helps users connect with peers and access relevant group features</li>
                            <li>Supports accurate record-keeping and communication</li>
                            <li>Is restricted to registered, logged-in users only</li>
                            <li>Includes privacy measures to protect sensitive personal data</li>
                        </ul>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            We balance community benefits with privacy protection, ensuring that only necessary information is shared.
                        </p>
                    </div>

                    <!-- Contact Information -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Contact Us</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            If you have questions about this Privacy Policy or our data practices, please contact:
                        </p>
                        <ul class="list-none mt-4 space-y-2 text-gray-600">
                            <li><strong>ICSIS Help Desk:</strong> Available through the portal's support section</li>
                            <li><strong>School IT Coordinator:</strong> Contact information available in the About Us section</li>
                            <li><strong>Data Protection Officer:</strong> Reach out via the school's administration office</li>
                        </ul>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            We are committed to addressing your privacy concerns promptly and transparently.
                        </p>
                    </div>

                    <!-- Policy Updates -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Policy Updates</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            This Privacy Policy may be updated periodically to reflect changes in our practices or legal requirements. We will notify users of significant changes through the ICSIS portal or via email. Continued use of ICSIS after updates constitutes acceptance of the revised policy.
                        </p>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            <em>Last updated: November 2025</em>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="bg-brown-100 py-16">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Terms and Conditions</h2>

            <div class="bg-cream-50 p-8 rounded-xl shadow hover:shadow-md transition">
                <div class="space-y-8">

                    <!-- Acceptance of Terms -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Acceptance of Terms</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            By accessing and using the Irosin Central School Information System (ICSIS), you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.
                        </p>
                    </div>

                    <!-- User Eligibility -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">User Eligibility and Registration</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            ICSIS is available to:
                        </p>
                        <ul class="list-disc list-inside mt-4 space-y-2 text-gray-600">
                            <li>Currently enrolled students of Irosin Central School</li>
                            <li>Parents or guardians of enrolled students</li>
                            <li>Graduates of Irosin Central School</li>
                            <li>School teachers and administrative staff</li>
                        </ul>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            Students are pre-registered by school administrators. Parents and graduates must register themselves and provide valid identification for verification. All users must complete the face detection verification process during registration.
                        </p>
                    </div>

                    <!-- User Responsibilities -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">User Responsibilities and Conduct</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            Users agree to:
                        </p>
                        <ul class="list-disc list-inside mt-4 space-y-2 text-gray-600">
                            <li>Provide accurate and truthful information during registration and profile updates</li>
                            <li>Maintain the confidentiality of login credentials and account access</li>
                            <li>Use the system only for lawful purposes related to school communication and information sharing</li>
                            <li>Respect the rights and privacy of other users</li>
                            <li>Follow community guidelines and school policies</li>
                            <li>Report any technical issues or security concerns promptly</li>
                        </ul>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            Users are prohibited from:
                        </p>
                        <ul class="list-disc list-inside mt-4 space-y-2 text-gray-600">
                            <li>Sharing account credentials with others</li>
                            <li>Posting inappropriate, offensive, or harmful content</li>
                            <li>Attempting to access unauthorized areas or data</li>
                            <li>Using the system for commercial purposes or spam</li>
                            <li>Impersonating other users or providing false information</li>
                        </ul>
                    </div>

                    <!-- Content Guidelines -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Content Guidelines and Moderation</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            ICSIS employs AI-powered content moderation to maintain a respectful community environment. Comments and posts are automatically scanned for:
                        </p>
                        <ul class="list-disc list-inside mt-4 space-y-2 text-gray-600">
                            <li>Rude, offensive, or inappropriate language</li>
                            <li>Harmful or discriminatory content</li>
                            <li>Spam or irrelevant posts</li>
                            <li>Violations of school policies</li>
                        </ul>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            Violating content may be removed, and repeated violations may result in temporary or permanent suspension of commenting privileges or account access. Users are responsible for the content they post and engage with.
                        </p>
                    </div>

                    <!-- Group Membership and Access -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Group Membership and Access Control</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            Groups are created and managed by school administrators and teachers to organize community discussions and information sharing. Users may request to join groups, but membership requires administrative approval. Group access controls ensure that:
                        </p>
                        <ul class="list-disc list-inside mt-4 space-y-2 text-gray-600">
                            <li>Only approved members can view group-specific announcements and events</li>
                            <li>News posts remain publicly accessible to all users</li>
                            <li>Group discussions stay relevant to the intended community</li>
                        </ul>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            Users must respect group purposes and maintain appropriate conduct within group spaces.
                        </p>
                    </div>

                    <!-- Account Security and Verification -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Account Security and Identity Verification</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            Account security is maintained through:
                        </p>
                        <ul class="list-disc list-inside mt-4 space-y-2 text-gray-600">
                            <li>Mandatory face detection verification during registration</li>
                            <li>Document verification for parents and graduates</li>
                            <li>Secure login procedures and password requirements</li>
                            <li>Regular security audits and system updates</li>
                        </ul>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            Users must immediately report any suspected unauthorized access to their accounts. The school reserves the right to verify user identities at any time and suspend accounts that cannot be properly verified.
                        </p>
                    </div>

                    <!-- Service Availability -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Service Availability and Technical Support</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            ICSIS strives to provide reliable access to the platform, but service availability may be affected by:
                        </p>
                        <ul class="list-disc list-inside mt-4 space-y-2 text-gray-600">
                            <li>Scheduled maintenance periods</li>
                            <li>Technical issues or system updates</li>
                            <li>Internet connectivity problems</li>
                            <li>Force majeure events beyond our control</li>
                        </ul>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            Technical support is available through the ICSIS Help Desk and school IT coordinator. Users experiencing technical difficulties should contact support immediately for assistance.
                        </p>
                    </div>

                    <!-- Limitation of Liability -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Limitation of Liability</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            ICSIS and Irosin Central School provide the platform "as is" without warranties of any kind. We are not liable for:
                        </p>
                        <ul class="list-disc list-inside mt-4 space-y-2 text-gray-600">
                            <li>Indirect, incidental, or consequential damages</li>
                            <li>Loss of data or information</li>
                            <li>Service interruptions or technical issues</li>
                            <li>User-generated content or interactions</li>
                        </ul>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            Users assume all responsibility for their use of the platform and interactions with other users.
                        </p>
                    </div>

                    <!-- Termination -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Account Termination</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            The school reserves the right to suspend or terminate user accounts for violations of these terms, school policies, or inappropriate conduct. Users may also request account deletion at any time. Upon termination:
                        </p>
                        <ul class="list-disc list-inside mt-4 space-y-2 text-gray-600">
                            <li>Access to the platform will be immediately revoked</li>
                            <li>User data may be retained for legal or administrative purposes</li>
                            <li>Some data may be permanently deleted based on retention policies</li>
                        </ul>
                    </div>

                    <!-- Governing Law -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Governing Law and Dispute Resolution</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            These terms are governed by the laws of the Republic of the Philippines. Any disputes arising from the use of ICSIS will be resolved through the school's administrative procedures and, if necessary, through appropriate legal channels.
                        </p>
                    </div>

                    <!-- Updates to Terms -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Updates to Terms and Conditions</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            These terms may be updated periodically to reflect changes in school policies, legal requirements, or system functionality. Users will be notified of significant changes through the platform or via email. Continued use of ICSIS after updates constitutes acceptance of the revised terms.
                        </p>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            <em>Last updated: November 2025</em>
                        </p>
                    </div>

                    <!-- Contact Information -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Contact Information</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            For questions about these Terms and Conditions or to report violations, please contact:
                        </p>
                        <ul class="list-none mt-4 space-y-2 text-gray-600">
                            <li><strong>ICSIS Help Desk:</strong> Available through the portal's support section</li>
                            <li><strong>School Administration:</strong> Contact the principal's office for policy-related concerns</li>
                            <li><strong>IT Coordinator:</strong> For technical and access-related issues</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </section>