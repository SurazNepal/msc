<div class="space-y-6 max-w-7xl mx-auto text-slate-700">

    <div class="flex items-center justify-between pb-2">
        <div>
            <h2 class="text-xl font-semibold text-slate-800">Client Testimonials</h2>
            <p class="text-xs text-slate-400 mt-0.5">Review, approve, or discard testimonials submitted by visitors.</p>
        </div>
    </div>

    <div class="bg-white border border-slate-200/80 rounded-xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-2">
            <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
            <h3 class="text-sm font-semibold text-slate-800">
                Pending Moderation ({{ $pendingReviews->count() }})
            </h3>
        </div>

        @if($pendingReviews->isEmpty())
            <p class="text-xs text-slate-400 p-5 text-center">No reviews awaiting approval right now.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-200/80 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <th class="py-3 px-5">Author</th>
                            <th class="py-3 px-5">Rating</th>
                            <th class="py-3 px-5 w-1/2">Comment</th>
                            <th class="py-3 px-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600">
                        @foreach($pendingReviews as $review)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-3.5 px-5">
                                    <div class="font-semibold text-slate-800">{{ $review->name }}</div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">{{ $review->designation ?? 'Guest' }}</div>
                                </td>
                                <td class="py-3.5 px-5">
                                    <div class="flex text-amber-400">
                                        @for($i=1; $i<=5; $i++)
                                            <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-current' : 'text-slate-200' }}" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                </td>
                                <td class="py-3.5 px-5 text-slate-500 line-clamp-2 mt-2 break-all" title="{{ $review->comment }}">
                                    {{ $review->comment }}
                                </td>
                                <td class="py-3.5 px-5 text-right space-x-1 whitespace-nowrap">
                                    <button wire:click="selectReview({{ $review->id }}, 'approve')" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-[11px] font-medium rounded text-white transition-colors">Approve</button>
                                    <button wire:click="selectReview({{ $review->id }}, 'delete')" class="px-2.5 py-1 bg-rose-50 hover:bg-rose-100 text-[11px] font-medium text-rose-600 rounded border border-rose-200 transition-colors">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

   <div class="bg-white border border-slate-200/80 rounded-xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100">
            <h3 class="text-sm font-semibold text-slate-800">Live Published Reviews</h3>
        </div>

        @if($approvedReviews->isEmpty())
            <p class="text-xs text-slate-400 p-5 text-center">No published reviews found on your site yet.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-200/80 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <th class="py-3 px-5">Author</th>
                            <th class="py-3 px-5">Rating</th>
                            <th class="py-3 px-5 w-1/2">Comment</th>
                            <th class="py-3 px-5 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600">
                        @foreach($approvedReviews as $review)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-3.5 px-5">
                                    <div class="font-semibold text-slate-800">{{ $review->name }}</div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">{{ $review->designation }}</div>
                                </td>
                                <td class="py-3.5 px-5">
                                    <div class="flex text-amber-400">
                                        @for($i=1; $i<=5; $i++)
                                            <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-current' : 'text-slate-200' }}" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                </td>
                                <td class="py-3.5 px-5 text-slate-500 line-clamp-2 mt-2 break-all" title="{{ $review->comment }}">
                                    {{ $review->comment }}
                                </td>
                                <td class="py-3.5 px-5 text-right space-x-2 whitespace-nowrap">
                                    <button wire:click="rejectReview({{ $review->id }})" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-[11px] font-medium text-slate-600 rounded transition-colors">
                                        Reject
                                    </button>

                                    <button wire:click="selectReview({{ $review->id }}, 'delete')" class="px-2 py-1 text-rose-600 hover:text-rose-700 hover:underline font-medium transition-colors">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-100">
                {{ $approvedReviews->links() }}
            </div>
        @endif
    </div>

    <flux:modal name="approve-review-modal" class="md:w-[450px] bg-white text-slate-800">
        <div class="space-y-4">
            <flux:heading size="lg">Approve This Review?</flux:heading>
            <flux:subheading class="text-slate-500 text-xs">This action publishes the testimonial live to your public home page section.</flux:subheading>

            <div class="p-3.5 bg-slate-50 rounded-lg text-xs space-y-1.5 border border-slate-100">
                <p class="font-semibold text-orange-600">{{ $modalReviewName }}</p>
                <p class="text-slate-600 italic">"{{ $modalReviewComment }}"</p>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <flux:modal.close>
                    <flux:button variant="ghost" size="sm">Cancel</flux:button>
                </flux:modal.close>
                <flux:button wire:click="approveReview" size="sm" class="bg-emerald-600 hover:bg-emerald-700 text-white border-none">Publish</flux:button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="delete-review-modal" class="md:w-[450px] bg-white text-slate-800">
        <div class="space-y-4">
            <flux:heading size="lg" class="text-rose-600">Delete Feedback Entry?</flux:heading>
            <flux:subheading class="text-slate-500 text-xs">This operation is destructive and cannot be reversed easily.</flux:subheading>

            <div class="p-3.5 bg-slate-50 rounded-lg text-xs space-y-1.5 border border-slate-100">
                <p class="font-semibold text-slate-700">{{ $modalReviewName }}</p>
                <p class="text-slate-500 italic">"{{ $modalReviewComment }}"</p>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <flux:modal.close>
                    <flux:button variant="ghost" size="sm">Cancel</flux:button>
                </flux:modal.close>
                <flux:button wire:click="deleteReview" size="sm" class="bg-rose-600 hover:bg-rose-700 text-white border-none">Delete Permanently</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
