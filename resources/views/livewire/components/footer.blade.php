<footer class="border-t border-white/5 bg-dark-900">
    <div class="max-w-7xl mx-auto px-6 py-16">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-10 mb-14">

            <div class="col-span-2 lg:col-span-1">
                <a href="/" class="font-display text-lg font-bold text-white flex items-center gap-2 mb-5">
                    <span class="w-8 h-8 rounded-lg bg-brand flex items-center justify-center text-white font-bold text-sm">M</span>
                    Mind Share Connect
                </a>
                <p class="text-slate-400 text-sm leading-relaxed mb-6">
                    Ideas. Innovation. Inspiration. — Integrated marketing and social communication services across Nepal.
                </p>

                @if($socials->isNotEmpty())
                    <div class="flex items-center gap-3">
                        @foreach($socials as $social)
                            @php
                                $iconName = match(Str::lower($social->name)) {
                                    'facebook'  => 'facebook',
                                    'linkedin'  => 'linkedin',
                                    'github'    => 'github',
                                    'instagram' => 'instagram',
                                    'youtube'   => 'youtube',
                                    'twitter', 'x' => 'twitter',
                                    default     => 'globe-alt'
                                };
                            @endphp
                            <a href="{{ $social->url }}" target="_blank" title="{{ $social->name }}"
                               class="w-9 h-9 rounded-lg bg-dark-700 border border-white/10 flex items-center justify-center text-slate-400 hover:text-brand hover:border-brand/40 transition-colors">
                                <flux:icon :name="$iconName" variant="micro" class="size-4" />
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            @foreach($navigations->groupBy('heading') as $heading => $group)
                <div>
                    <h5 class="font-display font-semibold text-white text-sm mb-5 tracking-wider uppercase">
                        {{ $heading }}
                    </h5>
                    <ul class="space-y-3">
                        @foreach($group as $link)
                            {{-- We can now call ->related directly as an object accessor, matching the admin view logic --}}
                            @php
                                $resolvedItem = collect($link->related)->first();
                            @endphp

                            @if($resolvedItem)
                                <li>
                                    <a href="{{ $resolvedItem->route }}" class="text-slate-400 text-sm hover:text-brand transition-colors block truncate" title="{{ $resolvedItem->title }}">
                                        {{ $resolvedItem->title }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endforeach

            @if($navigations->groupBy('heading')->count() < 2)
                @foreach(range(1, 2 - $navigations->groupBy('heading')->count()) as $spacer)
                    <div></div>
                @endforeach
            @endif

            <div>
                <h5 class="font-display font-semibold text-white text-sm mb-5">Contact</h5>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li class="leading-relaxed">{!! nl2br(e($contactSetting->address)) !!}</li>
                    <li>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactSetting->phone) }}" class="hover:text-brand transition-colors">
                            T: {{ $contactSetting->phone }}
                        </a>
                    </li>
                    <li>
                        <a href="mailto:{{ $contactSetting->email }}" class="hover:text-brand transition-colors">
                            {{ $contactSetting->email }}
                        </a>
                    </li>
                    <li>
                        <a href="/" class="hover:text-brand transition-colors">
                            {{ request()->getHost() }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/5 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-slate-500 text-sm">© Mind Share Connect {{ now()->year }}. All Rights Reserved.</p>
            <p class="text-slate-600 text-xs">
                @if($aboutSetting->registration_number)
                    Reg. No: {{ $aboutSetting->registration_number }}
                @endif
                @if($aboutSetting->registration_number && $aboutSetting->pan_vat_number)
                    &nbsp;|&nbsp;
                @endif
                @if($aboutSetting->pan_vat_number)
                    PAN/VAT: {{ $aboutSetting->pan_vat_number }}
                @endif
            </p>
        </div>
    </div>
</footer>
