<!-- ===== CONTACT ===== -->
   <section id="contact" class="py-24 max-w-7xl mx-auto px-6">
    <div class="rounded-3xl border border-white/10 bg-dark-800 overflow-hidden relative">
        <div class="hero-glow absolute inset-0 pointer-events-none"></div>
        <div class="absolute inset-0 opacity-[0.02]" style="background-image:linear-gradient(rgba(255,255,255,.5) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.5) 1px,transparent 1px);background-size:40px 40px;"></div>

        <div class="relative grid lg:grid-cols-2 gap-0">
            <div class="p-12 lg:p-16 border-b lg:border-b-0 lg:border-r border-white/10">
                <div class="inline-flex items-center gap-2 pill rounded-full px-4 py-1.5 text-sm text-brand-light mb-6 font-medium">Contact Us</div>
                <h2 class="font-display text-4xl font-bold text-white mb-6">Get in <span class="gradient-text">touch with us</span></h2>

                <div class="space-y-5 mb-8">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-brand/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-slate-400 text-xs mb-0.5">Address</div>
                            <div class="text-white text-sm font-medium leading-relaxed">{!! nl2br(e($contactSetting->address)) !!}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-brand/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                        </div>
                        <div>
                            <div class="text-slate-400 text-xs mb-0.5">Phone / Fax</div>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactSetting->phone) }}" class="text-white text-sm font-medium hover:text-brand transition-colors">
                                {{ $contactSetting->phone }}
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-brand/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        </div>
                        <div>
                            <div class="text-slate-400 text-xs mb-0.5">Email</div>
                            <a href="mailto:{{ $contactSetting->email }}" class="text-white text-sm font-medium hover:text-brand transition-colors">
                                {{ $contactSetting->email }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-white/10 bg-dark-700 p-4 text-xs space-y-1">
                    @if($aboutSetting->registration_number)
                        <div class="text-slate-400">Company Registration No: <span class="text-white">{{ $aboutSetting->registration_number }}</span></div>
                    @endif
                    @if($aboutSetting->registration_date_text)
                        <div class="text-slate-400">Date: <span class="text-white">{{ $aboutSetting->registration_date_text }}</span></div>
                    @endif
                    @if($aboutSetting->pan_vat_number)
                        <div class="text-slate-400">PAN/VAT: <span class="text-white">{{ $aboutSetting->pan_vat_number }}</span></div>
                    @endif
                </div>
            </div>

            <div class="p-12 lg:p-16">
                <h3 class="font-display text-2xl font-bold text-white mb-2">Send us a Message</h3>
                <p class="text-slate-400 text-sm mb-8">Tell us about your event or communication needs and we'll get back to you promptly.</p>

                <form wire:submit.prevent="submitMessage" class="space-y-4">
                    <div>
                        <input type="text" wire:model="name" placeholder="Your full name *" class="w-full px-4 py-3.5 rounded-xl bg-dark-900 border border-white/10 text-white placeholder-slate-500 text-sm focus:outline-none focus:border-brand/50 transition-colors @error('name') border-red-500/50 focus:border-red-500 @enderror" />
                        @error('name') <p class="text-xs text-red-400 mt-1 pl-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <input type="email" wire:model="email" placeholder="Email address *" class="w-full px-4 py-3.5 rounded-xl bg-dark-900 border border-white/10 text-white placeholder-slate-500 text-sm focus:outline-none focus:border-brand/50 transition-colors @error('email') border-red-500/50 focus:border-red-500 @enderror" />
                        @error('email') <p class="text-xs text-red-400 mt-1 pl-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <input type="tel" wire:model="phone" placeholder="Phone number" class="w-full px-4 py-3.5 rounded-xl bg-dark-900 border border-white/10 text-white placeholder-slate-500 text-sm focus:outline-none focus:border-brand/50 transition-colors @error('phone') border-red-500/50 focus:border-red-500 @enderror" />
                        @error('phone') <p class="text-xs text-red-400 mt-1 pl-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <input type="text" wire:model="subject" placeholder="Subject *" class="w-full px-4 py-3.5 rounded-xl bg-dark-900 border border-white/10 text-white placeholder-slate-500 text-sm focus:outline-none focus:border-brand/50 transition-colors @error('subject') border-red-500/50 focus:border-red-500 @enderror" />
                        @error('subject') <p class="text-xs text-red-400 mt-1 pl-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <textarea rows="4" wire:model="message" placeholder="Your message *" class="w-full px-4 py-3.5 rounded-xl bg-dark-900 border border-white/10 text-white placeholder-slate-500 text-sm focus:outline-none focus:border-brand/50 transition-colors resize-none @error('message') border-red-500/50 focus:border-red-500 @enderror"></textarea>
                        @error('message') <p class="text-xs text-red-400 mt-1 pl-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" wire:loading.attr="disabled" class="w-full py-3.5 rounded-xl bg-brand text-white font-medium hover:bg-brand-dark transition-colors flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="submitMessage" class="flex items-center gap-2">
                            Send Message
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                        </span>
                        <span wire:loading wire:target="submitMessage" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Sending...
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
