<div class="p-6 max-w-7xl mx-auto bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
    <form wire:submit.prevent="save" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="pb-3 border-b border-zinc-200 dark:border-zinc-800">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Create New Portfolio Event</h1>
            <p class="text-xs text-zinc-500">Fill out details to publish a new event entry.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" x-data="{ isUploading: false, progress: 0 }">
            <div class="md:col-span-2">
                <flux:input type="text" label="Title" wire:model="title" badge="Required" />
            </div>
            <div>
                <flux:input type="text" label="Year / Edition" wire:model="year" placeholder="e.g., 2026" />
            </div>
            <div>
                <flux:select label="Status" placeholder="Select status.." wire:model="status">
                    @foreach(\App\Enums\PortfolioStatusEnum::labels() as $value => $label)
                        <flux:select.option value="{{ $value }}">{{ $label }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <div class="md:col-span-2">
                <flux:input type="text" label="Badges / Tags (Comma Separated)" wire:model="tags" placeholder="e.g., UI/UX, Laravel" />
            </div>

            <div class="md:col-span-2 space-y-2"
                x-on:livewire-upload-start="isUploading = true"
                x-on:livewire-upload-finish="isUploading = false; progress = 0"
                x-on:livewire-upload-progress="progress = $event.detail.progress">

                <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Portfolio Banner Asset</label>
                <input type="file" wire:model="thumbnail" class="block w-full text-xs text-zinc-900 border border-zinc-300 rounded-lg bg-zinc-50 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-400" />

                <div x-show="isUploading" class="w-full bg-zinc-200 rounded-full h-1.5 dark:bg-zinc-700 mt-2">
                    <div class="bg-blue-600 h-1.5 rounded-full" :style="'width:' + progress + '%'"></div>
                </div>

                @if ($thumbnail)
                    <div class="relative aspect-[16/6] border border-zinc-200 dark:border-zinc-800 rounded-lg overflow-hidden mt-2">
                        <img src="{{ $thumbnail->temporaryUrl() }}" class="w-full h-full object-cover" />
                        <button type="button" wire:click="removeUpload" class="absolute top-2 right-2 bg-zinc-900/80 backdrop-blur text-white p-1 rounded hover:bg-red-600 transition-colors text-xs">Remove</button>
                    </div>
                @endif
            </div>

            <div class="md:col-span-2">
                <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300 block mb-1">Detailed Description</label>
                <x-rich-text-editor wire:model="description">
                    <div id="content">{!! $description !!}</div>
                </x-rich-text-editor>
            </div>
        </div>

        <div class="flex justify-end gap-2 pt-4 border-t border-zinc-200 dark:border-zinc-800">
            <flux:button as="a" href="{{ route('admin.portfolio-events') }}" wire:navigate variant="ghost">Back to List</flux:button>
            <flux:button type="submit" variant="primary">Publish Event</flux:button>
        </div>
    </form>
</div>
