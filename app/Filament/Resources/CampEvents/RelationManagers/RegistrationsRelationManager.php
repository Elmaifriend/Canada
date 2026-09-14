<?php

namespace App\Filament\Resources\CampEvents\RelationManagers;

use App\Enums\RegistrationStatus;
use App\Filament\Resources\CamperRegistrations\CamperRegistrationResource;
use App\Models\CamperRegistration;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RegistrationsRelationManager extends RelationManager
{
    protected static string $relationship = 'registrations';

    protected static ?string $title = 'Camper Registrations';

    protected static \BackedEnum|string|null $icon = Heroicon::OutlinedUserGroup;

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle(fn (CamperRegistration $record) => $record->camper ? "{$record->camper->first_name} {$record->camper->last_name}" : "Registration #{$record->id}")
            ->heading('Registered Campers')
            ->columns([
                TextColumn::make('camper.first_name')
                    ->label('Camper Full Name')
                    ->formatStateUsing(fn (CamperRegistration $record) => $record->camper ? $record->camper->first_name.' '.$record->camper->last_name : 'N/A')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('status')
                    ->label('Registration Status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Registration Date')
                    ->dateTime('M j, Y g:i A')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter by Status')
                    ->options(RegistrationStatus::class)
                    ->native(false),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()->url(fn (CamperRegistration $record): string => CamperRegistrationResource::getUrl('edit', ['record' => $record])),
                    EditAction::make()->url(fn (CamperRegistration $record): string => CamperRegistrationResource::getUrl('edit', ['record' => $record])),
                    DeleteAction::make(),
                ]),
            ]);
    }
}
