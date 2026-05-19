<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light" style="color-scheme: light;">
    <head>
        @include('partials.head')
        @include('sweetalert2::index')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        {{--<script src="sweetalert2.min.js"></script>
<link rel="stylesheet" href="sweetalert2.min.css"> --}}
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo
                    :sidebar="true"
                    :href="auth()->user()->hasRole('admin') ? route('admin.dashboard') : route('employee.dashboard')"
                    wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')" class="grid">
                    <flux:sidebar.item
                        icon="home"
                        :href="auth()->user()->hasRole('admin') ? route('admin.dashboard') : route('employee.dashboard')"
                        :current="request()->routeIs('*.dashboard')"
                        wire:navigate
                    >
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                    <flux:navlist.item icon="newspaper" :href="route('admin.portfolio-event')" :current="request()->routeIs('admin.portfolio-event')" wire:navigate>
                        {{ __('Events') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="handshake" :href="route('admin.our-clients')" :current="request()->routeIs('admin.our-clients')" wire:navigate>
                        {{ __('Our Clients') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="users-round" :href="route('admin.teams')" :current="request()->routeIs('admin.teams')" wire:navigate>
                        {{ __('Teams') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="list-ordered" :href="route('admin.work')" :current="request()->routeIs('admin.work')" wire:navigate>
                        {{ __('How We Work') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="building-2" :href="route('admin.aboutManager')" :current="request()->routeIs('admin.aboutManager')" wire:navigate>
                        {{ __('About Manager') }}
                    </flux:navlist.item>
                </flux:sidebar.group>
                <flux:navlist.group :heading="__('Others')" expandable>
                    <flux:navlist.item icon="wrench" :href="route('admin.services')" :current="request()->routeIs('admin.services')" wire:navigate>
                        {{ __('Services') }}
                    </flux:navlist.item>

                </flux:navlist.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
            @endpersist

        @fluxScripts
        <script>
        $(document).ready(function() {
            document.addEventListener('swalToast', function(e) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'swal2-toast-center'
                    },
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: e.detail[0].icon,
                    title: e.detail[0].message,
                });
            });
            document.addEventListener('confirm_delete', function(e) {
                const actionType = e.detail[0].for; // Get the 'for' parameter
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('deleteAction' + actionType);
                        }
                    });
            });
            const notifBtn = document.getElementById('notifBtn');
            const notifDropdown = document.getElementById('notifDropdown');

            if (notifBtn && notifDropdown) {
                notifBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    notifDropdown.classList.toggle('hidden');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function() {
                    if (!notifDropdown.classList.contains('hidden')) {
                        notifDropdown.classList.add('hidden');
                    }
                });
                // Prevent clicks inside dropdown from closing it
                notifDropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        });
        </script>

    </body>
</html>
