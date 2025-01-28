 <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8  gap-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-semibold mb-4">Users by Status</h3>
                <canvas id="usersByStatusChart"></canvas>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-semibold mb-4">Users by Country</h3>
                <canvas id="usersByCountryChart"></canvas>
            </div>

        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
<script>
 const usersByCountryData = {!! json_encode($usersByCountry) !!};
 const usersByCountryLabels = usersByCountryData.map(item => item.country);
 const usersByCountryCounts = usersByCountryData.map(item => item.total);

 const ctx = document.getElementById('usersByCountryChart');
 new Chart(ctx, {
    type: 'pie',
    data: {
        labels: usersByCountryLabels,
        datasets: [{
            label: '# of Users',
            data: usersByCountryCounts,
            borderWidth: 1
         }]
     },
     // ... chart options ...
 });

// Users by Status Chart (Pie Chart)
const usersByStatusData = {!! json_encode($usersByStatus) !!};
const usersByStatusLabels = usersByStatusData.map(item => item.status);
const usersByStatusCounts = usersByStatusData.map(item => item.total);

const ctx2 = document.getElementById('usersByStatusChart');
new Chart(ctx2, {
    type: 'bar', // pie chart
    data: {
        labels: usersByStatusLabels,
        datasets: [{
            label: '# of Users',
            data: usersByStatusCounts,
            borderWidth: 1
        }]
    },
    // ... pie chart options ...
});
</script>
</x-app-layout>

