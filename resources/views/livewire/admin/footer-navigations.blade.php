<div class="p-6 space-y-6 max-w-6xl mx-auto bg-white dark:bg-zinc-900 rounded-xl shadow">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Footer Link Columns Manager</h2>
            <p class="text-sm text-zinc-500">Group your dynamic services and layout pages together cleanly into custom navigation categories.</p>
        </div>
        <flux:button variant="filled" wire:click="showFooterNavigationModal">Create Section Column Heading</flux:button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($footerGroups as $columnHeading => $links)
            <div class="border border-zinc-200 dark:border-zinc-800 rounded-xl p-4 bg-zinc-50/50 dark:bg-zinc-950/30 flex flex-col justify-between" wire:key="column-group-{{ Str::slug($columnHeading) }}">
                <div>
                    <div class="flex items-center justify-between border-b pb-2 dark:border-zinc-800 mb-3">
                        <span class="text-xs uppercase font-mono tracking-wider font-bold text-orange-600 dark:text-orange-500">{{ $columnHeading }}</span>
                        <div class="flex items-center space-x-1">
                            <flux:button size="xs" variant="ghost" wire:click="editHeading('{{ $columnHeading }}')">Rename</flux:button>
                            <flux:button size="xs" variant="ghost" class="text-red-600 hover:text-red-700" wire:click="destroyHeading('{{ $columnHeading }}')">Drop</flux:button>
                        </div>
                    </div>

                    <ul class="space-y-2">
                        @foreach($links as $link)
                            @if($link->type) {{-- Filters out dummy empty container column row items cleanly --}}
                                @php $resolvedItem = collect($link->related)->first(); @endphp
                                @if($resolvedItem)
                                    <li class="flex items-center justify-between bg-white dark:bg-zinc-900 px-3 py-2 rounded-lg border dark:border-zinc-800/80 text-xs text-zinc-600 dark:text-zinc-300 shadow-xs" wire:key="link-node-{{ $link->id }}">
                                        <div class="truncate pr-2">
                                            <span class="font-medium block truncate text-zinc-800 dark:text-zinc-100">{{ $resolvedItem->title }}</span>
                                            <span class="font-mono text-[10px] text-zinc-400 block truncate">{{ $resolvedItem->route }}</span>
                                        </div>
                                        <div class="flex gap-1 shrink-0">
                                            <flux:button size="xs" variant="ghost" wire:click="editContent({{ $link->id }})">Edit</flux:button>
                                            <flux:button size="xs" variant="ghost" class="text-red-500 hover:text-red-600" wire:click="destroyContent({{ $link->id }})">×</flux:button>
                                        </div>
                                    </li>
                                @endif
                            @endif
                        @endforeach
                    </ul>
                </div>

                <div class="mt-4 pt-3 border-t border-dashed dark:border-zinc-800">
                    <flux:button size="sm" variant="ghost" class="w-full text-center" wire:click="ShowContentModal('{{ $columnHeading }}')">+ Link Pages to Column</flux:button>
                </div>
            </div>
        @empty
            <div class="col-span-full border border-dashed rounded-xl p-12 text-center text-zinc-400 dark:border-zinc-800">
                No custom navigation column arrays found. Create a column heading folder row node context to start.
            </div>
        @endforelse
    </div>

    <flux:modal name="addFooterHeadingModal" class="w-full max-w-md mx-auto">
        <form wire:submit.prevent="{{ $isEditHeading ? 'updateHeading' : 'storeHeading' }}" class="space-y-4">
            <flux:heading size="lg">{{ $isEditHeading ? 'Rename Column Folder Category' : 'Create Custom Column Heading' }}</flux:heading>

            <flux:input label="Category Header Name Text String" wire:model="heading" required placeholder="e.g., OUR SERVICES" />

            <div class="flex justify-end space-x-2 pt-4">
                <flux:button type="button" wire:click="resetData" variant="ghost">Cancel</flux:button>
                <flux:button type="submit" variant="primary">Save Heading Structure Node</flux:button>
            </div>
        </form>
    </flux:modal>

    <flux:modal name="addFooterContentModal" class="w-full max-w-lg mx-auto">
        <form wire:submit.prevent="{{ $isEditContent ? 'updateContent' : 'storeContent' }}" class="space-y-4">
            <flux:heading size="lg">{{ $isEditContent ? 'Modify Linked Mapping Route' : 'Bind App Routes to Column Cluster' }}</flux:heading>
            <p class="text-xs text-zinc-400 font-mono">TARGET MATRIX HEADWORD: <span class="text-zinc-800 dark:text-zinc-200 uppercase font-bold">{{ $heading }}</span></p>

            <div class="space-y-2">
                <label class="text-sm font-medium text-zinc-800 dark:text-zinc-200">Select Structural Route Option Nodes</label>
                <div class="border rounded-lg max-h-60 overflow-y-auto divide-y dark:border-zinc-800 dark:divide-zinc-800 bg-zinc-50/50 dark:bg-zinc-950/20">
                    @foreach($pages as $p)
                        <label class="flex items-center gap-3 p-3 text-xs text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-900 cursor-pointer transition-colors" wire:key="select-opt-{{ $p['value'] }}">
                            @if($isEditContent)
                                <input type="radio" value="{{ $p['value'] }}" wire:model="selectedPages.0" class="rounded-full border-zinc-300 dark:border-zinc-700 text-orange-600 focus:ring-orange-500" />
                            @else
                                <input type="checkbox" value="{{ $p['value'] }}" wire:model="selectedPages" class="rounded border-zinc-300 dark:border-zinc-700 text-orange-600 focus:ring-orange-500" />
                            @endif
                            <span class="font-medium select-none">{{ $p['title'] }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end space-x-2 pt-4">
                <flux:button type="button" wire:click="resetData" variant="ghost">Cancel</flux:button>
                <flux:button type="submit" variant="primary">Commit Node Record</flux:button>
            </div>
        </form>
    </flux:modal>

</div>
