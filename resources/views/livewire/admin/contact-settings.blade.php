<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Contact Information Settings</h1>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
            Update the primary corporate credentials used across public frontend maps and communication templates.
        </p>
    </div>

    @if (session()->has('status'))
        <div class="mb-6 p-4 rounded-lg bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/50 text-emerald-800 dark:text-emerald-400 text-sm flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 flex-shrink-0">
                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 p-4 rounded-lg bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-800/50 text-rose-800 dark:text-rose-400 text-sm flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 flex-shrink-0">
                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm overflow-hidden">
        <form wire:submit.prevent="save" class="p-6 space-y-6">

            <div class="space-y-1">
                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Official Street Address</label>
                <input type="text" id="address" wire:model="address"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-gray-100 dark:bg-gray-700 dark:border-gray-600 p-2.5"
                    placeholder="e.g., Sparks Hub, Kathmandu, Nepal" />
                @error('address') <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1">
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact Telephone Number</label>
                    <input type="text" id="phone" wire:model="phone"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-gray-100 dark:bg-gray-700 dark:border-gray-600 p-2.5"
                        placeholder="e.g., +977 1-4XXXXXX" />
                    @error('phone') <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Public Support Email Address</label>
                    <input type="email" id="email" wire:model="email"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-gray-100 dark:bg-gray-700 dark:border-gray-600 p-2.5"
                        placeholder="e.g., contact@youragency.com" />
                    @error('email') <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center justify-end border-t border-gray-200 dark:border-gray-700 pt-5 mt-6 gap-3">
                <flux:button type="submit" variant="primary" icon="check" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save">Save Configurations</span>
                    <span wire:loading wire:target="save">Synchronizing changes...</span>
                </flux:button>
            </div>
        </form>
    </div>
</div>
