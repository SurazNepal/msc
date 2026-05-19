<div class="p-6 space-y-6 max-w-6xl mx-auto bg-white dark:bg-zinc-900 rounded-xl shadow">
    <div>
        <h2 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">About & Features Layout Customizer</h2>
        <p class="text-sm text-zinc-500">Configure global metadata headers, registration tags, metrics counters, and child highlights text.</p>
    </div>

    <form wire:submit.prevent="saveSettings" class="space-y-6 border-b pb-6 dark:border-zinc-800">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:input label="Badge Upper Text" wire:model="state.badge_text" />
            <flux:input label="Primary Block Title" wire:model="state.title" />

            <div class="md:col-span-2">
                <flux:textarea label="Paragraph Summary One" rows="3" wire:model="state.description_one" />
            </div>
            <div class="md:col-span-2">
                <flux:textarea label="Paragraph Summary Two (Optional)" rows="3" wire:model="state.description_two" />
            </div>

            <flux:input label="Company Reg Code String" wire:model="state.registration_number" />
            <flux:input label="Reg Subtext/Date" wire:model="state.registration_date_text" />
            <flux:input label="PAN / VAT Identifier" wire:model="state.pan_vat_number" />
            <flux:input label="PAN Subtext/Date" wire:model="state.pan_vat_date_text" />

            <flux:input label="Stats Counter Value" wire:model="state.stats_count" />
            <flux:input label="Stats Counter Legend" wire:model="state.stats_label" />
            <flux:input label="CTA Button Label text" wire:model="state.button_text" />
            <flux:input label="CTA Button Redirection Path/URL" wire:model="state.button_url" />

            <div x-data="{ localBanner: null, showExisting: true }" class="md:col-span-2 space-y-2">
                <label class="text-sm font-medium">Right-Side Graphical Core Illustration</label>
                <input type="file" @change="localBanner = URL.createObjectURL($event.target.files[0]); showExisting = false;" wire:model="banner_file" class="block w-full text-sm text-zinc-500 border rounded-lg cursor-pointer bg-zinc-50 dark:bg-zinc-800 dark:border-zinc-700" />

                <div class="flex gap-4 mt-2">
                    <template x-if="localBanner">
                        <div class="relative w-32 h-20 border rounded overflow-hidden">
                            <img :src="localBanner" class="object-cover w-full h-full" />
                        </div>
                    </template>
                    @if($existingBanner)
                        <div x-show="showExisting" class="relative w-32 h-20 border rounded overflow-hidden bg-zinc-800">
                            <img src="{{ $existingBanner }}" class="object-contain w-full h-full" />
                            <button type="button" @click="showExisting = false; $wire.shouldDeleteBanner = true;" class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 text-xs">×</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Persist Core Framework Content</flux:button>
        </div>
    </form>

    <div class="space-y-4">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-bold">Child Feature Segment List Blocks</h3>
            <flux:button size="sm" variant="filled" wire:click="openHighlightModal()">Add Solution Feature Block</flux:button>
        </div>

        <div class="border rounded-xl overflow-hidden dark:border-zinc-800">
            <table class="w-full text-sm text-left">
                <thead class="bg-zinc-100 dark:bg-zinc-800 text-xs uppercase font-mono">
                    <tr>
                        <th class="p-3">Icon</th>
                        <th class="p-3">Title</th>
                        <th class="p-3">Description</th>
                        <th class="p-3 text-center">Order</th>
                        <th class="p-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y dark:divide-zinc-800">
                    @forelse($highlights as $h)
                        <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/50">
                            <td class="p-3">
                                <div class="w-8 h-8 bg-zinc-900 rounded p-1 border dark:border-zinc-700 flex items-center justify-center">
                                    <img src="{{ $h->getFirstMediaUrl('highlight_icon') ?: 'https://placehold.co/32x32/orange/white?text=Icon' }}" class="max-w-full max-h-full object-contain" />
                                </div>
                            </td>
                            <td class="p-3 font-semibold">{{ $h->title }}</td>
                            <td class="p-3 max-w-xs truncate text-xs text-zinc-500">{{ $h->description }}</td>
                            <td class="p-3 text-center font-mono">{{ $h->sort_order }}</td>
                            <td class="p-3 text-center space-x-1 whitespace-nowrap" wire:key="highlight-actions-{{ $h->id }}">
                                <flux:button
                                    size="xs"
                                    wire:click="openHighlightModal({{ $h->id }})"
                                    x-on:click="$flux.modal('highlightModal').show()"
                                >
                                    Edit
                                </flux:button>

                                <flux:button
                                    size="xs"
                                    variant="danger"
                                    wire:click="deleteHighlight({{ $h->id }})"
                                >
                                    Drop
                                </flux:button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-zinc-400">No active card elements linked.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <flux:modal :dismissible="false" name="highlightModal" class="w-full max-w-lg mx-auto">
        <form wire:submit.prevent="saveHighlight" class="space-y-4">
            <flux:heading size="lg">{{ $isHighlightEdit ? 'Edit Solution Detail Model' : 'Insert Solution Highlight Module' }}</flux:heading>

            <flux:input label="Feature Title Line" wire:model="h_title" required />
            <flux:textarea label="Feature Paragraph Description Text" rows="3" wire:model="h_description" required />
            <flux:input type="number" label="Sorting Sequence Number Order" wire:model="h_sort_order" />

            <div x-data="{ localIcon: null, showExistingIcon: true }" class="space-y-2">
                <label class="text-sm font-medium">Card Highlight Icon / Vector SVG File</label>
                <input type="file" @change="localIcon = URL.createObjectURL($event.target.files[0]); showExistingIcon = false;" wire:model="h_icon" class="block w-full text-xs text-zinc-500 border rounded cursor-pointer dark:bg-zinc-800 dark:border-zinc-700" />

                <div class="flex gap-2 mt-1">
                    <template x-if="localIcon">
                        <div class="w-12 h-12 border rounded bg-zinc-900 p-1"><img :src="localIcon" class="w-full h-full object-contain" /></div>
                    </template>
                    @if($existingHIcon)
                        <div x-show="showExistingIcon" class="relative w-12 h-12 border rounded bg-zinc-900 p-1">
                            <img src="{{ $existingHIcon }}" class="w-full h-full object-contain" />
                            <button type="button" @click="showExistingIcon = false; $wire.shouldDeleteHIcon = true;" class="absolute -top-1 -right-1 bg-red-600 text-white rounded-full text-[9px] px-1">×</button>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-end space-x-2 pt-4">
                <flux:button type="button" x-on:click="$flux.modal('highlightModal').close()" variant="ghost">Cancel</flux:button>
                <flux:button type="submit" variant="primary">Commit Node Record</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
