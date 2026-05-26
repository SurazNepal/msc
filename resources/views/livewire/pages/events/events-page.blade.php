<div class="py-16 bg-dark-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-14">
            <div>
                <div class="inline-flex items-center gap-2 pill rounded-full px-4 py-1.5 text-sm text-brand-light mb-5 font-medium bg-brand/10">
                    Our Achievements
                </div>
                <h2 class="font-display text-4xl md:text-5xl font-bold text-white leading-tight">
                    Events delivered with<br/><span class="gradient-text">excellence</span>
                </h2>
            </div>

            <div class="relative w-full md:w-80">
                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    placeholder="Search events..."
                    class="w-full bg-dark-800 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-brand/50 transition-colors"
                />
            </div>
        </div>

        @if($events->isEmpty())
            <div class="col-span-full border border-dashed border-white/10 rounded-2xl p-12 text-center text-slate-500 bg-dark-800/40">
                No portfolio event highlights available at this time.
            </div>
        @else
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($events as $event)
                    <a href="{{ route('events.single', $event->slug) }}"
                       wire:navigate
                       wire:key="frontend-portfolio-{{ $event->slug }}"
                       class="project-card group block relative rounded-2xl overflow-hidden border border-white/10 bg-dark-800 transition-all duration-300 hover:border-brand/30 hover:-translate-y-1 hover:shadow-2xl">

                        <div class="aspect-[4/3] overflow-hidden bg-dark-700 relative">
                            @if($event->hasMedia('portfolio_image'))
                                <img src="{{ $event->getFirstMediaUrl('portfolio_image', 'large') }}"
                                     alt="{{ $event->title }}"
                                     class="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-105 transition-all duration-500" />
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-dark-950 text-slate-700">
                                    <svg class="w-12 h-12 text-white/10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="p-6 bg-dark-800">
                            <div class="flex flex-wrap gap-2 mb-4">
                                @if(is_array($event->tags))
                                    @foreach(array_slice($event->tags, 0, 2) as $tag)
                                        <span class="px-2.5 py-0.5 rounded-full bg-brand/10 text-brand text-xs font-medium whitespace-nowrap uppercase tracking-wider">
                                            {{ $tag }}
                                        </span>
                                    @endforeach
                                @endif

                                @if(!empty($event->year))
                                    <span class="px-2.5 py-0.5 rounded-full bg-white/5 text-slate-400 text-xs font-semibold whitespace-nowrap">
                                        {{ $event->year }}
                                    </span>
                                @endif
                            </div>

                            <h3 class="font-display font-bold text-white text-lg md:text-xl leading-snug line-clamp-1 group-hover:text-brand-light transition-colors duration-300">
                                {{ $event->title }}
                            </h3>

                            @if(!empty($event->description))
                                <p class="text-slate-400 text-sm mt-2 line-clamp-2 leading-relaxed">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($event->description), 120, '...') }}
                                </p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-12 pt-8 border-t border-white/5">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</div>
