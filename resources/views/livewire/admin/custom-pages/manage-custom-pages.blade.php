<div class="p-6">
  <div class="absolute top-4 right-4 z-50 space-y-3 pointer-events-none">
    {{-- Success Message Alert --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 3000)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="pointer-events-auto w-fit max-w-md p-4 text-sm text-green-800 bg-green-50/90 border border-green-200 rounded-xl backdrop-blur-sm dark:bg-zinc-900/90 dark:text-green-400 dark:border-zinc-800 flex items-center gap-2 shadow-lg">
            <flux:icon name="check-circle" variant="micro" class="text-green-600 dark:text-green-400 shrink-0" />
            <span>{{ session('message') }}</span>
        </div>
    @endif

    {{-- Error Message Alert --}}
    @if (session()->has('error'))
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 3000)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="pointer-events-auto w-fit max-w-md p-4 text-sm text-red-800 bg-red-50/90 border border-red-200 rounded-xl backdrop-blur-sm dark:bg-zinc-900/90 dark:text-red-400 dark:border-zinc-800 flex items-center gap-2 shadow-lg">
            <flux:icon name="exclamation-triangle" variant="micro" class="text-red-600 dark:text-red-400 shrink-0" />
            <span>{{ session('error') }}</span>
        </div>
    @endif
</div>
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Custom Pages List</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Manage internal stand-alone system layout components and descriptive routes.</p>
        </div>
        <flux:button as="a" href="{{ route('custom-pages.create') }}" wire:navigate variant="primary">Add Custom Page</flux:button>
    </div>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 bg-zinc-50 dark:bg-zinc-900 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800">
        <div class="flex items-center gap-2">
            <label for="show-entries" class="text-zinc-600 dark:text-zinc-400 text-sm">Show</label>
            <select id="show-entries" wire:model.live="perPage" class="w-[65px] border border-zinc-300 dark:border-zinc-700 p-1.5 rounded-lg text-sm bg-white dark:bg-zinc-800 text-black dark:text-white">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
            <span class="text-zinc-500 text-sm">entries</span>
        </div>

        <div class="w-full sm:w-72">
            <flux:input size="sm" placeholder="Filter by title..." wire:model.live="search" class="text-black dark:text-white" />
        </div>
    </div>

    <div class="overflow-x-auto shadow-sm rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">
        <table class="w-full text-sm text-left text-zinc-500 dark:text-zinc-300">
            <thead class="text-xs text-zinc-700 uppercase bg-zinc-100 dark:bg-zinc-800 dark:text-zinc-200">
                <tr class="text-center">
                    <th class="px-6 py-3">Thumbnail</th>
                    <th class="px-6 py-3 text-left">Title</th>
                    <th class="px-6 py-3 text-left">Slug Reference</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse ($pages as $page)
                    <tr class="text-center bg-white dark:bg-zinc-900 hover:bg-zinc-50 dark:hover:bg-zinc-800/60">
                        <td class="px-6 py-4">
                            <img class="mx-auto w-[60px] h-[60px] object-cover rounded-lg border dark:border-zinc-700" src="{{ $page->getFirstMediaUrl('featured_images', 'thumb') ?: 'https://placehold.co/60' }}">
                        </td>
                        <td class="px-6 py-4 font-medium text-left text-zinc-900 dark:text-white truncate max-w-[180px]">{{ $page->title }}</td>
                        <td class="px-6 py-4 text-left font-mono text-xs text-zinc-500 dark:text-zinc-400 max-w-xs truncate">
                            {{ $page->slug }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $page->status === 'Published' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-400' }}">
                                {{ $page->status ?? 'Published' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 space-x-1 whitespace-nowrap">
                            <flux:button size="xs" icon="user-pen" as="a" href="{{ route('custom-pages.edit', $page->slug) }}" wire:navigate>Edit</flux:button>
                            <flux:button size="xs" icon="user-round-x" wire:click="destroy({{ $page->id }})" variant="danger">Delete</flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center py-12 text-zinc-400" colspan="5">No Records Found!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($pages instanceof \Illuminate\Contracts\Pagination\Paginator || $pages instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="p-4 bg-zinc-50 dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-800">
                {{ $pages->links() }}
            </div>
        @endif
    </div>
</div>
