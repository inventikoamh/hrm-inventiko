<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-center">
            <div class="p-2.5 bg-emerald-100 rounded-lg">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-base font-semibold text-gray-900">Clients</h3>
                <p class="text-xs text-gray-500">Client management</p>
            </div>
        </div>
        <div class="text-right">
            <div class="text-xl font-bold text-gray-900">{{ $totalClients }}</div>
            <div class="text-xs text-gray-500">Total Clients</div>
        </div>
    </div>
    
    <div class="grid grid-cols-2 gap-3">
        <div class="bg-emerald-50 rounded-lg p-2.5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold text-emerald-900">{{ $clientsWithProjects }}</div>
                    <div class="text-xs text-emerald-700">With Projects</div>
                </div>
                <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="bg-blue-50 rounded-lg p-2.5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold text-blue-900">{{ $clientsThisMonth }}</div>
                    <div class="text-xs text-blue-700">New</div>
                </div>
                <div class="w-1.5 h-1.5 bg-blue-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="bg-purple-50 rounded-lg p-2.5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold text-purple-900">{{ $totalLeads }}</div>
                    <div class="text-xs text-purple-700">Total Leads</div>
                </div>
                <div class="w-1.5 h-1.5 bg-purple-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="bg-orange-50 rounded-lg p-2.5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold text-orange-900">{{ $leadsToday }}</div>
                    <div class="text-xs text-orange-700">Leads Today</div>
                </div>
                <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
            </div>
        </div>
    </div>
</div>
