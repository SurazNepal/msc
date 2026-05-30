<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Services List</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">The Service List effectively dictates Service presentation and structural web offerings.</p>
        </div>
        <flux:button as="a" href="{{ route('services.create') }}" wire:navigate variant="primary">Add Service</flux:button>
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
                    <th class="px-6 py-3">Icon</th>
                    <th class="px-6 py-3 text-left">Title</th>
                    <th class="px-6 py-3 text-left">Description</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse ($services as $service)
                    @php
                        $statusValue = $service->status instanceof \App\Enums\ServiceStatusEnum ? $service->status->value : $service->status;
                        $badgeColor = \App\Enums\ServiceStatusEnum::Colors()[$statusValue] ?? 'bg-zinc-100 text-zinc-800';
                        $badgeLabel = \App\Enums\ServiceStatusEnum::labels()[$statusValue] ?? ucfirst($statusValue);
                    @endphp
                    <tr class="text-center bg-white dark:bg-zinc-900 hover:bg-zinc-50 dark:hover:bg-zinc-800/60">
                        <td class="px-6 py-4">
                            <img class="mx-auto w-[60px] h-[60px] object-cover rounded-lg border dark:border-zinc-700" src="{{ $service->getFirstMediaUrl('icon', 'thumb') ?: 'https://placehold.co/60' }}">
                        </td>
                        <td class="px-6 py-4 font-medium text-left text-zinc-900 dark:text-white truncate max-w-[180px]">{{ $service->title }}</td>
                        <td class="px-6 py-4 text-left text-zinc-500 dark:text-zinc-400 max-w-xs truncate">
                            {{ Str::limit(strip_tags($service->description), 60, '...') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $badgeColor }}">
                                {{ $badgeLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-4 space-x-1 whitespace-nowrap">
                            <flux:button size="xs" icon="user-pen" as="a" href="{{ route('services.edit', $service->slug) }}" wire:navigate>Edit</flux:button>
                            <flux:button size="xs" icon="user-round-x" wire:click="destroy({{ $service->id }})" variant="danger">Delete</flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center py-12 text-zinc-400" colspan="5">No Records Found!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 bg-zinc-50 dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-800">
            {{ $services->links() }}
        </div>
    </div>
</div>
