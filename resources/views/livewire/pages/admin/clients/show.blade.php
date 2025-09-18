<div>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold text-gray-900">{{ $client->client_name }}</h1>
            <p class="mt-2 text-sm text-gray-700">{{ $client->company_name }}</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none space-x-3">
            @can('update client')
                <a href="{{ route('admin.clients.edit', $client) }}" 
                   class="block rounded-md bg-blue-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    Edit Client
                </a>
            @endcan
            <a href="{{ route('admin.clients.index') }}" 
               class="block rounded-md bg-gray-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                Back to Clients
            </a>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Client Information -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Client Information</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Basic details about the client.</p>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Client Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $client->client_name }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Company Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $client->company_name }}</dd>
                        </div>
                        @if($client->email)
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <a href="mailto:{{ $client->email }}" class="text-blue-600 hover:text-blue-900">
                                    {{ $client->email }}
                                </a>
                            </dd>
                        </div>
                        @endif
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Mobile</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <a href="tel:{{ $client->mobile }}" class="text-blue-600 hover:text-blue-900">
                                    {{ $client->formatted_mobile }}
                                </a>
                            </dd>
                        </div>
                        @if($client->description)
                        <div class="bg-gray-50 px-4 py-5 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <div class="prose max-w-none">
                                    {{ $client->description }}
                                </div>
                            </dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>
        </div>

        <!-- Client Stats -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Statistics</h3>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-2 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Total Projects</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0">{{ $client->getProjectCount() }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-2 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Active Projects</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0">{{ $client->getActiveProjectCount() }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-2 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Created</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0">{{ $client->created_at->format('M d, Y') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Projects Section -->
    @if($client->projects->count() > 0)
    <div class="mt-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Associated Projects</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Projects assigned to this client.</p>
            </div>
            <div class="border-t border-gray-200">
                <ul class="divide-y divide-gray-200">
                    @foreach($client->projects as $project)
                    <li class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($project->status->value === 'completed') bg-green-100 text-green-800
                                        @elseif($project->status->value === 'in_progress') bg-blue-100 text-blue-800
                                        @elseif($project->status->value === 'on_hold') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $project->status->value)) }}
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        <a href="{{ route('admin.projects.show', $project) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $project->title }}
                                        </a>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Lead: {{ $project->projectLead->name }}
                                    </div>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $project->estimated_days }} days
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
</div>
