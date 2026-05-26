<div class="max-w-3xl mx-auto mt-16 p-8 bg-[#13151a] border border-white/5 rounded-2xl shadow-xl">
    <div class="mb-8">
        <span class="px-3 py-1 text-xs font-semibold tracking-wider text-brand uppercase bg-brand/10 rounded-full border border-brand/20">
            Feedback Form
        </span>
        <h3 class="text-2xl font-display font-bold text-white mt-3">Share Your Experience</h3>
        <p class="text-slate-400 text-sm mt-1">Your insights keep us growing. Let us know how we did!</p>
    </div>

    <form wire:submit.prevent="submitReview" class="space-y-5">
        <div>
            <label class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-2">Your Rating *</label>
            <div class="flex items-center gap-1.5">
                @for($i = 1; $i <= 5; $i++)
                    <button type="button" wire:click="setRating({{ $i }})" class="focus:outline-none transition-transform active:scale-95 group">
                        <svg class="w-7 h-7 {{ $i <= $rating ? 'text-brand fill-brand' : 'text-slate-600 hover:text-slate-400' }} transition-colors"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </button>
                @endfor
            </div>
            @error('rating') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="name" class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-2">Full Name *</label>
                <input type="text" id="name" wire:model.defer="name" placeholder="Your name"
                       class="w-full bg-[#181a21] border border-white/10 text-white placeholder-slate-600 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand/50 focus:ring-1 focus:ring-brand/50 transition-colors">
                @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="designation" class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-2">Designation / Company</label>
                <input type="text" id="designation" wire:model.defer="designation" placeholder="e.g., Manager, Arakinko Express"
                       class="w-full bg-[#181a21] border border-white/10 text-white placeholder-slate-600 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand/50 focus:ring-1 focus:ring-brand/50 transition-colors">
                @error('designation') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="comment" class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-2">Your Message *</label>
            <textarea id="comment" wire:model.defer="comment" rows="4" placeholder="Write your review here..."
                      class="w-full bg-[#181a21] border border-white/10 text-white placeholder-slate-600 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand/50 focus:ring-1 focus:ring-brand/50 transition-colors resize-none"></textarea>
            @error('comment') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end pt-2">
            <button type="submit"
                    class="w-full md:w-auto px-6 py-3 rounded-xl bg-brand font-medium text-white text-sm hover:bg-brand-hover transition-colors flex items-center justify-center gap-2 shadow-lg shadow-brand/10">
                <span>Submit Review</span>
                <svg class="w-4 h-4 transform rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </button>
        </div>
    </form>
</div>
