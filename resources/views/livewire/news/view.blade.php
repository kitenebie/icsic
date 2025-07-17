    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-20">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left content -->
            <main class="flex-1 max-w-full lg:max-w-[720px]">
                <!-- Breadcrumb -->
                <nav aria-label="Breadcrumb" class="text-[13px] text-[#64748b] mb-4">
                    <ol class="inline-flex space-x-1">
                        <li>
                            <a class="hover:underline" href="#">
                                Home
                            </a>
                            <span class="mx-1">
                                ›
                            </span>
                        </li>
                        <li>
                            <a class="hover:underline" href="#">
                                {{ $this->Topic_category() }}
                            </a>
                            <span class="mx-1">
                                ›
                            </span>
                        </li>
                        <li aria-current="page" class="font-semibold text-[#475569]">
                            {{ $this->Topic_title() }}
                        </li>
                    </ol>
                </nav>
                <!-- Category label -->
                <div>
                    <span
                        class="inline-block bg-[#2CAC5B] text-white text-[10px] font-semibold uppercase px-2 py-[2px] rounded">
                        {{ $this->Topic_category() }}
                    </span>
                </div>
                <!-- Title -->
                <h1 class="mt-2 text-[#0f172a] font-extrabold text-[22px] sm:text-[26px] leading-tight">
                    {{ $this->Topic_title() }}
                </h1>
                <!-- Author and meta -->
                <div class="flex flex-wrap items-center gap-4 mt-3 text-[#475569] text-[13px]">
                    <div class="flex items-center gap-2">
                        <span
                            class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-[#e0e7ff] text-[#2CAC5B]">
                            <i class="fas fa-user">
                            </i>
                        </span>
                        <div class="leading-tight">
                            <p class="font-semibold text-[#0E391E] text-[13px] leading-tight">
                                {{ $News->author }}
                            </p>
                            <p class="text-[11px] leading-tight">
                                {!! $News->author_description !!}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1 text-[12px]">
                        <i class="far fa-clock">
                        </i>
                        <span>
                            {{ $News->read_duration }} min read
                        </span>
                    </div>
                    <div class="flex items-center gap-1 text-[12px]">
                        <i class="far fa-eye">
                        </i>
                        <span>
                            {{ $News->views }} views
                        </span>
                    </div>
                </div>
                <!-- Image with caption -->
                <figure class="mt-6 rounded-lg overflow-hidden shadow-md">
                    <img alt="A quantum computer processor at the Advanced Quantum Research Laboratory with a blue to purple gradient background and a flask icon in the center"
                        class="w-full object-cover" height="240" src="/storage/{{ $News->image }}" width="720" />
                    {{-- <figcaption class="text-[11px] italic text-[#64748b] bg-white px-3 py-1">
                        A quantum computer processor at the Advanced Quantum Research Laboratory.
                        Credit: Global Science Foundation
                    </figcaption> --}}
                </figure>
                <!-- Article content -->
                <article class="mt-4 text-[14px] text-[#1e293b] space-y-5">
                    @foreach ($News->content as $key => $content)
                        <h3 id="section-{{ $key }}" class="font-semibold text-[16px] text-[#0f172a]">
                            {{ $content['subject'] }}
                        </h3>
                        @forelse($content['Paragraph'] as $paragraph)
                            {!! $paragraph['content'] !!}
                        @empty
                        @endforelse
                        @forelse($content['Quote'] as $Quote)
                            <blockquote
                                class="border-l-4 py-2 border-[#2CAC5B] pl-4 italic text-[13px] text-[#3D4B42] bg-[#B8E3C8] rounded-md">
                                <p>
                                    {!! $Quote['Quote'] !!}
                                </p>
                                <footer class="mt-1 text-[11px] not-italic text-[#3D4B42]">
                                    — {{ $News->author }}
                                </footer>
                            </blockquote>
                        @empty
                        @endforelse
                    @endforeach



                </article>
                <!-- Author bio -->
                {{-- <section aria-label="Author biography"
                    class="mt-12 bg-[#EFF8F2] rounded-lg p-6 text-[13px] text-[#3D4B42]">
                    <div class="flex gap-4">
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-[#B8E3C8] text-[#3D4B42]">
                            <i class="fas fa-user">
                            </i>
                        </span>
                        <div>
                            <p class="font-semibold text-[#3D4B42] text-[14px] leading-tight">
                                Dr. Sarah Chen
                            </p>
                            <p class="text-[12px] mb-2">
                                Science Correspondent
                            </p>
                            <p class="text-[12px] leading-relaxed">
                                Dr. Sarah Chen holds a Ph.D. in Quantum Physics from MIT and has
                                been covering scientific breakthroughs for Global Insight News for
                                over 8 years. She specializes in making complex scientific concepts
                                accessible to general audiences.
                            </p>
                        </div>
                    </div>
                </section> --}}
                <!-- Comments -->
                <section class="mt-10">
                    <h2 class="font-semibold text-[14px] text-[#0f172a] mb-4">
                        Comments ({{ $this->all_comments_Count() }})
                    </h2>
                    <!-- Comment 1 -->
                    @forelse ($main_comments as $main_comment)
                        <article aria-label="Comment by {{ $this->user_name($main_comment->commentatorId) }}"
                            class=" bg-[#E7F5EC] rounded-lg p-4 mb-6 shadow-sm text-[13px] text-[#475569]">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-[#EFF8F2] text-[#1D723C]">
                                        <i class="fas fa-user">
                                        </i>
                                    </span>
                                    <div>
                                        <p class="font-semibold text-[#3D4B42] text-[13px] leading-tight">
                                            {{ $this->user_name($main_comment->commentatorId) }}
                                        </p>
                                    </div>
                                </div>
                                <time class="text-[11px] text-[#94a3b8] whitespace-nowrap" datetime="PT2H">
                                    {{ $this->formatDateHumanReadable($main_comment->created_at) }}
                                </time>
                            </div>
                            <p class="mb-3 leading-relaxed">
                                {!! $main_comment->comment !!}
                            </p>
                            <div class="flex items-center gap-4 text-[12px] text-[#64748b]">
                                @livewire('news.like-dislike', ['commentId' => $main_comment->id], key($main_comment->id))
                                <a role="button" href="#reply"
                                    wire:click='reply("{{ $main_comment->commentatorId }}", "reply", "{{ $main_comment->id }}", "")'
                                    class="text-[#2CAC5B] font-semibold hover:underline focus:outline-none">
                                    Reply
                                </a>
                            </div>

                            <!-- Reply -->
                            @forelse ($this->reply_comment($main_comment->id) as $reply)
                                <article aria-label="Reply by {{ $this->user_name($reply->commentatorId) }}"
                                    class="mt-6 bg-[#f1f5ff] rounded-lg p-3 text-[12px] text-[#475569]">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span
                                            class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-[#e0e7ff] text-[#2CAC5B]">
                                            <i class="fas fa-user">
                                            </i>
                                        </span>
                                        <p class="font-semibold text-[#3D4B42] leading-tight">
                                            {{ $this->user_name($reply->commentatorId) }}
                                        </p>
                                        <time class="text-[10px] text-[#94a3b8] whitespace-nowrap" datetime="PT1H">
                                            {{ $this->formatDateHumanReadable($reply->created_at) }}
                                        </time>
                                    </div>
                                    <p class="leading-relaxed">
                                        {!! $reply->comment !!}
                                    </p>
                                    <div class="mt-2 flex items-center gap-4 text-[12px] text-[#64748b]">
                                        @livewire('news.like-dislike', ['commentId' => $reply->id], key($reply->id))
                                        <a role="button" href="#reply"
                                            wire:click='reply("{{ $reply->commentatorId }}", "reply", "{{ $main_comment->id }}", "{{ $reply->id }}")'
                                            class="text-[#2CAC5B] font-semibold hover:underline focus:outline-none">
                                            Reply
                                        </a>
                                    </div>

                                </article>
                            @empty
                            @endforelse
                        </article>
                    @empty
                    @endforelse

                    @if ($this->voilateWords)
                        <div class="mt-6 bg-red-100 border border-red-400 text-red-700 p-4 rounded">
                            <p class="text-[13px]">
                                <strong>Warning:</strong> Your comment contains words that violate our community
                                guidelines.
                                Please revise your comment before submitting.
                            </p>
                            {{-- add the words --}}
                            <p class="text-[12px] mt-2">
                                Violated words: <span
                                    class="font-semibold">{{ implode(', ', $this->voilateWords) }}</span>
                        </div>
                    @endif
                    <!-- Comment Input -->
                    <div id="reply" class="mt-8 bg-[#F8FAFC] p-4 rounded-lg shadow-sm">
                        <h3 class="text-[14px] font-semibold text-[#0f172a] mb-2">Leave a Comment</h3>

                        <div
                            class="text-[12px] p-2 px-4 mb-3  @if ($this->ReplycommentInput) bg-[#f1f5ff] border @endif rounded text-gray-600">
                            {!! $this->ReplycommentInput !!}</div>
                        <div class="flex items-start gap-2">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-[#EFF8F2] text-[#1D723C] mt-1">
                                <i class="fas fa-user"></i>
                            </span>
                            <form wire:submit="save_comment" class="flex-1">
                                <textarea wire:model='commentInput'
                                    class="w-full border border-[#cbd5e1] rounded-md p-2 text-[13px] text-[#334155] focus:outline-none focus:ring-2 focus:ring-[#2CAC5B]"
                                    rows="3" placeholder="Write your comment here...">{{ $this->ReplycommentInput }}</textarea>
                                <div class="mt-2 flex justify-end">
                                    <button type="submit"
                                        class="px-4 py-1.5 text-[13px] font-medium text-white bg-[#2CAC5B] rounded-md hover:bg-[#249c50] transition-colors">
                                        Send
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </main>
            <!-- Right sidebar -->
            <aside class="hidden lg:flex flex-col w-[320px] flex-shrink-0 gap-6">
                <div class="sticky top-6 space-y-6">
                    <!-- Related Articles -->
                    <section aria-label="Related Articles"
                        class="bg-white rounded-lg p-4 text-[13px] text-[#3D4B42] shadow-sm">
                        <h2 class="font-semibold mb-3 text-[14px]">
                            Related Articles
                        </h2>
                        <article class="mb-4 last:mb-0">
                            <span class="inline-block text-[10px] font-semibold uppercase text-[#2CAC5B] mb-1">
                                Technology
                            </span>
                            <h3 class="font-semibold text-[13px] text-[#0f172a] leading-tight mb-1">
                                Tech Giants Invest Billions in Quantum Computing Research
                            </h3>
                            <p class="text-[11px] text-[#64748b] leading-tight">
                                Major technology companies are racing to develop quantum computing
                                capabilities...
                            </p>
                        </article>
                        <article class="mb-4 last:mb-0">
                            <span class="inline-block text-[10px] font-semibold uppercase text-[#22c55e] mb-1">
                                Business
                            </span>
                            <h3 class="font-semibold text-[13px] text-[#0f172a] leading-tight mb-1">
                                Quantum Computing Startups Attract Record Venture Capital
                            </h3>
                            <p class="text-[11px] text-[#64748b] leading-tight">
                                Investment in quantum computing startups has reached an all-time
                                high...
                            </p>
                        </article>
                        <article>
                            <span class="inline-block text-[10px] font-semibold uppercase text-[#ec4899] mb-1">
                                Science
                            </span>
                            <h3 class="font-semibold text-[13px] text-[#0f172a] leading-tight mb-1">
                                The Physics Behind Quantum Computing Explained
                            </h3>
                            <p class="text-[11px] text-[#64748b] leading-tight">
                                Understanding the fundamental principles that make quantum computers
                                work...
                            </p>
                        </article>
                    </section>
                    <!-- Sticky Table of Contents below Related Articles -->
                    <section aria-label="Table of Contents"
                        class="bg-white rounded-lg p-4 text-[13px] text-[#3D4B42] shadow-sm">
                        <h2 class="font-semibold mb-3 text-[14px]">
                            Table of Contents
                        </h2>
                        <ul class="list-disc list-inside space-y-1 text-[#475569]">
                            @foreach ($News->content as $key => $content)
                                @if (!$content['subject'] == null)
                                    <li>
                                        <a href="#section-{{ $key }}" id="btn-section-{{ $key }}"
                                            onclick="scrollWithOffset(event, 'section-{{ $key }}')">
                                            {{ $content['subject'] }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                            {{-- <li class="text-[#2CAC5B] font-semibold hover:underline">
                                Introduction
                            </li> --}}
                        </ul>
                    </section>
                </div>
            </aside>
        </div>
        <script>
            const yOffset = -80; // consistent offset for scroll and highlight

            function scrollWithOffset(event, id) {
                event.preventDefault();

                // Remove style from previously active button
                const lastBtnId = localStorage.getItem('lastStateBtn');
                if (lastBtnId) {
                    const lastBtn = document.getElementById(lastBtnId);
                    if (lastBtn) {
                        lastBtn.classList.remove('text-[#2CAC5B]', 'font-semibold', 'hover:underline');
                    }
                }

                const element = document.getElementById(id);
                const btnElement = document.getElementById(`btn-${id}`);
                const y = element.getBoundingClientRect().top + window.pageYOffset + yOffset;

                btnElement.classList.add('text-[#2CAC5B]', 'font-semibold', 'hover:underline');
                localStorage.setItem('lastStateBtn', `btn-${id}`);

                window.scrollTo({
                    top: y,
                    behavior: 'smooth'
                });
            }

            // Auto highlight nav button during scroll
            window.addEventListener('scroll', () => {
                const sections = document.querySelectorAll('div[id^="section-"]');

                let currentSectionId = null;
                sections.forEach(section => {
                    const rect = section.getBoundingClientRect();
                    if (rect.top <= 100 && rect.bottom > 100) {
                        currentSectionId = section.id;
                    }
                });

                if (currentSectionId) {
                    // Remove old highlight
                    document.querySelectorAll('[id^="btn-section-"]').forEach(btn => {
                        btn.classList.remove('text-[#2CAC5B]', 'font-semibold', 'hover:underline');
                    });

                    // Add highlight to current button
                    const activeBtn = document.getElementById(`btn-${currentSectionId}`);
                    if (activeBtn) {
                        activeBtn.classList.add('text-[#2CAC5B]', 'font-semibold', 'hover:underline');
                        localStorage.setItem('lastStateBtn', `btn-${currentSectionId}`);
                    }
                }
            });
        </script>

    </div>
