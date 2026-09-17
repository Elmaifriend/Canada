<?php

namespace App\Filament\Resources\CamperRegistrations\Schemas;

use App\Enums\RegistrationStatus;
use App\Filament\Forms\Components\QrCodeCard;
use App\Filament\Resources\Campers\CamperResource;
use App\Filament\Resources\CampEvents\CampEventResource;
use App\Models\Camper;
use App\Models\CamperRegistration;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\URL;

class CamperRegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('CamperRegistrationTabs')
                    ->tabs([
                        // ==========================================
                        // TAB 1: REGISTRO E INFORMACIÓN GENERAL
                        // ==========================================
                        Tab::make('General & Camper Info')
                            ->icon(Heroicon::OutlinedUser)
                            ->schema([
                                Grid::make(['default' => 1, 'lg' => 2])
                                    ->schema([
                                        Section::make('Camper & Event Selection')
                                            ->description('Assign a camper to an active camp session.')
                                            ->icon(Heroicon::OutlinedUserGroup)
                                            ->schema([
                                                Select::make('camper_id')
                                                    ->label('Registered Camper')
                                                    ->relationship('camper', 'first_name')
                                                    ->getOptionLabelFromRecordUsing(
                                                        fn (Camper $record): string => "{$record->first_name} {$record->last_name}"
                                                    )
                                                    ->searchable(['first_name', 'last_name'])
                                                    ->preload()
                                                    ->native(false)
                                                    ->required()
                                                    ->live()
                                                    ->afterStateUpdated(function (Set $set, ?string $state) {
                                                        if (! $state) {
                                                            $set('camper_gender', null);
                                                            $set('camper_dob', null);
                                                            $set('camper_health_card', null);
                                                            $set('camper_address', null);
                                                            $set('camper_custody', null);

                                                            return;
                                                        }

                                                        $camper = Camper::find($state);
                                                        if ($camper) {
                                                            $set('camper_gender', $camper->gender?->value ?? $camper->gender);
                                                            $set('camper_dob', $camper->date_of_birth?->format('Y-m-d'));
                                                            $set('camper_health_card', $camper->health_card_number);
                                                            $set('camper_address', $camper->address);
                                                            $set('camper_custody', $camper->custody_details);
                                                        }
                                                    })
                                                    ->suffixAction(
                                                        Action::make('openCamperRecord')
                                                            ->icon('heroicon-m-arrow-top-right-on-square')
                                                            ->tooltip('Open camper profile in new tab')
                                                            ->url(fn (?string $state): ?string => $state ? CamperResource::getUrl('edit', ['record' => $state]) : null, shouldOpenInNewTab: true)
                                                            ->visible(fn (?string $state): bool => ! empty($state))
                                                    )
                                                    ->columnSpanFull(),

                                                Select::make('camp_event_id')
                                                    ->label('Camp Session Event')
                                                    ->relationship('campEvent', 'name')
                                                    ->searchable()
                                                    ->preload()
                                                    ->native(false)
                                                    ->required()
                                                    ->live()
                                                    ->suffixAction(
                                                        Action::make('openCampEventRecord')
                                                            ->icon('heroicon-m-arrow-top-right-on-square')
                                                            ->tooltip('Open camp session details in new tab')
                                                            ->url(fn (?string $state): ?string => $state ? CampEventResource::getUrl('edit', ['record' => $state]) : null, shouldOpenInNewTab: true)
                                                            ->visible(fn (?string $state): bool => ! empty($state))
                                                    )
                                                    ->columnSpanFull(),

                                                // Campos de solo lectura integrados dentro del mismo contenedor
                                                Grid::make(3)
                                                    ->schema([
                                                        TextInput::make('camper_gender')
                                                            ->label('Gender')
                                                            ->disabled()
                                                            ->dehydrated(false)
                                                            ->afterStateHydrated(function (TextInput $component, ?CamperRegistration $record) {
                                                                if ($record?->camper) {
                                                                    $component->state($record->camper->gender?->value ?? $record->camper->gender);
                                                                }
                                                            }),

                                                        TextInput::make('camper_dob')
                                                            ->label('Date of Birth')
                                                            ->disabled()
                                                            ->dehydrated(false)
                                                            ->afterStateHydrated(function (TextInput $component, ?CamperRegistration $record) {
                                                                if ($record?->camper) {
                                                                    $component->state($record->camper->date_of_birth?->format('Y-m-d'));
                                                                }
                                                            }),

                                                        TextInput::make('camper_health_card')
                                                            ->label('Health Card Number')
                                                            ->disabled()
                                                            ->dehydrated(false)
                                                            ->afterStateHydrated(function (TextInput $component, ?CamperRegistration $record) {
                                                                if ($record?->camper) {
                                                                    $component->state($record->camper->health_card_number);
                                                                }
                                                            }),
                                                    ])
                                                    ->columnSpanFull(),

                                                Grid::make(2)
                                                    ->schema([
                                                        Textarea::make('camper_address')
                                                            ->label('Address')
                                                            ->rows(2)
                                                            ->disabled()
                                                            ->dehydrated(false)
                                                            ->afterStateHydrated(function (Textarea $component, ?CamperRegistration $record) {
                                                                if ($record?->camper) {
                                                                    $component->state($record->camper->address);
                                                                }
                                                            }),

                                                        Textarea::make('camper_custody')
                                                            ->label('Custody Details')
                                                            ->rows(2)
                                                            ->disabled()
                                                            ->dehydrated(false)
                                                            ->afterStateHydrated(function (Textarea $component, ?CamperRegistration $record) {
                                                                if ($record?->camper) {
                                                                    $component->state($record->camper->custody_details);
                                                                }
                                                            }),
                                                    ])
                                                    ->columnSpanFull(),
                                            ])
                                            ->columnSpan(1),

                                        Section::make('Status & Public Links')
                                            ->description('Manage registration status, portal links, and scannable QR codes.')
                                            ->icon(Heroicon::OutlinedClipboardDocumentCheck)
                                            ->schema([
                                                Select::make('status')
                                                    ->label('Registration Status')
                                                    ->options(RegistrationStatus::class)
                                                    ->native(false)
                                                    ->required()
                                                    ->columnSpanFull(),

                                                QrCodeCard::make('public_link_qr')
                                                    ->label('Registration Portal QR Code')
                                                    ->url(fn (?CamperRegistration $record): ?string => $record?->token ? url("/public/camper-register?token={$record->token}") : null)
                                                    ->caption('Scan to access registration')
                                                    ->qrSize(200)
                                                    ->columnSpanFull(),

                                                TextInput::make('public_link')
                                                    ->label('Public Access Link')
                                                    ->prefixIcon(Heroicon::OutlinedLink)
                                                    ->formatStateUsing(function (?CamperRegistration $record): ?string {
                                                        if (! $record) {
                                                            return null;
                                                        }

                                                        // Obtener la sesión asociada (soporta relación BelongsTo o BelongsToMany/Pivote)
                                                        $session = $record->registrationSession 
                                                            ?? $record->registrationSessions()->first();

                                                        $sessionToken = $session?->token;

                                                        if (! $sessionToken) {
                                                            return null;
                                                        }

                                                        // Genera la URL firmada válida por 15 días
                                                        return URL::temporarySignedRoute(
                                                            'public.camper.edit',
                                                            now()->addDays(15),
                                                            ['token' => $sessionToken]
                                                        );
                                                    })
                                                    ->placeholder('Generated after saving')
                                                    ->disabled()
                                                    ->dehydrated(false)
                                                    ->copyable()
                                                    ->suffixAction(
                                                        Action::make('openPublicLink')
                                                            ->icon('heroicon-m-arrow-top-right-on-square')
                                                            ->tooltip('Open public portal link in new tab')
                                                            ->url(fn (?string $state): ?string => $state, shouldOpenInNewTab: true)
                                                            ->visible(fn (?string $state): bool => ! empty($state))
                                                    )
                                                    ->columnSpanFull(),
                                            ])
                                            ->columnSpan(1),
                                    ]),
                            ]),

                        // ==========================================
                        // TAB 2: INFORMACIÓN MÉDICA (CAMPER MEDICAL)
                        // ==========================================
                        Tab::make('Medical Information')
                            ->icon(Heroicon::OutlinedHeart)
                            ->schema([
                                Group::make()
                                    ->relationship('camper')
                                    ->schema([
                                        Section::make('Medical Profile')
                                            ->description('Detalles médicos asociados al perfil del acampante.')
                                            ->relationship('medical')
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        Textarea::make('allergies')
                                                            ->label('Allergies')
                                                            ->rows(3)
                                                            ->placeholder('Lista de alergias conocidas...'),

                                                        Textarea::make('medications')
                                                            ->label('Medications')
                                                            ->rows(3)
                                                            ->placeholder('Medicamentos actuales o requeridos...'),

                                                        Textarea::make('dietary_restrictions')
                                                            ->label('Dietary Restrictions')
                                                            ->rows(3)
                                                            ->placeholder('Restricciones alimentarias...'),

                                                        Textarea::make('critical_alerts')
                                                            ->label('Critical Medical Alerts')
                                                            ->rows(3)
                                                            ->placeholder('Alertas o condiciones críticas a considerar...'),
                                                    ]),
                                            ]),
                                    ]),
                            ]),

                        // ==========================================
                        // TAB 3: PERMISOS Y CONSENTIMIENTOS
                        // ==========================================
                        Tab::make('Permissions & Consents')
                            ->icon(Heroicon::OutlinedDocumentCheck)
                            ->schema([
                                Section::make('Camper Consents')
                                    ->description('Gestión de autorizaciones asociadas a esta inscripción.')
                                    ->relationship('consent')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Toggle::make('photo_permission')
                                                    ->label('Photo Permission')
                                                    ->helperText('Permiso para capturar y publicar fotografías.'),

                                                Toggle::make('travel_permission')
                                                    ->label('Travel Permission')
                                                    ->helperText('Permiso para traslados y excursiones.'),

                                                Toggle::make('contact_permission')
                                                    ->label('Contact Permission')
                                                    ->helperText('Permiso para contacto en el marco del evento.'),

                                                Toggle::make('medical_permission')
                                                    ->label('Medical Treatment Permission')
                                                    ->helperText('Autorización de atención médica en caso de emergencia.'),
                                            ]),

                                        DateTimePicker::make('signed_at')
                                            ->label('Consent Signed At')
                                            ->native(false)
                                            ->default(now()),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
