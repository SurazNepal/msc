<div>
    <section class="pt-32 pb-16 hero-glow relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.03]" style="background-image:linear-gradient(rgba(255,255,255,.5) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.5) 1px,transparent 1px);background-size:60px 60px;"></div>
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="inline-flex items-center gap-2 pill rounded-full px-4 py-1.5 text-sm text-brand-light mb-4 font-medium">Our Team</div>
            <h1 class="font-display text-5xl md:text-6xl font-bold text-white mb-4">The People Behind <span class="gradient-text">MSC</span></h1>
            <p class="text-slate-400 max-w-xl mx-auto text-lg mb-6">A talented, passionate team dedicated to delivering communication that inspires real difference — for businesses and communities across Nepal.</p>
            <div class="flex items-center justify-center gap-2 text-sm text-slate-500">
                <a href="{{ route('home') }}" class="hover:text-brand transition-colors">Home</a>
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-300">Team</span>
            </div>
        </div>
    </section>

    @if($managingDirector)
        <section class="py-20 max-w-7xl mx-auto px-6">
            <div class="text-center mb-14">
                <div class="inline-flex items-center gap-2 pill rounded-full px-4 py-1.5 text-sm text-brand-light mb-4 font-medium">Leadership</div>
                <h2 class="font-display text-4xl font-bold text-white">Meet our <span class="gradient-text">{{ $managingDirector->job_post }}</span></h2>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="featured-card rounded-3xl bg-dark-800 overflow-hidden border border-white/5 shadow-2xl">
                    <div class="grid md:grid-cols-2">
                        <div class="relative overflow-hidden min-h-[380px] bg-dark-900">
                            @if($managingDirector->hasMedia('team_image'))
                                <img src="{{ $managingDirector->getFirstMediaUrl('team_image', 'large') }}"
                                     alt="{{ $managingDirector->full_name }}"
                                     class="absolute inset-0 w-full h-full object-cover object-top" />
                            @else
                                <div class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center bg-gradient-to-br from-dark-950 to-dark-900 text-slate-600">
                                    <div class="w-16 h-16 rounded-full bg-brand/10 border border-brand/20 flex items-center justify-center text-xl font-bold text-brand-light mb-2 uppercase">
                                        {{ substr($managingDirector->full_name, 0, 2) }}
                                    </div>
                                    <span class="text-xs text-slate-500 font-medium">No Identity File Uploaded</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent to-dark-800/60"></div>
                            <div class="absolute bottom-4 left-4 pill rounded-full px-3 py-1.5 text-xs text-brand-light font-medium">{{ $managingDirector->job_post }}</div>
                        </div>

                        <div class="p-10 flex flex-col justify-center">
                            <div class="text-brand text-xs font-semibold uppercase tracking-widest mb-3">Founder &amp; MD</div>
                            <h3 class="font-display text-3xl font-bold text-white mb-4">{{ $managingDirector->full_name }}</h3>

                            <p class="text-slate-400 text-sm leading-relaxed mb-6">The visionary leader behind Mind Share Connect, {{ Str::before($managingDirector->full_name, ' ') }} brings over 14 years of expertise in integrated marketing and event management across Nepal. His leadership is defined by a relentless focus on customer satisfaction and communication excellence.</p>
                            <p class="text-slate-400 text-sm leading-relaxed mb-8">Under his direction, MSC has grown from a startup into one of Nepal's most trusted communication and event management companies, partnering with leading NGOs, hospitals, and media organisations.</p>

                            <div class="flex items-center gap-3">
                                <a href="{{ route('home') }}#contact" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-brand text-white text-sm font-medium hover:bg-brand-dark transition-colors">
                                    Get in Touch <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                                <a href="#" class="w-9 h-9 rounded-lg bg-dark-700 border border-white/10 flex items-center justify-center text-slate-400 hover:text-brand hover:border-brand/40 transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452z"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="py-4 pb-20 max-w-7xl mx-auto px-6">
        <div class="text-center mb-14">
            <div class="inline-flex items-center gap-2 pill rounded-full px-4 py-1.5 text-sm text-brand-light mb-4 font-medium">Core Team</div>
            <h2 class="font-display text-4xl font-bold text-white">The team that makes it <span class="gradient-text">happen</span></h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($coreTeam as $member)
                <div class="team-card rounded-2xl bg-dark-800 overflow-hidden group border border-white/5">
                    <div class="relative overflow-hidden bg-dark-900" style="height:280px;">
                        @if($member->hasMedia('team_image'))
                            <img src="{{ $member->getFirstMediaUrl('team_image', 'small') }}"
                                 alt="{{ $member->full_name }}"
                                 class="w-full h-full object-cover object-top opacity-90 group-hover:opacity-100 group-hover:scale-105 transition-all duration-500" />
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center p-6 text-center bg-gradient-to-br from-dark-950 to-dark-900 text-slate-600">
                                <div class="w-12 h-12 rounded-full bg-brand/10 border border-brand/20 flex items-center justify-center text-sm font-bold text-brand-light mb-2 uppercase">
                                    {{ substr($member->full_name, 0, 2) }}
                                </div>
                                <span class="text-[11px] text-slate-500">Photo Unavailable</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-dark-900/70 via-transparent to-transparent"></div>

                        <div class="social-bar absolute bottom-3 left-0 right-0 flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <a href="#" class="w-8 h-8 rounded-full bg-brand flex items-center justify-center hover:bg-brand-dark transition-colors">
                                <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452z"/></svg>
                            </a>
                        </div>
                    </div>
                    <div class="p-5">
                        <h4 class="font-display font-semibold text-white text-base mb-0.5">{{ $member->full_name }}</h4>
                        <p class="text-slate-400 text-xs font-medium group-hover:text-brand transition-colors duration-300">{{ $member->job_post }}</p>
                    </div>
                </div>
            @endforeach

            <div class="rounded-2xl bg-dark-800 overflow-hidden flex items-center justify-center p-8 text-center border border-brand/20 bg-gradient-to-br from-brand/5 to-dark-950/90 min-h-[340px]">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-brand/20 flex items-center justify-center mx-auto mb-5">
                        <svg class="w-7 h-7 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    </div>
                    <h4 class="font-display font-semibold text-white text-lg mb-2">Join Our Team</h4>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6">Passionate about events and communication? We'd love to hear from you.</p>
                    <a href="{{ route('home') }}#contact" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-brand text-white text-sm font-medium hover:bg-brand-dark transition-colors">
                        Get in Touch <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>

        </div>
    </section>

    <section class="py-16 bg-dark-800 border-y border-white/5">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 pill rounded-full px-4 py-1.5 text-sm text-brand-light mb-4 font-medium">Our Values</div>
                <h2 class="font-display text-3xl font-bold text-white">What drives us every day</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="rounded-2xl bg-dark-700 p-7 text-center border border-white/5">
                    <div class="w-12 h-12 rounded-xl bg-brand/20 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/></svg>
                    </div>
                    <h4 class="font-display font-semibold text-white mb-2">Ideas</h4>
                    <p class="text-slate-400 text-sm leading-relaxed">Every great event starts with a great idea. We think creatively and strategically to develop concepts that stand out and deliver impact.</p>
                </div>
                <div class="rounded-2xl p-7 text-center border border-brand/30 bg-gradient-to-br from-brand/10 to-dark-900/90">
                    <div class="w-12 h-12 rounded-xl bg-brand flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                    </div>
                    <h4 class="font-display font-semibold text-white mb-2">Innovation</h4>
                    <p class="text-slate-400 text-sm leading-relaxed">We embrace new technologies, tools, and approaches — staying ahead of the curve to deliver modern communication solutions for our clients.</p>
                </div>
                <div class="rounded-2xl bg-dark-700 p-7 text-center border border-white/5">
                    <div class="w-12 h-12 rounded-xl bg-brand/20 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/></svg>
                    </div>
                    <h4 class="font-display font-semibold text-white mb-2">Inspiration</h4>
                    <p class="text-slate-400 text-sm leading-relaxed">We believe communication has the power to inspire real difference. Every project we take on is guided by this principle — creating lasting impressions.</p>
                </div>
            </div>
        </div>
    </section>
</div>
