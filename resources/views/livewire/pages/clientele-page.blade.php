<div>
  <section class="pt-32 pb-16 hero-glow relative overflow-hidden">
    <div class="absolute inset-0 opacity-[0.03]" style="background-image:linear-gradient(rgba(255,255,255,.5) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.5) 1px,transparent 1px);background-size:60px 60px;"></div>
    <div class="max-w-7xl mx-auto px-6 text-center">
      <div class="inline-flex items-center gap-2 pill rounded-full px-4 py-1.5 text-sm text-brand-light mb-4 font-medium">Clientele</div>
      <h1 class="font-display text-5xl md:text-6xl font-bold text-white mb-4">
        Trusted by <span class="gradient-text">leading organisations</span>
      </h1>
      <p class="text-slate-400 max-w-2xl mx-auto text-lg mb-6">We are proud to partner with reputed institutions, NGOs, hospitals, and professional bodies across Nepal — delivering communication excellence since 2011.</p>
      <div class="flex items-center justify-center gap-2 text-sm text-slate-500">
        <a href="{{ route('home') }}" class="hover:text-brand transition-colors">Home</a>
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-300">Clientele</span>
      </div>
    </div>
  </section>

  <section class="py-10 bg-dark-800 border-y border-white/5">
    <div class="max-w-7xl mx-auto px-6">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
        @foreach($stats as $index => $stat)
          <div class="{{ $index > 0 && $index < 3 ? 'border-x border-white/5' : '' }} {{ $index === 2 ? 'border-r border-white/5' : '' }}">
            <div class="font-display text-3xl font-bold text-white">{{ $stat['count'] }}<span class="text-brand">+</span></div>
            <div class="text-slate-400 text-xs mt-1">{{ $stat['label'] }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  @if($clients->isNotEmpty())
    <section class="py-8 overflow-hidden border-b border-white/5">
      <div class="flex" style="width:max-content">
        <div class="flex items-center gap-14 animate-marquee">
          {{-- Render the set twice to guarantee infinite CSS marquee cycles seamlessly --}}
          @foreach([1, 2] as $loopIndicator)
            @foreach($clients as $client)
              <span class="font-display text-base font-semibold text-white/15 whitespace-nowrap">{{ $client->full_name }}</span>
              <span class="text-brand/30 text-lg">·</span>
            @endforeach
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <section class="py-20 max-w-7xl mx-auto px-6">
    <div class="text-center mb-14">
      <div class="inline-flex items-center gap-2 pill rounded-full px-4 py-1.5 text-sm text-brand-light mb-4 font-medium">All Partners</div>
      <h2 class="font-display text-4xl font-bold text-white">Our full <span class="gradient-text">client portfolio</span></h2>
      <p class="text-slate-400 mt-3 max-w-lg mx-auto text-sm">Hover over each card to see full colour. Click to learn more about our work with each partner.</p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
      @foreach($clients as $client)
        @php
          $logoUrl = $client->getFirstMediaUrl('client_logo', 'small');
        @endphp

        <div
          @if($client->website_url) onclick="window.open('{{ $client->website_url }}', '_blank')" @endif
          class="client-card rounded-2xl bg-dark-700 p-6 flex flex-col items-center justify-center gap-3 {{ $client->website_url ? 'cursor-pointer' : '' }}"
          style="min-height:140px;"
        >
          @if($logoUrl)
            <img src="{{ $logoUrl }}" alt="{{ $client->full_name }}" class="h-14 object-contain" onerror="this.style.display='none'"/>
          @else
            <div class="w-10 h-10 rounded-full bg-brand/10 flex items-center justify-center text-brand font-bold text-xs">
              {{ strtoupper(substr($client->full_name, 0, 2)) }}
            </div>
          @endif
          <span class="font-display text-xs font-semibold text-slate-300 text-center">{{ $client->full_name }}</span>
        </div>
      @endforeach

      <div onclick="window.location.href='{{ route('contact') }}'" class="rounded-2xl flex flex-col items-center justify-center gap-3 p-6 cursor-pointer text-center" style="min-height:140px;border:1px solid rgba(224,92,26,.2);background:linear-gradient(135deg,rgba(224,92,26,.06) 0%,rgba(22,28,36,.9) 100%);">
        <div class="w-10 h-10 rounded-xl bg-brand/20 flex items-center justify-center">
          <svg class="w-5 h-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        </div>
        <span class="font-display text-xs font-semibold text-brand">Become a Partner</span>
      </div>
    </div>
  </section>

  <section class="py-16 bg-dark-800 border-y border-white/5">
    <div class="max-w-7xl mx-auto px-6">
      <div class="text-center mb-12">
        <div class="inline-flex items-center gap-2 pill rounded-full px-4 py-1.5 text-sm text-brand-light mb-4 font-medium">Sectors We Serve</div>
        <h2 class="font-display text-3xl font-bold text-white">Expertise across <span class="gradient-text">multiple industries</span></h2>
      </div>
      <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-5">
        @foreach($sectors as $sector)
          <div class="rounded-2xl bg-dark-700 p-7 text-center" style="border:1px solid {{ $sector['highlighted'] ? 'rgba(224,92,26,.25)' : 'rgba(255,255,255,.07)' }};">
            <div class="w-12 h-12 rounded-xl {{ $sector['highlighted'] ? 'bg-brand' : 'bg-brand/20' }} flex items-center justify-center mx-auto mb-4">
              <svg class="w-6 h-6 {{ $sector['highlighted'] ? 'text-white' : 'text-brand' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                {!! $sector['icon'] !!}
              </svg>
            </div>
            <h4 class="font-display font-semibold text-white mb-2">{{ $sector['title'] }}</h4>
            <p class="text-slate-400 text-xs leading-relaxed">{{ $sector['description'] }}</p>
            <div class="mt-3 text-brand text-xs font-medium">{{ $sector['meta'] }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
<section id="testimonials" class="py-24 bg-dark-800 overflow-hidden group">
    <div class="max-w-7xl mx-auto px-6 mb-14 text-center">
        <div class="inline-flex items-center gap-2 pill rounded-full px-4 py-1.5 text-sm text-brand-light mb-5 font-medium">Testimonials</div>
        <h2 class="font-display text-4xl md:text-5xl font-bold text-white">What Our <span class="gradient-text">Clients Say</span></h2>
    </div>

    @if($testimonials->isEmpty())
        <div class="text-center py-8">
            <p class="text-slate-400 text-sm">No client testimonials have been published yet.</p>
        </div>
    @else
        <div class="relative w-full flex overflow-x-hidden [mask-image:_linear-gradient(to_right,_transparent_0%,_white_10%,_white_90%,_transparent_100%)]">

            <div class="animate-marquee group-hover:pause-marquee flex gap-6 whitespace-nowrap min-w-max shrink-0 items-stretch py-4 pr-6">
                @foreach($testimonials as $review)
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
                @foreach($testimonials as $review)
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

        </div>
    @endif
</section>

  <section class="py-10 pb-24 max-w-7xl mx-auto px-6">
    <div class="rounded-3xl bg-dark-800 p-12 text-center relative overflow-hidden" style="border:1px solid rgba(255,255,255,.07)">
      <div class="absolute inset-0 pointer-events-none" style="background:radial-gradient(ellipse 50% 60% at 50% 100%,rgba(224,92,26,.12) 0%,transparent 70%);"></div>
      <div class="relative">
        <h2 class="font-display text-3xl md:text-4xl font-bold text-white mb-3">Ready to join our client family?</h2>
        <p class="text-slate-400 max-w-lg mx-auto mb-8">Let's talk about how Mind Share Connect can bring your next event or campaign to life.</p>
        <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-brand text-white font-medium hover:bg-brand-dark transition-colors shadow-lg shadow-brand/20">
          Get in Touch <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
      </div>
    </div>
  </section>
</div>
