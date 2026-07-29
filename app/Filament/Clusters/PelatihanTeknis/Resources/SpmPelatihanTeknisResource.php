<?php

namespace App\Filament\Clusters\PelatihanTeknis\Resources;

use App\Actions\Images\ConvertUploadedImageToWebp;
use App\Exceptions\InvalidUploadedImage;
use App\Filament\Clusters\PelatihanTeknis\PelatihanTeknisCluster;
use App\Filament\Clusters\PelatihanTeknis\Resources\SpmPelatihanTeknisResource\Pages;
use App\Models\SpmPelatihanTeknis;
use App\Rules\AuthorizedSpmImageUpload;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class SpmPelatihanTeknisResource extends Resource
{
    protected static ?string $model = SpmPelatihanTeknis::class;

    protected static ?string $cluster = PelatihanTeknisCluster::class;

    protected static ?string $slug = 'spm';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'SPM';

    protected static ?string $modelLabel = 'SPM';

    protected static ?string $pluralModelLabel = 'SPM';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            FileUpload::make('image_path')
                ->label('Gambar SPM')
                ->helperText('JPEG, PNG, atau WebP. Maksimal 5 MB dan 4096 × 4096 piksel. File akan dikonversi otomatis menjadi WebP.')
                ->acceptedFileTypes([
                    'image/jpeg',
                    'image/png',
                    'image/webp',
                ])
                ->rules([
                    'image',
                    'extensions:jpg,jpeg,png,webp',
                    'mimes:jpg,jpeg,png,webp',
                    Rule::dimensions()
                        ->maxWidth(ConvertUploadedImageToWebp::MAX_DIMENSION)
                        ->maxHeight(ConvertUploadedImageToWebp::MAX_DIMENSION),
                ])
                ->nestedRecursiveRule(
                    fn (?SpmPelatihanTeknis $record): AuthorizedSpmImageUpload => new AuthorizedSpmImageUpload(
                        $record?->getRawOriginal('image_path'),
                    ),
                )
                ->maxSize(5120)
                ->maxParallelUploads(1)
                ->disk('public')
                ->directory(ConvertUploadedImageToWebp::DIRECTORY_PELATIHAN_TEKNIS)
                ->visibility('public')
                ->saveUploadedFileUsing(
                    function (
                        FileUpload $component,
                        TemporaryUploadedFile $file,
                        ConvertUploadedImageToWebp $converter,
                    ): string {
                        try {
                            return $converter->execute($file, ConvertUploadedImageToWebp::DIRECTORY_PELATIHAN_TEKNIS);
                        } catch (InvalidUploadedImage $exception) {
                            throw ValidationException::withMessages([
                                $component->getStatePath() => $exception->getMessage(),
                            ]);
                        }
                    },
                )
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Gambar SPM')
                    ->disk('public')
                    ->square(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSpmPelatihanTekniss::route('/'),
            'create' => Pages\CreateSpmPelatihanTeknis::route('/create'),
            'edit' => Pages\EditSpmPelatihanTeknis::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return parent::canCreate() && ! SpmPelatihanTeknis::query()->exists();
    }
}
