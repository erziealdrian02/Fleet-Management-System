<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Stat Card 1 -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Users</h3>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $getUser }}</p>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Mileage</h3>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $getMiles }} Km</p>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Trips</h3>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $getTrip }}</p>
                    </div>
                </div>

                <!-- Stat Card 4 -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Vehicle</h3>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $getVehicle }}</p>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Analytics Overview</h3>
                    <div class="w-full" style="height: 400px;">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        // Chart initialization
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('myChart').getContext('2d');
            const chartLabels = {!! json_encode($chartLabels) !!};  // Label tanggal (30 hari terakhir)
            const chartData = {!! json_encode($chartData) !!};  // Data total distance per tanggal

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Total Distance per Day (Km) - Last 30 Days',
                        data: chartData,
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Distance (Km)'
                            }
                        }
                    }
                }
            });
        });


        // JSON processing
        document.querySelector('button').addEventListener('click', () => {
            const jsonInput = document.querySelector('#jsonInput').value;
            try {
                const parsedJson = JSON.parse(jsonInput);
                console.log('Parsed JSON:', parsedJson);
                // Handle the JSON data here
                alert('JSON processed successfully!');
            } catch (error) {
                alert('Invalid JSON format');
            }
        });
    </script>
</x-app-layout>