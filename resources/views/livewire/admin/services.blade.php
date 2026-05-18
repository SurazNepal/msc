<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 p-4 rounded-xl">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Services List</h1>
            <flux:modal x-data="{ isUploading: false, progress: 0 }"
                :dismissible="false"
                @close="resetData(); isUploading = false; progress = 0;"
                name="serviceModal"
                class="md:w-96"
                x-on:close="if (window.editorInstance) { window.editorInstance.destroy().catch(err => console.error('CKEditor destroy error:', err)); window.editorInstance = null; }">
                <form method="post" action="#" wire:submit='{{$isEditMode ? 'update' : 'save'}}' enctype='multipart/form-data' name='addService'>
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">
                                {{ $isEditMode ? 'Edit Service' : 'Add New Service' }}
                            </flux:heading>
                        </div>

                        <flux:input label="Title" badge="Required" type="text" wire:model='title' name="title" required/>

                        <div x-data="{ isUploading: false, progress: 0 }"
                            x-on:livewire-upload-start="isUploading = true"
                            x-on:livewire-upload-finish="isUploading = false; progress = 0"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress"
                            class="space-y-2">
                            <flux:input type="file" size="sm" badge="Use size below 2MB" name="icon" id="icon" wire:model='icon' label="Service Icon"/>
                            {{-- Progress bar for image upload --}}
                            <div x-show="isUploading" class="w-full mt-2">
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                    <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" :style="'width:' + progress + '%'"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Uploading image... <span x-text="progress"></span>%</p>
                            </div>

                            @if($icon)
                                <div class="mt-2">
                                    <img src="{{ $icon->temporaryUrl() }}" class="w-16 h-16 object-cover rounded-md border mt-1" alt="New upload preview">
                                </div>
                                @elseif($isEditMode && $existingIcon)
                                <div class="mt-2">
                                    <img src="{{ $existingIcon }}" class="w-16 h-16 object-cover rounded-md border mt-1" alt="Current service icon">
                                </div>
                                @endif
                        </div>

                        <div>
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                            <textarea id="description" wire:model="description" name="description" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Write your thoughts here..."></textarea>
                        </div>

                        <div class="flex space-x-2">
                            <flux:spacer />
                            <flux:modal.close>
                                <flux:button variant="ghost">Cancel</flux:button>
                            </flux:modal.close>
                            <flux:button type="submit" name="submit" variant="primary">
                                {{ $isEditMode ? 'Update Service' : 'Save Service' }}
                            </flux:button>
                        </div>
                    </div>
                </form>
            </flux:modal>

            <flux:modal.trigger wire:click.prevent="showServiceModal">
                <flux:button variant="primary">Add Service</flux:button>
            </flux:modal.trigger>
        </div>
        <p class="mb-4 text-sm text-gray-400">
            The Service List effectively dictates Service presentation and provides space to list your Service and offerings in the most appealing way.
        </p>

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

        <!-- Category Table -->
        <div class="overflow-x-auto">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-white">
                    <thead class="font-bold text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-white">
                        <tr class="text-center">
                            <th scope="col" class="px-6 py-3">
                                Icon
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Title
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Description
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($services as $service)
                            <tr class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <img class="mx-auto w-[100px]" src="{{ $service->getFirstMediaUrl('icon', 'thumb') ?: 'https://placehold.co/100' }}" alt="">
                                </th>
                                <td class="px-6 py-4 ">
                                    {{$service->title}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$service->description}}
                                </td>
                                <td class="px-6 py-4">
                                    <flux:button icon="user-pen"  wire:click='edit({{$service->id}})'>Edit</flux:button>
                                    <flux:button icon="user-round-x" wire:click='destroy({{$service->id}})' variant="danger">Delete</flux:button>
                                </td>
                            </tr>

                            @empty
                            <tr><td class="text-center" colspan='4'>No Record Found!</td></tr>
                            @endforelse
                    </tbody>

                </table>
                <div class="p-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                    {{ $services->links() }}
                </div>
            </div>
        </div>

    </div>
</div>

