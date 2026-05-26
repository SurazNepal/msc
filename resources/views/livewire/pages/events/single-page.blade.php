<div class="py-16 bg-dark-900 min-h-screen text-white">
    <div class="max-w-4xl mx-auto px-6">

        <a href="{{ route('events') }}" wire:navigate class="inline-flex items-center gap-2 text-sm text-slate-400 hover:text-brand-light transition-colors mb-8 group">
            <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to all events
        </a>

        <div class="rounded-2xl overflow-hidden bg-dark-800 border border-white/5 mb-8 shadow-2xl">
            @if($event->hasMedia('portfolio_image'))
                <img src="{{ $event->getFirstMediaUrl('portfolio_image', 'large') }}" alt="{{ $event->title }}" class="w-full max-h-[460px] object-cover">
            @else
                <div class="w-full h-64 flex items-center justify-center bg-dark-800 text-slate-600">
                    <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            @endif
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="md:col-span-2">
                <h1 class="text-3xl md:text-4xl font-extrabold font-display mb-4 tracking-tight">{{ $event->title }}</h1>

                <div class="prose prose-invert max-w-none text-slate-300 leading-relaxed text-base whitespace-pre-line">
                    {{ strip_tags($event->description)}}
                </div>
            </div>

            <div class="bg-dark-800/40 border border-white/5 rounded-xl p-6 h-fit space-y-5">
                <div>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Event Year</h4>
                    <p class="text-lg font-semibold text-brand-light">{{ $event->year }}</p>
                </div>

                @if(!empty($event->tags))
                    <div>
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Project Tags</h4>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($event->tags as $tag)
                                <span class="text-xs text-white bg-dark-800 border border-white/10 px-2.5 py-1 rounded-md">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
