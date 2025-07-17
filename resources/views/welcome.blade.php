<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: "Inter", sans-serif;
        }

        .reaction-popup {
            position: absolute;
            bottom: 100%;
            left: 150% !important;
            transform: translateX(-25%);
            background: rgb(255, 255, 255);
          border-radius: 9999px;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.15);
            padding: 6px 10px;
            display: flex;
            gap: 8px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
            z-index: 9999 !important;
            user-select: none;
            visibility: hidden;
        }

        .reaction-popup.show {
            visibility: visible;
            opacity: 1;
            pointer-events: auto;
        }

        .reaction-popup span {
            font-size: 24px;
            cursor: pointer;
            transition: transform 0.15s ease;
            line-height: 1;
        }

        .reaction-popup span:hover {
            transform: scale(1.4);
        }

        /* Tooltip arrow */
        .reaction-popup::after {
            content: "";
            position: absolute;
            bottom: -6px;
            left: 50%;
            transform: translateX(-50%);
            border-width: 6px;
            border-style: solid;
            border-color: white transparent transparent transparent;
        }

        /* Scrollbar for comments */
        .comments-scroll {
            max-height: 300px;
            overflow-y: auto;
        }

        /* Reaction icon styles for post like icon */
        #like-icon-post {
            font-size: 18px;
            vertical-align: middle;
            margin-right: 4px;
            transition: color 0.3s ease;
        }

        #like-icon-post.liked {
            color: #2563eb;
            /* blue-600 */
        }
    </style>
@fluxAppearance
</head>

