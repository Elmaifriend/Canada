<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Application Rejected</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased;">

    <!-- Outer Wrapper Table -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; table-layout: fixed;">
        <tr>
            <td align="center" style="padding: 30px 10px;">
                
                <!-- Main Container Card -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 16px; border: 1px solid #fee2e2; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); overflow: hidden;">
                    <tr>
                        <td style="padding: 32px 24px;">

                            <!-- Header / Error Icon -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" style="padding-bottom: 16px;">
                                        <!-- X Badge -->
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="center" valign="middle" style="width: 64px; height: 64px; background-color: #fee2e2; color: #991b1b; border-radius: 50%; font-size: 28px; font-weight: bold; line-height: 64px;">
                                                    &#10007;
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding-bottom: 8px;">
                                        <h1 style="margin: 0; font-size: 24px; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: -0.5px;">
                                            APPLICATION REJECTED
                                        </h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding-bottom: 24px;">
                                        <p style="margin: 0; font-size: 15px; color: #475569; line-height: 1.5;">
                                            We regret to inform you that your group application has been reviewed and <strong>unfortunately rejected</strong>.
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 24px;">
                                        <!-- Status Notice Callout -->
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #fef2f2; border-left: 4px solid #991b1b; border-radius: 0 12px 12px 0;">
                                            <tr>
                                                <td style="padding: 16px;">
                                                    <p style="margin: 0 0 4px 0; font-size: 14px; font-weight: 700; color: #991b1b;">
                                                        What's next?
                                                    </p>
                                                    <p style="margin: 0; font-size: 13px; color: #334155; line-height: 1.4;">
                                                        We are unable to proceed with your request at this time. If you have any questions or need further clarification regarding this decision, please reach out to us. Your registered contact email is <span style="font-weight: 600; color: #0f172a;">{{ $group->email }}</span>.
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
                                                <td width="50%" valign="top" style="padding-bottom: 12px;">
                                                    <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #94a3b8; letter-spacing: 0.5px;">Group Name</span>
                                                    <p style="margin: 4px 0 0 0; font-size: 14px; font-weight: 600; color: #1e293b;">{{ $group->name }}</p>
                                                </td>
                                                <td width="50%" valign="top" style="padding-bottom: 12px;">
                                                    @if($group->organization_name)
                                                        <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #94a3b8; letter-spacing: 0.5px;">Organization</span>
                                                        <p style="margin: 4px 0 0 0; font-size: 14px; font-weight: 600; color: #1e293b;">{{ $group->organization_name }}</p>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="50%" valign="top" style="padding-bottom: 12px;">
                                                    <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #94a3b8; letter-spacing: 0.5px;">Primary Contact</span>
                                                    <p style="margin: 4px 0 0 0; font-size: 14px; font-weight: 600; color: #1e293b;">{{ $group->primary_contact_name }}</p>
                                                </td>
                                                <td width="50%" valign="top" style="padding-bottom: 12px;">
                                                    <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #94a3b8; letter-spacing: 0.5px;">Status</span>
                                                    <p style="margin: 4px 0 0 0;">
                                                        <span style="display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 12px; font-weight: 600; background-color: #fee2e2; color: #991b1b;">
                                                            Rejected
                                                        </span>
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="50%" valign="top" style="padding-bottom: 12px;">
                                                    <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #94a3b8; letter-spacing: 0.5px;">Email Address</span>
                                                    <p style="margin: 4px 0 0 0; font-size: 14px; font-weight: 600; color: #1e293b;">{{ $group->email }}</p>
                                                </td>
                                                <td width="50%" valign="top" style="padding-bottom: 12px;">
                                                    <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #94a3b8; letter-spacing: 0.5px;">Phone Number</span>
                                                    <p style="margin: 4px 0 0 0; font-size: 14px; font-weight: 600; color: #1e293b;">{{ $group->phone }}</p>
                                                </td>
                                            </tr>
                                            @if($group->address)
                                                <tr>
                                                    <td colspan="2" valign="top">
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
                            @if($group->members && $group->members->isNotEmpty())
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 24px;">
                                    <tr>
                                        <td style="padding-bottom: 12px;">
                                            <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #1e293b;">
                                                Group Members ({{ $group->members->count() }})
                                            </h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px;">
                                                @foreach($group->members as $member)
                                                    <tr>
                                                        <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #1e293b; border-bottom: 1px solid #f1f5f9;">
                                                            {{ $member->name ?? trim(($member->first_name ?? '') . ' ' . ($member->last_name ?? '')) }}
                                                        </td>
                                                        <td align="right" style="padding: 12px 16px; font-size: 13px; color: #64748b; border-bottom: 1px solid #f1f5f9;">
                                                            {{ $member->email ?? $member->role ?? '' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            @endif

                            <!-- Group Events & Activities -->
                            @if($group->events && $group->events->isNotEmpty())
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 24px;">
                                    <tr>
                                        <td style="padding-bottom: 12px;">
                                            <h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #1e293b;">
                                                Requested Events & Activities ({{ $group->events->count() }})
                                            </h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @foreach($group->events as $event)
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 16px;">
                                                    <tr>
                                                        <td style="padding: 16px;">
                                                            <!-- Meta Data Table -->
                                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-bottom: 1px solid #f1f5f9; padding-bottom: 12px; margin-bottom: 12px;">
                                                                <tr>
                                                                    <td valign="top" style="padding-bottom: 8px;">
                                                                        <span style="font-size: 10px; font-weight: 700; text-transform: uppercase; color: #94a3b8; letter-spacing: 0.5px;">Dates</span>
                                                                        <p style="margin: 2px 0 0 0; font-size: 13px; font-weight: 600; color: #1e293b;">
                                                                            {{ is_string($event->start_date) ? $event->start_date : ($event->start_date?->format('M d, Y') ?? 'N/A') }}
                                                                            @if($event->end_date && $event->end_date != $event->start_date)
                                                                                – {{ is_string($event->end_date) ? $event->end_date : $event->end_date->format('M d, Y') }}
                                                                            @endif
                                                                        </p>
                                                                    </td>
                                                                    @if($event->expected_attendees)
                                                                        <td valign="top" style="padding-bottom: 8px;">
                                                                            <span style="font-size: 10px; font-weight: 700; text-transform: uppercase; color: #94a3b8; letter-spacing: 0.5px;">Expected Attendees</span>
                                                                            <p style="margin: 2px 0 0 0; font-size: 13px; font-weight: 600; color: #1e293b;">
                                                                                {{ $event->expected_attendees }}
                                                                            </p>
                                                                        </td>
                                                                    @endif
                                                                    @if($event->status)
                                                                        <td valign="top" align="right" style="padding-bottom: 8px;">
                                                                            <span style="font-size: 10px; font-weight: 700; text-transform: uppercase; color: #94a3b8; letter-spacing: 0.5px;">Event Status</span>
                                                                            <p style="margin: 2px 0 0 0;">
                                                                                <span style="display: inline-block; padding: 2px 8px; background-color: #fee2e2; color: #991b1b; border-radius: 10px; font-size: 11px; font-weight: 600;">
                                                                                    {{ is_object($event->status) && method_exists($event->status, 'getLabel') ? $event->status->getLabel() : ($event->status->value ?? $event->status) }}
                                                                                </span>
                                                                            </p>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            </table>

                                                            <!-- Operational Notes -->
                                                            @if($event->operational_notes)
                                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 12px;">
                                                                    <tr>
                                                                        <td style="padding-top: 4px;">
                                                                            <span style="font-size: 10px; font-weight: 700; text-transform: uppercase; color: #94a3b8; letter-spacing: 0.5px;">Operational Notes</span>
                                                                            <p style="margin: 4px 0 0 0; font-size: 13px; font-weight: 400; color: #475569; line-height: 1.5;">
                                                                                {{ $event->operational_notes }}
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            @endif

                                                            <!-- Rejected Reason (Conditional) -->
                                                            @if($event->rejected_reason)
                                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #fef2f2; border-left: 3px solid #991b1b; border-radius: 0 6px 6px 0; margin-top: 8px;">
                                                                    <tr>
                                                                        <td style="padding: 10px 12px;">
                                                                            <span style="font-size: 10px; font-weight: 700; text-transform: uppercase; color: #991b1b; letter-spacing: 0.5px;">Rejected Reason</span>
                                                                            <p style="margin: 2px 0 0 0; font-size: 13px; font-weight: 400; color: #991b1b; line-height: 1.4;">
                                                                                {{ $event->rejected_reason }}
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                </table>
                                            @endforeach
                                        </td>
                                    </tr>
                                </table>
                            @endif

                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</body>
</html>