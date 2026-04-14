@extends('layouts.admin')

@section('title', 'Monthly Revenue')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <a href="{{ route('admin.subscriptions.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700">← Dashboard</a>
            <h1 class="text-3xl font-bold text-gray-900 mt-1">Monthly Revenue</h1>
            <p class="text-gray-600">Last 12 months</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-2xl font-bold text-gray-900">₨ {{ number_format($months->sum('revenue'), 0) }}</p>
            <p class="text-xs text-gray-500 mt-1">12-Month Total</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-2xl font-bold text-gray-900">₨ {{ number_format($months->avg('revenue'), 0) }}</p>
            <p class="text-xs text-gray-500 mt-1">Monthly Average</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-2xl font-bold text-green-600">₨ {{ number_format($months->last()['revenue'] ?? 0, 0) }}</p>
            <p class="text-xs text-gray-500 mt-1">This Month</p>
        </div>
    </div>

    <!-- Bar Chart (CSS) -->
    @php $maxRev = $months->max('revenue') ?: 1; @endphp
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-6">Revenue Trend</h2>
        <div class="flex items-end gap-3 h-48">
            @foreach($months as $m)
            @php $pct = ($m['revenue'] / $maxRev) * 100; @endphp
            <div class="flex-1 flex flex-col items-center gap-1">
                <span class="text-xs text-gray-500">₨{{ number_format($m['revenue']/1000, 0) }}k</span>
                <div class="w-full bg-blue-500 rounded-t hover:bg-blue-600 transition-colors"
                     style="height: {{ max($pct, 2) }}%" title="₨ {{ number_format($m['revenue'], 0) }}"></div>
                <span class="text-[10px] text-gray-400 rotate-0">{{ substr($m['month'], 0, 3) }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Month</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Revenue (NPR)</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($months->reverse() as $m)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-sm text-gray-900">{{ $m['month'] }}</td>
                    <td class="px-6 py-3 text-sm font-semibold text-gray-900 text-right">₨ {{ number_format($m['revenue'], 0) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
