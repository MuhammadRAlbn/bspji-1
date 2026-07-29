<?php

namespace App\Filament\Clusters\VerifikasiTkdn\Resources;

use App\Actions\Images\ConvertUploadedImageToWebp;
use App\Exceptions\InvalidUploadedImage;
use App\Filament\Clusters\VerifikasiTkdn\Resources\SpmTkdnResource\Pages;
use App\Filament\Clusters\VerifikasiTkdn\VerifikasiTkdnCluster;
use App\Models\SpmTkdn;
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

class SpmTkdnResource extends Resource
{
    protected static ?string $model = SpmTkdn::class;

    protected static ?string $cluster = VerifikasiTkdnCluster::class;

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
                    fn (?SpmTkdn $record): AuthorizedSpmImageUpload => new AuthorizedSpmImageUpload(
                        $record?->getRawOriginal('image_path'),
                    ),
                )
                ->maxSize(5120)
                ->maxParallelUploads(1)
                ->disk('public')
                ->directory(ConvertUploadedImageToWebp::DIRECTORY_VERIFIKASI_TKDN)
                ->visibility('public')
                ->saveUploadedFileUsing(
                    function (
                        FileUpload $component,
                        TemporaryUploadedFile $file,
                        ConvertUploadedImageToWebp $converter,
                    ): string {
                        try {
                            return $converter->execute($file, ConvertUploadedImageToWebp::DIRECTORY_VERIFIKASI_TKDN);
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
            'index' => Pages\ListSpmTkdns::route('/'),
            'create' => Pages\CreateSpmTkdn::route('/create'),
            'edit' => Pages\EditSpmTkdn::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return parent::canCreate() && ! SpmTkdn::query()->exists();
    }
}
