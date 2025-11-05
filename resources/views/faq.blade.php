<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICSIS FAQ - Frequently Asked Questions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&amp;display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-messaging-compat.js"></script>
    <script src="/build/assets/app.js"></script>
    <link rel="stylesheet" href="/build/assets/app-LEGjbQqW.css">
    <link rel="stylesheet" href="/css/custome.css">
    <script src="/build/assets/app-Bb96QejN.js" type="module"></script>
    <link rel="stylesheet" href="/css/costume.css">
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

<body class="bg-cream-50">
    <!-- Header -->
    <header class="bg-brown-50 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold text-gray-800">ICSIS</h1>
                    <span class="text-sm text-gray-600">Irosin Central School Information System</span>
                </div>
                <nav class="flex space-x-4">
                    <a href="{{ route('login') }}" class="text-brown-600 hover:text-brown-800 font-medium">Login</a>
                    <a href="{{ route('register') }}"
                        class="bg-brown-600 text-brown-50 px-4 py-2 rounded-lg hover:bg-brown-700 font-medium">Register</a>
                </nav>
            </div>
        </div>
    </header>
    <section class="bg-brown-100 py-16">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Frequently Asked Questions</h2>

            <div class="space-y-4" id="faqAccordion">

                <!-- FAQ 1 -->
                <div class="bg-cream-50 rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">1. What is the Irosin Central School
                            Information System (ICSIS)?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <strong>Overview:</strong> The Irosin Central School Information System (ICSIS) is a
                        comprehensive digital platform designed to streamline communication, information sharing, and
                        community engagement for the Irosin Central School community.<br /><br />

                        <strong>Key Features and Benefits:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Centralized Information Hub:</strong> All school-related information, news, and
                                updates in one accessible location</li>
                            <li><strong>Multi-User Platform:</strong> Designed for students, parents, teachers,
                                graduates, and school staff with role-specific features</li>
                            <li><strong>Real-Time Communication:</strong> Instant access to announcements, news, and
                                important updates</li>
                            <li><strong>Community Building:</strong> Group features for class-specific discussions and
                                alumni networking</li>
                            <li><strong>Event Management:</strong> Calendar integration for school events, holidays, and
                                important dates</li>
                            <li><strong>Interactive Features:</strong> Commenting, reacting, and community engagement
                                tools</li>
                            <li><strong>Mobile Accessibility:</strong> Responsive design that works on smartphones,
                                tablets, and computers</li>
                        </ul><br />

                        <strong>Core Components:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>News Feed:</strong> Latest school happenings, achievements, and program updates
                            </li>
                            <li><strong>Announcements:</strong> Official communications from school administration and
                                teachers</li>
                            <li><strong>Calendar Events:</strong> School events, exams, parent meetings, and holidays
                            </li>
                            <li><strong>Community Groups:</strong> Class-based and interest-based discussion spaces</li>
                            <li><strong>Member Directory:</strong> Verified member information for community connection
                            </li>
                        </ul><br />

                        <strong>Security and Privacy:</strong> ICSIS employs advanced security measures including
                        encrypted connections, user verification, AI-powered content moderation, and role-based access
                        controls to ensure a safe and secure environment for all users.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-cream-50 rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">2. Who can use ICSIS?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <strong>Eligible User Categories:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Current Students:</strong> All enrolled students from Grade 1 to Grade 6 at
                                Irosin Central School</li>
                            <li><strong>Parents/Guardians:</strong> Legal guardians or parents of currently enrolled
                                students who can verify their relationship</li>
                            <li><strong>School Graduates:</strong> Former students who graduated from Irosin Central
                                School and wish to maintain community connections</li>
                            <li><strong>Teaching Staff:</strong> All classroom teachers, subject teachers, and special
                                education instructors</li>
                            <li><strong>School Administrators:</strong> Principal, and administrative personnel</li>
                            <li><strong>Support Staff:</strong> Librarians, counselors, nurses, IT personnel, and other
                                school support staff</li>
                        </ul><br />

                        <strong>Role-Based Access and Permissions:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Student Access:</strong> View news, announcements, calendar events, participate
                                in approved groups, comment and react to posts</li>
                            <li><strong>Parent Access:</strong> Monitor student-related announcements, communicate with
                                teachers, access parent-specific groups, view school events</li>
                            <li><strong>Graduate Access:</strong> Stay updated with school news, participate in alumni
                                groups, network with other graduates, access career resources</li>
                            <li><strong>Teacher Access:</strong> Post announcements, create and manage groups, access
                                student records, moderate Content</li>
                            <li><strong>Administrator Access:</strong> Full system management, user account creation,
                                content oversight, system configuration</li>
                        </ul><br />

                        <strong>Verification Requirements:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Students:</strong> Pre-registered by school administration with verified
                                enrollment status</li>
                            <li><strong>Parents:</strong> Must provide relationship verification through emergency
                                contact matching and valid ID</li>
                            <li><strong>Graduates:</strong> Submit school ID or graduation certificate for verification
                            </li>
                            <li><strong>Staff:</strong> Verified through school employment records and official
                                credentials</li>
                        </ul><br />

                        <strong>Access Restrictions:</strong> All users must complete identity verification during
                        registration. Access is granted only after successful verification, and accounts can be
                        suspended for policy violations or if eligibility criteria are no longer met.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-cream-50 rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">3. How do I log in and create an account on
                            ICSIS?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <strong>Students:</strong> Students are pre-registered by the school administrator and will
                        receive their login credentials directly via email or through their class adviser.<br /><br />

                        <strong>Parents and Graduates:</strong> Parents and graduates need to register themselves on the
                        ICSIS registration page. The registration process includes several verification steps:<br />
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Basic Information:</strong> Provide your full name, email address, contact
                                number, and relationship details.</li>
                            <li><strong>Relationship Verification (Parents):</strong> Parents must use the same contact
                                number that the student has listed as the guardian's emergency contact to establish
                                their relationship to the student.</li>
                            <li><strong>ID Document Upload:</strong> Both graduates and parents are required to upload a
                                valid ID from Irosin Central School or another government-issued ID (such as driver's
                                license, passport, or national ID) for verification by the school administrator.</li>
                            <li><strong>CAPTCHA Verification:</strong> Complete the CAPTCHA challenge to prove you are
                                not a robot and prevent automated spam registrations.</li>
                            <li><strong>Face Live Detection:</strong> Undergo real-time facial recognition verification
                                where you must:
                                <ul class="list-disc list-inside ml-6 mt-1 space-y-1">
                                    <li>Grant camera permission in your browser</li>
                                    <li>Position yourself so only one face is visible in the frame</li>
                                    <li>Smile at the camera when prompted</li>
                                    <li>Blink your eyes when instructed</li>
                                    <li>Follow audio guidance throughout the process</li>
                                </ul>
                            </li>
                        </ul>
                        After completing all registration steps, check your email for a verification link to activate
                        your account. This ensures your email address is valid and completes the security verification
                        process.<br /><br />
                        <strong>Important:</strong> Keep your login details confidential to protect your personal
                        information. If you encounter any issues during face detection (such as poor lighting or camera
                        problems), ensure you are in a well-lit area with a stable internet connection and try again.
                    </div>
                </div>


                <!-- FAQ 4 -->
                <div class="bg-cream-50 rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">4. What kind of information can I find in the
                            News, Announcements, and Calendar Events sections?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <strong>News Section:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Student Achievements:</strong> Academic awards, sports victories, arts
                                performances, and special recognitions</li>
                            <li><strong>School Events:</strong> Coverage of school programs, field trips, cultural
                                activities, and community outreach</li>
                            <li><strong>Program Launches:</strong> New initiatives, clubs, after-school programs, and
                                educational enhancements</li>
                            <li><strong>Staff Updates:</strong> Professional development, new appointments, and faculty
                                achievements</li>
                            <li><strong>Educational Highlights:</strong> Innovative teaching methods, curriculum
                                updates, and learning outcomes</li>
                        </ul><br />

                        <strong>Announcements Section:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Schedule Changes:</strong> Modified class timings, early dismissals, delayed
                                openings, or holiday adjustments</li>
                            <li><strong>Policy Updates:</strong> New school rules, dress code changes, or procedural
                                modifications</li>
                            <li><strong>Emergency Communications:</strong> Weather-related closures, health alerts, or
                                urgent notifications</li>
                            <li><strong>Administrative Notices:</strong> Enrollment deadlines, fee payments, document
                                submissions, and important deadlines</li>
                            <li><strong>Facility Updates:</strong> Maintenance schedules, room changes, or equipment
                                availability</li>
                            <li><strong>Health and Safety:</strong> Immunization requirements, health screenings, or
                                safety protocols</li>
                        </ul><br />

                        <strong>Calendar Events Section:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Academic Calendar:</strong> Exam schedules, report card distributions,
                                parent-teacher conferences</li>
                            <li><strong>Holidays and Breaks:</strong> School holidays, semester breaks, and long
                                weekends</li>
                            <li><strong>Sports Events:</strong> Intramural games, inter-school competitions, and
                                athletic meets</li>
                            <li><strong>Cultural Activities:</strong> School festivals, performances, exhibitions, and
                                cultural celebrations</li>
                            <li><strong>Parent Involvement:</strong> PTA meetings, volunteer opportunities, and family
                                engagement events</li>
                            <li><strong>Professional Development:</strong> Teacher training days, workshops, and
                                curriculum planning sessions</li>
                            <li><strong>Community Events:</strong> Open houses, career days, guest speakers, and
                                community partnerships</li>
                        </ul><br />

                        <strong>Additional Features:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Interactive Elements:</strong> Users can react with emojis, comment, and share
                                relevant posts</li>
                            <li><strong>Notification System:</strong> Automatic alerts for important announcements and
                                upcoming events</li>
                            <li><strong>Mobile Accessibility:</strong> All features available on mobile devices with
                                push notifications</li>
                        </ul>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="bg-cream-50 rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">5. Can I interact with the news and
                            announcements?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <strong>Yes! ICSIS encourages active community participation through various interactive
                            features:</strong><br /><br />

                        <strong>Reaction Options:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Emoji Reactions:</strong> Express your feelings with like 👍, love ❤️, lough 😂,
                                sad 🥲, and other relevant emojis</li>
                            <li><strong>Quick Feedback:</strong> Instant reactions help show community engagement and
                                support</li>
                            <li><strong>Anonymous Reactions:</strong> React without leaving a comment if you prefer
                                privacy</li>
                        </ul><br />

                        <strong>Commenting Features:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Text Comments:</strong> Share your thoughts, ask questions, or provide
                                additional context</li>
                            <li><strong>Threaded Discussions:</strong> Reply to specific comments to create organized
                                conversations</li>
                        </ul><br />

                        <strong>Community Guidelines for Interaction:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Respectful Communication:</strong> Keep comments constructive, polite, and
                                school-appropriate</li>
                            <li><strong>Relevant Contributions:</strong> Comments should relate to the post topic and
                                add value to the discussion</li>
                            <li><strong>Supportive Environment:</strong> Encourage and celebrate achievements, offer
                                help when appropriate</li>
                            <li><strong>Report Issues:</strong> Use the report feature for inappropriate content rather
                                than engaging negatively</li>
                        </ul><br />

                        <strong>Moderation and Safety:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>AI Content Monitoring:</strong> All comments are automatically scanned for
                                inappropriate content</li>
                            <li><strong>Real-time Filtering:</strong> Harmful or offensive content is flagged and
                                removed immediately</li>
                            <li><strong>Community Standards:</strong> Comments must align with school values and
                                policies</li>
                            <li><strong>Accountability:</strong> Users are responsible for their interactions and may
                                face consequences for violations</li>
                        </ul><br />

                        <strong>Benefits of Participation:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Community Building:</strong> Strengthen connections between students, parents,
                                teachers, and alumni</li>
                            <li><strong>Knowledge Sharing:</strong> Learn from others' experiences and insights</li>
                            <li><strong>Feedback Loop:</strong> Help improve school programs through constructive input
                            </li>
                            <li><strong>Recognition:</strong> Celebrate achievements and milestones together</li>
                        </ul>
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="bg-cream-50 rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">6. Are there any rules or filters for
                            commenting?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Yes. ICSIS uses an AI-powered moderation system that automatically scans all comments for rude,
                        offensive, inappropriate, or harmful language. This system helps maintain a safe and respectful
                        environment for all users.<br /><br />

                        <strong>Important Guidelines for Users:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Student Users:</strong> Since most of our community consists of students, please
                                be especially mindful of your language and comments. Avoid using unnecessary or
                                inappropriate words, even if they might seem harmless. Focus on constructive,
                                respectful, and school-appropriate communication.</li>
                            <li><strong>All Users:</strong> While AI moderation provides an important safety net, users
                                are ultimately responsible for the content they post. Think before you comment and
                                ensure your contributions add value to the community discussion.</li>
                            <li><strong>Best Practices:</strong> Use comments to share relevant thoughts, ask questions,
                                provide feedback, or support your fellow community members. Keep discussions focused on
                                school-related topics and maintain a positive, respectful tone.</li>
                        </ul><br />

                        <strong>Consequences:</strong> Comments that violate our guidelines may be removed immediately.
                        Repeated violations can result in temporary suspension of commenting privileges or, in severe
                        cases, restriction of account access. We encourage all users to help create a welcoming
                        environment where everyone feels safe to participate.
                    </div>
                </div>


                <!-- FAQ 7 -->
                <div class="bg-cream-50 rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">7. What are the groups in ICSIS, and how do
                            they work?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <strong>Understanding ICSIS Groups:</strong> Groups are specialized community spaces within
                        ICSIS that bring together members with shared interests, classes, or purposes. They function as
                        focused discussion forums and collaboration hubs.<br /><br />

                        <strong>Types of Groups:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Class-Based Groups:</strong> Organized by grade level and section (e.g., "Grade
                                3 - Section A") for students, parents, and teachers</li>
                            <li><strong>Subject Groups:</strong> Focused on specific academic subjects like Math Club,
                                Science Enthusiasts, or English Literature</li>
                            <li><strong>Activity Groups:</strong> Sports teams, arts clubs, music groups, and
                                extracurricular activities</li>
                            <li><strong>Parent Groups:</strong> PTA committees, parent volunteers, and grade-level
                                parent communities</li>
                            <li><strong>Alumni Groups:</strong> Graduation year networks and professional interest
                                groups for former students</li>
                            <li><strong>Special Interest Groups:</strong> Environmental clubs, community service, or
                                hobby-based communities</li>
                        </ul><br />

                        <strong>How Groups Work:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Targeted Communications:</strong> Group-specific announcements, discussions, and
                                updates</li>
                            <li><strong>Event Coordination:</strong> Plan and organize group activities, meetings, and
                                events</li>
                            <li><strong>Private Discussions:</strong> Focused conversations relevant to group members
                                only</li>
                            <li><strong>Collaborative Projects:</strong> Work on group assignments, projects, or
                                initiatives</li>
                            <li><strong>Support Networks:</strong> Provide peer support, mentorship, and academic
                                assistance</li>
                        </ul><br />

                        <strong>Group Features:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Member Directory:</strong> View and connect with other group members</li>
                            <li><strong>Discussion Threads:</strong> Organized topic-based conversations</li>
                            <li><strong>Event Calendar:</strong> Group-specific events and meeting schedules</li>
                            <li><strong>Moderation Tools:</strong> Manage content and membership</li>
                        </ul><br />

                        <strong>Access and Privacy:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Content Visibility:</strong> Group content is only visible to approved members
                            </li>
                        </ul><br />

                        <strong>Group Management:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Creation:</strong> Only teachers and administrators can create official school
                                groups</li>
                            <li><strong>Moderation:</strong> Monitor content and ensure appropriate conduct</li>
                        </ul>
                    </div>
                </div>

                <!-- FAQ 8 -->
                <div class="bg-cream-50 rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">8. How do I join or create a group?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <strong>Creating Groups:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Who Can Create:</strong> Only verified teachers and school administrators can
                                create official groups to ensure proper organization and oversight</li>
                            <li><strong>Purpose Requirement:</strong> Groups must serve a legitimate educational,
                                extracurricular, or community purpose</li>
                            <li><strong>Naming Conventions:</strong> Groups follow standard naming formats (e.g., "Grade
                                4 - Science Club" or "PTA - Grade 2 Parents")</li>
                            <li><strong>Initial Setup:</strong> Group creators set initial permissions, description, and
                                membership criteria</li>
                        </ul><br />

                        <strong>Joining Existing Groups:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Automatic Assignment:</strong> Students are often automatically added to their
                                class and grade-level groups</li>
                            <li><strong>Parent Assignment:</strong> Parents may be automatically added to grade-level
                                parent groups based on their child's enrollment</li>
                            <li><strong>Assignment Process:</strong> Teachers and Administrators can assign group to
                                users</li>
                        </ul><br />

                        <strong>Membership Criteria:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Eligibility Verification:</strong> Members must meet group-specific criteria
                                (grade level, parent status, alumni year, etc.)</li>
                            <li><strong>Conduct Standards:</strong> Members must maintain appropriate behavior and
                                follow group guidelines</li>
                            <li><strong>Maximum Capacity:</strong> Groups no size limits</li>
                        </ul><br />

                        <strong>Access Control and Privacy:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Content Visibility:</strong> Group discussions are only visible to approved
                                members</li>
                            <li><strong>Announcement Filtering:</strong> Group members receive targeted announcements
                                relevant to their groups</li>
                        </ul><br />

                        <strong>Important Notes:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Regular Review:</strong> Groups are periodically reviewed to ensure they remain
                                active and relevant</li>
                            <li><strong>Community Standards:</strong> All groups must adhere to school policies and
                                community guidelines</li>
                            <li><strong>Support Available:</strong> Contact group leaders or administrators if you have
                                questions about joining</li>
                        </ul>
                    </div>
                </div>


                <!-- FAQ 9 -->
                <div class="bg-cream-50 rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">9. How does ICSIS protect my personal
                            information and keep interactions safe?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <strong>Data Protection Measures:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Secure Login:</strong> Encrypted authentication with strong password
                                requirements and secure session management</li>
                            <li><strong>Role-Based Access Control:</strong> Users can only access information and
                                features appropriate to their role (student, parent, teacher, graduate)</li>
                            <li><strong>Data Encryption:</strong> All sensitive data is encrypted in transit (HTTPS) and
                                at rest on our servers</li>
                            <li><strong>Regular Security Audits:</strong> Ongoing system monitoring and periodic
                                security assessments</li>
                            <li><strong>Access Restrictions:</strong> Only registered and logged-in users can view
                                member information and participate in community features</li>
                        </ul><br />

                        <strong>Community Safety Features:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>AI Comment Moderation:</strong> Automated scanning of all comments and posts for
                                inappropriate content, with immediate removal of violating content</li>
                            <li><strong>Account Verification:</strong> Mandatory identity verification during
                                registration prevents fake accounts</li>
                            <li><strong>Activity Monitoring:</strong> System logs and monitoring to detect unusual or
                                suspicious activities</li>
                        </ul><br />

                        <strong>Privacy Protections:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Minimal Data Collection:</strong> We only collect information necessary for
                                system functionality and user verification</li>
                            <li><strong>Consent-Based Processing:</strong> All data processing requires explicit user
                                consent</li>
                            <li><strong>Data Retention Limits:</strong> Personal data is retained only as long as
                                necessary for service provision</li>
                            <li><strong>No Third-Party Sharing:</strong> User data is never sold or shared with external
                                companies for marketing purposes</li>
                            <li><strong>Right to Access and Delete:</strong> Users can request to view or delete their
                                personal information</li>
                        </ul><br />

                        <strong>Additional Security Measures:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Regular System Updates:</strong> Continuous security patches and software
                                updates</li>
                            <li><strong>Incident Response:</strong> Established procedures for handling security
                                incidents</li>
                            <li><strong>User Education:</strong> Guidelines and best practices provided to help users
                                protect their accounts</li>
                            <li><strong>Backup and Recovery:</strong> Secure data backup systems to prevent data loss
                            </li>
                        </ul><br />

                        <strong>What We Protect:</strong> Your personal information, login credentials, communication
                        history, profile data, and all interactions within the ICSIS platform are safeguarded through
                        multiple layers of security. We are committed to maintaining a safe, respectful, and private
                        environment for all school community members.
                    </div>
                </div>

                <!-- FAQ 10 -->
                <div class="bg-cream-50 rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">10. Can I access ICSIS on mobile
                            devices?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <strong>Yes! ICSIS is fully optimized for mobile access with comprehensive device
                            support:</strong><br /><br />

                        <strong>Supported Devices and Browsers:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Smartphones:</strong> iPhone (iOS 12+), Android phones (Android 8.0+)</li>
                            <li><strong>Tablets:</strong> iPad, Android tablets, and other modern tablet devices</li>
                            <li><strong>Browsers:</strong> Safari, Chrome, Firefox, Edge, and other modern web browsers
                            </li>
                            <li><strong>Operating Systems:</strong> iOS, Android, and cross-platform compatibility</li>
                        </ul><br />

                        <strong>Mobile Features:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Responsive Design:</strong> Interface automatically adjusts to screen size and
                                orientation</li>
                            <li><strong>Touch-Friendly:</strong> Large buttons, swipe gestures, and intuitive navigation
                            </li>
                            <li><strong>Offline Capability:</strong> Basic viewing of cached content when offline</li>
                            <li><strong>Camera Integration:</strong> Direct access to device camera for profile pictures
                                and uploads</li>
                            <li><strong>Location Services:</strong> Optional location sharing for event check-ins</li>
                        </ul><br />

                        <strong>Mobile-Specific Functionality:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Quick Actions:</strong> One-tap reactions, comments, and sharing</li>
                            <li><strong>Photo Upload:</strong> Direct camera access for sharing photos and documents
                            </li>
                        </ul><br />

                        <strong>Performance Optimization:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Fast Loading:</strong> Optimized for mobile networks and data usage</li>
                            <li><strong>Battery Efficient:</strong> Minimal battery drain with smart caching</li>
                            <li><strong>Data Conscious:</strong> Compressed images and efficient data transfer</li>
                            <li><strong>Low Bandwidth:</strong> Works well on slower mobile connections</li>
                        </ul><br />

                        <strong>Mobile Access Instructions:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Web Access:</strong> Visit the ICSIS website directly through your mobile
                                browser</li>
                            <li><strong>Bookmark:</strong> Save ICSIS to your home screen for quick access</li>
                            <li><strong>App-Like Experience:</strong> Add to home screen for full-screen, app-like
                                functionality</li>
                            <li><strong>Auto-Login:</strong> Stay logged in securely across sessions</li>
                        </ul><br />

                        <strong>Mobile Security:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Secure Connections:</strong> All mobile access uses HTTPS encryption</li>
                            <li><strong>Device Security:</strong> Compatible with device-level security features</li>
                            <li><strong>Session Management:</strong> Automatic logout after periods of inactivity</li>
                        </ul><br />

                        <strong>Troubleshooting Mobile Access:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Browser Updates:</strong> Ensure your browser is up to date</li>
                            <li><strong>Cache Clearing:</strong> Clear browser cache if experiencing issues</li>
                            <li><strong>Network Issues:</strong> Try switching between WiFi and mobile data</li>
                            <li><strong>Support:</strong> Contact IT support for mobile-specific technical assistance
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- FAQ 11 -->
                <div class="bg-cream-50 rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">11. What should I do if I forget my
                            password?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <strong>Password Reset Process:</strong> ICSIS provides a secure, straightforward process to
                        regain access to your account.<br /><br />

                        <strong>Step-by-Step Reset Instructions:</strong>
                        <ol class="list-decimal list-inside mt-2 space-y-2">
                            <li><strong>Access Reset Page:</strong> Click the "Forgot Password?" link on the login page
                            </li>
                            <li><strong>Enter Identifier:</strong> Provide your registered email address or username
                            </li>
                            <li><strong>Check Email:</strong> Look for a password reset email in your inbox (check spam
                                folder if needed)</li>
                            <li><strong>Click Reset Link:</strong> Click the secure reset link in the email (link
                                expires in 24 hours)</li>
                            <li><strong>Create New Password:</strong> Enter a strong new password following the
                                requirements shown</li>
                            <li><strong>Confirm Reset:</strong> Your password is successfully changed and you can log in
                            </li>
                        </ol><br />

                        <strong>Password Requirements:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Minimum Length:</strong> At least 8 characters</li>
                            <li><strong>Complexity:</strong> Include uppercase, lowercase, numbers, and special
                                characters</li>
                            <li><strong>No Personal Info:</strong> Should not contain your name, email, or easily
                                guessable information</li>
                        </ul><br />

                        <strong>Security Features:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Time-Limited Links:</strong> Reset links expire after 24 hours for security</li>
                            <li><strong>One-Time Use:</strong> Each reset link can only be used once</li>
                            <li><strong>IP Tracking:</strong> Unusual reset attempts are monitored</li>
                            <li><strong>Email Verification:</strong> Confirms you have access to the registered email
                            </li>
                        </ul><br />

                        <strong>Troubleshooting Common Issues:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Email Not Received:</strong> Check spam/junk folders, wait 10-15 minutes, or try
                                resending</li>
                            <li><strong>Expired Link:</strong> Request a new reset link if the previous one expired</li>
                            <li><strong>Wrong Email:</strong> Ensure you're using the email address registered with your
                                account</li>
                            <li><strong>Account Locked:</strong> Contact IT support if your account is temporarily
                                locked due to multiple failed attempts</li>
                        </ul><br />

                        <strong>Prevention Tips:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Password Manager:</strong> Use a reputable password manager to store and
                                generate strong passwords</li>
                            <li><strong>Regular Updates:</strong> Change your password periodically for better security
                            </li>
                            <li><strong>Unique Passwords:</strong> Don't reuse passwords across different websites</li>
                            <li><strong>Backup Email:</strong> Set up a recovery email address for additional security
                            </li>
                        </ul><br />

                        <strong>When to Contact Support:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li>Reset email is not received after multiple attempts</li>
                            <li>You don't have access to your registered email</li>
                            <li>You suspect unauthorized access to your account</li>
                            <li>Your account appears to be compromised</li>
                            <li>You need to change your registered email address</li>
                        </ul><br />

                        <strong>Contact Information:</strong> For password reset issues or account recovery assistance,
                        contact the ICSIS Help Desk or school IT coordinator through the support section or by emailing
                        the IT office.
                    </div>
                </div>

                <!-- FAQ 12 -->
                <div class="bg-cream-50 rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">12. What if I encounter technical problems or
                            have questions about ICSIS?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <strong>ICSIS Support System:</strong> We provide comprehensive technical support and assistance
                        for all users.<br /><br />

                        <strong>Primary Support Channels:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>ICSIS Help Desk:</strong> 24/7 online support portal accessible from the login
                                page</li>
                            <li><strong>School IT Coordinator:</strong> Direct technical support for urgent issues</li>
                            <li><strong>Email Support:</strong> <a
                                    href="https://mail.google.com/mail/?view=cm&fs=1&to=irosincentralschool01@gmail.com">irosincentralschool01@gmail.com</a>
                                for detailed inquiries</li>
                            <li><strong>Phone Support:</strong> School office main line during business hours</li>
                            <li><strong>In-App Support:</strong> Help button available throughout the platform</li>
                        </ul><br />

                        <strong>Types of Issues We Assist With:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Account Problems:</strong> Login issues, password resets, profile updates</li>
                            <li><strong>Technical Difficulties:</strong> Browser compatibility, mobile access, slow
                                loading</li>
                            <li><strong>Feature Questions:</strong> How-to guides, functionality explanations</li>
                            <li><strong>Content Issues:</strong> Missing posts, incorrect information, display problems
                            </li>
                            <li><strong>Security Concerns:</strong> Suspicious activity, privacy questions</li>
                            <li><strong>Group Management:</strong> Joining groups, permissions, group settings</li>
                        </ul><br />

                        <strong>Self-Help Resources:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>FAQ Section:</strong> Comprehensive answers to common questions</li>
                            <li><strong>User Guides:</strong> Step-by-step tutorials and video walkthroughs</li>
                            <li><strong>Troubleshooting Tips:</strong> Common solutions for frequent issues</li>
                            <li><strong>System Status:</strong> Real-time updates on platform availability</li>
                            <li><strong>Community Forums:</strong> User-to-user support and tips</li>
                        </ul><br />

                        <strong>Support Response Times:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Urgent Issues:</strong> Account security, complete system outages - within 1
                                hour</li>
                            <li><strong>High Priority:</strong> Login problems, data loss - within 4 hours</li>
                            <li><strong>Standard Support:</strong> Feature questions, general inquiries - within 24
                                hours</li>
                            <li><strong>Enhancement Requests:</strong> New features, improvements - reviewed weekly</li>
                        </ul><br />

                        <strong>How to Submit a Support Request:</strong>
                        <ol class="list-decimal list-inside mt-2 space-y-2">
                            <li><strong>Identify the Issue:</strong> Clearly describe the problem and steps to reproduce
                                it</li>
                            <li><strong>Provide Details:</strong> Include your device type, browser, error messages, and
                                screenshots</li>
                            <li><strong>Choose Contact Method:</strong> Use the most appropriate channel for your issue
                            </li>
                            <li><strong>Include Context:</strong> Mention when the issue started and any recent changes
                            </li>
                            <li><strong>Follow Up:</strong> Keep your support ticket number for reference</li>
                        </ol><br />

                        <strong>Prevention and Best Practices:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Regular Updates:</strong> Keep your browser and devices updated</li>
                            <li><strong>Clear Cache:</strong> Regularly clear browser cache and cookies</li>
                            <li><strong>Use Supported Browsers:</strong> Chrome, Firefox, Safari, or Edge</li>
                            <li><strong>Strong Connection:</strong> Use stable internet for best performance</li>
                            <li><strong>Report Early:</strong> Address issues promptly to prevent escalation</li>
                        </ul><br />

                        <strong>Emergency Contacts:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>System Outages:</strong> Check status page or contact IT coordinator directly
                            </li>
                            <li><strong>Security Incidents:</strong> Report immediately to prevent data compromise</li>
                            <li><strong>Data Loss:</strong> Contact support within 24 hours for recovery options</li>
                        </ul><br />

                        <strong>Feedback and Suggestions:</strong> We welcome user feedback to improve ICSIS. Share your
                        suggestions through the feedback form or contact support with enhancement ideas.
                    </div>
                </div>

                <!-- FAQ 13 -->
                <div class="bg-cream-50 rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">13. Where can I learn more about Irosin Central
                            School?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <strong>Comprehensive School Information Resources:</strong> Irosin Central School provides
                        multiple channels for learning about our institution, history, programs, and
                        community.<br /><br />

                        <strong>ICSIS Platform Resources:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>About Us Section:</strong> Complete school history, mission, vision, and core
                                values</li>
                            <li><strong>News Feed:</strong> Current events, achievements, and school announcements</li>
                            <li><strong>Team Directory:</strong> Meet our teachers, administrators, and support staff
                            </li>
                            <li><strong>Event Calendar:</strong> Upcoming school events, holidays, and important dates
                            </li>
                        </ul><br />

                        <strong>Official School Website:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Admission Information:</strong> Enrollment procedures, requirements, and
                                deadlines</li>
                            <li><strong>School Facilities:</strong> Campus tour, classrooms, laboratories, and amenities
                            </li>
                            <li><strong>Student Life:</strong> Clubs, sports, extracurricular activities, and student
                                organizations</li>
                            <li><strong>Parent Resources:</strong> PTA information, volunteer opportunities, and family
                                engagement</li>
                        </ul><br />

                        <strong>Community and Social Media:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Official Facebook Page:</strong> Daily updates, event announcements, and
                                community interaction</li>
                            <li><strong>Alumni Network:</strong> Connect with former students and stay updated on school
                                developments</li>
                        </ul><br />

                        <strong>Direct Engagement Opportunities:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Open House Events:</strong> Visit the campus, meet teachers, and experience
                                school life</li>
                            <li><strong>Parent-Teacher Conferences:</strong> Direct interaction with teachers and
                                administrators</li>
                            <li><strong>School Tours:</strong> Guided campus tours for prospective students and families
                            </li>
                            <li><strong>Community Meetings:</strong> PTA meetings and town hall sessions</li>
                            <li><strong>Volunteer Programs:</strong> Hands-on involvement in school activities</li>
                        </ul><br />

                        <strong>Contact Information for More Details:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Main Office:</strong> Call or visit for comprehensive information packages</li>
                            <li><strong>Admissions Office:</strong> Specific questions about enrollment and programs
                            </li>
                            <li><strong>School Principal:</strong> Leadership vision and school direction</li>
                            <li><strong>PTA President:</strong> Parent perspective and community involvement</li>
                        </ul><br />

                        <strong>Additional Resources:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Local Government:</strong> Municipal education office for regional context</li>
                            <li><strong>Department of Education:</strong> National education standards and policies</li>
                            <li><strong>Educational Partners:</strong> Information about affiliated organizations and
                                programs</li>
                            <li><strong>Reference Materials:</strong> Books, articles, and research about the school's
                                history</li>
                        </ul>
                    </div>
                </div>

                <!-- FAQ 14 -->
                <div class="bg-cream-50 rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">14. Can I update my profile information?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <strong>Yes! ICSIS allows users to maintain accurate and current profile information with some
                            security restrictions.</strong><br /><br />

                        <strong>Information You Can Update:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Email Address:</strong> Primary contact email for verification email, OTP and
                                password recovery</li>
                            <li><strong>Profile Picture:</strong> Upload or update your profile photo (must meet
                                verification standards)</li>
                        </ul><br />

                        <strong>Restricted Information (Cannot Be Changed Directly):</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Full Legal Name:</strong> To prevent identity confusion and maintain record
                                accuracy</li>
                            <li><strong>Contact Number:</strong> Primary phone number used for verification and
                                emergency contact</li>
                            <li><strong>User Role:</strong> Student, parent, teacher, or graduate status (managed by
                                administrators)</li>
                            <li><strong>Enrollment Status:</strong> Current school enrollment and grade level
                                information</li>
                        </ul><br />

                        <strong>How to Update Your Profile:</strong>
                        <ol class="list-decimal list-inside mt-2 space-y-2">
                            <li><strong>Access Profile Settings:</strong> Click your profile in the top navigation</li>
                            <li><strong>Make Changes:</strong> Update the allowed fields with your new information</li>
                            <li><strong>Save Changes:</strong> Click "Save" or "Update Profile" to apply changes</li>
                        </ol><br />

                        <strong>Requesting Changes to Restricted Information:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Formal Request Process:</strong> Submit a written request through the school's
                                administration office</li>
                            <li><strong>Required Documentation:</strong> Provide supporting documents (ID, court orders,
                                marriage certificates, etc.)</li>
                            <li><strong>Verification Process:</strong> Changes are reviewed and verified by school
                                administrators</li>
                            <li><strong>Processing Time:</strong> Requests typically take 3-5 business days to process
                            </li>
                            <li><strong>Notification:</strong> You'll be notified via email when changes are approved
                                and applied</li>
                        </ul><br />

                        <strong>Profile Picture Guidelines:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Clear Photo:</strong> Face must be clearly visible and well-lit</li>
                            <li><strong>Appropriate Content:</strong> School-appropriate attire and background</li>
                            <li><strong>File Format:</strong> JPG, PNG, or GIF formats accepted</li>
                            <li><strong>Verification:</strong> Profile pictures may need to match ID verification photos
                            </li>
                        </ul><br />

                        <strong>Privacy Considerations:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Information Visibility:</strong> Choose what information is visible to other
                                users</li>
                            <li><strong>Activity Privacy:</strong> Control whether your posts and comments are publicly
                                visible</li>
                            <li><strong>Contact Permissions:</strong> Decide who can send you messages or friend
                                requests</li>
                        </ul><br />

                        <strong>Important Notes:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Regular Updates:</strong> Keep your contact information current for important
                                communications</li>
                            <li><strong>Accuracy Matters:</strong> Ensure all profile information is truthful and
                                accurate</li>
                            <li><strong>Security First:</strong> Never share sensitive information in public profile
                                fields</li>
                            <li><strong>Backup Contact:</strong> Consider adding a secondary email for account recovery
                            </li>
                        </ul><br />

                        <strong>Need Help?</strong> If you encounter issues updating your profile or need to request
                        changes to restricted information, contact the ICSIS Help Desk or school administration for
                        assistance.
                    </div>
                </div>

                <!-- FAQ 15 -->
                <div class="bg-cream-50 rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">15. Will I receive notifications for new
                            updates?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <strong>Yes! ICSIS provides comprehensive notification system to keep you informed and
                            engaged.</strong><br /><br />

                        <strong>Types of Notifications You Receive:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>News Updates:</strong> New articles, school announcements, and important news
                                posts</li>
                        </ul><br />

                        <strong>Privacy and Security:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Secure Delivery:</strong> All notifications are encrypted and securely
                                transmitted</li>
                            <li><strong>No Data Sharing:</strong> Notification preferences are not shared with third
                                parties</li>
                            <li><strong>Opt-Out Options:</strong> You can unsubscribe from non-essential notifications
                                anytime</li>
                        </ul><br />
                    </div>
                </div>

                <!-- FAQ 16 -->
                <div class="bg-cream-50 rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">16. Why are all members of the school displayed
                            on the Irosin Central School Information System?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <strong>Community Transparency and Engagement:</strong> The member directory is a core feature
                        designed to build a connected, supportive school community while maintaining appropriate privacy
                        protections.<br /><br />

                        <strong>Primary Purposes of Member Display:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Community Building:</strong> Helps students, parents, teachers, and alumni
                                connect and build relationships</li>
                            <li><strong>Transparency:</strong> Demonstrates the school's commitment to openness and
                                accountability</li>
                            <li><strong>Record Accuracy:</strong> Ensures all community members are properly documented
                                and verified</li>
                            <li><strong>Communication Facilitation:</strong> Enables appropriate communication channels
                                between stakeholders</li>
                            <li><strong>Support Networks:</strong> Allows formation of peer support groups and
                                mentorship opportunities</li>
                            <li><strong>Event Coordination:</strong> Supports organization of school events and group
                                activities</li>
                        </ul><br />

                        <strong>Who Can View Member Information:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Registered Users Only:</strong> Only verified, logged-in users can access the
                                member directory</li>
                        </ul><br />

                        <strong>Information Display Levels:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Basic Profile:</strong> Name, role, grade/section (for students), profile
                                picture</li>
                            <li><strong>Contact Information:</strong> Limited to school-related contact methods</li>
                        </ul><br />

                        <strong>Privacy Protections in Place:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Sensitive Data Hidden:</strong> Personal addresses, phone numbers, and other
                                private information are not displayed</li>
                            <li><strong>Access Controls:</strong> Users can only message others through approved school
                                channels</li>
                            <li><strong>Moderation Oversight:</strong> All interactions are monitored for appropriate
                                conduct</li>
                            <li><strong>Data Minimization:</strong> Only necessary information is shared for community
                                functionality</li>
                        </ul><br />

                        <strong>Educational and Social Benefits:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Peer Learning:</strong> Students can connect with others in similar classes or
                                interests</li>
                            <li><strong>Parent Networking:</strong> Parents can connect with other parents of children
                                in the same grade</li>
                            <li><strong>Teacher Collaboration:</strong> Educators can easily identify colleagues and
                                collaborators</li>
                            <li><strong>Alumni Connections:</strong> Graduates can maintain relationships with their
                                alma mater</li>
                            <li><strong>Mentorship Programs:</strong> Facilitates matching mentors with students who
                                need guidance</li>
                        </ul><br />

                        <strong>School Community Advantages:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Emergency Communications:</strong> Verified member list for urgent notifications
                            </li>
                            <li><strong>Event Planning:</strong> Accurate attendance tracking and communication</li>
                            <li><strong>Resource Sharing:</strong> Easy identification of who needs or can provide
                                assistance</li>
                            <li><strong>Accountability:</strong> Clear record of all school community members</li>
                            <li><strong>Inclusion:</strong> Ensures no one is left out of important communications</li>
                        </ul><br />

                        <strong>Managing Your Visibility:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Profile Settings:</strong> Control what information is displayed in your profile
                            </li>
                        </ul><br />

                        <strong>Questions or Concerns:</strong> If you have specific concerns about member visibility or
                        privacy, please contact the school administration or data protection officer for clarification
                        and assistance.
                    </div>
                </div>

                <!-- FAQ 17 -->
                <div class="bg-cream-50 rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">17. What is the face detection feature during
                            registration and how does it work?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <strong>Face Detection</strong> is an advanced security feature used during user registration to
                        capture and verify profile pictures. Here's how it works:<br><br>

                        <strong>Process:</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Camera Access:</strong> Users grant camera permission to start the process</li>
                            <li><strong>Liveness Detection:</strong> The system performs three validation steps:
                                <ul class="list-disc list-inside ml-6 mt-1 space-y-1">
                                    <li>👤 <strong>Face Verification:</strong> Users must keep only one face in view
                                    </li>
                                    <li>😊 <strong>Smile Detection:</strong> Users must smile at the camera</li>
                                    <li>👁️ <strong>Blink Detection:</strong> Users must blink their eyes</li>
                                </ul>
                            </li>
                            <li><strong>Photo Capture:</strong> After successful validation, a profile picture is
                                automatically captured</li>
                            <li><strong>ID Verification:</strong> The captured photo is compared with uploaded ID images
                                to ensure they match</li>
                        </ul><br>

                        <strong>Why Face Detection?</strong>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li>🔒 <strong>Security:</strong> Prevents fake accounts and ensures real user registration
                            </li>
                            <li>🎯 <strong>Verification:</strong> Confirms the person registering matches their ID
                                documents</li>
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

                        <strong>Privacy & Security:</strong> All face detection happens locally in your browser. Images
                        are only used for verification and are securely stored on our servers. No third-party services
                        process your facial data.
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">18. What are the limitations of the ICSI
                            System?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        While ICSIS provides a comprehensive platform for school communication and management, it has
                        some limitations to consider:
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Internet Dependency:</strong> The system requires a stable internet connection
                                for access and functionality.</li>
                            <li><strong>Device Requirements:</strong> Face detection during registration needs a device
                                with a camera and a modern web browser (Chrome, Firefox, Safari, or Edge).</li>
                            <li><strong>Browser Compatibility:</strong> Older browsers or those without camera support
                                may not fully support all features like face detection.</li>
                            <li><strong>AI Moderation Accuracy:</strong> The comment moderation system uses AI, which
                                may occasionally flag appropriate content or miss inappropriate content.</li>
                            <li><strong>Notification Delivery:</strong> Notifications depend on user settings, network
                                conditions, and may not reach users if email/SMS services are unavailable.</li>
                            <li><strong>Institution-Specific:</strong> The system is tailored for Irosin Central School
                                and may require customization for other institutions.</li>
                            <li><strong>User Verification Time:</strong> Account approvals and verifications may take
                                time depending on administrative review.</li>
                            <li><strong>No Offline Access:</strong> The platform does not support offline functionality.
                            </li>
                            <li><strong>Mobile Experience:</strong> While responsive, it's web-based and not a native
                                mobile app, which may limit some advanced mobile features.</li>
                            <li><strong>Data Retention:</strong> User data is subject to school policies and may be
                                retained or deleted according to institutional guidelines.</li>
                        </ul>
                    </div>
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
                            At Irosin Central School Information System (ICSIS), we are committed to protecting your
                            privacy and ensuring the security of your personal information. This Privacy Policy outlines
                            how we collect, use, protect, and manage your data in compliance with applicable laws and
                            regulations. By using ICSIS, you agree to the practices described in this policy.
                        </p>
                    </div>

                    <!-- Data Collection -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Data Collection</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            We collect personal information necessary to provide our services, including:
                        </p>
                        <ul class="list-disc list-inside mt-4 space-y-2 text-gray-600">
                            <li><strong>Registration Information:</strong> Name, email, contact number, and relationship
                                details (for parents/guardians)</li>
                            <li><strong>Profile Pictures:</strong> Captured via face detection during registration for
                                verification purposes</li>
                            <li><strong>Identification Documents:</strong> Government-issued IDs submitted for
                                verification</li>
                            <li><strong>Usage Data:</strong> Login activity, interactions (comments, reactions), and
                                group memberships</li>
                            <li><strong>Device Information:</strong> Browser type, IP address, and device details for
                                security and analytics</li>
                        </ul>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            All data collection is performed with user consent and follows strict verification processes
                            to ensure authenticity.
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
                            <li><strong>Role-Based Access Control:</strong> Users can only access information
                                appropriate to their role</li>
                            <li><strong>AI Comment Moderation:</strong> Automated filtering of inappropriate content
                            </li>
                            <li><strong>Regular System Updates:</strong> Ongoing security patches and improvements</li>
                            <li><strong>Data Encryption:</strong> All sensitive data is encrypted in transit and at rest
                            </li>
                            <li><strong>Access Restrictions:</strong> Only registered and logged-in users can view
                                member information</li>
                        </ul>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            We regularly audit our systems and update our security practices to address emerging
                            threats.
                        </p>
                    </div>

                    <!-- User Rights -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Your Rights and Choices</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            You have the following rights regarding your personal information:
                        </p>
                        <ul class="list-disc list-inside mt-4 space-y-2 text-gray-600">
                            <li><strong>Access and Update:</strong> You can view and update most profile information,
                                except name and contact number which require formal requests</li>
                            <li><strong>Data Portability:</strong> Request a copy of your personal data in a structured
                                format</li>
                            <li><strong>Data Deletion:</strong> Request deletion of your account and associated data,
                                subject to legal and operational requirements</li>
                            <li><strong>Consent Withdrawal:</strong> Opt-out of non-essential communications and data
                                processing</li>
                            <li><strong>Complaint Filing:</strong> Report privacy concerns to our data protection
                                officer</li>
                        </ul>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            To exercise these rights or make changes to restricted fields, please contact the school
                            administration or IT coordinator.
                        </p>
                    </div>

                    <!-- Face Detection Privacy -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Face Detection and Biometric Data</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            Our face detection feature is used solely for user verification during registration:
                        </p>
                        <ul class="list-disc list-inside mt-4 space-y-2 text-gray-600">
                            <li><strong>Local Processing:</strong> Face detection occurs entirely in your browser; no
                                data is sent to external servers</li>
                            <li><strong>Limited Use:</strong> Facial data is only used for identity verification and
                                profile picture capture</li>
                            <li><strong>No Third-Party Sharing:</strong> We do not share facial recognition data with
                                any third-party services</li>
                            <li><strong>Data Retention:</strong> Facial images are securely stored and used only for
                                account verification purposes</li>
                            <li><strong>Consent Required:</strong> Camera access and face detection require explicit
                                user permission</li>
                        </ul>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            This feature enhances security by preventing fake accounts while maintaining user privacy.
                        </p>
                    </div>

                    <!-- Community Visibility -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Community Information Display</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            To foster transparency and community engagement, member information (students, parents,
                            teachers, alumni) is displayed within ICSIS. This visibility:
                        </p>
                        <ul class="list-disc list-inside mt-4 space-y-2 text-gray-600">
                            <li>Helps users connect with peers and access relevant group features</li>
                            <li>Supports accurate record-keeping and communication</li>
                            <li>Is restricted to registered, logged-in users only</li>
                            <li>Includes privacy measures to protect sensitive personal data</li>
                        </ul>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            We balance community benefits with privacy protection, ensuring that only necessary
                            information is shared.
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
                            <li><strong>School IT Coordinator:</strong> Contact information available in the About Us
                                section</li>
                            <li><strong>Data Protection Officer:</strong> Reach out via the school's administration
                                office</li>
                        </ul>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            We are committed to addressing your privacy concerns promptly and transparently.
                        </p>
                    </div>

                    <!-- Policy Updates -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Policy Updates</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            This Privacy Policy may be updated periodically to reflect changes in our practices or legal
                            requirements. We will notify users of significant changes through the ICSIS portal or via
                            email. Continued use of ICSIS after updates constitutes acceptance of the revised policy.
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
                            By accessing and using the Irosin Central School Information System (ICSIS), you accept and
                            agree to be bound by the terms and provision of this agreement. If you do not agree to abide
                            by the above, please do not use this service.
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
                            Students are pre-registered by school administrators. Parents and graduates must register
                            themselves and provide valid identification for verification. All users must complete the
                            face detection verification process during registration.
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
                            <li>Use the system only for lawful purposes related to school communication and information
                                sharing</li>
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
                            ICSIS employs AI-powered content moderation to maintain a respectful community environment.
                            Comments and posts are automatically scanned for:
                        </p>
                        <ul class="list-disc list-inside mt-4 space-y-2 text-gray-600">
                            <li>Rude, offensive, or inappropriate language</li>
                            <li>Harmful or discriminatory content</li>
                            <li>Spam or irrelevant posts</li>
                            <li>Violations of school policies</li>
                        </ul>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            Violating content may be removed, and repeated violations may result in temporary or
                            permanent suspension of commenting privileges or account access. Users are responsible for
                            the content they post and engage with.
                        </p>
                    </div>

                    <!-- Group Membership and Access -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Group Membership and Access Control</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            Groups are created and managed by school administrators and teachers to organize community
                            discussions and information sharing. Users may request to join groups, but membership
                            requires administrative approval. Group access controls ensure that:
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
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Account Security and Identity
                            Verification</h3>
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
                            Users must immediately report any suspected unauthorized access to their accounts. The
                            school reserves the right to verify user identities at any time and suspend accounts that
                            cannot be properly verified.
                        </p>
                    </div>

                    <!-- Service Availability -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Service Availability and Technical
                            Support</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            ICSIS strives to provide reliable access to the platform, but service availability may be
                            affected by:
                        </p>
                        <ul class="list-disc list-inside mt-4 space-y-2 text-gray-600">
                            <li>Scheduled maintenance periods</li>
                            <li>Technical issues or system updates</li>
                            <li>Internet connectivity problems</li>
                            <li>Force majeure events beyond our control</li>
                        </ul>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            Technical support is available through the ICSIS Help Desk and school IT coordinator. Users
                            experiencing technical difficulties should contact support immediately for assistance.
                        </p>
                    </div>

                    <!-- Limitation of Liability -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Limitation of Liability</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            ICSIS and Irosin Central School provide the platform "as is" without warranties of any kind.
                            We are not liable for:
                        </p>
                        <ul class="list-disc list-inside mt-4 space-y-2 text-gray-600">
                            <li>Indirect, incidental, or consequential damages</li>
                            <li>Loss of data or information</li>
                            <li>Service interruptions or technical issues</li>
                            <li>User-generated content or interactions</li>
                        </ul>
                        <p class="text-gray-600 text-lg leading-relaxed mt-4">
                            Users assume all responsibility for their use of the platform and interactions with other
                            users.
                        </p>
                    </div>

                    <!-- Termination -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Account Termination</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            The school reserves the right to suspend or terminate user accounts for violations of these
                            terms, school policies, or inappropriate conduct. Users may also request account deletion at
                            any time. Upon termination:
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
                            These terms are governed by the laws of the Republic of the Philippines. Any disputes
                            arising from the use of ICSIS will be resolved through the school's administrative
                            procedures and, if necessary, through appropriate legal channels.
                        </p>
                    </div>

                    <!-- Updates to Terms -->
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Updates to Terms and Conditions</h3>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            These terms may be updated periodically to reflect changes in school policies, legal
                            requirements, or system functionality. Users will be notified of significant changes through
                            the platform or via email. Continued use of ICSIS after updates constitutes acceptance of
                            the revised terms.
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
                            <li><strong>School Administration:</strong> Contact the principal's office for
                                policy-related concerns</li>
                            <li><strong>IT Coordinator:</strong> For technical and access-related issues</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </section>

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
