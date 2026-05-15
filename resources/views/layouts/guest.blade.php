<x-layouts.guest.main :title="$title ?? null" :withFilters="$withFilters ?? false" :breadcrumbs="$breadcrumbs ?? null" :mightAlsoLike="$mightAlsoLike ?? false">
        {{ $slot }}
</x-layouts.guest.main>
