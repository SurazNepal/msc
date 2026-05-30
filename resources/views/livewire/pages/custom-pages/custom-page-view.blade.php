<div class="bg-dark-900 min-h-screen text-slate-300 font-sans selection:bg-brand selection:text-white">

    {{-- Hero Header Layout --}}
    <div class="relative py-20 md:py-28 overflow-hidden border-b border-white/5 bg-gradient-to-b from-dark-950 via-dark-900 to-dark-900">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-brand/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-emerald-500/5 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-brand-light bg-brand/10 border border-brand/20 mb-6">
                Published Document
            </div>
            <h1 class="font-display text-4xl md:text-6xl font-black text-white tracking-tight leading-tight max-w-4xl mx-auto">
                {!! Str::before($title, '&') !!}
                @if(Str::contains($title, '&'))
                    <span class="gradient-text">& {!! Str::after($title, '&') !!}</span>
                @endif
            </h1>
        </div>
    </div>

    {{-- Core Layout Container --}}
    <div class="max-w-7xl mx-auto px-6 py-16 md:py-24">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-start">

            {{-- Left Side: Main Rich Text Content Area --}}
            <div class="lg:col-span-7 space-y-8">
                <div class="prose prose-slate prose-invert max-w-none text-base md:text-lg leading-relaxed text-slate-300 font-normal
                            prose-headings:text-white prose-headings:font-bold prose-headings:tracking-tight
                            prose-strong:text-white prose-a:text-brand-light hover:prose-a:underline">
                    {!! $content !!}
                </div>
            </div>

            {{-- Right Side: Image Banner & Document Metadata --}}
            <div class="lg:col-span-5 space-y-6">

                {{-- Featured Image Box --}}
                <div class="relative aspect-[4/3] rounded-2xl overflow-hidden border border-white/10 bg-dark-950 group shadow-2xl">
                    @if($imageUrl)
                        <img src="{{ $imageUrl }}"
                             alt="{{ $title }}"
                             class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center p-6 text-center bg-gradient-to-br from-dark-950 to-dark-900 text-slate-600">
                            <svg class="w-12 h-12 mb-3 text-slate-700 stroke-[1.25]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                            <span class="text-xs font-medium tracking-wide text-slate-500">No Image Asset Assigned</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-dark-950/60 to-transparent pointer-events-none"></div>
                </div>

                {{-- Metadata Tracking Info Grid --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl border border-white/5 bg-dark-950/20 space-y-1">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Timeline</div>
                        <div class="text-xs font-semibold text-white truncate" title="Date Published">
                            Published
                        </div>
                        <div class="text-[11px] text-slate-400">
                            {{ $createdAt }}
                        </div>
                    </div>

                    <div class="p-4 rounded-xl border border-white/5 bg-dark-950/20 space-y-1">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Content Metrics</div>
                        <div class="text-xs font-semibold text-white truncate" title="Approximate Reading Length">
                            Estimated Length
                        </div>
                        <div class="text-[11px] text-slate-400">
                            {{ str_word_count(strip_tags($content)) }} words
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
