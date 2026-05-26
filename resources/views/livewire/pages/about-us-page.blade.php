<div class="bg-dark-900 min-h-screen text-slate-300 font-sans selection:bg-brand selection:text-white">

    <div class="relative py-20 md:py-28 overflow-hidden border-b border-white/5 bg-gradient-to-b from-dark-950 via-dark-900 to-dark-900">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-brand/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-emerald-500/5 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-brand-light bg-brand/10 border border-brand/20 mb-6">
                {{ $settings->badge_text }}
            </div>
            <h1 class="font-display text-4xl md:text-6xl font-black text-white tracking-tight leading-tight max-w-4xl mx-auto">
                {!! Str::before($settings->title, '&') !!}
                @if(Str::contains($settings->title, '&'))
                    <span class="gradient-text">& {!! Str::after($settings->title, '&') !!}</span>
                @endif
            </h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-16 md:py-24">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-start">

            <div class="lg:col-span-7 space-y-8">
                <div class="space-y-6 text-base md:text-lg leading-relaxed text-slate-300 font-normal">
                    <p class="border-l-2 border-brand pl-4 py-1 font-medium text-white text-lg md:text-xl">
                        {{ $settings->description_one }}
                    </p>
                    @if($settings->description_two)
                        <p class="text-slate-400">
                            {{ $settings->description_two }}
                        </p>
                    @endif
                </div>

                <div class="inline-flex items-center gap-6 p-6 rounded-2xl border border-white/10 bg-dark-950/40 backdrop-blur-sm shadow-xl">
                    <div class="text-4xl md:text-5xl font-black font-display text-brand-light tracking-tight">
                        {{ $settings->stats_count }}
                    </div>
                    <div class="text-xs uppercase tracking-wider font-semibold text-slate-400 max-w-[120px] leading-snug">
                        {{ $settings->stats_label }}
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 space-y-6">
                <div class="relative aspect-[4/3] rounded-2xl overflow-hidden border border-white/10 bg-dark-950 group shadow-2xl">
                    @if($settings->hasMedia('about_banner'))
                        <img src="{{ $settings->getFirstMediaUrl('about_banner') }}"
                             alt="About Mind Share Connect"
                             class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center p-6 text-center bg-gradient-to-br from-dark-950 to-dark-900 text-slate-600">
                            <svg class="w-12 h-12 mb-3 text-slate-700 stroke-[1.25]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                            <span class="text-xs font-medium tracking-wide text-slate-500">Mind Share Connect Corporate Identity</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-dark-950/60 to-transparent pointer-events-none"></div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl border border-white/5 bg-dark-950/20 space-y-1">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Registration Details</div>
                        <div class="text-xs font-semibold text-white truncate" title="{{ $settings->registration_number }}">
                            {{ $settings->registration_number }}
                        </div>
                        <div class="text-[11px] text-slate-400">
                            {{ $settings->registration_date_text }}
                        </div>
                    </div>

                    <div class="p-4 rounded-xl border border-white/5 bg-dark-950/20 space-y-1">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Tax Identification</div>
                        <div class="text-xs font-semibold text-white truncate" title="{{ $settings->pan_vat_number }}">
                            {{ $settings->pan_vat_number }}
                        </div>
                        <div class="text-[11px] text-slate-400">
                            {{ $settings->pan_vat_date_text }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @if($highlights->isNotEmpty())
        <div class="border-t border-white/5 bg-dark-950/30 py-20 md:py-24">
            <div class="max-w-7xl mx-auto px-6">

                <div class="mb-12 md:mb-16">
                    <h2 class="font-display text-2xl md:text-4xl font-bold text-white tracking-tight">
                        Our Core <span class="gradient-text">Highlights</span>
                    </h2>
                    <p class="text-xs text-slate-400 mt-1 max-w-md">The core pillars and key structural milestones that set our delivery standards apart.</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($highlights as $highlight)
                        <div class="p-6 rounded-2xl border border-white/10 bg-dark-900/40 flex flex-col justify-between transition duration-300 hover:border-white/20 hover:-translate-y-1 hover:bg-dark-900/70 group">
                            <div class="space-y-4">
                                <div class="w-10 h-10 rounded-xl bg-brand/10 border border-brand/20 flex items-center justify-center text-brand-light group-hover:scale-105 transition-transform duration-300">
                                    @if($highlight->hasMedia('highlight_icon'))
                                        <img src="{{ $highlight->getFirstMediaUrl('highlight_icon') }}"
                                             alt="{{ $highlight->title }}"
                                             class="w-5 h-5 object-contain">
                                    @else
                                        <svg class="w-5 h-5 stroke-[1.75]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @endif
                                </div>

                                <div class="space-y-2">
                                    <h3 class="font-display font-semibold text-white text-base">
                                        {{ $highlight->title }}
                                    </h3>
                                    <p class="text-xs text-slate-400 leading-relaxed font-normal">
                                        {{ $highlight->description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    @endif
</div>
