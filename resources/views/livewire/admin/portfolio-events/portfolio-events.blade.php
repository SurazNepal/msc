<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Portfolio Events</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Manage, organize, and publish event case studies.</p>
        </div>
        <flux:button as="a" href="{{ route('admin.portfolio-events.create') }}" wire:navigate variant="primary">Add Event</flux:button>
    </div>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4 bg-zinc-50 dark:bg-zinc-900 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800">
        <div class="flex items-center gap-2">
            <label for="show-entries" class="text-zinc-600 dark:text-zinc-400 text-sm">Show</label>
            <select id="show-entries" wire:model.live="perPage" class="w-[65px] border border-zinc-300 dark:border-zinc-700 p-1.5 rounded-lg text-sm text-black dark:text-white bg-white dark:bg-zinc-800">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
        </div>
        <div class="w-full sm:w-72">
            <flux:input size="sm" placeholder="Search event title..." wire:model.live="search" class="text-black dark:text-white" />
        </div>
    </div>

    <div class="overflow-x-auto shadow-sm rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">
        <table class="w-full text-sm text-left text-zinc-500 dark:text-zinc-300">
            <thead class="text-xs text-zinc-700 uppercase bg-zinc-100 dark:bg-zinc-800 dark:text-zinc-200">
                <tr class="text-center">
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Image</th>
                    <th class="px-4 py-3 text-left">Title</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Tags</th>
                    <th class="px-4 py-3">Year</th>
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @php $serial = 1 + (($events->currentPage() - 1) * $events->perPage()); @endphp
                @forelse($events as $event)
                    @php
                        $statusVal = $event->status instanceof \App\Enums\PortfolioStatusEnum ? $event->status->value : $event->status;
                        $statusLabel = \App\Enums\PortfolioStatusEnum::labels()[$statusVal] ?? 'Unknown';
                        $statusColor = \App\Enums\PortfolioStatusEnum::colors()[$statusVal] ?? 'bg-zinc-100 text-zinc-700';
                    @endphp
                    <tr class="text-center hover:bg-zinc-50 dark:hover:bg-zinc-800/60">
                        <td class="px-4 py-4 font-mono text-xs">{{ $serial++ }}</td>
                        <td class="px-4 py-4">
                            <img class="mx-auto w-[80px] h-[55px] object-cover rounded border dark:border-zinc-700" src="{{ $event->getFirstMediaUrl('portfolio_image', 'thumb') ?: 'https://placehold.co/80x55/27272a/ffffff?text=No+Image' }}">
                        </td>
                        <td class="px-4 py-4 font-medium text-left max-w-[200px] truncate text-zinc-900 dark:text-white">{{ $event->title }}</td>
                        <td class="px-4 py-4">
                            <span class="px-2.5 py-0.5 text-[11px] font-semibold rounded-full {{ $statusColor }}">{{ $statusLabel }}</span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex flex-wrap gap-1 justify-center max-w-[200px]">
                                @if(is_array($event->tags))
                                    @foreach($event->tags as $tag)
                                        <span class="px-1.5 py-0.5 text-[9px] font-bold uppercase rounded bg-orange-100 text-orange-800 dark:bg-orange-950/40 dark:text-orange-400">{{ $tag }}</span>
                                    @endforeach
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-4 font-medium text-zinc-800 dark:text-zinc-200">{{ $event->year ?: '—' }}</td>
                        <td class="px-4 py-4 space-x-1 whitespace-nowrap">
                            <flux:button as="a" href="{{ route('admin.portfolio-events.edit', $event->slug) }}" wire:navigate size="xs">Edit</flux:button>
                            <flux:button size="xs" variant="danger" wire:click="destroy({{ $event->id }})">Delete</flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-12 text-zinc-400">No Portfolio Events Found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 bg-zinc-50 dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-800">
            {{ $events->links() }}
        </div>
    </div>
</div>
