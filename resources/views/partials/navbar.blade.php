<nav class="border-b z-50 sticky top-0 bg-white border-gray-200">
    <div class="flex items-center justify-between px-6 py-4">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <img alt="Irosin Central School logo" class="w-6 h-6"
                src="https://storage.googleapis.com/a1aa/image/496df554-c03f-4d0f-b627-889d928b8201.jpg" />
            <span class="font-semibold text-gray-900 text-sm sm:text-base">
                Irosin Central School
            </span>
        </div>

        <!-- Hamburger button (mobile only) -->
        <button id="menu-toggle" class="md:hidden text-gray-600 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Desktop Nav Links -->
        <ul id="disktop-view" class="space-x-6 text-sm text-gray-600 items-center">
            <li><a href="/" class="{{ request()->routeIs('home') ? 'font-semibold text-gray-900' : 'hover:text-gray-900' }}">Home</a></li>
            <li><a href="/news" class="{{ request()->routeIs('news') ? 'font-semibold text-gray-900' : 'hover:text-gray-900' }}">News</a></li>
            @if (auth()->user() && auth()->user()->role != 'pending')
                <li><a href="/announcements" class="{{ request()->routeIs('announcements') ? 'font-semibold text-gray-900' : 'hover:text-gray-900' }}">Announcements</a></li>
                <li><a href="/events" class="{{ request()->routeIs('events') ? 'font-semibold text-gray-900' : 'hover:text-gray-900' }}">Events</a></li>
                <li><a href="/gallery" class="{{ request()->routeIs('gallery') ? 'font-semibold text-gray-900' : 'hover:text-gray-900' }}">Gallery</a></li>
            @endif
            <li><a href="/about" class="{{ request()->routeIs('about') ? 'font-semibold text-gray-900' : 'hover:text-gray-900' }}">About Us</a></li>
        </ul>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden px-6 pb-4 space-y-2 text-sm text-gray-600 transition-all duration-300">
        <a href="/" class="{{ request()->routeIs('home') ? 'font-semibold text-gray-900 block' : 'hover:text-gray-900 block' }}">Home</a>
        <a href="/news" class="{{ request()->routeIs('news') ? 'font-semibold text-gray-900 block' : 'hover:text-gray-900 block' }}">News</a>
        <a href="/about" class="{{ request()->routeIs('about') ? 'font-semibold text-gray-900 block' : 'hover:text-gray-900 block' }}">About Us</a>
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
