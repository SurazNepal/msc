<div class="p-6 max-w-6xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Social Media Integrations</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Manage external corporate profile anchors.</p>
        </div>
        <flux:button variant="primary" icon="plus" wire:click="openCreateModal">Add Platform</flux:button>
    </div>

    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Platform Name</th>
                        <th scope="col" class="px-6 py-3">Target Profile URL</th>
                        <th scope="col" class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($socials as $social)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 bg-white dark:bg-gray-800" wire:key="social-row-{{ $social->id }}">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $social->name }}
                            </td>
                            <td class="px-6 py-4 truncate max-w-xs text-blue-600 dark:text-blue-400">
                                <a href="{{ $social->url }}" target="_blank" class="hover:underline">{{ $social->url }}</a>
                            </td>
                            <td class="px-6 py-4 text-right space-x-1 whitespace-nowrap">
                                <flux:button icon="pencil" variant="ghost" size="sm" wire:click="edit({{ $social->id }})" />
                                <flux:button icon="trash" variant="ghost" size="sm" class="text-red-500 hover:text-red-600" wire:click="delete({{ $social->id }})" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-8 text-gray-400 dark:text-gray-500">No profile links mapped yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <flux:modal name="social-media-modal" class="md:w-[500px] space-y-6">
        <div>
            <flux:heading size="lg">{{ $isEditMode ? 'Modify Integration Parameters' : 'Add New Social Connection' }}</flux:heading>
            <flux:subheading>Define target path records configuration pointers explicitly.</flux:subheading>
        </div>

        <form wire:submit.prevent="save" class="space-y-4">
            <div class="space-y-1">
                <label for="name" class="text-sm font-medium text-gray-700 dark:text-gray-300">Platform Identity Name</label>
                <input type="text" id="name" wire:model="name" placeholder="e.g., Facebook, GitHub, LinkedIn"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:text-white dark:bg-gray-700 dark:border-gray-600 p-2.5 focus:ring-2 focus:ring-primary-500" />
                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1">
                <label for="url" class="text-sm font-medium text-gray-700 dark:text-gray-300">Hyperlink Address URL</label>
                <input type="text" id="url" wire:model="url" placeholder="https://..."
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:text-white dark:bg-gray-700 dark:border-gray-600 p-2.5 focus:ring-2 focus:ring-primary-500" />
                @error('url') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-2 justify-end pt-4 border-t border-gray-100 dark:border-gray-700">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save">Save Connection</span>
                    <span wire:loading wire:target="save">Processing...</span>
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
