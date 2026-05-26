<!-- ===== SERVICES ===== -->
   <section id="services" class="py-24 bg-dark-800">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 pill rounded-full px-4 py-1.5 text-sm text-brand-light mb-5 font-medium">Our Services</div>
            <h2 class="font-display text-4xl md:text-5xl font-bold text-white mb-4">
                Full-spectrum communication<br/><span class="gradient-text">for every occasion</span>
            </h2>
            <p class="text-slate-400 max-w-xl mx-auto">From large-scale conferences to brand campaigns, we manage every detail with precision and creativity.</p>
        </div>

       <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($services as $service)
                <a href="{{ route('services.single', $service->slug) }}" wire:navigate class="service-card block rounded-2xl border border-white/10 bg-dark-700 p-7 transition-all duration-300 cursor-pointer group" wire:key="frontend-service-{{ $service->id }}">
                    <div class="w-12 h-12 rounded-xl bg-brand/20 flex items-center justify-center mb-5 group-hover:bg-brand/30 transition-colors">
                        @if($service->hasMedia('icon'))
                            <img src="{{ $service->getFirstMediaUrl('icon', 'small') }}" alt="{{ $service->title }}" class="w-6 h-6 object-contain" />
                        @else
                            <svg class="w-6 h-6 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                            </svg>
                        @endif
                    </div>
                    <h3 class="font-display font-semibold text-white mb-3">{{ $service->title }}</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-5">{!! Str::words(strip_tags($service->description), 20, '...') !!}</p>
                </a>
            @endforeach
        </div>

        <div class="mt-12 rounded-2xl border border-white/10 bg-dark-700 p-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="flex -space-x-2">
                    @php
                // Tailored background colors matching your original design structure
                $bgStyles = [
                    0 => 'bg-brand/30 text-brand',
                    1 => 'bg-orange-500/20 text-orange-300',
                    2 => 'bg-amber-500/20 text-amber-300',
                    3 => 'bg-slate-500/20 text-slate-300'
                ];
            @endphp

            @forelse($avatarClients as $index => $client)
                <div class="w-10 h-10 rounded-full border-2 border-dark-700 overflow-hidden flex items-center justify-center text-xs font-bold shrink-0 {{ $bgStyles[$index] ?? 'bg-brand/30 text-brand' }}" title="{{ $client->full_name }}">
                    @if($client->hasMedia('client_logo'))
                        <img src="{{ $client->getFirstMediaUrl('client_logo', 'thumb') }}" alt="{{ $client->full_name }}" class="w-full h-full object-cover bg-white p-1" />
                    @else
                        @php
                            // Generates two-letter initials from full name string dynamically
                            $words = explode(' ', $client->full_name);
                            $initials = isset($words[1])
                                ? Str::upper(substr($words[0], 0, 1) . substr($words[1], 0, 1))
                                : Str::upper(substr($words[0], 0, 2));
                        @endphp
                        {{ $initials }}
                    @endif
                </div>
            @empty
                <div class="w-10 h-10 rounded-full bg-brand/30 border-2 border-dark-700 flex items-center justify-center text-xs text-brand font-bold">MK</div>
                <div class="w-10 h-10 rounded-full bg-orange-500/20 border-2 border-dark-700 flex items-center justify-center text-xs text-orange-300 font-bold">IJ</div>
                <div class="w-10 h-10 rounded-full bg-amber-500/20 border-2 border-dark-700 flex items-center justify-center text-xs text-amber-300 font-bold">BR</div>
            @endforelse
                </div>
                <div>
                    <div class="text-brand text-xs font-medium mb-0.5">Our Network</div>
                    <div class="text-white font-display font-semibold">
                        {{ $setting->stats_count ?? '16' }}+ {{ $setting->stats_label ?? 'Active Client Partners' }}
                    </div>
                    <div class="text-slate-400 text-sm">
                        Delivering impact across Nepal since {{ !empty($setting->registration_date_text) ? strip_tags(Str::afterLast($setting->registration_date_text, ' ')) : '2011' }}.
                    </div>
                </div>
            </div>
            <a href="#contact" class="flex-shrink-0 inline-flex items-center gap-2 px-6 py-3 rounded-full bg-brand text-white text-sm font-medium hover:bg-brand-dark transition-colors">
                Work With Us
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>
