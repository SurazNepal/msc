<div>
    <section class="pt-32 pb-16 hero-glow relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.03]" style="background-image:linear-gradient(rgba(255,255,255,.5) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.5) 1px,transparent 1px);background-size:60px 60px;"></div>
        <div class="max-w-4xl mx-auto px-6 text-center">

            <a href="{{ route('our-services') }}" wire:navigate class="inline-flex items-center gap-2 text-sm text-slate-400 hover:text-brand-light transition-colors mb-8 group">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to All Services
            </a>

            <h1 class="font-display gradient-text text-4xl md:text-5xl font-bold text-white mb-6">
                {{ $service->title }}
            </h1>

            <div class="flex items-center justify-center gap-2 text-sm text-slate-500">
                <a href="/" class="hover:text-brand transition-colors">Home</a>
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('services') }}" class="hover:text-brand transition-colors">Services</a>
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-300">{{ $service->title }}</span>
            </div>
                       </div>
    </section>

    <section class="py-20 max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-3 gap-10 items-start">

            <div class="lg:col-span-2">
                @if($icon)
                    <div class="w-16 h-16 rounded-2xl bg-brand/10 border border-brand/20 flex items-center justify-center mb-6">
                        <img src="{{ $icon }}" class="w-8 h-8 object-contain" alt="service icon" />
                    </div>
                    @endif

                <div class="text-slate-300 leading-relaxed text-lg prose prose-invert max-w-none">
                    {!! $htmlContent !!}
                </div>
                <div class="mt-10">
                    <a href="/contact" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-brand text-white text-sm font-medium hover:bg-brand-dark transition-colors shadow-lg shadow-brand/10">
                        Get a Free Proposal For This Service
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>

            <div class="rounded-2xl card bg-dark-800 p-8 sticky top-28 border border-white/5">
                <h4 class="font-display font-semibold text-white mb-5 text-sm uppercase tracking-widest text-brand">What's Included</h4>

                @if(count($features) > 0)
                    <div class="space-y-3.5">
                        @foreach($features as $item)
                            <div class="check-item flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-brand flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-slate-300 text-sm leading-snug">{!! e($item) !!}</span>
                            </div>
                            @endforeach
                    </div>
                    @else
                    <p class="text-slate-500 text-sm italic">Tailored premium layout specifications matching your requirements.</p>
                    @endif
            </div>

        </div>
    </section>
</div>
