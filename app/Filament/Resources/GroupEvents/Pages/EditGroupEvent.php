<?php

namespace App\Filament\Resources\GroupEvents\Pages;

use App\Enums\GuestGroupStatus;
use App\Filament\Resources\GroupEvents\GroupEventResource;
use App\Mail\GroupApprovedMail;
use App\Mail\GroupRejectedMail;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

class EditGroupEvent extends EditRecord
{
    protected static string $resource = GroupEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),

            Action::make('approve')
                ->label('Approve Request')
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->requiresConfirmation()
                ->modalHeading('Approve this request?')
                ->modalDescription('This will change the status to Approved and send a confirmation email to the client.')
                ->modalSubmitActionLabel('Yes, approve')
                ->visible(fn ($record) => $record->status !== GuestGroupStatus::APPROVED)
                ->action(function ($record) {
                    $record->update(['status' => GuestGroupStatus::APPROVED]);

                    if ($record->group && $record->group->email) {
                        Mail::to($record->group->email)->send(new GroupApprovedMail($record->group));
                    }

                    Notification::make()
                        ->success()
                        ->title('Approved')
                        ->body('The request has been approved and the email was sent successfully.')
                        ->send();
                }),

            Action::make('reject')
                ->label('Reject Request')
                ->color('danger')
                ->icon('heroicon-o-x-circle')
                ->visible(fn ($record) => $record->status !== GuestGroupStatus::REJECTED)
                ->form([
                    Textarea::make('rejected_reason')
                        ->label('Rejection Reason')
                        ->placeholder('Specify why this application is being rejected...')
                        ->required()
                        ->rows(3),
                ])
                ->action(function (array $data, $record) {
                    $record->update([
                        'status' => GuestGroupStatus::REJECTED,
                        'rejected_reason' => $data['rejected_reason'],
                    ]);

                    if ($record->group && $record->group->email) {
                        Mail::to($record->group->email)->send(new GroupRejectedMail($record->group, $data['rejected_reason']));
                    }

                    Notification::make()
                        ->success()
                        ->title('Rejected')
                        ->body('The request has been rejected and the email was sent successfully.')
                        ->send();
                }),
        ];
    }
}