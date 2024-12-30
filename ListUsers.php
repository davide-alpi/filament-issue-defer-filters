<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    public function table(Table $table): Table
    {

        return $table
            ->columns([
                TextColumn::make('email'),
            ])
            ->filters([
                Filter::make('filters')
                    ->form([
                        Select::make('type')
                            ->options([
                                'gmail' => 'gmail',
                                'yahoo' => 'yahoo',
                            ])
                            ->required()
                            ->live(),
                    ])
                    ->query(function (Builder $query, array $data, BaseFilter $filter): Builder {
                        try {
                            $filter
                                ->getForm()
                                ->getComponents()[0]
                                ->getLivewire()
                                ->validate();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title("Current filters are not valid")
                                ->body($e->getMessage())
                                ->danger()
                                ->send();

                            return $query;
                        }

                        return $query->where('email', 'LIKE', '%' . $data["type"] . '%');
                    }),
            ], layout: FiltersLayout::AboveContent)
            ->deferFilters();
    }
}
