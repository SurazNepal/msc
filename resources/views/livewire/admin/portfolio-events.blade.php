<div class="flex flex-col gap-4 p-4 rounded-xl">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Portfolio Events</h1>
        <flux:button variant="primary" wire:click.prevent="showEventModal">Add Event</flux:button>
    </div>

    <flux:modal x-data="{ isUploading: false, progress: 0 }"
        :dismissible="false"
        @close="resetData();isUploading=false;progress=0;"
        name="portfolioEventModal"
        class="w-full max-w-3xl mx-auto px-4"
        x-on:close="if (window.editorInstance) { window.editorInstance.destroy().catch(err => console.error('CKEditor destroy error:', err)); window.editorInstance = null; }">
        <form wire:submit.prevent="save" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                <flux:heading size="lg">{{ $this->isEditMode ? 'Update Portfolio Event' : 'Add Portfolio Event' }}</flux:heading>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <flux:input type="text" name="title" label="Title" wire:model="title" badge="Required"  />
                    </div>

                    <div>
                        <flux:input type="text" name="year" label="Year / Edition" wire:model="year" placeholder="e.g., 2026" badge="Optional" />
                    </div>

                    <div class="md:col-span-2">
                        <flux:select label="Status" placeholder="Select status.." wire:model="status">
                            @foreach(\App\Enums\PortfolioStatusEnum::labels() as $value => $label)
                                <flux:select.option value="{{ $value }}">{{ $label }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>

                    <div class="md:col-span-2">
                        <flux:input type="text" name="tags" label="Badges / Tags (Comma Separated)" wire:model="tags" placeholder="e.g., UI/UX, Laravel" badge="Required" />
                    </div>

                    <div x-data="{ isUploading: false, progress: 0 }"
                        x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false; progress = 0"
                        x-on:livewire-upload-error="isUploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                        class="md:col-span-2 space-y-2">

                        <div class="flex flex-col">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Portfolio Image Preview</label>
                            <input type="file" wire:model="thumbnail" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600" />
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mt-2">
                            {{-- Progress bar for image upload --}}
                            <div x-show="isUploading" class="col-span-full w-full mt-2">
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                    <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" :style="'width:' + progress + '%'"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Uploading image... <span x-text="progress"></span>%</p>
                            </div>

                            {{-- 1. Temporary Upload Live Preview --}}
                            @if ($thumbnail)
                                <div class="relative aspect-[16/10] border rounded-lg overflow-hidden shadow group">
                                    <img src="{{ $thumbnail->temporaryUrl() }}" class="w-full h-full object-cover" />
                                    <button wire:click.prevent="removeUpload" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1.5 hover:bg-red-600 focus:outline-none transition opacity-90 hover:scale-105" title="Remove newly chosen file">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            {{-- 2. Spatie Existing Image Persistent Storage Preview --}}
                            @elseif ($isEditMode && $existingThumbnail)
                                <div class="relative aspect-[16/10] border rounded-lg overflow-hidden shadow group">
                                    <img src="{{ $existingThumbnail }}" class="w-full h-full object-cover" />
                                    <button type="button" wire:click.prevent="deleteExistingThumbnail"
                                        class="absolute top-2 right-2 z-50 bg-red-600 text-white rounded-full p-2 hover:bg-red-700 shadow-md focus:outline-none transition-all duration-150 hover:scale-110 flex items-center justify-center"
                                        title="Delete image from database permanently">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5 0v8.25a.75.75 0 0 0 1.5 0v-8.25Zm4.5 0a.75.75 0 1 0-1.5 0v8.25a.75.75 0 0 0 1.5 0v-8.25Z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300 block mb-1">Description</label>
                    <x-rich-text-editor wire:model="description">
                        <div id="content" >{!! $description !!}</div>
                    </x-rich-text-editor>
                </div>

                <div class="flex justify-end space-x-2">
                    <flux:button type="button" x-on:click="$flux.modal('portfolioEventModal').close()" variant="ghost">Cancel</flux:button>
                    <flux:button type="submit" variant="primary">
                        {{ $this->isEditMode ? 'Update' : 'Store' }}
                    </flux:button>
                </div>
            </div>
        </form>
    </flux:modal>

    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-white">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-white">
                <tr class="text-center">
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Image</th>
                    <th class="px-6 py-3">Title</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Tags</th>
                    <th class="px-6 py-3">Year / Edition</th>
                    <th class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $serial = 1 + (($events->currentPage() - 1) * $events->perPage()); @endphp
                @forelse($events as $event)
                    @php
                        $statusVal = $event->status instanceof \App\Enums\PortfolioStatusEnum ? $event->status->value : $event->status;
                        $statusLabel = \App\Enums\PortfolioStatusEnum::labels()[$statusVal] ?? 'Unknown';
                        $statusColor = \App\Enums\PortfolioStatusEnum::colors()[$statusVal] ?? 'bg-gray-100 text-gray-700';
                    @endphp
                    <tr class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 font-mono text-xs">{{ $serial++ }}</td>
                        <td class="px-6 py-4">
                            <img class="mx-auto w-[100px] h-[65px] object-cover rounded border dark:border-zinc-700" src="{{ $event->getFirstMediaUrl('portfolio_image', 'thumb') ?: 'https://placehold.co/100x65/27272a/ffffff?text=No+Image' }}" alt="Thumbnail">
                        </td>
                        <td class="px-6 py-4 font-medium text-left max-w-xs truncate text-gray-900 dark:text-white">{{ $event->title }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1 justify-center">
                                @if(is_array($event->tags))
                                    @foreach($event->tags as $tag)
                                        <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-full bg-orange-100 text-orange-800 dark:bg-orange-950/40 dark:text-orange-400 border border-orange-200 dark:border-orange-900/40">
                                            {{ $tag }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded bg-zinc-100 dark:bg-zinc-700 text-gray-800 dark:text-zinc-200">{{ $event->year ?: 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4 space-x-1 whitespace-nowrap">
                            <flux:button size="sm" wire:click="edit({{ $event->id }})">Edit</flux:button>
                            <flux:button size="sm" variant="danger" wire:click="destroy({{ $event->id }})">Delete</flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-gray-400 bg-gray-50 dark:bg-gray-900/30">No Portfolio Events Found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            {{ $events->links() }}
        </div>
    </div>
</div>

<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js'></script>

@section('script')
<script>
document.addEventListener("DOMContentLoaded", function () {
    new FroalaEditor('#content');
});
</script>
@endsection
