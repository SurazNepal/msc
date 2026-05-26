<!-- ===== TESTIMONIALS ===== -->
<section id="testimonials" class="py-24 bg-dark-800 overflow-hidden group">
    <div class="max-w-7xl mx-auto px-6 mb-14 text-center">
        <div class="inline-flex items-center gap-2 pill rounded-full px-4 py-1.5 text-sm text-brand-light mb-5 font-medium">Testimonials</div>
        <h2 class="font-display text-4xl md:text-5xl font-bold text-white">What Our <span class="gradient-text">Clients Say</span></h2>
    </div>

    @if($reviews->isEmpty())
        <div class="text-center py-8">
            <p class="text-slate-400 text-sm">No client testimonials have been published yet.</p>
        </div>
    @else
        <div class="relative w-full flex overflow-x-hidden [mask-image:_linear-gradient(to_right,_transparent_0%,_white_10%,_white_90%,_transparent_100%)]">

            <div class="animate-marquee group-hover:pause-marquee flex gap-6 whitespace-nowrap min-w-max shrink-0 items-stretch py-4 pr-6">
                @foreach($reviews as $review)
                    <div class="w-[380px] shrink-0 rounded-2xl border border-white/10 bg-dark-900/50 p-6 flex flex-col justify-between whitespace-normal transition-all duration-300 hover:scale-[1.02] hover:border-brand/40 hover:bg-dark-900/80 hover:shadow-[0_10px_30px_-15px_rgba(224,92,26,0.15)]">
                        <div>
                            <div class="flex gap-1 mb-4">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-brand fill-current' : 'text-white/10' }}" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>

                            <p class="text-slate-300 leading-relaxed mb-5 text-sm break-words line-clamp-4">
                                "{{ $review->comment }}"
                            </p>
                        </div>

                        <div class="flex items-center gap-3 mt-auto pt-2 border-t border-white/5">
                            @php
                                $words = explode(' ', $review->name);
                                $initials = strtoupper(substr($words[0] ?? '', 0, 1) . substr($words[1] ?? '', 0, 1));
                            @endphp
                            <div class="w-9 h-9 rounded-full bg-brand/20 border border-brand/30 flex items-center justify-center text-xs font-bold text-brand-light uppercase tracking-wider shrink-0">
                                {{ $initials }}
                            </div>
                            <div>
                                <div class="font-display font-semibold text-white text-sm">{{ $review->name }}</div>
                                <div class="text-slate-400 text-xs mt-0.5">{{ $review->designation ?? 'Guest Client' }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div aria-hidden="true" class="animate-marquee group-hover:pause-marquee flex gap-6 whitespace-nowrap min-w-max shrink-0 items-stretch py-4 pr-6">
                @foreach($reviews as $review)
                    <div class="w-[380px] shrink-0 rounded-2xl border border-white/10 bg-dark-900/50 p-6 flex flex-col justify-between whitespace-normal transition-all duration-300 hover:scale-[1.02] hover:border-brand/40 hover:bg-dark-900/80 hover:shadow-[0_10px_30px_-15px_rgba(224,92,26,0.15)]">
                        <div>
                            <div class="flex gap-1 mb-4">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-brand fill-current' : 'text-white/10' }}" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>

                            <p class="text-slate-300 leading-relaxed mb-5 text-sm break-words line-clamp-4">
                                "{{ $review->comment }}"
                            </p>
                        </div>

                        <div class="flex items-center gap-3 mt-auto pt-2 border-t border-white/5">
                            <div class="w-9 h-9 rounded-full bg-brand/20 border border-brand/30 flex items-center justify-center text-xs font-bold text-brand-light uppercase tracking-wider shrink-0">
                                {{ strtoupper(substr($review->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="font-display font-semibold text-white text-sm">{{ $review->name }}</div>
                                <div class="text-slate-400 text-xs mt-0.5">{{ $review->designation ?? 'Guest Client' }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    @endif

    {{-- <div class="mt-16 max-w-2xl mx-auto px-6"> --}}
    {{--     <livewire:components.review-submission /> --}}
    {{-- </div> --}}
</section>
