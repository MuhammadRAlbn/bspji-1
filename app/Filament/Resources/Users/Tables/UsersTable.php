<?php

namespace App\Filament\Resources\Users\Tables;

use App\Filament\Resources\Users\Actions\DeleteUserAction;
use App\Models\User;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label('Nama')->searchable()->sortable(),
            TextColumn::make('email')->label('Email')->searchable()->sortable(),
            TextColumn::make('role')->label('Role')->badge()
                ->formatStateUsing(fn (string $state): string => User::roleOptions()[$state] ?? 'Belum ditetapkan'),
            IconColumn::make('is_active')->label('Aktif')->boolean(),
            TextColumn::make('created_at')->label('Dibuat')->dateTime()->sortable(),
        ])->filters([
            SelectFilter::make('role')->label('Role')->options(User::roleOptions()),
            TernaryFilter::make('is_active')->label('Akun Aktif'),
        ])->recordActions([EditAction::make(), DeleteUserAction::make()])->defaultSort('created_at', 'desc');
    }
}
