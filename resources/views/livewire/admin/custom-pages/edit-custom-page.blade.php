<div class="p-6 w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
    <form wire:submit.prevent="update" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="pb-3 border-b border-zinc-200 dark:border-zinc-800">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Modify Custom Page Record</h1>
            <p class="text-xs text-zinc-500">Alter configuration metrics or update content strings regarding this system layout component.</p>
        </div>

        <div class="grid grid-cols-1 gap-4" x-data="{ isUploading: false, progress: 0 }">
            <div>
                <flux:input label="Title" badge="Required" type="text" wire:model="title" required/>
            </div>

            <div>
                <flux:select label="Status" placeholder="Select status.." wire:model="status">
                    <flux:select.option value="Published">Published</flux:select.option>
                    <flux:select.option value="Draft">Draft</flux:select.option>
                </flux:select>
            </div>

            <div class="space-y-2"
                x-on:livewire-upload-start="isUploading = true"
                x-on:livewire-upload-finish="isUploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress">

                <flux:input type="file" size="sm" badge="Max 2MB" name="featuredImage" id="featuredImage" wire:model="featuredImage" label="Change Featured Banner Image Asset"/>

                <div x-show="isUploading" class="w-full mt-2" x-cloak>
                    <div class="w-full bg-zinc-200 dark:bg-zinc-800 rounded-full h-1.5">
                        <div class="bg-blue-600 h-1.5 rounded-full transition-all" :style="'width:' + progress + '%'"></div>
                    </div>
                </div>

                @if($featuredImage)
                    <div class="mt-2">
                        <img src="{{ $featuredImage->temporaryUrl() }}" class="w-40 h-24 object-cover rounded-lg border dark:border-zinc-700">
                    </div>
                @elseif($existingFeaturedImage)
                    <div class="mt-2">
                        <img src="{{ $existingFeaturedImage }}" class="w-40 h-24 object-cover rounded-lg border dark:border-zinc-700">
                    </div>
                @endif
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-zinc-700 dark:text-zinc-300">Detailed Content Markup</label>
                <x-rich-text-editor wire:model="content">
                    <div id="content">{!! $content !!}</div>
                </x-rich-text-editor>
            </div>
        </div>

        <div class="flex justify-end gap-2 pt-4 border-t border-zinc-200 dark:border-zinc-800">
            <flux:button as="a" href="{{ route('manage-custom-pages') }}" wire:navigate variant="ghost">Cancel</flux:button>
            <flux:button type="submit" variant="primary">Update Custom Page</flux:button>
        </div>
    </form>
</div>
