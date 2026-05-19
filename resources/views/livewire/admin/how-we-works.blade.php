<div class="flex flex-col gap-4 p-4 rounded-xl">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Workflow Breakdown ("How We Work")</h1>
        <flux:button variant="primary" wire:click.prevent="showStepModal">Add Process Step</flux:button>
    </div>

    <flux:modal :dismissible="false" @close="resetData();" name="stepModal" class="w-full max-w-3xl mx-auto px-4">
        <form wire:submit.prevent="save" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                <flux:heading size="lg">{{ $this->isEditMode ? 'Update Step Logic' : 'Add Strategic Stage' }}</flux:heading>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <flux:select label="Process Step Identifier" wire:model="step" badge="Required">
                            @foreach(\App\Enums\WorkStepEnum::labels() as $value => $label)
                                <flux:select.option value="{{ $value }}">{{ $label }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div>
                        <flux:input type="text" name="title" label="Stage Header Title" wire:model="title" badge="Required" />
                    </div>

                   <div class="md:col-span-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300 block mb-1">Description</label>
                    <x-rich-text-editor wire:model="description">
                        <div id="content" >{!! $description !!}</div>
                    </x-rich-text-editor>
                </div>

                    <div class="md:col-span-2">
                        <flux:select label="Visibility Status" wire:model="status">
                            @foreach(\App\Enums\WorkStatusEnum::labels() as $value => $label)
                                <flux:select.option value="{{ $value }}">{{ $label }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div x-data="{
                            isUploading: false,
                            progress: 0,
                            localPreview: null,
                            showExisting: true,
                            clearUpload(el) {
                                this.localPreview = null;
                                el.value = '';
                            }
                         }"
                        x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false; progress = 0"
                        x-on:livewire-upload-error="isUploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                        class="md:col-span-2 space-y-2">

                        <div class="flex flex-col">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Process Illustration Icon Asset</label>
                            <input type="file"
                                x-ref="fileInput"
                                @change="localPreview = URL.createObjectURL($event.target.files[0]); showExisting = false;"
                                wire:model="icon"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600" />
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mt-2">
                            {{-- Upload Progress Info --}}
                            <div x-show="isUploading" class="col-span-full w-full mt-2" x-cloak>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                    <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" :style="'width:' + progress + '%'"></div>
                                </div>
                            </div>

                            {{-- 1. Alpine Driven Upload Preview Box --}}
                            <div x-show="localPreview" x-cloak class="relative aspect-[16/10] border rounded-lg overflow-hidden shadow p-2 bg-gray-50 dark:bg-zinc-900 flex items-center justify-center">
                                <img :src="localPreview" class="max-w-full max-h-full object-contain" />
                                <button type="button" @click="clearUpload($refs.fileInput); $wire.removeImage();" class="absolute top-2 right-2 z-50 bg-red-500 text-white rounded-full p-1.5 hover:bg-red-600 focus:outline-none transition-all duration-150 shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            {{-- 2. Persistent Spatie Media Asset Preview Box --}}
                            @if ($isEditMode && $existingIcon)
                                <div x-show="!localPreview && showExisting" class="relative aspect-[16/10] border rounded-lg overflow-hidden shadow p-2 bg-gray-50 dark:bg-zinc-900 flex items-center justify-center">
                                    <img src="{{ $existingIcon }}" class="max-w-full max-h-full object-contain" />
                                    <button type="button" @click="showExisting = false; $wire.markExistingIconForDeletion();"
                                        class="absolute top-2 right-2 z-50 bg-red-600 text-white rounded-full p-2 hover:bg-red-700 shadow-md focus:outline-none transition-all duration-150"
                                        title="Remove Icon Media File">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5 0v8.25a.75.75 0 0 0 1.5 0v-8.25Zm4.5 0a.75.75 0 1 0-1.5 0v8.25a.75.75 0 0 0 1.5 0v-8.25Z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-2">
                    <flux:button type="button" x-on:click="$flux.modal('stepModal').close()" variant="ghost">Cancel</flux:button>
                    <flux:button type="submit" variant="primary">{{ $this->isEditMode ? 'Update Strategy' : 'Save Strategy' }}</flux:button>
                </div>
            </div>
        </form>
    </flux:modal>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
        <div class="flex items-center gap-2">
            <label for="perPage" class="text-gray-600 text-sm">Show</label>
            <select id="perPage" wire:model.live="perPage" class="w-[65px] border p-2 rounded text-sm text-black dark:text-white bg-transparent">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
            </select>
            <span class="text-gray-600 text-sm">entries</span>
        </div>
        <flux:input size="sm" placeholder="Search workflow steps..." wire:model.live="search" class="text-black dark:text-white w-full sm:w-64" />
    </div>

    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-white">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-white">
                <tr class="text-center">
                    <th class="px-6 py-3">Step</th>
                    <th class="px-6 py-3">Icon representation</th>
                    <th class="px-6 py-3">Strategic Title</th>
                    <th class="px-6 py-3">Description Core Summary</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Action Operations</th>
                </tr>
            </thead>
            <tbody>
                @forelse($steps as $item)
                    @php
                        $stepVal = $item->step instanceof \App\Enums\WorkStepEnum ? $item->step->value : $item->step;
                        $statusVal = $item->status instanceof \App\Enums\WorkStatusEnum ? $item->status->value : $item->status;
                        $statusLabel = \App\Enums\WorkStatusEnum::labels()[$statusVal] ?? 'Unknown';
                        $statusColor = \App\Enums\WorkStatusEnum::colors()[$statusVal] ?? 'bg-gray-100 text-gray-700';
                    @endphp
                    <tr class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 font-bold text-indigo-600 dark:text-indigo-400 font-mono">#{{ $stepVal }}</td>
                        <td class="px-6 py-4">
                            <div class="mx-auto w-12 h-12 bg-gray-50 dark:bg-zinc-900 rounded border dark:border-zinc-700 flex items-center justify-center p-1">
                                <img class="max-w-full max-h-full object-contain" src="{{ $item->getFirstMediaUrl('work_icon', 'thumb') ?: 'https://placehold.co/48x48/27272a/ffffff?text=Icon' }}" alt="Step Icon">
                            </div>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">{{ $item->title }}</td>
                        <td class="px-6 py-4 text-left max-w-sm truncate text-xs">{!! $item->description !!}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-4 space-x-1 whitespace-nowrap">
                            <flux:button size="sm" wire:click="edit({{ $item->id }})">Edit</flux:button>
                            <flux:button size="sm" variant="danger" wire:click="destroy({{ $item->id }})">Delete</flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-gray-400 bg-gray-50 dark:bg-gray-900/30">No Active Flow Matrix Setup Located</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            {{ $steps->links() }}
        </div>
    </div>
</div>
