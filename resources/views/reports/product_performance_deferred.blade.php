<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Product Performance Report
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('reports.product_performance.def') }}" method="POST">
                @csrf
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                    <div class="p6">
                        Please select the criteria you want to be applied to the report and submit.
                    </div>
                    <div class="flex justify-between p-5 px-0">
                        <div class="w-1/3">
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        </div>
                        <div class="w-1/3 ml-3">
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        </div>
                        <div class="w-1/3">
                            <button type="submit" class="mt-7 ml-3 rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
                        </div>
                    </div>

                    <div class="overflow-hidden shadow sm:rounded-lg p-6">
                        <h3 class="font-semibold text-lg text-gray-800 leading-tight mb-4">Download Reports</h3>
                        <ul>
                            @foreach($reports as $report)
                                <li><a href="/storage/reports/{{ $report->filename }}" class="text-blue-500">{{ $report->filename }}</a></li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
