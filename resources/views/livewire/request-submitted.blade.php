<div class="w-full max-w-4xl mx-auto py-10 px-4 sm:px-6">
    <div class="bg-white shadow-md rounded-2xl p-6 sm:p-10 border border-emerald-100">
        
        <!-- Header / Success Icon -->
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-100 text-[#135860] rounded-full mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <h1 class="text-2xl sm:text-3xl font-heading font-bold text-slate-900 mb-2">
                Application Submitted Successfully!
            </h1>
            
            <p class="text-slate-600 text-base sm:text-lg max-w-xl mx-auto mb-6">
                Thank you for submitting your application. We have received your request and our team will review it shortly.
            </p>

            <!-- Status Notice -->
            <div class="p-4 bg-emerald-50/60 border-l-4 border-[#135860] rounded-r-2xl text-left max-w-2xl mx-auto mb-8">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-[#135860]" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-heading font-bold text-[#135860]">
                            What happens next?
                        </p>
                        <p class="mt-1 text-sm text-slate-700">
                            We will send an email to <span class="font-semibold text-slate-900">{{ $group->email }}</span> with our final decision or if we require further details or an interview.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <hr class="border-slate-100 mb-8" />

        <!-- Application Summary -->
        <div class="space-y-8 text-left">
            <h2 class="text-xl font-heading font-bold text-slate-900 border-b border-slate-100 pb-3">
                Application Summary
            </h2>

            <!-- Primary Contact & Group Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/70 p-6 rounded-2xl border border-slate-200/60">
                <div>
                    <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Group / Application Name</span>
                    <p class="text-base font-semibold text-slate-800 mt-1">{{ $group->name }}</p>
                </div>

                @if($group->organization_name)
                    <div>
                        <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Organization</span>
                        <p class="text-base font-semibold text-slate-800 mt-1">{{ $group->organization_name }}</p>
                    </div>
                @endif

                <div>
                    <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Primary Contact</span>
                    <p class="text-base font-semibold text-slate-800 mt-1">{{ $group->primary_contact_name }}</p>
                </div>

                <div>
                    <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Overall Status</span>
                    <p class="mt-1">
                        @php
                            $mainEvent = $group->events?->first();
                            $status = $mainEvent?->status;
                            
                            $statusValue = $status instanceof \BackedEnum ? $status->value : (is_string($status) ? $status : null);
                            
                            $badgeClass = match($statusValue) {
                                'approved', 'confirmed', 'completed' => 'bg-emerald-100 text-[#135860]',
                                'under_review', 'interview_required' => 'bg-amber-100 text-amber-800',
                                'rejected', 'cancelled' => 'bg-rose-100 text-rose-800',
                                default => 'bg-sky-100 text-sky-800',
                            };

                            $statusLabel = 'Pending';
                            if ($status instanceof \BackedEnum) {
                                $statusLabel = method_exists($status, 'getLabel') ? $status->getLabel() : $status->value;
                            } elseif (is_string($status)) {
                                $statusLabel = ucfirst($status);
                            }
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                            {{ $statusLabel }}
                        </span>
                    </p>
                </div>

                <div>
                    <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Email Address</span>
                    <p class="text-base font-semibold text-slate-800 mt-1">{{ $group->email }}</p>
                </div>

                <div>
                    <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Phone Number</span>
                    <p class="text-base font-semibold text-slate-800 mt-1">{{ $group->phone }}</p>
                </div>

                @if($group->address)
                    <div class="md:col-span-2">
                        <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Address</span>
                        <p class="text-base font-semibold text-slate-800 mt-1">{{ $group->address }}</p>
                    </div>
                @endif
            </div>

            <!-- Group Members -->
            @if($group->members && $group->members->isNotEmpty())
                <div>
                    <h3 class="text-md font-heading font-bold text-slate-800 mb-3">
                        Group Members ({{ $group->members->count() }})
                    </h3>
                    <div class="bg-white border border-slate-200/80 rounded-2xl overflow-hidden shadow-sm">
                        <ul class="divide-y divide-slate-100">
                            @foreach($group->members as $member)
                                <li class="p-4 flex justify-between items-center text-sm">
                                    <span class="font-medium text-slate-800">{{ $member->name ?? trim(($member->first_name ?? '') . ' ' . ($member->last_name ?? '')) }}</span>
                                    <span class="text-slate-500">{{ $member->email ?? $member->role ?? '' }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Group Events & Activities -->
            @if($group->events && $group->events->isNotEmpty())
                <div>
                    <h3 class="text-md font-heading font-bold text-slate-800 mb-3">
                        Requested Events & Activities ({{ $group->events->count() }})
                    </h3>
                    <div class="space-y-4">
                        @foreach($group->events as $event)
                            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm space-y-4">
                                <!-- Event Meta Data -->
                                <div class="flex flex-wrap justify-between items-start gap-4 pb-3 border-b border-slate-100">
                                    <div>
                                        <span class="text-xs font-bold uppercase text-slate-400 tracking-wider">Dates</span>
                                        <p class="text-sm font-semibold text-slate-800 mt-0.5">
                                            {{ $event->start_date?->format('M d, Y') ?? 'N/A' }} 
                                            @if($event->end_date && $event->end_date != $event->start_date)
                                                – {{ $event->end_date->format('M d, Y') }}
                                            @endif
                                        </p>
                                    </div>

                                    @if($event->expected_attendees)
                                        <div>
                                            <span class="text-xs font-bold uppercase text-slate-400 tracking-wider">Expected Attendees</span>
                                            <p class="text-sm font-semibold text-slate-800 mt-0.5">
                                                {{ $event->expected_attendees }} {{ Str::plural('guest', $event->expected_attendees) }}
                                            </p>
                                        </div>
                                    @endif

                                    @if($event->status)
                                        <div>
                                            <span class="text-xs font-bold uppercase text-slate-400 tracking-wider">Event Status</span>
                                            <p class="mt-0.5">
                                                @php
                                                    $eventStatus = $event->status;
                                                    $eventStatusValue = $eventStatus instanceof \BackedEnum ? $eventStatus->value : (is_string($eventStatus) ? $eventStatus : null);
                                                    
                                                    $eventBadgeClass = match($eventStatusValue) {
                                                        'approved', 'confirmed', 'completed' => 'bg-emerald-100 text-[#135860]',
                                                        'under_review', 'interview_required' => 'bg-amber-100 text-amber-800',
                                                        'rejected', 'cancelled' => 'bg-rose-100 text-rose-800',
                                                        default => 'bg-slate-100 text-slate-700',
                                                    };

                                                    $eventStatusLabel = 'Unknown';
                                                    if ($eventStatus instanceof \BackedEnum) {
                                                        $eventStatusLabel = method_exists($eventStatus, 'getLabel') ? $eventStatus->getLabel() : $eventStatus->value;
                                                    } elseif (is_string($eventStatus)) {
                                                        $eventStatusLabel = ucfirst($eventStatus);
                                                    }
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $eventBadgeClass }}">
                                                    {{ $eventStatusLabel }}
                                                </span>
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Operational Notes / Rejected Reason -->
                                @if($event->rejected_reason)
                                    <div class="text-xs bg-rose-50 p-3 rounded-xl border border-rose-100 text-rose-700">
                                        <span class="font-bold">Rejection Reason:</span> {{ $event->rejected_reason }}
                                    </div>
                                @endif

                                @if($event->operational_notes)
                                    <div class="text-xs bg-slate-50 p-3 rounded-xl border border-slate-100 text-slate-600">
                                        <span class="font-bold text-slate-700">Notes:</span> {{ $event->operational_notes }}
                                    </div>
                                @endif

                                <!-- Event Service Requests / Activities -->
                                @if($event->serviceRequests && $event->serviceRequests->isNotEmpty())
                                    <div>
                                        <h4 class="text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">
                                            Requested Services / Activities
                                        </h4>
                                        <div class="bg-slate-50/80 rounded-xl p-3 border border-slate-100">
                                            <ul class="divide-y divide-slate-200/60">
                                                @foreach($event->serviceRequests as $service)
                                                    <li class="py-2.5 first:pt-0 last:pb-0 flex flex-col sm:flex-row sm:justify-between sm:items-center text-sm gap-1">
                                                        <div class="flex items-center gap-2">
                                                            <span class="w-2 h-2 rounded-full bg-[#135860] flex-shrink-0"></span>
                                                            <span class="font-semibold text-slate-800">
                                                                {{ $service->service_name }}
                                                            </span>
                                                            @if($service->service_category)
                                                                <span class="text-xs text-slate-500 bg-white px-2 py-0.5 rounded border border-slate-200">
                                                                    @php
                                                                        $cat = $service->service_category;
                                                                    @endphp
                                                                    {{ is_object($cat) && method_exists($cat, 'getLabel') ? $cat->getLabel() : (is_object($cat) ? ($cat->value ?? '') : ucfirst((string)$cat)) }}
                                                                </span>
                                                            @endif
                                                        </div>

                                                        <div class="flex items-center gap-3 text-xs text-slate-500 pl-4 sm:pl-0">
                                                            @if($service->quantity)
                                                                <span class="font-medium bg-slate-200/60 px-2 py-0.5 rounded text-slate-700">
                                                                    Qty: {{ $service->quantity }}
                                                                </span>
                                                            @endif
                                                            @if($service->notes)
                                                                <span class="italic text-slate-600">
                                                                    "{{ $service->notes }}"
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Reference Token & Actions -->
        <div class="pt-8 mt-8 border-t border-slate-100 text-center space-y-5">
            <p class="text-xs text-slate-400">
                Application Reference Token: <span class="font-mono font-bold text-slate-600">{{ $group->token }}</span>
            </p>
        </div>

    </div>
</div>