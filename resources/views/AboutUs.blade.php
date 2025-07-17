<x-layouts.custome.header>
    <!-- index.html -->
    <script src="https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.12.0/firebase-messaging.js"></script>

    <script>
        const firebaseConfig = {
            apiKey: "AIzaSyBomSVQcMytesRLPUZgz9I-MVuQt5yEKCQ",
            authDomain: "fb1-tst.firebaseapp.com",
            projectId: "fb1-tst",
            storageBucket: "fb1-tst.appspot.com",
            messagingSenderId: "426139628396",
            appId: "1:426139628396:web:52ec020c8d45e26c53b949"
        };

        firebase.initializeApp(firebaseConfig);

        const messaging = firebase.messaging();

        messaging.requestPermission()
            .then(() => messaging.getToken({
                vapidKey: 'BLJJr71stgKSHvCXc3CzT4xpi7XEzzxlP7go-fAEmN0aVqFGkF7IrFr1v8McqDrebAPHf2awcAfa-Wd2ylOCDG4'
            }))
            .then((token) => {
                console.log("Token:", token);
                // Send token to your Laravel API
                fetch('/send-notification', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        fcm_token: token
                    })
                });
            })
            .catch(console.error);

        messaging.onMessage((payload) => {
            console.log('Message received. ', payload);
            // Show notification manually if needed
            new Notification(payload.notification.title, {
                body: payload.notification.body
            });
        });
    </script>

    <section class="bg-white py-16">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Our History / Kasaysayan ng Paaralan</h2>

            <div class="bg-gray-50 p-8 rounded-xl shadow hover:shadow-md transition max-w-4xl mx-auto">
                <div class="flex items-center gap-4 mb-6">
                    <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8c1.657 0 3-1.79 3-4s-1.343-4-3-4-3 1.79-3 4 1.343 4 3 4zM19 8v2a3 3 0 01-3 3h-4v6h2m0 0h4v2a1 1 0 01-1 1H6a1 1 0 01-1-1v-2h4m2 0v-6H8a3 3 0 01-3-3V8" />
                    </svg>
                    <h3 class="text-2xl font-semibold text-gray-700">Our History</h3>
                </div>
                <p class="text-gray-600 text-lg leading-relaxed">
                    Established in 1950, Irosin Central School began as a small community institution serving a handful
                    of
                    barangays in the area. Over the years, it has grown into a respected educational center known for
                    its
                    commitment to academic excellence and holistic student development.<br><br>
                    The school has continuously evolved with modernization efforts, expanding facilities, and dedicated
                    educators who foster a nurturing environment for learners to thrive.<br><br>
                    Through decades of service, ICS remains a pillar of the community, producing graduates who
                    contribute
                    positively to society.
                </p>

                <div class="flex items-center gap-4 mt-10 mb-6">
                    <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8c1.657 0 3-1.79 3-4s-1.343-4-3-4-3 1.79-3 4 1.343 4 3 4zM19 8v2a3 3 0 01-3 3h-4v6h2m0 0h4v2a1 1 0 01-1 1H6a1 1 0 01-1-1v-2h4m2 0v-6H8a3 3 0 01-3-3V8" />
                    </svg>
                    <h3 class="text-2xl font-semibold text-gray-700">Kasaysayan ng Paaralan</h3>
                </div>
                <p class="text-gray-600 text-lg leading-relaxed">
                    Itinatag noong 1950, ang Irosin Central School ay nagsimula bilang maliit na paaralan para sa ilang
                    barangay sa paligid. Sa paglipas ng panahon, lumago ito bilang isang kilalang institusyong
                    pang-edukasyon na may dedikasyon sa kahusayan sa pag-aaral at kabuuang pag-unlad ng
                    mag-aaral.<br><br>
                    Patuloy na umuunlad ang paaralan sa pamamagitan ng mga modernisasyon, pagpapalawak ng mga pasilidad,
                    at mga guro na nagbibigay ng maayos na kapaligiran para sa pag-unlad ng mga mag-aaral.<br><br>
                    Sa loob ng maraming dekada, nananatili ang ICS bilang haligi ng komunidad na lumalago at lumilikha
                    ng mga mag-aaral na may positibong ambag sa lipunan.
                </p>
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Our Mission & Vision / Aming Misyon at Bisyon
            </h2>

            <div class="grid md:grid-cols-2 gap-8">

                <!-- Mission -->
                <div class="bg-gray-50 p-8 rounded-xl shadow hover:shadow-md transition">
                    <div class="flex items-center gap-4 mb-4">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-2xl font-semibold text-gray-700">Our Mission / Aming Misyon</h3>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        To empower individuals and communities by delivering innovative and impactful solutions that
                        inspire growth, inclusivity, and sustainability.<br><br>
                        <span class="font-semibold">Upang bigyang-lakas ang mga indibidwal at komunidad sa pamamagitan
                            ng paghahatid ng mga makabago at makabuluhang solusyon na naghihikayat ng paglago,
                            pagkakapantay-pantay, at pagpapanatili.</span>
                    </p>
                </div>

                <!-- Vision -->
                <div class="bg-gray-50 p-8 rounded-xl shadow hover:shadow-md transition">
                    <div class="flex items-center gap-4 mb-4">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8c1.657 0 3-1.79 3-4s-1.343-4-3-4-3 1.79-3 4 1.343 4 3 4zM19 8v2a3 3 0 01-3 3h-4v6h2m0 0h4v2a1 1 0 01-1 1H6a1 1 0 01-1-1v-2h4m2 0v-6H8a3 3 0 01-3-3V8" />
                        </svg>
                        <h3 class="text-2xl font-semibold text-gray-700">Our Vision / Aming Bisyon</h3>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        To be a global leader in fostering creativity, innovation, and connection—shaping a better
                        future through bold ideas and inclusive progress.<br><br>
                        <span class="font-semibold">Maging isang pandaigdigang lider sa pagsusulong ng pagkamalikhain,
                            inobasyon, at koneksyon—nagbibigay-hugis sa mas magandang kinabukasan sa pamamagitan ng
                            matapang na mga ideya at inklusibong pag-unlad.</span>
                    </p>
                </div>

            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Our Core Values / Mga Pundamental na Halaga
            </h2>

            <div class="grid md:grid-cols-4 gap-8 text-center">

                <div class="bg-gray-50 p-8 rounded-xl shadow hover:shadow-md transition">
                    <div class="flex justify-center mb-4">
                        <!-- New icon: Heart for Maka-Diyos -->
                        <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 21c-4.97-4.74-8-7.58-8-10.5a4 4 0 018-2.5 4 4 0 018 2.5c0 2.92-3.03 5.76-8 10.5z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Maka-Diyos</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Upholding faith and spirituality as the foundation of all our actions and decisions.<br>
                        <span class="font-semibold">Pagtataguyod ng pananampalataya at espiritwalidad bilang pundasyon
                            ng lahat ng aming gawain at desisyon.</span>
                    </p>
                </div>

                <div class="bg-gray-50 p-8 rounded-xl shadow hover:shadow-md transition">
                    <div class="flex justify-center mb-4">
                        <!-- New icon: Hands shaking for Maka-Tao -->
                        <svg class="w-12 h-12 text-pink-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 17l-3-3 1.5-1.5M14 7l3 3-1.5 1.5M5 12l7 7 7-7" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Maka-Tao</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Respecting human dignity and promoting compassion, justice, and unity among people.<br>
                        <span class="font-semibold">Paggalang sa dignidad ng tao at pagtataguyod ng malasakit,
                            katarungan, at pagkakaisa sa lahat.</span>
                    </p>
                </div>

                <div class="bg-gray-50 p-8 rounded-xl shadow hover:shadow-md transition">
                    <div class="flex justify-center mb-4">
                        <!-- New icon: Leaf for Maka-Kalikasan -->
                        <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 22s8-4 8-10a8 8 0 00-16 0c0 6 8 10 8 10z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Maka-Kalikasan</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Caring for the environment and promoting sustainable use of natural resources.<br>
                        <span class="font-semibold">Pangangalaga sa kalikasan at pagtataguyod ng napapanatiling
                            paggamit
                            ng likas na yaman.</span>
                    </p>
                </div>

                <div class="bg-gray-50 p-8 rounded-xl shadow hover:shadow-md transition">
                    <div class="flex justify-center mb-4">
                        <!-- New icon: Flag for Maka-Bansa -->
                        <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v18l14-9L5 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Maka-Bansa</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Demonstrating patriotism and working towards national development and pride.<br>
                        <span class="font-semibold">Pagpapakita ng pagmamahal sa bayan at pagtutulungan para sa
                            pambansang pag-unlad at dangal.</span>
                    </p>
                </div>

            </div>
        </div>
    </section>


    <section class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-16">Our School Team</h2>

            <div id="teamSections" class="space-y-16"></div>
        </div>
    </section>


    <section class="bg-gray-100 py-16">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Frequently Asked Questions</h2>

            <div class="space-y-4" id="faqAccordion">

                <!-- FAQ 1 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">1. What is the Irosin Central School
                            Information System (ICSIS)?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        ICSIS is an online platform designed to make school information and communication easier for
                        students, parents, teachers, graduates, and school staff. It centralizes important features like
                        school news, announcements, calendar events, document requests, community groups, and more—all
                        in one secure place.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">2. Who can use ICSIS?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        ICSIS is accessible to:
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Students</strong> currently enrolled at Irosin Central School</li>
                            <li><strong>Parents or guardians</strong> of students</li>
                            <li><strong>Graduates</strong> who want to stay connected</li>
                            <li><strong>Teachers and school administrators</strong> who manage records and
                                communications</li>
                        </ul>
                        Each user type has specific roles and permissions to ensure secure and appropriate access.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">3. How do I log in and create an account on
                            ICSIS?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Students are pre-registered by the school administrator and will receive their login credentials
                        directly.<br /><br />
                        Parents and graduates need to register themselves on the ICSIS registration page.<br />
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li>Parents must use the same contact number that the student has listed as the guardian’s
                                emergency contact to specify their relationship to the student for verification.</li>
                            <li>Graduates should provide their details as part of the registration process.</li>
                            <li>Both graduates and parents are required to submit a valid ID from Irosin Central School
                                or another valid government-issued ID for verification by the school administrator.</li>
                        </ul>
                        After registering, check your email and complete the verification process to activate your
                        account. This ensures your email address is valid and secures your access.<br /><br />
                        Keep your login details confidential to protect your personal information.
                    </div>
                </div>


                <!-- FAQ 4 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">4. What kind of information can I find in the
                            News, Announcements, and Calendar Events sections?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <strong>News:</strong> Latest school happenings, student achievements, program launches, and
                        updates.
                        <br /><br />
                        <strong>Announcements:</strong> Official statements or reminders from school officials, such as
                        schedule changes or policy updates.
                        <br /><br />
                        <strong>Calendar Events:</strong> Upcoming school events, holidays, exams, parent meetings, and
                        other important dates to help you stay organized.
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">5. Can I interact with the news and
                            announcements?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Yes! Users can react with emojis (like, love, etc.) and comment on posts to engage with the
                        school community and share feedback.
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">6. Are there any rules or filters for
                            commenting?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Yes. ICSIS uses an AI-powered moderation system that scans comments for rude, offensive, or
                        inappropriate language. Violating comments may be removed and users may lose commenting
                        privileges if issues persist.
                    </div>
                </div>

                <!-- FAQ 7 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">7. How do I request official school documents
                            through ICSIS?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <b>(Parent)</b> can request documents like Form 137 (Student Permanent Record), Form 138 (Report
                        Card), and
                        Certificate of Good Moral by filling out an online form. The school will process your request
                        and notify you when your document is ready.
                    </div>
                </div>

                <!-- FAQ 8 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">8. Who can request documents?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Parents can submit document requests. Requests must come
                        from authorized users and contact details should be kept updated for smooth processing.
                    </div>
                </div>

                <!-- FAQ 9 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">9. What are the groups in ICSIS, and how do
                            they work?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        <b>Groups</b> are community spaces where parents, students, and graduates connect based on
                        shared
                        classes, interests, or activities. They help organize discussions, resource sharing,
                        announcements, and events. A <b>"My Groups"</b> button is available for users to quickly access
                        the
                        groups they have already joined. Within these groups, users can easily stay updated with the
                        latest announcements and upcoming events relevant to their communities.
                    </div>
                </div>

                <!-- FAQ 10 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">10. How do I join or create a group?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Only school administrators and teachers can create groups to avoid redundancy and maintain
                        organization
                        within ICSIS. Users can request to join groups, but group membership requires admin approval.
                        Groups filter access so that only members can view updates in announcements and calendar events
                        related to that group. Please note that news posts are public and visible to all users
                        regardless of group membership.
                    </div>
                </div>


                <!-- FAQ 11 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">11. How does ICSIS protect my personal
                            information and keep interactions safe?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        ICSIS employs secure login, role-based access control, AI comment moderation, and regular system
                        updates to safeguard your data and maintain a respectful community.
                    </div>
                </div>

                <!-- FAQ 12 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">12. Can I access ICSIS on mobile
                            devices?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Yes! ICSIS is mobile-friendly and works smoothly on smartphones and tablets via web browsers,
                        letting you stay connected wherever you go.
                    </div>
                </div>

                <!-- FAQ 13 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">13. What should I do if I forget my
                            password?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Click the <b>“Forgot Password?”</b> link on the login page, enter your registered email or
                        username,
                        and follow the instructions sent to your email to reset your password. For issues, contact the
                        school IT office.
                    </div>
                </div>

                <!-- FAQ 14 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">14. What if I encounter technical problems or
                            have questions about ICSIS?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Contact the ICSIS Help Desk or your school’s IT coordinator. Their contact info is in the About
                        Us section or on the login page. They can assist with account issues, technical problems, and
                        general questions.
                    </div>
                </div>

                <!-- FAQ 15 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">15. Where can I learn more about Irosin Central
                            School?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Visit the About Us section on the ICSIS portal or the official school website to learn about the
                        school’s history, vision, mission, and more.
                    </div>
                </div>

                <!-- FAQ 16 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">16. Can I update my profile information?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Yes, users can update their profile information such as email, and other
                        personal details.
                        However, the name, and contact number field cannot be changed to prevent identity confusion and
                        ensure the
                        authenticity of user records. To request a change to your name or contact number, please file a
                        formal request.
                    </div>
                </div>

                <!-- FAQ 17 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">17. Will I receive notifications for new
                            updates?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        Yes, users will receive notifications for new news posts, announcements, events, and other
                        important updates.
                        Notifications will appear within the portal and may also be sent via email or SMS, depending on
                        your notification settings.
                    </div>
                </div>

                <!-- FAQ 18 -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button class="w-full text-left p-5 flex justify-between items-center faq-toggle">
                        <span class="text-lg font-medium text-gray-800">18. Why are all members of the school displayed
                            on the Irosin Central School Information System?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform transform rotate-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-content px-5 pb-5 text-gray-600 hidden">
                        All members of the school—students, parents, teachers, and alumni—are displayed on the system to
                        promote transparency,
                        foster community engagement, and ensure accurate record-keeping. This visibility helps users
                        connect with their peers,
                        access group-based features, and receive relevant updates. Only registered and logged-in users
                        can view member information,
                        and privacy measures are implemented to protect sensitive data.
                    </div>
                </div>

            </div>
        </div>
    </section>

    <x-modal />

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


    <script>
        const teamData = {
            Principal: [{
                name: "Dr. Maria Lopez",
                role: "School Principal",
                description: "Committed to nurturing a culture of excellence and leadership.",
                image: "https://randomuser.me/api/portraits/women/44.jpg"
            }],
            "Subject Teachers": [{
                    name: "Mr. John Cruz",
                    role: "Math Teacher",
                    description: "Expert in Algebra and Calculus with 10+ years of experience.",
                    image: "https://randomuser.me/api/portraits/men/32.jpg"
                },
                {
                    name: "Ms. Hannah Lim",
                    role: "Science Teacher",
                    description: "Inspires curiosity through experiments and discovery.",
                    image: "https://randomuser.me/api/portraits/women/51.jpg"
                },
                {
                    name: "Mrs. Lisa Park",
                    role: "English Teacher",
                    description: "Passionate about literature and writing.",
                    image: "https://randomuser.me/api/portraits/women/65.jpg"
                },
                {
                    name: "Mr. Mark Smith",
                    role: "History Teacher",
                    description: "Brings history alive through engaging stories.",
                    image: "https://randomuser.me/api/portraits/men/45.jpg"
                },
                {
                    name: "Ms. Clara Davis",
                    role: "Geography Teacher",
                    description: "Maps and earth sciences enthusiast.",
                    image: "https://randomuser.me/api/portraits/women/12.jpg"
                },
                {
                    name: "Mr. Paul Walker",
                    role: "Physical Education Teacher",
                    description: "Promotes fitness and team sports.",
                    image: "https://randomuser.me/api/portraits/men/51.jpg"
                },
                {
                    name: "Ms. Evelyn Young",
                    role: "Art Teacher",
                    description: "Encourages creativity through diverse media.",
                    image: "https://randomuser.me/api/portraits/women/29.jpg"
                },
                {
                    name: "Mr. Anthony Hall",
                    role: "Music Teacher",
                    description: "Loves inspiring students with melodies.",
                    image: "https://randomuser.me/api/portraits/men/15.jpg"
                },
                {
                    name: "Mrs. Grace Allen",
                    role: "Computer Science Teacher",
                    description: "Teaches coding and digital literacy.",
                    image: "https://randomuser.me/api/portraits/women/34.jpg"
                },
                {
                    name: "Mr. Kevin Ross",
                    role: "Economics Teacher",
                    description: "Explains market dynamics and finance.",
                    image: "https://randomuser.me/api/portraits/men/20.jpg"
                },
                {
                    name: "Ms. Rachel Bennett",
                    role: "Foreign Language Teacher",
                    description: "Passionate about languages and cultures.",
                    image: "https://randomuser.me/api/portraits/women/45.jpg"
                }
            ],
            "Adviser Teachers": [{
                    name: "Mr. Leo Gomez",
                    role: "Grade 1 Adviser",
                    description: "Guides students with compassion and mentorship.",
                    image: "https://randomuser.me/api/portraits/men/47.jpg"
                },
                {
                    name: "Ms. Sandra White",
                    role: "Grade 2 Adviser",
                    description: "Supports students’ academic and personal growth.",
                    image: "https://randomuser.me/api/portraits/women/38.jpg"
                },
                {
                    name: "Mrs. Olivia Carter",
                    role: "Grade 3 Adviser",
                    description: "Encourages leadership and community involvement.",
                    image: "https://randomuser.me/api/portraits/women/24.jpg"
                },
                {
                    name: "Mr. David Brooks",
                    role: "Grade 4 Adviser",
                    description: "Prepares seniors for college and career paths.",
                    image: "https://randomuser.me/api/portraits/men/26.jpg"
                },
                {
                    name: "Ms. Linda Foster",
                    role: "Grade 5 Adviser",
                    description: "Fosters a safe and supportive environment.",
                    image: "https://randomuser.me/api/portraits/women/49.jpg"
                },
                {
                    name: "Mr. Robert King",
                    role: "Grade 6 Adviser",
                    description: "Helps students develop strong study habits.",
                    image: "https://randomuser.me/api/portraits/men/18.jpg"
                }
            ],
            Staff: [{
                    name: "Ms. Angela Rivera",
                    role: "Registrar",
                    description: "Handles records, enrollment, and academic documents.",
                    image: "https://randomuser.me/api/portraits/women/36.jpg"
                },
                {
                    name: "Mr. David Morales",
                    role: "IT Support",
                    description: "Maintains school’s computer systems and networks.",
                    image: "https://randomuser.me/api/portraits/men/29.jpg"
                },
                {
                    name: "Mrs. Emily Tan",
                    role: "Librarian",
                    description: "Organizes learning resources and supports research.",
                    image: "https://randomuser.me/api/portraits/women/22.jpg"
                },
                {
                    name: "Ms. Patricia Scott",
                    role: "Counselor",
                    description: "Provides emotional support and guidance.",
                    image: "https://randomuser.me/api/portraits/women/42.jpg"
                },
                {
                    name: "Mr. Brian Cooper",
                    role: "Accountant",
                    description: "Manages school finances and budgets.",
                    image: "https://randomuser.me/api/portraits/men/38.jpg"
                },
                {
                    name: "Mrs. Jessica Hill",
                    role: "Receptionist",
                    description: "Greets visitors and handles communications.",
                    image: "https://randomuser.me/api/portraits/women/19.jpg"
                },
                {
                    name: "Mr. Steven Clark",
                    role: "Security Officer",
                    description: "Ensures safety on campus.",
                    image: "https://randomuser.me/api/portraits/men/43.jpg"
                },
                {
                    name: "Ms. Michelle Reed",
                    role: "Nurse",
                    description: "Provides health care and first aid.",
                    image: "https://randomuser.me/api/portraits/women/27.jpg"
                }
            ],
            Utilities: [{
                    name: "Mr. Carlo Dela Cruz",
                    role: "Maintenance Staff",
                    description: "Ensures the school environment is safe and clean daily.",
                    image: "https://randomuser.me/api/portraits/men/62.jpg"
                },
                {
                    name: "Ms. Teresa Gomez",
                    role: "Janitor",
                    description: "Keeps classrooms and facilities spotless.",
                    image: "https://randomuser.me/api/portraits/women/18.jpg"
                },
                {
                    name: "Mr. Felix Ramirez",
                    role: "Gardener",
                    description: "Maintains school gardens and outdoor areas.",
                    image: "https://randomuser.me/api/portraits/men/39.jpg"
                },
                {
                    name: "Ms. Gloria Martinez",
                    role: "Cafeteria Staff",
                    description: "Prepares meals and manages food service.",
                    image: "https://randomuser.me/api/portraits/women/55.jpg"
                },
                {
                    name: "Mr. Samuel Ortiz",
                    role: "Electrician",
                    description: "Handles electrical repairs and installations.",
                    image: "https://randomuser.me/api/portraits/men/53.jpg"
                }
            ]
        };


        const container = document.getElementById("teamSections");

        Object.keys(teamData).forEach(section => {
            const sectionDiv = document.createElement("div");

            // For Principal section, center the single card differently
            if (section === "Principal") {
                sectionDiv.innerHTML = `
                    <h3 class="text-2xl font-semibold text-gray-700 mb-6 border-b pb-2 text-center">${section}</h3>
                    <div class="flex justify-center">
                        ${teamData[section].map(member => `
                                                                                                    <div class="bg-gray-100 rounded-lg shadow hover:shadow-md transition max-w-xs mx-auto">
                                                                                                        <img src="${member.image}" class="w-full h-60 object-cover" alt="${member.name}">
                                                                                                        <div class="p-4 text-center">
                                                                                                        <h4 class="text-xl font-bold text-gray-800">${member.name}</h4>
                                                                                                        <p class="text-sm text-gray-500 mb-2">${member.role}</p>
                                                                                                        <p class="text-sm text-gray-600">${member.description}</p>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    `).join('')}
                    </div>
                    `;
            } else {
                // Other sections as grid
                sectionDiv.innerHTML = `
                    <h3 class="text-2xl font-semibold text-gray-700 mb-6 border-b pb-2 text-center">${section}</h3>
                    <div class="grid justify-center gap-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
                        ${teamData[section].map(member => `
                                                                                                    <div class="bg-gray-100 rounded-lg shadow hover:shadow-md transition max-w-xs mx-auto">
                                                                                                        <img src="${member.image}" class="w-full h-60 object-cover" alt="${member.name}">
                                                                                                        <div class="p-4 text-center">
                                                                                                        <h4 class="text-xl font-bold text-gray-800">${member.name}</h4>
                                                                                                        <p class="text-sm text-gray-500 mb-2">${member.role}</p>
                                                                                                        <p class="text-sm text-gray-600">${member.description}</p>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    `).join('')}
                    </div>
                    `;
            }

            container.appendChild(sectionDiv);
        });
    </script>
</x-layouts.custome.header>
