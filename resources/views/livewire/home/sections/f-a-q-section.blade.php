<!-- ===== FAQ / SERVICES DETAIL ===== -->
<section id="faq" class="py-24 max-w-7xl mx-auto px-6">
    <div class="grid lg:grid-cols-2 gap-16 items-start">
        <div class="lg:sticky lg:top-28">
            <div class="inline-flex items-center gap-2 pill rounded-full px-4 py-1.5 text-sm text-brand-light mb-5 font-medium">Service Details</div>
            <h2 class="font-display text-4xl md:text-5xl font-bold text-white mb-6">
                What's included<br/>in our <span class="gradient-text">services?</span>
            </h2>
            <p class="text-slate-400 mb-8">Each service is fully customisable to your needs. Click on a service to see the full scope of what we deliver.</p>
            <a href="#contact" class="inline-flex items-center gap-2 px-6 py-3 rounded-full border border-brand/50 text-brand text-sm font-medium hover:bg-brand hover:text-white transition-colors">
                Request a Proposal
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="space-y-4">
            @forelse($services as $service)
                <div class="rounded-2xl border border-white/10 bg-dark-800 overflow-hidden" wire:key="frontend-service-{{ $service->id }}">
                    <button class="faq-btn w-full text-left px-6 py-5 flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-display font-semibold text-white pr-4">{{ $service->title }}</span>
                        <svg class="faq-icon w-5 h-5 text-brand flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                    </button>
                    <div class="faq-answer px-6 pb-0">
                        <div class="text-slate-400 text-sm leading-relaxed pb-5">
                            {{-- Strips dirty style tags while preserving formatting like line breaks or bold definitions safely --}}
                            {!! strip_tags($service->description, '<strong><b><i><em><u><br><p>') !!}
                        </div>
                    </div>
                </div>
            @empty
                <div class="border border-dashed border-white/10 rounded-2xl p-12 text-center text-slate-500">
                    No individual service capabilities listed at this time.
                </div>
            @endforelse
        </div>
    </div>
</section>
