<nav class="border-b z-50 sticky top-0 bg-white border-gray-200">
    <div class="flex items-center justify-between px-6 py-4">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <img alt="Green book icon representing Irosin Central School logo" class="w-6 h-6"
                src="https://storage.googleapis.com/a1aa/image/496df554-c03f-4d0f-b627-889d928b8201.jpg" />
            <span class="font-semibold text-gray-900 text-sm sm:text-base">
                Irosin Central School
            </span>
        </div>

        <!-- Hamburger button (mobile only) -->
        <button id="menu-toggle" class="md:hidden text-gray-600 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Desktop Nav Links -->
        <ul class="hidden md:flex space-x-6 text-sm text-gray-600">
            <li><a href="/"
                    class="{{ request()->routeIs('home') ? 'font-semibold text-gray-900' : 'hover:text-gray-900' }}">Home</a>
            </li>
            <li><a href="/news"
                    class="{{ request()->routeIs('news') ? 'font-semibold text-gray-900' : 'hover:text-gray-900' }}">News</a>
            </li>

            @if (auth()->user() && auth()->user()->role != 'pending')
                <li><a href="/announcements"
                        class="{{ request()->routeIs('announcements') ? 'font-semibold text-gray-900' : 'hover:text-gray-900' }}">Announcements</a>
                </li>
                <li><a href="/events"
                        class="{{ request()->routeIs('events') ? 'font-semibold text-gray-900' : 'hover:text-gray-900' }}">Events</a>
                </li>
                <li><a href="/gallery"
                        class="{{ request()->routeIs('gallery') ? 'font-semibold text-gray-900' : 'hover:text-gray-900' }}">Gallery</a>
                </li>
                <li><a href="/about"
                        class="{{ request()->routeIs('about') ? 'font-semibold text-gray-900' : 'hover:text-gray-900' }}">About
                        Us</a></li>

                <li x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex items-center space-x-2 px-4 text-gray-700 hover:text-gray-900 focus:outline-none">
                        <span>More</span>
                        <svg class="w-4 h-4 transform transition-transform duration-200" :class="{ 'rotate-180': open }"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <ul x-show="open" @click.away="open = false"
                        class="absolute left-0 mt-2 bg-white border border-gray-200 rounded shadow-md z-10">
                        @if (auth()->user()->role == 'parent' || auth()->user()->role == 'admin')
                            <li>
                                <button href="#" onclick="toggleFormModal(true)"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Request
                                    Documents</button>
                            </li>
                        @endif
                        <li><button href="#" id="open_users_groupModal"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">My
                                Groups</button></li>
                        <li><button onclick="modalNotify()" href="#" id="open_users_Notification"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Notification</button>
                        </li>
                        <li><button onclick="modalProfile()" href="#" id="open_users_Profile"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Profile</button>
                        </li>
                    </ul>
                </li>
            @endif

            @if (!auth()->check())
                <a class="hidden md:inline-block bg-green-800 text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-md hover:bg-green-900"
                    href="/">Login</a>
            @else
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="hidden md:inline-block bg-red-600 text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-md hover:bg-red-800">
                        Logout
                    </button>
                </form>
            @endif
        </ul>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden px-6 pb-4 space-y-2 text-sm text-gray-600">
        <a href="/"
            class="{{ request()->routeIs('home') ? 'font-semibold text-gray-900 block' : 'hover:text-gray-900 block' }}">Home</a>
        <a href="/news"
            class="{{ request()->routeIs('news') ? 'font-semibold text-gray-900 block' : 'hover:text-gray-900 block' }}">News</a>

        @if (auth()->user() && auth()->user()->role != 'pending')
            <a href="/announcements"
                class="{{ request()->routeIs('announcements') ? 'font-semibold text-gray-900 block' : 'hover:text-gray-900 block' }}">Announcements</a>
            <a href="/events"
                class="{{ request()->routeIs('events') ? 'font-semibold text-gray-900 block' : 'hover:text-gray-900 block' }}">Events</a>
            <a href="/gallery"
                class="{{ request()->routeIs('gallery') ? 'font-semibold text-gray-900 block' : 'hover:text-gray-900 block' }}">Gallery</a>
            <a href="/about"
                class="{{ request()->routeIs('about') ? 'font-semibold text-gray-900 block' : 'hover:text-gray-900 block' }}">About
                Us</a>

            <div class="border-t border-gray-200 pt-2 mt-2">
                <p class="text-gray-500 text-xs uppercase tracking-wide">More</p>

                @if (auth()->user()->role == 'parent' || auth()->user()->role == 'admin')
                    <button href="#" onclick="toggleFormModal(true)"
                        class="block px-2 py-1 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Request
                        Documents</button>
                @endif
                <button href="#" id="open_users_groupModal"
                    class="block px-2 py-1 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">My Groups</button>
                <button onclick="modalNotify()" href="#" id="open_users_Notification1"
                    class="block px-2 py-1 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Notification</button>
                <button onclick="modalProfile()" href="#" id="open_users_Profile"
                    class="block px-2 py-1 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">Profile</button>

            </div>
        @endif

        @if (!auth()->check())
            <div class="flex mt-4">
                <a href="/" class="bg-green-800 text-white font-semibold px-4 py-2 rounded-md">Login</a>
            </div>
        @else
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-600 text-white font-semibold px-4 py-2 rounded-md">
                    Logout
                </button>
            </form>
        @endif
    </div>

    <script>
        // Select all <a> elements
        const links = document.querySelectorAll('a');
        const loadingIndicator = document.getElementById('loadingIndicator');
        
        // Add click listener to each link
        links.forEach(link => {
            link.addEventListener('click', function(event) {
                loadingIndicator.classList.remove('hidden');
                console.log('Link clicked:', link.href);
            });
        });
    </script>
    <script src="/build/js/header.js"></script>
</nav>
