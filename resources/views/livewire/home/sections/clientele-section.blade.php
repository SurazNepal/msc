<!-- ===== CLIENTELE ===== -->
   <section id="clients" class="py-24 bg-dark-800">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-14">
            <div class="inline-flex items-center gap-2 pill rounded-full px-4 py-1.5 text-sm text-brand-light mb-5 font-medium">Our Clients</div>
            <h2 class="font-display text-4xl md:text-5xl font-bold text-white">Trusted by <span class="gradient-text">leading organisations</span></h2>
            <p class="text-slate-400 mt-4 max-w-xl mx-auto">We are proud to partner with reputed institutions, NGOs, hospitals, and media organisations across Nepal.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-4">
            @forelse($clients as $client)
                <div class="rounded-xl border border-white/10 bg-dark-700 p-5 flex flex-col items-center justify-center gap-2 hover:border-brand/30 transition-colors group" wire:key="frontend-client-{{ $client->id }}">

                    @if($client->hasMedia('client_logo'))
                        <img src="{{ $client->getFirstMediaUrl('client_logo', 'small') }}"
                             alt="{{ $client->full_name }}"
                             class="h-12 object-contain opacity-60 group-hover:opacity-100 transition-opacity filter grayscale group-hover:grayscale-0"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='block'" />
                    @endif

                    <span @class([
                        'font-display text-sm font-semibold text-slate-400 group-hover:text-white transition-colors text-center',
                        'hidden' => $client->hasMedia('client_logo'),
                        'block' => !$client->hasMedia('client_logo')
                    ])>
                        {{ $client->full_name }}
                    </span>

                    <span class="text-xs text-slate-500 group-hover:text-slate-300 transition-colors text-center">
                        {{ $client->full_name }}
                    </span>
                </div>
            @empty
                <div class="col-span-full border border-dashed border-white/10 rounded-2xl p-12 text-center text-slate-500">
                    Our trusted partner portfolio is currently being updated.
                </div>
            @endforelse
        </div>

        <p class="text-center text-slate-500 text-sm mt-6">And many more — <a href="https://www.msc.com.np/clientele/" target="_blank" class="text-brand hover:underline">view full clientele list →</a></p>
    </div>
</section>
