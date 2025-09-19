<div>
    <div class="space-y-6">
        <!-- Header -->
        <div class="rounded-xl shadow-sm border p-6 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-200', 'bg-slate-800 border-slate-700') }}">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Monthly Attendance Report</h1>
                    <p class="mt-1 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600', 'text-slate-400') }}">Comprehensive attendance analysis for {{ $monthName }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Month Selector -->
                    <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Month:</label>
                        <select wire:model.live="selectedMonth" 
                                class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }}">
                            @foreach($this->getMonthOptions() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Year Selector -->
                    <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Year:</label>
                        <select wire:model.live="selectedYear" 
                                class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }}">
                            @foreach($this->getYearOptions() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error Messages -->
        @if (session('error'))
            <div class="px-4 py-3 rounded-lg border transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-red-50 border-red-200 text-red-800', 'bg-red-900/20 border-red-800 text-red-300') }}">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-500', 'text-red-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Working Days Widget -->
        <div class="rounded-xl shadow-sm border p-6 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gradient-to-r from-blue-50 to-indigo-50 border-blue-200', 'bg-gradient-to-r from-blue-900/20 to-indigo-900/20 border-blue-800') }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="p-3 rounded-lg transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-100', 'bg-blue-900/50') }}">
                        <svg class="w-6 h-6 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-600', 'text-blue-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Total Working Days</h3>
                        <p class="text-3xl font-bold text-blue-600">{{ $totalWorkingDays }}</p>
                        <p class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600', 'text-slate-400') }}">
                            Monday to Saturday ({{ $monthName }})
                            @if($selectedYear == now()->year && $selectedMonth == now()->month)
                                <span class="text-orange-600 font-medium">- Up to today</span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Working Days</div>
                    <div class="text-2xl font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $totalWorkingDays }}</div>
                </div>
            </div>
        </div>


        <!-- Detailed Table -->
        <div class="rounded-xl shadow-sm border overflow-hidden transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-200', 'bg-slate-800 border-slate-700') }}">
            <div class="px-6 py-4 border-b transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-200', 'border-slate-600') }}">
                <h3 class="text-lg font-semibold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Detailed Attendance Report</h3>
                <p class="text-sm mt-1 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600', 'text-slate-400') }}">
                    Individual attendance breakdown
                    @if($selectedYear == now()->year && $selectedMonth == now()->month)
                        <span class="text-orange-600 font-medium">(Up to today)</span>
                    @endif
                </p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('divide-gray-200', 'divide-slate-700') }}">
                    <thead class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-50', 'bg-slate-700') }}">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">S.No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">User</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Present</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Late</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Left Early</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Absent</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">On Leave</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Total Days</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white divide-gray-200', 'bg-slate-800 divide-slate-700') }}">
                        @forelse($attendanceData as $index => $data)
                        <tr class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('hover:bg-gray-50', 'hover:bg-slate-700') }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full flex items-center justify-center transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-200', 'bg-slate-600') }}">
                                        <span class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">{{ substr($data['user']->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $data['user']->name }}</div>
                                        <div class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">{{ $data['user']->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-green-100 text-green-800', 'bg-green-900/30 text-green-300') }}">
                                    {{ $data['present'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-yellow-100 text-yellow-800', 'bg-yellow-900/30 text-yellow-300') }}">
                                    {{ $data['late'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-orange-100 text-orange-800', 'bg-orange-900/30 text-orange-300') }}">
                                    {{ $data['left_early'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-red-100 text-red-800', 'bg-red-900/30 text-red-300') }}">
                                    {{ $data['absent'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-100 text-blue-800', 'bg-blue-900/30 text-blue-300') }}">
                                    {{ $data['on_leave'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">
                                {{ $data['total_days'] }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">
                                No attendance data found for the selected month.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>