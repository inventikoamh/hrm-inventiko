<div>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold text-gray-900">{{ $project->title }}</h1>
            <p class="mt-2 text-sm text-gray-700">Project details and information.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none space-x-3">
            @can('edit projects')
                <a href="{{ route('admin.projects.edit', $project) }}" 
                   class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    Edit Project
                </a>
            @endcan
            <a href="{{ route('admin.projects.index') }}" 
               class="inline-flex items-center rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                Back to Projects
            </a>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Project Information -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Project Information</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Basic project details and description.</p>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $project->description ?: 'No description provided.' }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $project->status_badge }}">
                                    {{ $project->status_name }}
                                </span>
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Priority</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $project->priority_badge }}">
                                    {{ $project->priority_name }}
                                </span>
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Budget</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $project->formatted_budget }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Project Team & Timeline -->
        <div class="space-y-6">
            <!-- Project Team -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Project Team</h3>
                </div>
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <div class="space-y-4">
                            <!-- Project Lead -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Project Lead</h4>
                                <div class="mt-1 flex items-center">
                                    @if($project->projectLead->profile_picture)
                                        <img src="{{ $project->projectLead->profile_picture_url }}" alt="{{ $project->projectLead->name }}" class="w-8 h-8 rounded-full object-cover">
                                    @else
                                        <img src="{{ $project->projectLead->getDefaultProfilePicture() }}" alt="{{ $project->projectLead->name }}" class="w-8 h-8 rounded-full object-cover">
                                    @endif
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $project->projectLead->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $project->projectLead->email }}</p>
                                    </div>
                                </div>
                            </div>

                            @if($project->client)
                            <!-- Client -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Client</h4>
                                <div class="mt-1 flex items-center">
                                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-medium text-white">
                                            {{ strtoupper(substr($project->client->client_name, 0, 2)) }}
                                        </span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $project->client->client_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $project->client->company_name }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Team Members -->
                            @if($teamMembers->count() > 0)
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Team Members</h4>
                                    <div class="mt-2 space-y-2">
                                        @foreach($teamMembers as $member)
                                            <div class="flex items-center">
                                                @if($member->profile_picture)
                                                    <img src="{{ $member->profile_picture_url }}" alt="{{ $member->name }}" class="w-6 h-6 rounded-full object-cover">
                                                @else
                                                    <img src="{{ $member->getDefaultProfilePicture() }}" alt="{{ $member->name }}" class="w-6 h-6 rounded-full object-cover">
                                                @endif
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-900">{{ $member->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ $member->email }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Team Members</h4>
                                    <p class="mt-1 text-sm text-gray-500">No team members assigned.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Timeline -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Project Timeline</h3>
                </div>
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Start Date</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $project->estimated_start_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Estimated Duration</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $project->estimated_days }} days</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Estimated End Date</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $project->estimated_end_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Progress</h4>
                                <div class="mt-2">
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="bg-blue-600 h-2 rounded-full" 
                                                 style="width: {{ $project->progress_percentage }}%"></div>
                                        </div>
                                        <span class="text-sm text-gray-600">{{ $project->progress_percentage }}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>