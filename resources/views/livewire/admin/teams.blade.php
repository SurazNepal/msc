<div class="flex flex-col gap-4 p-4 rounded-xl">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Teams Directory</h1>
        <flux:button variant="primary" wire:click.prevent="showTeamModal">Add Member</flux:button>
    </div>

    <flux:modal :dismissible="false" @close="resetData();" name="teamModal" class="w-full max-w-3xl mx-auto px-4">
        <form wire:submit.prevent="save" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                <flux:heading size="lg">{{ $this->isEditMode ? 'Update Team Profile' : 'Add Team Member' }}</flux:heading>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <flux:input type="text" name="full_name" label="Full Name" wire:model="full_name" badge="Required" />
                        <flux:error name="full_name" />
                    </div>

                    <div>
                        <flux:input type="text" name="job_post" label="Job Post / Designation" wire:model="job_post" placeholder="e.g., Senior Web Developer" badge="Required" />
                        <flux:error name="job_post" />
                    </div>

                    <div class="md:col-span-2">
                        <flux:select label="Status" placeholder="Select status.." wire:model="status">
                            @foreach(\App\Enums\TeamStatusEnum::labels() as $value => $label)
                                <flux:select.option value="{{ $value }}">{{ $label }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:error name="status" />
                    </div>

                    <div x-data="{ isUploading: false, progress: 0 }"
                        x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false; progress = 0"
                        x-on:livewire-upload-error="isUploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                        class="md:col-span-2 space-y-2">

                        <div class="flex flex-col">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Profile Photo</label>
                            <input type="file" id="team-file-{{ $thumbnail ? 'active' : 'empty' }}" wire:model="thumbnail" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600" />
                            <flux:error name="thumbnail" />
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mt-2">
                            <div x-show="isUploading" class="col-span-full w-full mt-2" x-cloak>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                    <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" :style="'width:' + progress + '%'"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Uploading... <span x-text="progress"></span>%</p>
                            </div>

                            @if ($thumbnail)
                                <div wire:key="temp-team-thumb" class="relative aspect-square border rounded-lg overflow-hidden shadow group">
                                    <img src="{{ $thumbnail->temporaryUrl() }}" class="w-full h-full object-cover" />
                                    <button type="button" wire:click="removeUpload" class="absolute top-2 right-2 z-50 bg-red-500 text-white rounded-full p-1.5 hover:bg-red-600 focus:outline-none transition-all duration-150 shadow-md" title="Cancel upload">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                            @elseif ($isEditMode && $existingThumbnail)
                                <div wire:key="stored-team-thumb" class="relative aspect-square border rounded-lg overflow-hidden shadow group">
                                    <img src="{{ $existingThumbnail }}" class="w-full h-full object-cover" />
                                    <button type="button" wire:click="deleteExistingThumbnail" class="absolute top-2 right-2 z-50 bg-red-600 text-white rounded-full p-1.5 hover:bg-red-700 shadow-md focus:outline-none transition-all duration-150 flex items-center justify-center" title="Delete from disk">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5 0v8.25a.75.75 0 0 0 1.5 0v-8.25Zm4.5 0a.75.75 0 1 0-1.5 0v8.25a.75.75 0 0 0 1.5 0v-8.25Z" clip-rule="evenodd" /></svg>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-2">
                    <flux:button type="button" x-on:click="$flux.modal('teamModal').close()" variant="ghost">Cancel</flux:button>
                    <flux:button type="submit" variant="primary">{{ $this->isEditMode ? 'Update' : 'Store' }}</flux:button>
                </div>
            </div>
        </form>
    </flux:modal>
 <!-- Search and Show Entries Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
            <div class="flex items-center gap-2">
                <label for="show-entries" class="text-gray-600 text-sm">Show</label>
                <select
                    id="show-entries"
                    wire:model.live="perPage"
                    class="w-[50px] border p-2 rounded text-sm text-black dark:text-white"
                >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
                <span class="text-gray-600 text-sm">entries</span>
            </div>

            <div class="flex items-center">
                <flux:input
                    size="sm"
                    placeholder="Filter by..."
                    wire:model.live="search"
                    class="text-black dark:text-white"
                />
            </div>
        </div>
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-white">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-white">
                <tr class="text-center">
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Photo</th>
                    <th class="px-6 py-3">Full Name</th>
                    <th class="px-6 py-3">Designation</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $serial = 1 + (($teams->currentPage() - 1) * $teams->perPage()); @endphp
                @forelse($teams as $member)
                    @php
                        $statusVal = $member->status instanceof \App\Enums\TeamStatusEnum ? $member->status->value : $member->status;
                        $statusLabel = \App\Enums\TeamStatusEnum::labels()[$statusVal] ?? 'Unknown';
                        $statusColor = \App\Enums\TeamStatusEnum::colors()[$statusVal] ?? 'bg-gray-100 text-gray-700';
                    @endphp
                    <tr class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 font-mono text-xs">{{ $serial++ }}</td>
                        <td class="px-6 py-4">
                            <img class="mx-auto w-[55px] h-[55px] object-cover rounded-full border dark:border-zinc-700 shadow-sm" src="{{ $member->getFirstMediaUrl('team_image', 'thumb') ?: 'https://placehold.co/55x55/27272a/ffffff?text=Avatar' }}" alt="Profile">
                        </td>
                        <td class="px-6 py-4 font-semibold text-center text-gray-900 dark:text-white">{{ $member->full_name }}</td>
                        <td class="px-6 py-4 text-center font-medium text-gray-600 dark:text-zinc-300">{{ $member->job_post }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-4 space-x-1 whitespace-nowrap">
                            <flux:button size="sm" wire:click="edit({{ $member->id }})">Edit</flux:button>
                            <flux:button size="sm" variant="danger" wire:click="destroy({{ $member->id }})">Delete</flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-gray-400 bg-gray-50 dark:bg-gray-900/30">No Team Members Found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            {{ $teams->links() }}
        </div>
    </div>
</div>
