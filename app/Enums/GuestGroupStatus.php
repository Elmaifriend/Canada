<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum GuestGroupStatus: string implements HasLabel, HasColor
{
    case INQUIRY_RECEIVED = 'inquiry_received';     // Initial inquiry received
    case DRAFT = 'draft';                           // Draft in preparation
    case PENDING = 'pending';                       // Pending processing
    case UNDER_REVIEW = 'under_review';             // Under admin review
    case INTERVIEW_REQUIRED = 'interview_required'; // Direct contact or interview required
    case APPROVED = 'approved';                     // Application approved
    case CONFIRMED = 'confirmed';                   // Confirmed and scheduled
    case COMPLETED = 'completed';                   // Event/Stay completed
    case REJECTED = 'rejected';                     // Application rejected
    case CANCELLED = 'cancelled';                   // Process cancelled

    public function getLabel(): string
    {
        return match ($this) {
            self::INQUIRY_RECEIVED => 'Inquiry Received',
            self::DRAFT => 'Draft',
            self::PENDING => 'Pending',
            self::UNDER_REVIEW => 'Under Review',
            self::INTERVIEW_REQUIRED => 'Interview Required',
            self::APPROVED => 'Approved',
            self::CONFIRMED => 'Confirmed',
            self::COMPLETED => 'Completed',
            self::REJECTED => 'Rejected',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::INQUIRY_RECEIVED, self::PENDING => 'info',
            self::DRAFT => 'gray',
            self::UNDER_REVIEW, self::INTERVIEW_REQUIRED => 'warning',
            self::APPROVED, self::CONFIRMED, self::COMPLETED => 'success',
            self::REJECTED, self::CANCELLED => 'danger',
        };
    }
}