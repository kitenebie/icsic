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
                        ICSIS is an online platform designed to make school information and communication easier for students, parents, teachers, graduates, and school staff. It centralizes important features like school news, announcements, calendar events, document requests, community groups, and more—all in one secure place.
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
                        <span class="text-lg font-medium text-gray-800">7. How do I request official school documents through ICSIS?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <b>(Parent)</b> can request documents like Form 137 (Student Permanent Record), Form 138 (Report Card), and Certificate of Good Moral by filling out an online form. The school will process your request and notify you when your document is ready.
                    </div>
                </div>

                <!-- FAQ 8 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">8. Who can request documents?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Parents can submit document requests. Requests must come from authorized users and contact details should be kept updated for smooth processing.
                    </div>
                </div>

                <!-- FAQ 9 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">9. What are the groups in ICSIS, and how do they work?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <b>Groups</b> are community spaces where parents, students, and graduates connect based on shared classes, interests, or activities. They help organize discussions, resource sharing, announcements, and events. A <b>"My Groups"</b> button is available for users to quickly access the groups they have already joined. Within these groups, users can easily stay updated with the latest announcements and upcoming events relevant to their communities.
                    </div>
                </div>

                <!-- FAQ 10 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">10. How do I join or create a group?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Only school administrators and teachers can create groups to avoid redundancy and maintain organization within ICSIS. Users can request to join groups, but group membership requires admin approval. Groups filter access so that only members can view updates in announcements and calendar events related to that group. Please note that news posts are public and visible to all users regardless of group membership.
                    </div>
                </div>

                <!-- FAQ 11 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">11. How does ICSIS protect my personal information and keep interactions safe?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        ICSIS employs secure login, role-based access control, AI comment moderation, and regular system updates to safeguard your data and maintain a respectful community.
                    </div>
                </div>

                <!-- FAQ 12 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">12. Can I access ICSIS on mobile devices?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Yes! ICSIS is mobile-friendly and works smoothly on smartphones and tablets via web browsers, letting you stay connected wherever you go.
                    </div>
                </div>

                <!-- FAQ 13 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">13. What should I do if I forget my password?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Click the <b>"Forgot Password?"</b> link on the login page, enter your registered email or username, and follow the instructions sent to your email to reset your password. For issues, contact the school IT office.
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
    <script>
        location.href = '/faq';
    </script>
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