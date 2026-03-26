<x-filament-widgets::widget>
    <x-filament::section>
        <div class="grid gap-6 lg:grid-cols-2">
            <div>
                <h3 class="text-base font-semibold text-gray-950">Páginas más vistas (30d)</h3>
                <div class="mt-4 space-y-3">
                    @forelse($topPages as $row)
                        <div class="flex items-center justify-between rounded-lg border border-gray-200 px-4 py-3">
                            <div>
                                <p class="font-medium text-gray-900">{{ $row['page'] ?: '/' }}</p>
                                <p class="text-sm text-gray-500">{{ $row['conversions'] }} conversiones</p>
                            </div>
                            <span class="text-sm font-semibold text-primary-600">{{ $row['views'] }} vistas</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Aún no hay pageviews registradas.</p>
                    @endforelse
                </div>
            </div>

            <div>
                <h3 class="text-base font-semibold text-gray-950">Páginas con peor conversión (30d)</h3>
                <div class="mt-4 space-y-3">
                    @forelse($worstPages as $row)
                        <div class="flex items-center justify-between rounded-lg border border-gray-200 px-4 py-3">
                            <div>
                                <p class="font-medium text-gray-900">{{ $row['page'] ?: '/' }}</p>
                                <p class="text-sm text-gray-500">{{ $row['conversions'] }} conversiones sobre {{ $row['views'] }} vistas</p>
                            </div>
                            <span class="text-sm font-semibold text-danger-600">{{ number_format($row['rate'], 2) }}%</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Se necesitan al menos 10 vistas por página para calcularlo.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
