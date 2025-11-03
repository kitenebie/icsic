<nav class="border-b z-50 sticky top-0 bg-white border-cream-100">
    <div class="flex items-center justify-between px-6 py-4">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <img alt="Irosin Central School logo" class="w-6 h-6"
                src="https://storage.googleapis.com/a1aa/image/496df554-c03f-4d0f-b627-889d928b8201.jpg" />
            <span class="font-semibold text-brown-800 text-sm sm:text-base">
                Irosin Central School
            </span>
        </div>

        <!-- Hamburger button (mobile only) -->
        <button id="menu-toggle" class="md:hidden text-gray-600 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Desktop Nav Links -->
        <ul id="disktop-view" class="space-x-6 text-sm text-gray-600 items-center">
            <li>
                <a href="/"
                    class="{{ request()->routeIs('home') ? 'font-semibold text-brown-800' : 'hover:text-brown-800' }}">
                    Home
                </a>
            </li>
            <li>
                <a href="/news"
                    class="{{ request()->routeIs('news') ? 'font-semibold text-brown-800' : 'hover:text-brown-800' }}">
                    News
                </a>
            </li>

            @if (auth()->user() && auth()->user()->role != 'pending')
                <li><a href="/announcements"
                        class="{{ request()->routeIs('announcements') ? 'font-semibold text-brown-800' : 'hover:text-brown-800' }}">Announcements</a>
                </li>
                <li><a href="/events"
                        class="{{ request()->routeIs('events') ? 'font-semibold text-brown-800' : 'hover:text-brown-800' }}">Events</a>
                </li>
                {{-- <li><a href="/gallery"
                        class="{{ request()->routeIs('gallery') ? 'font-semibold text-brown-800' : 'hover:text-brown-800' }}">Gallery</a></li> --}}

                <!-- Dropdown -->
                <li x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex items-center space-x-2 px-2 py-1 text-gray-700 hover:text-brown-800 focus:outline-none">
                        <span>More</span>
                        <svg class="w-4 h-4 transform transition-transform duration-200" :class="{ 'rotate-180': open }"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <ul x-show="open" @click.away="open = false"
                        class="absolute left-0 mt-2 bg-white border border-gray-200 rounded shadow-md z-10 w-40">
                        {{-- <li><button id="open_users_groupModal"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My
                                Groups</button></li> --}}
                        <li><button onclick="modalNotify()" id="open_users_Notification"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Notification</button>
                        </li>
                        <li><button onclick="modalProfile()" id="open_users_Profile"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</button>
                        </li>
                    </ul>
                </li>
            @endif

            <li>
                <a href="/about"
                    class="{{ request()->routeIs('about') ? 'font-semibold text-brown-800' : 'hover:text-brown-800' }}">About
                    Us</a>
            </li>

            @if (!auth()->check())
                <a class="bg-green-800 text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-md hover:bg-green-900"
                    href="/">Login</a>
            @else
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-md hover:bg-red-800">
                        Logout
                    </button>
                </form>
            @endif
        </ul>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu"
        class="md:hidden hidden px-6 pb-4 space-y-2 text-sm text-gray-600 transition-all duration-300">
        <a href="/"
            class="{{ request()->routeIs('home') ? 'font-semibold text-brown-800 block' : 'hover:text-brown-800 block' }}">Home</a>
        <a href="/news"
            class="{{ request()->routeIs('news') ? 'font-semibold text-brown-800 block' : 'hover:text-brown-800 block' }}">News</a>

        @if (auth()->user() && auth()->user()->role != 'pending')
            <a href="/announcements"
                class="{{ request()->routeIs('announcements') ? 'font-semibold text-brown-800 block' : 'hover:text-brown-800 block' }}">Announcements</a>
            <a href="/events"
                class="{{ request()->routeIs('events') ? 'font-semibold text-brown-800 block' : 'hover:text-brown-800 block' }}">Events</a>
            {{-- <a href="/gallery"
                class="{{ request()->routeIs('gallery') ? 'font-semibold text-brown-800 block' : 'hover:text-brown-800 block' }}">Gallery</a> --}}

            <div class="border-t border-gray-200 pt-2 mt-2">
                <p class="text-gray-500 text-xs uppercase tracking-wide">More</p>
                {{-- <button id="open_users_groupModal"
                    class="block w-full text-left px-2 py-1 text-sm text-gray-700 hover:bg-gray-100">My Groups</button> --}}
                <button onclick="modalNotify()" id="open_users_Notification1"
                    class="block w-full text-left px-2 py-1 text-sm text-gray-700 hover:bg-gray-100">Notification</button>
                <button onclick="modalProfile()" id="open_users_Profile"
                    class="block w-full text-left px-2 py-1 text-sm text-gray-700 hover:bg-gray-100">Profile</button>
            </div>
        @endif

        {{-- <a href="/about"
            class="{{ request()->routeIs('about') ? 'font-semibold text-brown-800 block' : 'hover:text-brown-800 block' }}">About
            Us</a> --}}

        @if (!auth()->check())
            <div class="flex mt-4">
                <a href="/" class="bg-green-800 text-white font-semibold px-4 py-2 rounded-md">Login</a>
            </div>
        @else
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-600 text-white font-semibold px-4 py-2 rounded-md">Logout</button>
            </form>
        @endif
    </div>

    <!-- Loading Indicator -->
    <div id="loadingIndicator" class="hidden fixed top-0 left-0 w-full h-1 bg-green-600 animate-pulse z-50"></div>


    <script>
        const toggleBtn = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const desktopMenu = document.getElementById('disktop-view');
        const loadingIndicator = document.getElementById('loadingIndicator');

        // Mobile menu toggle
        toggleBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Handle nav link loading bar
        const navLinks = document.querySelectorAll('nav a');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                loadingIndicator.classList.remove('hidden');
            });
        });

        // Remove desktop menu on mobile
        function handleResize() {
            if (window.innerWidth < 768) {
                if (desktopMenu) desktopMenu.style.display = 'none';
                desktopMenu.classList.add('hidden');
            } else {
                if (desktopMenu) desktopMenu.style.display = 'flex';
                desktopMenu.classList.remove('hidden');
            }
        }

        // Run once & on resize
        handleResize();
        window.addEventListener('resize', handleResize);
    </script>
</nav>
