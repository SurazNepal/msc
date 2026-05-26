<!-- ===== PROJECTS / ACHIEVEMENTS ===== -->
<section id="projects" class="py-24 bg-dark-800">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-14">
            <div>
                <div class="inline-flex items-center gap-2 pill rounded-full px-4 py-1.5 text-sm text-brand-light mb-5 font-medium bg-brand/10">
                    Our Achievements
                </div>
                <h2 class="font-display text-4xl md:text-5xl font-bold text-white">
                    Events delivered with<br/><span class="gradient-text">excellence</span>
                </h2>
            </div>
            <div class="text-right">
                <div class="font-display text-4xl font-bold text-white">14<span class="text-brand">+</span></div>
                <div class="text-slate-400 text-sm max-w-xs">Years of delivering exceptional events and communications across Nepal</div>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @forelse($portfolioEvents as $event)
                <a href="{{ route('events.single', $event->slug) }}" wire:navigate class="project-card group block relative rounded-2xl overflow-hidden border border-white/10 bg-dark-700 transition-all duration-300 hover:border-brand/30 hover:-translate-y-1" wire:key="frontend-portfolio-{{ $event->id }}">
                    <div class="aspect-[4/3] overflow-hidden bg-dark-700">
                        @if($event->hasMedia('portfolio_image'))
                            <img src="{{ $event->getFirstMediaUrl('portfolio_image', 'large') }}"
                                 alt="{{ $event->title }}"
                                 class="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-105 transition-all duration-500" />
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-dark-950">
                                <span class="font-display text-white/20 text-xl px-4 text-center">{{ $event->title }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="p-6 bg-dark-700">
                        <div class="flex flex-wrap gap-2 mb-3">
                            @if(is_array($event->tags))
                                @foreach(array_slice($event->tags, 0, 2) as $tag)
                                    <span class="px-2.5 py-1 rounded-full bg-brand/10 text-brand text-xs whitespace-nowrap uppercase tracking-wider font-medium">{{ $tag }}</span>
                                @endforeach
                            @endif

                            @if(!empty($event->year))
                                <span class="px-2.5 py-1 rounded-full bg-white/5 text-slate-400 text-xs whitespace-nowrap font-semibold">{{ $event->year }}</span>
                            @endif
                        </div>
                        <h3 class="font-display font-bold text-white text-base md:text-lg leading-snug group-hover:text-brand-light transition-colors duration-300">{{ $event->title }}</h3>
                    </div>
                </a>
            @empty
                <div class="col-span-full border border-dashed border-white/10 rounded-2xl p-12 text-center text-slate-500">
                    No portfolio event highlights available at this time.
                </div>
            @endforelse
        </div>
        <div class="mt-14 flex justify-center">
            <a href="{{ route('events') }}"
               wire:navigate
               class="inline-flex items-center gap-2 pill rounded-full px-6 py-2.5 text-sm text-brand-light font-medium bg-brand/10 border border-brand/20 hover:bg-brand/20 hover:scale-[1.03] active:scale-[0.98] transition-all duration-300 shadow-md">
                View All Events
                <svg class="w-4 h-4 text-brand-light transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>
    </div>
</section>
