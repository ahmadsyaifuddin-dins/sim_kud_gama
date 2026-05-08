<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-gauge-high text-pink-600 text-xl"></i>
            {{ __('Dashboard KUD Gajah Mada') }}
        </div>
    </x-slot>

    <div class="p-6 bg-gray-50 min-h-screen">

        <div class="mb-4">
            @include('components.alerts.success')
            @include('components.alerts.error')
        </div>

        <div class="flex justify-end mb-4">
            <a href="{{ route('backup.database') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
                <i class="fa-solid fa-database mr-2"></i> Backup Database (.sql)
            </a>
        </div>

        <div class="flex flex-col gap-8 mb-6">
            <div class="w-full">
                @include('dashboard._summary')
            </div>

            <div class="w-full">
                @include('dashboard._status')
            </div>
        </div>

        @include('dashboard._charts')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('dusunChart').getContext('2d');
        const dusunChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Jumlah Anggota',
                    data: {!! json_encode($data) !!},
                    backgroundColor: [
                        '#ec4899', '#3b82f6', '#f59e0b', '#10b981', '#8b5cf6', '#ef4444', '#14b8a6'
                    ],
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            font: {
                                family: "'Arial', sans-serif",
                                size: 12,
                                weight: 'bold'
                            },
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                },
                cutout: '70%'
            }
        });
    </script>
</x-app-layout>