<body class="bg-white text-gray-800">
    <nav class="border-b border-gray-200">
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
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
      
          <!-- Desktop Nav Links -->
          <ul class="hidden md:flex space-x-6 text-sm text-gray-600">
            <li><a class="font-semibold text-gray-900" href="#">Home</a></li>
            <li><a class="hover:text-gray-900" href="#">News</a></li>
            <li><a class="hover:text-gray-900" href="#">Announcements</a></li>
            <li><a class="hover:text-gray-900" href="#">Events</a></li>
            <li><a class="hover:text-gray-900" href="#">Gallery</a></li>
            <li><a class="hover:text-gray-900" href="#">About Us</a></li>
          </ul>
      
          <!-- Login Button -->
          <a class="hidden md:inline-block bg-green-800 text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-md hover:bg-green-900"
            href="#">Login</a>
        </div>
      
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden px-6 pb-4 space-y-2 text-sm text-gray-600">
          <a class="block font-semibold text-gray-900" href="#">Home</a>
          <a class="block hover:text-gray-900" href="#">News</a>
          <a class="block hover:text-gray-900" href="#">Announcements</a>
          <a class="block hover:text-gray-900" href="#">Events</a>
          <a class="block hover:text-gray-900" href="#">Gallery</a>
          <a class="block hover:text-gray-900" href="#">About Us</a>
          <a class="block bg-green-800 text-white text-xs font-semibold px-4 py-2 rounded-md hover:bg-green-900 w-fit"
            href="#">Login</a>
        </div>
      </nav>
      
      <script>
        // JavaScript for toggling the mobile menu
        document.getElementById("menu-toggle").addEventListener("click", () => {
          const menu = document.getElementById("mobile-menu");
          menu.classList.toggle("hidden");
        });
      </script>
      
    <!-- Hero Section -->
    <section class="bg-green-700 text-white px-6 py-12 sm:py-16 md:py-20 lg:py-24">
        <div class="max-w-7xl mx-auto flex flex-col-reverse md:flex-row items-center justify-between gap-10 md:gap-20">
            <div class="max-w-xl">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold leading-tight">
                    Welcome to
                    <span class="font-extrabold"> Irosin Central School </span>
                </h1>
                <p class="mt-3 text-sm sm:text-base max-w-md">
                    Nurturing minds, building character, and shaping the future leaders
                    of tomorrow.
                </p>
                <div class="mt-6 flex space-x-3">
                    <button
                        class="bg-white text-green-800 font-bold text-xs sm:text-sm px-4 py-2 rounded-md hover:bg-gray-100">
                        Create an account
                    </button>
                    <button
                        class="border border-white text-white font-semibold text-xs sm:text-sm px-4 py-2 rounded-md hover:bg-white hover:text-green-700 transition">
                        Learn More
                    </button>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6 shadow-lg max-w-[320px] sm:max-w-[360px] md:max-w-[400px] w-full">
                <div class="bg-gray-300 rounded-md p-6">
                    <img alt="Green and white stylized school icon graphic on gray background"
                        class="w-full h-auto rounded" height="180"
                        src="https://storage.googleapis.com/a1aa/image/e1fce618-5246-45d1-e9ee-dcfa7139ace0.jpg"
                        width="320" />
                </div>
            </div>
        </div>
    </section>

    <!-- Latest News Section -->
    <section class="max-w-7xl mx-auto px-6 py-12 sm:py-16">
        <h2 class="text-center font-bold text-lg sm:text-xl mb-2">Latest News</h2>
        <p class="text-center text-gray-600 text-xs sm:text-sm mb-8 max-w-md mx-auto">
            Stay updated with the latest happenings at Irosin Central School.
        </p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- News Card 1 -->
            <article class="bg-green-100 rounded-lg shadow-sm overflow-hidden flex flex-col">
                <div class="bg-green-200 p-6 flex justify-center items-center">
                    <i class="fas fa-newspaper text-green-800 text-3xl"> </i>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <time class="text-gray-500 text-xs flex items-center gap-1 mb-1" datetime="2023-05-15">
                        <i class="far fa-calendar-alt"> </i>
                        May 15, 2023
                    </time>
                    <h3 class="font-semibold text-sm mb-1 leading-snug">
                        Irosin Central School Wins Regional Science Fair
                    </h3>
                    <p class="text-gray-600 text-xs flex-grow">
                        Our students brought home the gold medal in the Regional Science
                        Fair Competition held last week...
                    </p>
                    <a class="mt-3 text-green-800 text-xs font-semibold inline-flex items-center hover:underline"
                        href="#">
                        Read more
                        <i class="fas fa-chevron-right ml-1 text-[10px]"> </i>
                    </a>
                </div>
            </article>
            <!-- News Card 2 -->
            <article class="bg-green-100 rounded-lg shadow-sm overflow-hidden flex flex-col">
                <div class="bg-green-200 p-6 flex justify-center items-center">
                    <i class="fas fa-puzzle-piece text-green-800 text-3xl"> </i>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <time class="text-gray-500 text-xs flex items-center gap-1 mb-1" datetime="2023-05-08">
                        <i class="far fa-calendar-alt"> </i>
                        May 8, 2023
                    </time>
                    <h3 class="font-semibold text-sm mb-1 leading-snug">
                        New Computer Laboratory Inaugurated
                    </h3>
                    <p class="text-gray-600 text-xs flex-grow">
                        The school proudly inaugurated its state-of-the-art computer
                        laboratory equipped with 30 new computers...
                    </p>
                    <a class="mt-3 text-green-800 text-xs font-semibold inline-flex items-center hover:underline"
                        href="#">
                        Read more
                        <i class="fas fa-chevron-right ml-1 text-[10px]"> </i>
                    </a>
                </div>
            </article>
            <!-- News Card 3 -->
            <article class="bg-green-100 rounded-lg shadow-sm overflow-hidden flex flex-col">
                <div class="bg-green-200 p-6 flex justify-center items-center">
                    <i class="fas fa-book-open text-green-800 text-3xl"> </i>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <time class="text-gray-500 text-xs flex items-center gap-1 mb-1" datetime="2023-04-30">
                        <i class="far fa-calendar-alt"> </i>
                        April 30, 2023
                    </time>
                    <h3 class="font-semibold text-sm mb-1 leading-snug">
                        Teacher Training Program Completed
                    </h3>
                    <p class="text-gray-600 text-xs flex-grow">
                        Our faculty members successfully completed a comprehensive
                        training program on modern teaching methodologies...
                    </p>
                    <a class="mt-3 text-green-800 text-xs font-semibold inline-flex items-center hover:underline"
                        href="#">
                        Read more
                        <i class="fas fa-chevron-right ml-1 text-[10px]"> </i>
                    </a>
                </div>
            </article>
        </div>
        <div class="mt-8 flex justify-center">
            <button
                class="bg-green-800 text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-md hover:bg-green-900">
                View All News
            </button>
        </div>
    </section>

    <!-- Facebook-like Post Section -->
    <section class="max-w-2xl mx-auto px-6 pb-12">
        <h2 class="text-center font-bold text-lg sm:text-xl mb-2">Announcement</h2>
        <p class="text-center text-gray-600 text-xs sm:text-sm mb-8 max-w-md mx-auto">
            Stay updated with the latest happenings at Irosin Central School.
        </p>
        <!-- 4 -->
        <div class="mb-2 bg-white border border-gray-200 rounded-md shadow-sm text-gray-800 text-xs sm:text-sm"
            style="font-family: Arial, sans-serif">
            <!-- Header -->
            <div class="flex items-center gap-2 p-3 border-b border-gray-200">
                <img alt="Irosin Central School logo green circle with ICS text" class="w-6 h-6 rounded-full"
                    height="24"
                    src="https://storage.googleapis.com/a1aa/image/10e94bdc-c408-4a4f-44e0-cc6af4a3b589.jpg"
                    width="24" />
                <div class="flex flex-col leading-tight">
                    <span class="font-semibold text-[13px]">
                        Irosin Central School
                    </span>
                    <span class="text-gray-500 text-[11px]">
                        May 18, 2023 ·
                        <i class="fas fa-globe-americas"> </i>
                    </span>
                </div>
            </div>
            <!-- Post Content -->
            <div class="p-3">
                <p class="font-semibold text-[13px] mb-1 leading-snug">
                    School Facilities Improvement Project
                </p>
                <p class="text-gray-700 text-[12px] mb-3 leading-relaxed">
                    We're excited to share the progress of our school facilities
                    improvement project. The renovation includes new classrooms, library
                    expansion, and playground equipment installation.
                </p>
                <!-- Image Grid -->
                <div class="grid grid-cols-2 grid-rows-2 gap-1 mb-3">
                    <div class="bg-green-100 flex justify-center items-center p-6">
                        <img alt="Green building icon on light green background" class="max-w-full max-h-full"
                            height="120"
                            src="https://storage.googleapis.com/a1aa/image/c97e4578-3dd9-4058-ea79-e5256ee812d6.jpg"
                            width="120" />
                    </div>
                    <div class="bg-green-200 flex justify-center items-center p-6">
                        <img alt="Green library building icon on medium green background"
                            class="max-w-full max-h-full" height="120"
                            src="https://storage.googleapis.com/a1aa/image/71c14d6e-f25f-4f3f-0545-6426b7036834.jpg"
                            width="120" />
                    </div>
                    <div class="bg-green-100 flex justify-center items-center p-6">
                        <img alt="Green checkmark badge icon on light green background" class="max-w-full max-h-full"
                            height="120"
                            src="https://storage.googleapis.com/a1aa/image/c01e0b24-0b45-4d7c-4ec7-cd5925f418a8.jpg"
                            width="120" />
                    </div>
                    <div
                        class="bg-green-700 flex justify-center items-center p-6 relative text-white font-bold text-sm">
                        <span class="absolute inset-0 flex justify-center items-center">
                            +5
                        </span>
                    </div>
                </div>
                <!-- Project Timeline -->
                <div class="bg-green-100 p-2 rounded text-[11px] text-green-900 leading-tight">
                    <p class="flex items-center gap-1 mb-1 font-semibold">
                        <i class="fas fa-info-circle"> </i>
                        Project Timeline
                    </p>
                    <ul class="list-disc list-inside space-y-0.5">
                        <li>Phase 1 (Completed): Classroom renovations</li>
                        <li>Phase 2 (In Progress): Library expansion</li>
                        <li>Phase 3 (Starting June): Playground installation</li>
                        <li>Project Completion: July 2023</li>
                    </ul>
                </div>
            </div>
            <!-- Footer -->
            <div
                class="border-t border-gray-200 flex justify-between items-center px-3 py-2 text-gray-500 text-[11px] relative">
                <div class="flex relative items-center gap-0 relative">
                    <i class="fas fa-thumbs-up cursor-pointer select-none m-0" id="like-icon-post" style="color: #2CAC5B;
                        aria-label="Post like icon">
                    </i>
                    <i class="fas fa-heart cursor-pointer select-none m-0" id="like-icon-post" style="color: crimson;"
                        aria-label="Post like icon">
                    </i>
                    <i class="fas fa-laugh-squint cursor-pointer select-none m-0" id="like-icon-post" style="color: #FFC83D;"
                        aria-label="Post like icon">
                    </i>
                    <i class="fas fa-sad-tear cursor-pointer select-none m-0" id="like-icon-post" style="color: #FFC83D;"
                        aria-label="Post like icon">
                    </i>
                    <i class="fas fa-angry cursor-pointer select-none m-0" id="like-icon-post" style="color: #e74c3c;"
                        aria-label="Post like icon">
                    </i>
                    <span id="reaction-summary" class="text-gray-700 text-[11px] ml-2 select-none cursor-default">
                        100 reactions
                    </span>
                </div>
                <span> 24 comments </span>
            </div>
            <div class="border-t border-gray-200 flex justify-around text-gray-600 text-[11px] py-2">
                <button class="flex items-center gap-1 hover:text-gray-800 relative" id="like-button-footer"
                    aria-haspopup="true" aria-expanded="false" aria-controls="reaction-popup-footer"
                    aria-label="Like button with reactions">
                    <i class="far fa-thumbs-up fa-lg"> </i>
                    <!-- Reaction popup footer -->
                    <div class="reaction-popup" id="reaction-popup-footer" role="list" aria-label="Reactions"
                    >
                        <span role="button" aria-label="Like" data-reaction="like" title="Like">👍</span>
                        <span role="button" aria-label="Love" data-reaction="love" title="Love">💖</span>
                        <span role="button" aria-label="Haha" data-reaction="haha" title="Haha">😂</span>
                        <span role="button" aria-label="Sad" data-reaction="sad" title="Sad">😥</span>
                        <span role="button" aria-label="Angry" data-reaction="angry" title="Angry">😡</span>
                    </div>
                </button>
                <button class="flex items-center gap-1 hover:text-gray-800" id="comment-toggle-button"
                    aria-expanded="false" aria-controls="comments-section">
                    <i class="far fa-comment fa-lg"> </i>
                    Comment
                </button>
                <button class="flex items-center gap-1 hover:text-gray-800">
                    <i class="fas fa-share fa-lg"> </i>
                    Share
                </button>
            </div>
        </div>
        <!-- 3 -->
        <div class="mb-2 bg-white border border-gray-200 rounded-md shadow-sm text-gray-800 text-xs sm:text-sm"
            style="font-family: Arial, sans-serif">
            <!-- Header -->
            <div class="flex items-center gap-2 p-3 border-b border-gray-200">
                <img alt="Irosin Central School logo green circle with ICS text" class="w-6 h-6 rounded-full"
                    height="24"
                    src="https://storage.googleapis.com/a1aa/image/10e94bdc-c408-4a4f-44e0-cc6af4a3b589.jpg"
                    width="24" />
                <div class="flex flex-col leading-tight">
                    <span class="font-semibold text-[13px]">
                        Irosin Central School
                    </span>
                    <span class="text-gray-500 text-[11px]">
                        May 18, 2023 ·
                        <i class="fas fa-globe-americas"> </i>
                    </span>
                </div>
            </div>
            <!-- Post Content  -->
            <div class="p-3">
                <p class="font-semibold text-[13px] mb-1 leading-snug">
                    School Facilities Improvement Project
                </p>
                <p class="text-gray-700 text-[12px] mb-3 leading-relaxed">
                    We're excited to share the progress of our school facilities
                    improvement project. The renovation includes new classrooms, library
                    expansion, and playground equipment installation.
                </p>
                <!-- Image Grid -->
                <div class="grid grid-cols-1 grid-rows-3 gap-1 mb-3">
                    <div class="bg-green-100 flex justify-center items-center p-6">
                        <img alt="Green building icon on light green background" class="max-w-full max-h-full"
                            height="120"
                            src="https://storage.googleapis.com/a1aa/image/c97e4578-3dd9-4058-ea79-e5256ee812d6.jpg"
                            width="120" />
                    </div>
                    <div class="bg-green-200 flex justify-center items-center p-6">
                        <img alt="Green library building icon on medium green background"
                            class="max-w-full max-h-full" height="120"
                            src="https://storage.googleapis.com/a1aa/image/71c14d6e-f25f-4f3f-0545-6426b7036834.jpg"
                            width="120" />
                    </div>
                    <div class="bg-green-100 flex justify-center items-center p-6">
                        <img alt="Green checkmark badge icon on light green background" class="max-w-full max-h-full"
                            height="120"
                            src="https://storage.googleapis.com/a1aa/image/c01e0b24-0b45-4d7c-4ec7-cd5925f418a8.jpg"
                            width="120" />
                    </div>
                </div>
                <!-- Project Timeline -->
                <div class="bg-green-100 p-2 rounded text-[11px] text-green-900 leading-tight">
                    <p class="flex items-center gap-1 mb-1 font-semibold">
                        <i class="fas fa-info-circle"> </i>
                        Project Timeline
                    </p>
                    <ul class="list-disc list-inside space-y-0.5">
                        <li>Phase 1 (Completed): Classroom renovations</li>
                        <li>Phase 2 (In Progress): Library expansion</li>
                        <li>Phase 3 (Starting June): Playground installation</li>
                        <li>Project Completion: July 2023</li>
                    </ul>
                </div>
            </div>
            <!-- Footer -->
            <div
                class="border-t border-gray-200 flex justify-between items-center px-3 py-2 text-gray-500 text-[11px] relative">
                <div class="flex items-center gap-1 relative">
                    <i class="fas fa-thumbs-up cursor-pointer select-none m-0" id="like-icon-post" style="color: #2CAC5B;
                        aria-label="Post like icon">
                    </i>
                    <i class="fas fa-heart cursor-pointer select-none m-0" id="like-icon-post" style="color: crimson;"
                        aria-label="Post like icon">
                    </i>
                    <i class="fas fa-laugh-squint cursor-pointer select-none m-0" id="like-icon-post" style="color: #FFC83D;"
                        aria-label="Post like icon">
                    </i>
                    <i class="fas fa-sad-tear cursor-pointer select-none m-0" id="like-icon-post" style="color: #FFC83D;"
                        aria-label="Post like icon">
                    </i>
                    <i class="fas fa-angry cursor-pointer select-none m-0" id="like-icon-post" style="color: #e74c3c;"
                        aria-label="Post like icon">
                    </i>
                    <span id="reaction-summary" class="text-gray-700 text-[11px] ml-2 select-none cursor-default">
                        100 reactions
                    </span>
                    <span id="reaction-summary" class="text-gray-700 text-[11px] ml-1 select-none cursor-default">
                        68 reactions
                    </span>
                </div>
                <span> 24 comments </span>
            </div>
            <div class="border-t border-gray-200 flex justify-around text-gray-600 text-[11px] py-2">
                <button class="flex items-center gap-1 hover:text-gray-800 relative" id="like-button-footer"
                    aria-haspopup="true" aria-expanded="false" aria-controls="reaction-popup-footer"
                    aria-label="Like button with reactions">
                    <i class="far fa-thumbs-up fa-lg"> </i>
                    <!-- Reaction popup footer -->
                    <div class="reaction-popup" id="reaction-popup-footer" role="list" aria-label="Reactions"
                    >
                        <span role="button" aria-label="Like" data-reaction="like" title="Like">👍</span>
                        <span role="button" aria-label="Love" data-reaction="love" title="Love">💖</span>
                        <span role="button" aria-label="Haha" data-reaction="haha" title="Haha">😂</span>
                        <span role="button" aria-label="Sad" data-reaction="sad" title="Sad">😥</span>
                        <span role="button" aria-label="Angry" data-reaction="angry" title="Angry">😡</span>
                    </div>
                </button>
                <button class="flex items-center gap-1 hover:text-gray-800" id="comment-toggle-button"
                    aria-expanded="false" aria-controls="comments-section">
                    <i class="far fa-comment fa-lg"> </i>
                    Comment
                </button>
                <button class="flex items-center gap-1 hover:text-gray-800">
                    <i class="fas fa-share fa-lg"> </i>
                    Share
                </button>
            </div>
        </div>
        <!-- 2 -->
        <div class="mb-2 bg-white border border-gray-200 rounded-md shadow-sm text-gray-800 text-xs sm:text-sm"
            style="font-family: Arial, sans-serif">
            <!-- Header -->
            <div class="flex items-center gap-2 p-3 border-b border-gray-200">
                <img alt="Irosin Central School logo green circle with ICS text" class="w-6 h-6 rounded-full"
                    height="24"
                    src="https://storage.googleapis.com/a1aa/image/10e94bdc-c408-4a4f-44e0-cc6af4a3b589.jpg"
                    width="24" />
                <div class="flex flex-col leading-tight">
                    <span class="font-semibold text-[13px]">
                        Irosin Central School
                    </span>
                    <span class="text-gray-500 text-[11px]">
                        May 18, 2023 ·
                        <i class="fas fa-globe-americas"> </i>
                    </span>
                </div>
            </div>
            <!-- Post Content  -->
            <div class="p-3">
                <p class="font-semibold text-[13px] mb-1 leading-snug">
                    School Facilities Improvement Project
                </p>
                <p class="text-gray-700 text-[12px] mb-3 leading-relaxed">
                    We're excited to share the progress of our school facilities
                    improvement project. The renovation includes new classrooms, library
                    expansion, and playground equipment installation.
                </p>
                <!-- Image Grid -->
                <div class="grid grid-cols-1 grid-rows-2 gap-1 mb-3">
                    <div class="bg-green-100 flex justify-center items-center p-6">
                        <img alt="Green building icon on light green background" class="max-w-full max-h-full"
                            height="120"
                            src="https://storage.googleapis.com/a1aa/image/c97e4578-3dd9-4058-ea79-e5256ee812d6.jpg"
                            width="120" />
                    </div>
                    <div class="bg-green-200 flex justify-center items-center p-6">
                        <img alt="Green library building icon on medium green background"
                            class="max-w-full max-h-full" height="120"
                            src="https://storage.googleapis.com/a1aa/image/71c14d6e-f25f-4f3f-0545-6426b7036834.jpg"
                            width="120" />
                    </div>
                </div>
                <!-- Project Timeline -->
                <div class="bg-green-100 p-2 rounded text-[11px] text-green-900 leading-tight">
                    <p class="flex items-center gap-1 mb-1 font-semibold">
                        <i class="fas fa-info-circle"> </i>
                        Project Timeline
                    </p>
                    <ul class="list-disc list-inside space-y-0.5">
                        <li>Phase 1 (Completed): Classroom renovations</li>
                        <li>Phase 2 (In Progress): Library expansion</li>
                        <li>Phase 3 (Starting June): Playground installation</li>
                        <li>Project Completion: July 2023</li>
                    </ul>
                </div>
            </div>
            <!-- Footer -->
            <div
                class="border-t border-gray-200 flex justify-between items-center px-3 py-2 text-gray-500 text-[11px] relative">
                <div class="flex items-center gap-1 relative">
                    <i class="fas fa-thumbs-up cursor-pointer select-none m-0" id="like-icon-post" style="color: #2CAC5B;
                        aria-label="Post like icon">
                    </i>
                    <i class="fas fa-heart cursor-pointer select-none m-0" id="like-icon-post" style="color: crimson;"
                        aria-label="Post like icon">
                    </i>
                    <i class="fas fa-laugh-squint cursor-pointer select-none m-0" id="like-icon-post" style="color: #FFC83D;"
                        aria-label="Post like icon">
                    </i>
                    <i class="fas fa-sad-tear cursor-pointer select-none m-0" id="like-icon-post" style="color: #FFC83D;"
                        aria-label="Post like icon">
                    </i>
                    <i class="fas fa-angry cursor-pointer select-none m-0" id="like-icon-post" style="color: #e74c3c;"
                        aria-label="Post like icon">
                    </i>
                    <span id="reaction-summary" class="text-gray-700 text-[11px] ml-2 select-none cursor-default">
                        100 reactions
                    </span>
                    <span id="reaction-summary" class="text-gray-700 text-[11px] ml-1 select-none cursor-default">
                        68 reactions
                    </span>
                </div>
                <span> 24 comments </span>
            </div>
            <div class="border-t border-gray-200 flex justify-around text-gray-600 text-[11px] py-2">
                <button class="flex items-center gap-1 hover:text-gray-800 relative" id="like-button-footer"
                    aria-haspopup="true" aria-expanded="false" aria-controls="reaction-popup-footer"
                    aria-label="Like button with reactions">
                    <i class="far fa-thumbs-up fa-lg"> </i>
                    <!-- Reaction popup footer -->
                    <div class="reaction-popup" id="reaction-popup-footer" role="list" aria-label="Reactions"
                    >
                        <span role="button" aria-label="Like" data-reaction="like" title="Like">👍</span>
                        <span role="button" aria-label="Love" data-reaction="love" title="Love">💖</span>
                        <span role="button" aria-label="Haha" data-reaction="haha" title="Haha">😂</span>
                        <span role="button" aria-label="Sad" data-reaction="sad" title="Sad">😥</span>
                        <span role="button" aria-label="Angry" data-reaction="angry" title="Angry">😡</span>
                    </div>
                </button>
                <button class="flex items-center gap-1 hover:text-gray-800" id="comment-toggle-button"
                    aria-expanded="false" aria-controls="comments-section">
                    <i class="far fa-comment fa-lg"> </i>
                    Comment
                </button>
                <button class="flex items-center gap-1 hover:text-gray-800">
                    <i class="fas fa-share fa-lg"> </i>
                    Share
                </button>
            </div>
        </div>
        <!-- 1 -->
        <div class="mb-2 bg-white border border-gray-200 rounded-md shadow-sm text-gray-800 text-xs sm:text-sm"
            style="font-family: Arial, sans-serif">
            <!-- Header -->
            <div class="flex items-center gap-2 p-3 border-b border-gray-200">
                <img alt="Irosin Central School logo green circle with ICS text" class="w-6 h-6 rounded-full"
                    height="24"
                    src="https://storage.googleapis.com/a1aa/image/10e94bdc-c408-4a4f-44e0-cc6af4a3b589.jpg"
                    width="24" />
                <div class="flex flex-col leading-tight">
                    <span class="font-semibold text-[13px]">
                        Irosin Central School
                    </span>
                    <span class="text-gray-500 text-[11px]">
                        May 18, 2023 ·
                        <i class="fas fa-globe-americas"> </i>
                    </span>
                </div>
            </div>
            <!-- Post Content  -->
            <div class="p-3">
                <p class="font-semibold text-[13px] mb-1 leading-snug">
                    School Facilities Improvement Project
                </p>
                <p class="text-gray-700 text-[12px] mb-3 leading-relaxed">
                    We're excited to share the progress of our school facilities
                    improvement project. The renovation includes new classrooms, library
                    expansion, and playground equipment installation.
                </p>
                <!-- Image Grid -->
                <div class="grid grid-cols-1 grid-rows-1 gap-1 mb-3">
                    <div class="bg-green-200 flex justify-center items-center p-6">
                        <img alt="Green library building icon on medium green background"
                            class="max-w-full max-h-full" height="120"
                            src="https://storage.googleapis.com/a1aa/image/71c14d6e-f25f-4f3f-0545-6426b7036834.jpg"
                            width="120" />
                    </div>
                </div>
                <!-- Project Timeline -->
                <div class="bg-green-100 p-2 rounded text-[11px] text-green-900 leading-tight">
                    <p class="flex items-center gap-1 mb-1 font-semibold">
                        <i class="fas fa-info-circle"> </i>
                        Project Timeline
                    </p>
                    <ul class="list-disc list-inside space-y-0.5">
                        <li>Phase 1 (Completed): Classroom renovations</li>
                        <li>Phase 2 (In Progress): Library expansion</li>
                        <li>Phase 3 (Starting June): Playground installation</li>
                        <li>Project Completion: July 2023</li>
                    </ul>
                </div>
            </div>
            <!-- Footer -->
            <div
                class="border-t border-gray-200 flex justify-between items-center px-3 py-2 text-gray-500 text-[11px] relative">
                <div class="flex items-center gap-1 relative">
                    <i class="fas fa-thumbs-up cursor-pointer select-none m-0" id="like-icon-post" style="color: #2CAC5B;
                        aria-label="Post like icon">
                    </i>
                    <i class="fas fa-heart cursor-pointer select-none m-0" id="like-icon-post" style="color: crimson;"
                        aria-label="Post like icon">
                    </i>
                    <i class="fas fa-laugh-squint cursor-pointer select-none m-0" id="like-icon-post" style="color: #FFC83D;"
                        aria-label="Post like icon">
                    </i>
                    <i class="fas fa-sad-tear cursor-pointer select-none m-0" id="like-icon-post" style="color: #FFC83D;"
                        aria-label="Post like icon">
                    </i>
                    <i class="fas fa-angry cursor-pointer select-none m-0" id="like-icon-post" style="color: #e74c3c;"
                        aria-label="Post like icon">
                    </i>
                    <span id="reaction-summary" class="text-gray-700 text-[11px] ml-2 select-none cursor-default">
                        100 reactions
                    </span>
                    <span id="reaction-summary" class="text-gray-700 text-[11px] ml-1 select-none cursor-default">
                        68 reactions
                    </span>
                </div>
                <span> 24 comments </span>
            </div>
            <div class="border-t border-gray-200 flex justify-around text-gray-600 text-[11px] py-2">
                <button class="flex items-center gap-1 hover:text-gray-800 relative" id="like-button-footer"
                    aria-haspopup="true" aria-expanded="false" aria-controls="reaction-popup-footer"
                    aria-label="Like button with reactions">
                    <i class="far fa-thumbs-up fa-lg"> </i>
                    <!-- Reaction popup footer -->
                    <div class="reaction-popup" id="reaction-popup-footer" role="list"
                        aria-label="Reactions">
                        <span role="button" aria-label="Like" data-reaction="like" title="Like">👍</span>
                        <span role="button" aria-label="Love" data-reaction="love" title="Love">💖</span>
                        <span role="button" aria-label="Haha" data-reaction="haha" title="Haha">😂</span>
                        <span role="button" aria-label="Sad" data-reaction="sad" title="Sad">😥</span>
                        <span role="button" aria-label="Angry" data-reaction="angry" title="Angry">😡</span>
                    </div>
                </button>
                <button class="flex items-center gap-1 hover:text-gray-800" id="comment-toggle-button"
                    aria-expanded="false" aria-controls="comments-section">
                    <i class="far fa-comment fa-lg"> </i>
                    Comment
                </button>
                <button class="flex items-center gap-1 hover:text-gray-800">
                    <i class="fas fa-share fa-lg"> </i>
                    Share
                </button>
            </div>
        </div>
        <div class="mt-8 flex justify-center">
            <button
                class="bg-green-800 text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-md hover:bg-green-900">
                View All News
            </button>
        </div>

    </section>

    <section class="max-w-7xl mx-auto px-6 pb-12">
        <h2 class="text-center font-bold text-lg sm:text-xl mb-2">Events</h2>
        <p class="text-center text-gray-600 text-xs sm:text-sm mb-8 max-w-md mx-auto">
            Stay updated with the latest happenings at Irosin Central School.
        </p>

        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="bg-white rounded-xl p-6 shadow-md border">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-[#d9f0e1] rounded-md text-[#2f7a4e] font-semibold text-center w-14">
                <div class="text-xl leading-none pt-1 font-bold">28</div>
                <div class="text-sm pb-1">May</div>
                </div>
                <div class="bg-[#0b6b2f] text-white text-xs rounded-full px-3 py-1 font-semibold self-start">
                Academic
                </div>
            </div>
            <h3 class="font-bold text-[#0a1f3f] text-lg mb-1">Science Fair 2023</h3>
            <p class="text-[#4a5568] mb-4 text-sm leading-relaxed">
                Annual science fair showcasing student projects and innovations across all grade levels.
            </p>
            <div class="flex items-center text-[#6b7280] text-xs space-x-2 mb-1">
                <i class="far fa-clock"></i>
                <span>9:00 AM – 4:00 PM</span>
            </div>
            <div class="flex items-center text-[#6b7280] text-xs space-x-2">
                <i class="fas fa-map-marker-alt"></i>
                <span>School Gymnasium</span>
            </div>
            </div>
        
            <!-- Card 2 -->
            <div class="bg-white rounded-xl p-6 shadow-md border">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-[#d9f0e1] rounded-md text-[#2f7a4e] font-semibold text-center w-14">
                <div class="text-xl leading-none pt-1 font-bold">05</div>
                <div class="text-sm pb-1">Jun</div>
                </div>
                <div class="bg-[#0b6b2f] text-white text-xs rounded-full px-3 py-1 font-semibold self-start">
                Cultural
                </div>
            </div>
            <h3 class="font-bold text-[#0a1f3f] text-lg mb-1">Arts &amp; Culture Festival</h3>
            <p class="text-[#4a5568] mb-4 text-sm leading-relaxed">
                A celebration of arts, music, and cultural performances by our talented students.
            </p>
            <div class="flex items-center text-[#6b7280] text-xs space-x-2 mb-1">
                <i class="far fa-clock"></i>
                <span>1:00 PM – 5:00 PM</span>
            </div>
            <div class="flex items-center text-[#6b7280] text-xs space-x-2">
                <i class="fas fa-map-marker-alt"></i>
                <span>School Auditorium</span>
            </div>
            </div>
        
            <!-- Card 3 -->
            <div class="bg-white rounded-xl p-6 shadow-md border">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-[#d9f0e1] rounded-md text-[#2f7a4e] font-semibold text-center w-14">
                <div class="text-xl leading-none pt-1 font-bold">12</div>
                <div class="text-sm pb-1">Jun</div>
                </div>
                <div class="bg-[#0b6b2f] text-white text-xs rounded-full px-3 py-1 font-semibold self-start">
                Sports
                </div>
            </div>
            <h3 class="font-bold text-[#0a1f3f] text-lg mb-1">Annual Sports Meet</h3>
            <p class="text-[#4a5568] mb-4 text-sm leading-relaxed">
                Inter-class sports competition featuring various athletic events and team sports.
            </p>
            <div class="flex items-center text-[#6b7280] text-xs space-x-2 mb-1">
                <i class="far fa-clock"></i>
                <span>8:00 AM – 5:00 PM</span>
            </div>
            <div class="flex items-center text-[#6b7280] text-xs space-x-2">
                <i class="fas fa-map-marker-alt"></i>
                <span>School Sports Field</span>
            </div>
            </div>
        
            <!-- Card 4 -->
            <div class="bg-white rounded-xl p-6 shadow-md border">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-[#d9f0e1] rounded-md text-[#2f7a4e] font-semibold text-center w-14">
                <div class="text-xl leading-none pt-1 font-bold">20</div>
                <div class="text-sm pb-1">Jun</div>
                </div>
                <div class="bg-[#0b6b2f] text-white text-xs rounded-full px-3 py-1 font-semibold self-start">
                Community
                </div>
            </div>
            <h3 class="font-bold text-[#0a1f3f] text-lg mb-1">Community Outreach Day</h3>
            <p class="text-[#4a5568] mb-4 text-sm leading-relaxed">
                Students and teachers will participate in various community service activities around Irosin.
            </p>
            <div class="flex items-center text-[#6b7280] text-xs space-x-2 mb-1">
                <i class="far fa-clock"></i>
                <span>7:00 AM – 3:00 PM</span>
            </div>
            <div class="flex items-center text-[#6b7280] text-xs space-x-2">
                <i class="fas fa-map-marker-alt"></i>
                <span>Various Locations</span>
            </div>
            </div>
        
            <!-- Card 5 -->
            <div class="bg-white rounded-xl p-6 shadow-md border">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-[#d9f0e1] rounded-md text-[#2f7a4e] font-semibold text-center w-14">
                <div class="text-xl leading-none pt-1 font-bold">25</div>
                <div class="text-sm pb-1">Jun</div>
                </div>
                <div class="bg-[#0b6b2f] text-white text-xs rounded-full px-3 py-1 font-semibold self-start">
                Academic
                </div>
            </div>
            <h3 class="font-bold text-[#0a1f3f] text-lg mb-1">Math Olympiad</h3>
            <p class="text-[#4a5568] mb-4 text-sm leading-relaxed">
                Annual mathematics competition for elementary and junior high school students.
            </p>
            <div class="flex items-center text-[#6b7280] text-xs space-x-2 mb-1">
                <i class="far fa-clock"></i>
                <span>9:00 AM – 12:00 PM</span>
            </div>
            <div class="flex items-center text-[#6b7280] text-xs space-x-2">
                <i class="fas fa-map-marker-alt"></i>
                <span>School Library</span>
            </div>
            </div>
        
            <!-- Card 6 -->
            <div class="bg-white rounded-xl p-6 shadow-md border">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-[#d9f0e1] rounded-md text-[#2f7a4e] font-semibold text-center w-14">
                <div class="text-xl leading-none pt-1 font-bold">30</div>
                <div class="text-sm pb-1">Jun</div>
                </div>
                <div class="bg-[#0b6b2f] text-white text-xs rounded-full px-3 py-1 font-semibold self-start">
                Special
                </div>
            </div>
            <h3 class="font-bold text-[#0a1f3f] text-lg mb-1">School Foundation Day</h3>
            <p class="text-[#4a5568] mb-4 text-sm leading-relaxed">
                Celebration of the school's founding anniversary with various activities and programs.
            </p>
            <div class="flex items-center text-[#6b7280] text-xs space-x-2">
                <i class="far fa-clock"></i>
                <span>All Day</span>
            </div>
            </div>
        </div>
        <div class="mt-8 flex justify-center">
            <button
                class="bg-green-800 text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-md hover:bg-green-900">
                View All News
            </button>
        </div>
    </section>
    
    
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Handle all reaction buttons
            const likeButtons = document.querySelectorAll('[aria-label="Like button with reactions"]');
            const topIcons = document.querySelectorAll('#like-icon-post');

            const reactionMap = {
                like:  { class: ['fas', 'fa-thumbs-up', 'fa-lg'], color: '#2CAC5B' },
                love:  { class: ['fas', 'fa-heart', 'fa-lg'], color: 'crimson' },
                haha:  { class: ['fas', 'fa-laugh-squint', 'fa-spin', 'fa-lg'], color: '#FFC83D' }, //<i class="fas fa-laugh-squint"></i>
                sad:   { class: ['fas', 'fa-sad-tear', 'fa-lg'], color: '#FFC83D' },
                angry: { class: ['fas', 'fa-angry', 'fa-lg'], color: '#e74c3c' }
            };

            likeButtons.forEach((button) => {
                const popup = button.querySelector(".reaction-popup");

                // Show popup on mouseenter
                button.addEventListener("mouseenter", () => {
                    popup.classList.add("show");
                });

                // Hide popup on mouseleave
                button.addEventListener("mouseleave", () => {
                    popup.classList.remove("show");
                });

                // Reaction click inside this button
                const reactions = popup.querySelectorAll("span");
                reactions.forEach((reaction) => {
                    reaction.addEventListener("click", (e) => {
                        const type = e.target.getAttribute("data-reaction");
                        const icon = button.querySelector("i");

                        if (!icon || !reactionMap[type]) return;

                        // Update icon class and style
                        icon.className = ''; // Clear existing classes
                        reactionMap[type].class.forEach(cls => icon.classList.add(cls));
                        icon.style.color = reactionMap[type].color;

                        // Optional: close popup
                        popup.classList.remove("show");

                        // Optional: Send to server or update state
                        console.log(`You reacted with: ${type}`);
                    });
                });
            });

            // Top like icons (next to the "68 reactions" text)
            topIcons.forEach((icon) => {
                const container = icon.closest(".relative");
                const popup = container.querySelector(".reaction-popup");

                icon.addEventListener("mouseenter", () => {
                    popup.classList.add("show");
                });

                icon.addEventListener("mouseleave", () => {
                    popup.classList.remove("show");
                });

                popup.addEventListener("mouseenter", () => {
                    popup.classList.add("show");
                });

                popup.addEventListener("mouseleave", () => {
                    popup.classList.remove("show");
                });
            });
        });

    </script>

<flux:modal.trigger name="edit-profile">
    <flux:button>Edit profile</flux:button>
</flux:modal.trigger>

<flux:modal name="edit-profile" variant="flyout" position="bottom">
    <div class="space-y-6 lg-h-100">
        <div>
            <flux:heading size="lg">Update profile</flux:heading>
            <flux:text class="mt-2">Make changes to your personal details.</flux:text>
        </div>

        <flux:input label="Name" placeholder="Your name" />

        <flux:input label="Date of birth" type="date" />

        <div class="flex">
            <flux:spacer />

            <flux:button type="submit" variant="primary">Save changes</flux:button>
        </div>
    </div>
</flux:modal>
@fluxScripts()
</body>
</html>
