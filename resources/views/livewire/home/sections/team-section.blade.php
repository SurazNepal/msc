<!-- ===== TEAM ===== -->
<section id="team" class="py-24 max-w-7xl mx-auto px-6">
    <div class="text-center mb-14">
        <div class="inline-flex items-center gap-2 pill rounded-full px-4 py-1.5 text-sm text-brand-light mb-5 font-medium">Our Team</div>
        <h2 class="font-display text-4xl md:text-5xl font-bold text-white">
            Meet the people behind<br/><span class="gradient-text">Mind Share Connect</span>
        </h2>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($teamMembers as $member)
            @php
                // Generates professional two-letter initials dynamically from full name string
                $words = explode(' ', $member->full_name);
                $initials = isset($words[1])
                    ? Str::upper(substr($words[0], 0, 1) . substr($words[1], 0, 1))
                    : Str::upper(substr($words[0], 0, 2));
            @endphp

            <div @class([
                    'group rounded-2xl bg-dark-800 overflow-hidden transition-colors',
                    'border border-brand/30' => $loop->first,
                    'border border-white/10 hover:border-brand/40' => !$loop->first
                 ])
                 @if($loop->first) style="box-shadow:0 0 30px rgba(224,92,26,0.08)" @endif
                 wire:key="frontend-team-member-{{ $member->id }}">

                <div class="aspect-[3/4] overflow-hidden relative bg-dark-700">
                    @if($member->hasMedia('team_image'))
                        <img src="{{ $member->getFirstMediaUrl('team_image', 'large') }}"
                             alt="{{ $member->full_name }}"
                             class="team-img w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition-all duration-500"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex'" />
                    @endif

                    <div @class([
                            'w-full h-full items-center justify-center text-4xl font-display font-bold select-none',
                            'hidden' => $member->hasMedia('team_image'),
                            'flex' => !$member->hasMedia('team_image'),
                            'text-brand/30' => $loop->first,
                            'text-white/10' => !$loop->first
                         ])>
                        {{ $initials }}
                    </div>

                    <div class="absolute bottom-0 left-0 right-0 p-4 flex justify-center gap-3 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        <a href="#" class="w-8 h-8 rounded-full bg-brand flex items-center justify-center hover:bg-brand-dark transition-colors">
                            <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="p-5 text-center">
                    <h4 class="font-display font-semibold text-white mb-1">{{ $member->full_name }}</h4>
                    <p @class([
                        'text-xs font-medium',
                        'text-brand' => $loop->first,
                        'text-slate-400' => !$loop->first
                       ])>{{ $member->job_post }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>
