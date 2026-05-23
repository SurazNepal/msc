<!-- ===== CLIENT MARQUEE ===== -->
  <section class="py-10 border-y border-white/5 overflow-hidden bg-dark-800">
    <div class="flex" style="width:max-content">
      <div class="flex items-center gap-16 animate-marquee">
        @forelse ($clients as $client)
        <span class="font-display text-base font-semibold text-white/20 whitespace-nowrap">{{$client->full_name}}</span>
        @empty
           <span class="font-display text-base font-semibold text-white/10 whitespace-nowrap">Our Partners</span>
        @endforelse
      </div>
    </div>
  </section>
