<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-gauge-high text-pink-600 text-xl"></i>
            {{ __('Dashboard KUD Gajah Mada') }}
        </div>
    </x-slot>

    <div class="p-6 bg-gray-50 min-h-screen">

        @include('dashboard._summary')

        @include('dashboard._status')

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
                    borderWidth: 0, // Dibuat 0 agar flat dan modern
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
                cutout: '70%' // Lubang donat lebih elegan
            }
        });
    </script>
</x-app-layout>
