<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Submitted</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased;">

    <!-- Wrapper Table -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; padding: 30px 10px;">
        <tr>
            <td align="center">
                <!-- Container Card -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 16px; border: 1px solid #d1fae5; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); overflow: hidden;">
                    
                    <!-- Content Padding -->
                    <tr>
                        <td style="padding: 32px 24px;">

                            <!-- Header / Success Icon -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align: center;">
                                <tr>
                                    <td align="center" style="padding-bottom: 16px;">
                                        <!-- Checkmark Badge -->
                                        <div style="display: inline-block; width: 64px; height: 64px; background-color: #d1fae5; color: #135860; border-radius: 50%; text-align: center; line-height: 64px; font-size: 28px; font-weight: bold;">
                                            &#10003;
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 8px;">
                                        <h1 style="margin: 0; font-size: 24px; font-weight: 700; color: #0f172a;">
                                            Application Submitted Successfully!
                                        </h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 24px;">
                                        <p style="margin: 0; font-size: 15px; color: #475569; line-height: 1.5;">
                                            Thank you for submitting your application. We have received your request and our team will review it shortly.
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 24px;">
                                        <!-- Status Notice Callout -->
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ecfdf5; border-left: 4px solid #135860; border-radius: 0 12px 12px 0; text-align: left;">
                                            <tr>
                                                <td style="padding: 16px;">
                                                    <p style="margin: 0 0 4px 0; font-size: 14px; font-weight: 700; color: #135860;">
                                                        What happens next?
                                                    </p>
                                                    <p style="margin: 0; font-size: 13px; color: #334155; line-height: 1.4;">
                                                        We will send updates to <span style="font-weight: 600; color: #0f172a;">{{ $group->email ?? '' }}</span> regarding our final decision or if we require further details or an interview.
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Divider -->
                            <hr style="border: none; border-top: 1px solid #f1f5f9; margin: 0 0 24px 0;" />

                            <!-- Application Summary Header -->
                            <h2 style="margin: 0 0 16px 0; font-size: 18px; font-weight: 700; color: #0f172a; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">
                                Application Summary
                            </h2>

                            <!-- Primary Contact & Group Details Grid -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 16px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td width="50%" style="padding-bottom: 12px; vertical-align: top;">
                                                    <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #94a3b8; letter-spacing: 0.5px;">Group / Application Name</span>
                                                    <p style="margin: 4px 0 0 0; font-size: 14px; font-weight: 600; color: #1e293b;">{{ $group->name ?? '' }}</p>
                                                </td>
                                                <td width="50%" style="padding-bottom: 12px; vertical-align: top;">
                                                    @if(!empty($group->organization_name))
                                                        <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #94a3b8; letter-spacing: 0.5px;">Organization</span>
                                                        <p style="margin: 4px 0 0 0; font-size: 14px; font-weight: 600; color: #1e293b;">{{ $group->organization_name }}</p>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="50%" style="padding-bottom: 12px; vertical-align: top;">
                                                    <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #94a3b8; letter-spacing: 0.5px;">Primary Contact</span>
                                                    <p style="margin: 4px 0 0 0; font-size: 14px; font-weight: 600; color: #1e293b;">{{ $group->primary_contact_name ?? '' }}</p>
                                                </td>
                                                <td width="50%" style="padding-bottom: 12px; vertical-align: top;">
                                                    <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #94a3b8; letter-spacing: 0.5px;">Status</span>
                                                    <p style="margin: 4px 0 0 0;">
                                                        @php
                                                            $statusValue = is_object($group->status) ? ($group->status->value ?? null) : $group->status;
                                                            $badgeStyle = match($statusValue) {
                                                                'approved', 'confirmed', 'completed' => 'background-color: #d1fae5; color: #135860;',
                                                                'under_review', 'interview_required' => 'background-color: #fef3c7; color: #92400e;',
                                                                'rejected', 'cancelled' => 'background-color: #ffe4e6; color: #9f1239;',
                                                                default => 'background-color: #e0f2fe; color: #075985;',
                                                            };
                                                            
                                                            $statusLabel = 'Pending';
                                                            if (is_object($group->status)) {
                                                                $statusLabel = method_exists($group->status, 'getLabel') ? $group->status->getLabel() : ($group->status->value ?? 'Pending');
                                                            } elseif (!empty($group->status)) {
                                                                $statusLabel = $group->status;
                                                            }
                                                        @endphp
                                                        <span style="display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 12px; font-weight: 600; {{ $badgeStyle }}">
                                                            {{ $statusLabel }}
                                                        </span>
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="50%" style="padding-bottom: 12px; vertical-align: top;">
                                                    <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #94a3b8; letter-spacing: 0.5px;">Email Address</span>
                                                    <p style="margin: 4px 0 0 0; font-size: 14px; font-weight: 600; color: #1e293b;">{{ $group->email ?? '' }}</p>
                                                </td>
                                                <td width="50%" style="padding-bottom: 12px; vertical-align: top;">
                                                    <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #94a3b8; letter-spacing: 0.5px;">Phone Number</span>
                                                    <p style="margin: 4px 0 0 0; font-size: 14px; font-weight: 600; color: #1e293b;">{{ $group->phone ?? '' }}</p>
                                                </td>
                                            </tr>
                                            @if(!empty($group->address))
                                                <tr>
                                                    <td colspan="2" style="vertical-align: top;">
                                                        <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #94a3b8; letter-spacing: 0.5px;">Address</span>
                                                        <p style="margin: 4px 0 0 0; font-size: 14px; font-weight: 600; color: #1e293b;">{{ $group->address }}</p>
                                                    </td>
                                                </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Group Members -->
                            @if(isset($group->members) && $group->members->isNotEmpty())
                                <div style="margin-bottom: 24px;">
                                    <h3 style="margin: 0 0 12px 0; font-size: 15px; font-weight: 700; color: #1e293b;">
                                        Group Members ({{ $group->members->count() }})
                                    </h3>
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; border-collapse: separate; overflow: hidden;">
                                        @foreach($group->members as $member)
                                            <tr>
                                                <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #1e293b; border-bottom: 1px solid #f1f5f9;">
                                                    {{ $member->name ?? trim(($member->first_name ?? '') . ' ' . ($member->last_name ?? '')) }}
                                                </td>
                                                <td align="right" style="padding: 12px 16px; font-size: 13px; color: #64748b; border-bottom: 1px solid #f1f5f9;">
                                                    {{ $member->email ?? ($member->role ?? '') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            @endif

                            <!-- Group Events & Activities -->
                            @if(isset($group->events) && $group->events->isNotEmpty())
                                <div style="margin-bottom: 24px;">
                                    <h3 style="margin: 0 0 12px 0; font-size: 15px; font-weight: 700; color: #1e293b;">
                                        Requested Events & Activities ({{ $group->events->count() }})
                                    </h3>
                                    
                                    @foreach($group->events as $event)
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 16px; padding: 16px;">
                                            <tr>
                                                <td>
                                                    <!-- Meta Data -->
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-bottom: 1px solid #f1f5f9; padding-bottom: 12px; margin-bottom: 12px;">
                                                        <tr>
                                                            <td style="vertical-align: top; padding-bottom: 8px;">
                                                                <span style="font-size: 10px; font-weight: 700; text-transform: uppercase; color: #94a3b8; letter-spacing: 0.5px;">Dates</span>
                                                                <p style="margin: 2px 0 0 0; font-size: 13px; font-weight: 600; color: #1e293b;">
                                                                    {{ optional($event->start_date)->format('M d, Y') ?? 'N/A' }}
                                                                    @if(!empty($event->end_date) && $event->end_date != $event->start_date)
                                                                        – {{ optional($event->end_date)->format('M d, Y') }}
                                                                    @endif
                                                                </p>
                                                            </td>
                                                            @if(!empty($event->expected_attendees))
                                                                <td style="vertical-align: top; padding-bottom: 8px;">
                                                                    <span style="font-size: 10px; font-weight: 700; text-transform: uppercase; color: #94a3b8; letter-spacing: 0.5px;">Expected Attendees</span>
                                                                    <p style="margin: 2px 0 0 0; font-size: 13px; font-weight: 600; color: #1e293b;">
                                                                        {{ $event->expected_attendees }} {{ Str::plural('guest', $event->expected_attendees) }}
                                                                    </p>
                                                                </td>
                                                            @endif
                                                            @if(!empty($event->status))
                                                                <td style="vertical-align: top; padding-bottom: 8px;" align="right">
                                                                    <span style="font-size: 10px; font-weight: 700; text-transform: uppercase; color: #94a3b8; letter-spacing: 0.5px;">Event Status</span>
                                                                    <p style="margin: 2px 0 0 0;">
                                                                        @php
                                                                            $eventStatusLabel = is_object($event->status) 
                                                                                ? (method_exists($event->status, 'getLabel') ? $event->status->getLabel() : ($event->status->value ?? '')) 
                                                                                : $event->status;
                                                                        @endphp
                                                                        <span style="display: inline-block; padding: 2px 8px; background-color: #f1f5f9; color: #334155; border-radius: 10px; font-size: 11px; font-weight: 600;">
                                                                            {{ $eventStatusLabel }}
                                                                        </span>
                                                                    </p>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    </table>

                                                    <!-- Notes -->
                                                    @if(!empty($event->operational_notes))
                                                        <div style="background-color: #f8fafc; border: 1px solid #f1f5f9; border-radius: 8px; padding: 10px; font-size: 12px; color: #475569; margin-bottom: 12px;">
                                                            <strong style="color: #334155;">Notes:</strong> {{ $event->operational_notes }}
                                                        </div>
                                                    @endif

                                                    <!-- Services Requests / Activities -->
                                                    @if(isset($event->serviceRequests) && $event->serviceRequests->isNotEmpty())
                                                        <div style="margin-top: 8px;">
                                                            <span style="font-size: 10px; font-weight: 700; text-transform: uppercase; color: #94a3b8; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">
                                                                Requested Services / Activities
                                                            </span>
                                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; border: 1px solid #f1f5f9; border-radius: 8px;">
                                                                @foreach($event->serviceRequests as $service)
                                                                    <tr>
                                                                        <td style="padding: 8px 12px; border-bottom: 1px solid #edf2f7; font-size: 13px;">
                                                                            <strong style="color: #1e293b;">• {{ $service->service_name ?? '' }}</strong>
                                                                            @if(!empty($service->service_category))
                                                                                @php
                                                                                    $catLabel = is_object($service->service_category)
                                                                                        ? (method_exists($service->service_category, 'getLabel') ? $service->service_category->getLabel() : ($service->service_category->value ?? ''))
                                                                                        : $service->service_category;
                                                                                @endphp
                                                                                <span style="font-size: 11px; background-color: #ffffff; color: #64748b; border: 1px solid #e2e8f0; padding: 1px 6px; border-radius: 4px; margin-left: 6px;">
                                                                                    {{ $catLabel }}
                                                                                </span>
                                                                            @endif
                                                                        </td>
                                                                        <td align="right" style="padding: 8px 12px; border-bottom: 1px solid #edf2f7; font-size: 12px; color: #64748b;">
                                                                            @if(!empty($service->quantity))
                                                                                <span style="background-color: #e2e8f0; color: #334155; padding: 2px 6px; border-radius: 4px; font-weight: 600;">
                                                                                    Qty: {{ $service->quantity }}
                                                                                </span>
                                                                            @endif
                                                                            @if(!empty($service->notes))
                                                                                <span style="font-style: italic; margin-left: 6px; color: #475569;">
                                                                                    "{{ $service->notes }}"
                                                                                </span>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </table>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Reference Token & Footer -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-top: 1px solid #f1f5f9; padding-top: 20px; text-align: center;">
                                <tr>
                                    <td>
                                        <p style="margin: 0 0 12px 0; font-size: 12px; color: #94a3b8;">
                                            Application Reference Token: <strong style="font-family: monospace; color: #475569;">{{ $group->token ?? 'N/A' }}</strong>
                                        </p>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>