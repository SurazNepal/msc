<!-- ===== HOW IT WORKS ===== -->
   <section id="process" class="py-24 max-w-7xl mx-auto px-6">
    <div class="text-center mb-16">
        <div class="inline-flex items-center gap-2 pill rounded-full px-4 py-1.5 text-sm text-brand-light mb-5 font-medium">How We Work</div>
        <h2 class="font-display text-4xl md:text-5xl font-bold text-white">
            Crafting impact through<br/><span class="gradient-text">our process</span>
        </h2>
    </div>

    <div class="grid md:grid-cols-3 gap-8">
        @foreach($steps as $index => $item)
            @php
                // Safely extract integer/string representation from enum cast
                $stepValue = $item->step->value ?? $item->step;
                $formattedStep = str_pad($stepValue, 2, '0', STR_PAD_LEFT);

                // Identify if it's the second card (index 1) to apply the special highlight classes
                $isHighlighted = $index === 1;
            @endphp

            <div class="relative rounded-2xl border {{ $isHighlighted ? 'border-brand/30' : 'border-white/10' }} bg-dark-800 p-8"
                 @if($isHighlighted) style="background:linear-gradient(135deg,rgba(224,92,26,0.07) 0%,rgba(15,19,24,0.8) 100%);" @endif
                 wire:key="frontend-step-{{ $item->id }}">

                <div class="font-display text-7xl font-extrabold {{ $isHighlighted ? 'text-brand/10' : 'text-white/5' }} absolute top-6 right-6 leading-none select-none">
                    {{ $formattedStep }}
                </div>

                <div class="w-12 h-12 rounded-xl {{ $isHighlighted ? 'bg-brand' : 'bg-brand/20' }} flex items-center justify-center mb-6">
                    @if($item->hasMedia('work_icon'))
                        <img src="{{ $item->getFirstMediaUrl('work_icon', 'small') }}" alt="{{ $item->title }}" class="w-5 h-5 object-contain" />
                    @else
                        @if($index === 0)
                            <svg class="w-5 h-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/></svg>
                        @elseif($index === 1)
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        @else
                            <svg class="w-5 h-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @endif
                    @endif
                </div>

                <div class="text-brand text-xs font-semibold uppercase tracking-widest mb-2">Step {{ $formattedStep }}</div>
                <h3 class="font-display text-xl font-semibold text-white mb-3">{{ $item->title }}</h3>
                <p class="text-slate-400 text-sm leading-relaxed">{!! strip_tags($item->description, '<strong><b><i><em><u><ul><ol><li><br>') !!}</p>
            </div>
        @endforeach
    </div>
</section>
