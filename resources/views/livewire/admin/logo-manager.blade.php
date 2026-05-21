<div class="p-6 max-w-3xl mx-auto bg-white dark:bg-zinc-900 rounded-xl shadow space-y-6">
    <div>
        <h2 class="text-xl font-bold tracking-tight text-zinc-900 dark:text-white">Website Brand Identity Logo</h2>
        <p class="text-xs text-zinc-500">Upload and configure the central brand logo. Adding a new file automatically replaces the current live logo version.</p>
    </div>

    <form wire:submit.prevent="saveLogo" class="space-y-6">
        <flux:input label="Logo Alternate Text (SEO Alt Tag)" wire:model="alt_text" placeholder="e.g., Kata Chha Logo" required />

        <div x-data="{ localPreview: null }" class="space-y-2">
            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Logo Graphic Resource</label>

            <div class="border rounded-xl overflow-hidden bg-zinc-50 dark:bg-zinc-950 dark:border-zinc-800 flex flex-col items-center justify-center p-6 relative min-h-[220px]">

                <div class="max-w-full h-32 flex items-center justify-center mb-4">
                    <template x-if="localPreview">
                        <img :src="localPreview" alt="New Upload Preview" class="max-h-full object-contain rounded shadow-sm" />
                    </template>

                    <template x-if="!localPreview">
                        @if($existingLogoUrl)
                            <img src="{{ $existingLogoUrl }}" alt="{{ $alt_text }}" class="max-h-full object-contain filter drop-shadow-sm" />
                        @else
                            <div class="text-zinc-400 text-sm flex flex-col items-center gap-2 font-light">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-zinc-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 017.5 0z" />
                                </svg>
                                <span>No logo currently deployed.</span>
                            </div>
                        @endif
                    </template>
                </div>

                <div class="w-full max-w-md bg-[#161920] border border-zinc-800/80 p-4 rounded-lg flex items-center justify-between gap-3 shadow-md">
                    <label class="bg-white hover:bg-zinc-100 text-zinc-900 font-medium text-xs py-2 px-4 rounded cursor-pointer transition-colors whitespace-nowrap shadow-sm">
                        Choose File
                        <input type="file" accept="image/*" class="hidden"
                            @change="localPreview = URL.createObjectURL($event.target.files[0])"
                            wire:model="logo_file" />
                    </label>
                    <span class="text-xs text-zinc-400 truncate font-mono text-right flex-1">
                        <span x-text="$wire.logo_file ? 'New image selected' : 'No file chosen'"></span>
                    </span>
                </div>

                <div wire:loading wire:target="logo_file" class="absolute inset-0 bg-zinc-950/40 backdrop-blur-xs flex items-center justify-center rounded-xl">
                    <span class="text-xs text-white bg-zinc-900 px-3 py-1.5 rounded-full border border-zinc-800 animate-pulse shadow">Uploading temporary file stream...</span>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-2 border-t dark:border-zinc-800">
            <flux:button type="submit" variant="primary" class="w-full sm:w-auto">Update System Brand Identity Logo</flux:button>
        </div>
    </form>
</div>
