<?php

namespace Green\CrmCore\Filament\Actions;

use Filament\Actions\CreateAction;
use Filament\Forms;
use Green\CrmCore\Filament\Resources\Concerns\Contact\HasContactForm;
use Green\CrmCore\Models\Company;
use Green\CrmCore\Models\Contact;
use Green\CrmCore\Models\Domain;

class CreateContactAction extends CreateAction
{
    use HasContactForm, HasContactForm;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model(Contact::class);

        $this->form($this->getFormSchema());

        $this->mutateFormDataUsing(function (array $data): array {
            unset($data['suggested_company']);

            return $data;
        });

        $this->after(function ($record, array $data) {
            // メールアドレスを保存
            if (isset($data['email'])) {
                $record->emails()->create([
                    'email' => $data['email'],
                    'type' => 'work',
                    'is_primary' => true,
                ]);
            }

            // 会社との関連を保存
            if (isset($data['company_id'])) {
                $pivotData = [];
                if (isset($data['position'])) {
                    $pivotData['position'] = $data['position'];
                }
                if (isset($data['department'])) {
                    $pivotData['department'] = $data['department'];
                }

                $record->companies()->attach($data['company_id'], $pivotData);
            }
        });
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Grid::make(2)
                ->schema([
                    static::getFamilyNameField(),
                    static::getGivenNameField(),
                ]),
            Forms\Components\TextInput::make('email')
                ->label(__('green-crm-core::contact.fields.email'))
                ->email()
                ->required()
                ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                    if ($state && ! $get('company_id')) {
                        $domain = $this->extractDomainFromEmail($state);
                        if ($domain) {
                            // ドメインから会社を検索
                            $company = Domain::where('domain', $domain)
                                ->first()
                                ?->domainable;

                            if ($company instanceof Company) {
                                $set('company_id', $company->id);
                                $set('suggested_company', true);
                            }
                        }
                    }
                })
                ->live(onBlur: true),
            Forms\Components\Section::make(__('green-crm-core::contact.sections.company_info'))
                ->schema([
                    Forms\Components\Select::make('company_id')
                        ->label(__('green-crm-core::contact.fields.company'))
                        ->relationship('companies', 'company_name')
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            static::getCompanyNameField(),
                            Forms\Components\TextInput::make('url')
                                ->label(__('green-crm-core::company.fields.url'))
                                ->url()
                                ->required(),
                        ])
                        ->createOptionUsing(function (array $data) {
                            $company = Company::create([
                                'company_name' => $data['company_name'],
                            ]);

                            if (isset($data['url'])) {
                                // URLを保存
                                $company->urls()->create([
                                    'url' => $data['url'],
                                    'type' => 'website',
                                    'is_primary' => true,
                                ]);

                                // ドメインを保存
                                $domain = $this->extractDomain($data['url']);
                                if ($domain) {
                                    $company->domains()->create([
                                        'domain' => $domain,
                                        'type' => 'primary',
                                        'is_primary' => true,
                                    ]);
                                }
                            }

                            return $company->id;
                        })
                        ->helperText(fn (Forms\Get $get) => $get('suggested_company')
                                ? __('green-crm-core::contact.helpers.company_auto_selected')
                                : null
                        ),
                    Forms\Components\TextInput::make('position')
                        ->label(__('green-crm-core::contact.fields.position'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('department')
                        ->label(__('green-crm-core::contact.fields.department'))
                        ->maxLength(255),
                ])
                ->collapsible(),
        ];
    }

    protected function extractDomainFromEmail(string $email): ?string
    {
        $parts = explode('@', $email);
        if (count($parts) !== 2) {
            return null;
        }

        return $parts[1];
    }

    protected function extractDomain(string $url): ?string
    {
        $parsedUrl = parse_url($url);
        if (! isset($parsedUrl['host'])) {
            return null;
        }

        $host = $parsedUrl['host'];
        // www. を除去
        $host = preg_replace('/^www\./', '', $host);

        return $host;
    }
}
