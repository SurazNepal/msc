<div>
    <section class="pt-32 pb-16 hero-glow relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.03]" style="background-image:linear-gradient(rgba(255,255,255,.5) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.5) 1px,transparent 1px);background-size:60px 60px;"></div>
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="inline-flex items-center gap-2 pill rounded-full px-4 py-1.5 text-sm text-brand-light mb-4 font-medium">Our Services</div>
            <h1 class="font-display text-5xl md:text-6xl font-bold text-white mb-4">
                What We <span class="gradient-text">Deliver</span>
            </h1>
            <p class="text-slate-400 max-w-2xl mx-auto text-lg mb-6">Full-spectrum marketing and communication services — from national conferences to brand campaigns, executed with precision and creativity.</p>
            <div class="flex items-center justify-center gap-2 text-sm text-slate-500">
                <a href="/" class="hover:text-brand transition-colors">Home</a>
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-300">Our Services</span>
            </div>
        </div>
    </section>

    @foreach($featuredServices as $index => $service)
        <section class="py-20 max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-14 items-start">
                <div class="{{ $index % 2 != 0 ? 'lg:order-2' : '' }}">
                    <div class="inline-flex items-center gap-2 pill rounded-full px-3 py-1 text-xs text-brand-light mb-5 font-medium">Service {{ $service['index_label'] }}</div>

                    <h2 class="font-display text-3xl md:text-4xl font-bold mb-4 transition-colors">
    <a href="{{ route('services.single', $service['slug']) }}"
       wire:navigate
       class="gradient-text inline-block hover:opacity-80 transition-opacity">
        {!! e($service['title']) !!}
    </a>
</h2>

                    <div class="text-slate-400 leading-relaxed mb-8 prose prose-invert max-w-none">
                        {!! Str::words(strip_tags($service['description']), 20, '...') !!}
                    </div>

                    <div class="flex flex-wrap items-center gap-4">
                        <a href="/contact" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-brand text-white text-sm font-medium hover:bg-brand-dark transition-colors">
                            Request This Service <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>

                <div class="rounded-2xl card bg-dark-800 p-8 {{ $index % 2 != 0 ? 'lg:order-1' : '' }}">
                    <h4 class="font-display font-semibold text-white mb-5 text-sm uppercase tracking-widest text-brand">What's Included</h4>
                    @if(count($service['items']) > 0)
                        <div class="grid sm:grid-cols-2 gap-x-6">
                            @foreach(collect($service['items'])->chunk(ceil(count($service['items']) / 2)) as $chunk)
                                <div>
                                    @foreach($chunk as $item)
                                        <div class="check-item flex items-start gap-2 mb-3">
                                            <svg class="w-4 h-4 text-brand flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-slate-300 text-sm">{!! e($item) !!}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-slate-500 text-sm italic">Tailored solutions matching custom specifications.</p>
                    @endif
                </div>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-6"><div class="border-t border-white/5"></div></div>
    @endforeach

    @if($additionalServices->count() > 0)
        <section class="py-20 max-w-7xl mx-auto px-6">
            <div class="text-center mb-14">
                <div class="inline-flex items-center gap-2 pill rounded-full px-4 py-1.5 text-sm text-brand-light mb-4 font-medium">More Services</div>
                <h2 class="font-display text-4xl font-bold text-white">Additional <span class="gradient-text">specialisations</span></h2>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                @foreach($additionalServices as $service)
                    <a href="{{ route('services.single', $service['slug']) }}" wire:navigate class="card rounded-2xl bg-dark-800 p-8 flex flex-col justify-between hover:border-brand/30 transition-all group duration-300 border border-white/5">
                        <div>
                            <div class="flex items-center gap-4 mb-5">
                                <div class="w-12 h-12 rounded-xl bg-brand/20 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                    @if($service['icon'])
                                        <img src="{{ $service['icon'] }}" class="w-6 h-6 object-contain" alt="icon" />
                                    @else
                                        <svg class="w-6 h-6 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 7.5l16.5-4.125M12 6.75c-2.708 0-5.363.224-7.948.655C2.026 7.767.25 9.792.25 12.157v1.5c0 2.365 1.776 4.39 4.052 4.952A48.108 48.108 0 0012 19.5c2.7 0 5.332-.245 7.697-.693 2.276-.562 4.052-2.587 4.052-4.952v-1.5c0-2.365-1.776-4.39-4.052-4.952A48.108 48.108 0 0012 6.75z"/>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-brand text-xs font-semibold uppercase tracking-widest mb-0.5">Service {{ $service['index_label'] }}</div>
                                    <h3 class="font-display text-xl font-bold text-white group-hover:text-brand-light transition-colors">{!! e($service['title']) !!}</h3>
                                </div>
                            </div>
                            <div class="text-slate-400 text-sm leading-relaxed mb-5 prose prose-invert max-w-none">
                                {!! Str::words(strip_tags($service['description']), 20, '...') !!}
                            </div>
                        </div>

                        @if(count($service['items']) > 0)
                            <ul class="space-y-2 pt-4 border-t border-white/5">
                                @foreach(array_slice($service['items'], 0, 3) as $item)
                                    <li class="check-item flex items-start gap-2">
                                        <svg class="w-4 h-4 text-brand flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-slate-300 text-sm">{!! e($item) !!}</span>
                                    </li>
                                @endforeach
                                @if(count($service['items']) > 3)
                                    <li class="text-xs text-brand-light/70 pl-6 italic">+ {{ count($service['items']) - 3 }} more core capabilities</li>
                                @endif
                            </ul>
                        @endif
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <section class="py-16 max-w-7xl mx-auto px-6">
        <div class="rounded-3xl bg-dark-800 p-12 md:p-16 text-center relative overflow-hidden" style="border:1px solid rgba(255,255,255,.07)">
            <div class="absolute inset-0 pointer-events-none" style="background:radial-gradient(ellipse 60% 60% at 50% 100%,rgba(224,92,26,.12) 0%,transparent 70%);"></div>
            <div class="relative">
                <div class="inline-flex items-center gap-2 pill rounded-full px-4 py-1.5 text-sm text-brand-light mb-6 font-medium">Let's Collaborate</div>
                <h2 class="font-display text-4xl md:text-5xl font-bold text-white mb-4">Have an event in mind?</h2>
                <p class="text-slate-400 max-w-lg mx-auto mb-10">Tell us about your project and we'll put together a tailored proposal. No event too big, no detail too small.</p>
                <a href="/contact" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-brand text-white font-medium hover:bg-brand-dark transition-colors shadow-lg shadow-brand/20">
                    Get a Free Proposal
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </section>
</div>
