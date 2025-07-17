<div>
    <!-- SidebarNotification -->
    <div id="rightSidebarNotification" style="z-index: 9999"
        class="fixed top-0 right-0 h-full w-80 bg-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out z-40 overflow-y-auto">
        <div class="p-4 flex justify-between items-center border-b">
            <h2 class="text-lg font-semibold">Notifications</h2>
            <button onclick="closeSidebarNotification()"
                class="text-gray-500 hover:text-red-600 text-xl font-bold">&times;</button>
        </div>
        <!-- Notification Items -->
        <div class="divide-y lg:min-w-[300px] divide-gray-200">
            @foreach (\App\Models\Notification::latest()->get() as $notif)
                @php
                    $viewed = collect($notif->user_id_who_already_viewed);
                    $isViewed = $viewed->contains(auth()->id());

                    // Convert to array if it's a comma-separated string
                    $canViewList = is_array($notif->user_id_who_can_viewed)
                        ? $notif->user_id_who_can_viewed
                        : explode(',', $notif->user_id_who_can_viewed);

                    $canView = empty($notif->user_id_who_can_viewed) || in_array(auth()->id(), $canViewList);
                @endphp

                @if ($canView)
                    <div class="flex items-start gap-4 p-4 {{ $isViewed ? 'hover:bg-gray-100' : 'bg-blue-50 hover:bg-blue-100' }} transition-all cursor-pointer"
                        onclick="markAsRead({{ $notif->id }})">
                        <img src="/storage/{{ $notif->author_profile }}" class="w-10 h-10 rounded-full" alt="Avatar">

                        <div class="flex-1">
                            <!-- Author Name -->
                            <p class="text-sm font-semibold text-gray-900">{{ $notif->author_name }}</p>

                            <!-- Description -->
                            <p class="text-sm {{ $isViewed ? 'text-gray-700' : 'text-gray-800 font-medium' }}">
                                {{ $notif->category }}: {{ \Illuminate\Support\Str::limit($notif->descriptions, 100) }}

                            </p>

                            <!-- Timestamp -->
                            <p class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}
                            </p>
                        </div>

                        @unless ($isViewed)
                            <span class="w-2 h-2 bg-blue-600 rounded-full mt-2"></span>
                        @endunless
                    </div>
                @endif
            @endforeach
        </div>

    </div>

    <!-- OverlayNotification -->
    <div id="overlayNotification" class="fixed inset-0 bg-black bg-opacity-40 hidden z-30"
        onclick="closeSidebarNotification()"></div>

    <!-- JavaScript -->
    <script>
        const sidebarNotification = document.getElementById('rightSidebarNotification');
        const overlayNotification = document.getElementById('overlayNotification');

        function modalNotify() {
            sidebarNotification.classList.remove('translate-x-full');
            overlayNotification.classList.remove('hidden');
        }

        function closeSidebarNotification() {
            sidebarNotification.classList.add('translate-x-full');
            overlayNotification.classList.add('hidden');
        }

        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/mark-as-read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'ok' && data.redirect) {
                        window.location.href = data.redirect;
                    }
                });
        }
    </script>
</div>
