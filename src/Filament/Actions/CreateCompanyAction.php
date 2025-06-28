<?php

namespace Green\CrmCore\Filament\Actions;

use Filament\Actions\CreateAction;
use Filament\Forms;
use Green\CrmCore\Filament\Resources\Concerns\Company\HasCompanyForm;
use Green\CrmCore\Models\Company;

class CreateCompanyAction extends CreateAction
{
    use HasCompanyForm;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model(Company::class);

        $this->form($this->getFormSchema());

        $this->mutateFormDataUsing(function (array $data): array {
            unset($data['domain']);

            return $data;
        });

        $this->after(function ($record, array $data) {
            if (isset($data['url'])) {
                // URLを保存
                $record->urls()->create([
                    'url' => $data['url'],
                    'type' => 'website',
                    'is_primary' => true,
                ]);

                // ドメインを保存
                $domain = $this->extractDomain($data['url']);
                if ($domain) {
                    $record->domains()->create([
                        'domain' => $domain,
                        'type' => 'primary',
                        'is_primary' => true,
                    ]);
                }
            }
        });
    }

    protected function getFormSchema(): array
    {
        return [
            static::getCompanyNameField(),
            Forms\Components\TextInput::make('url')
                ->label(__('green-crm-core::company.fields.url'))
                ->url()
                ->required()
                ->helperText(__('green-crm-core::company.helpers.url_auto_domain'))
                ->afterStateUpdated(function ($state, Forms\Set $set) {
                    if ($state) {
                        $domain = $this->extractDomain($state);
                        $set('domain', $domain);
                    }
                })
                ->live(onBlur: true),
            Forms\Components\TextInput::make('domain')
                ->label(__('green-crm-core::company.fields.domain'))
                ->disabled()
                ->dehydrated(false),
        ];
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
