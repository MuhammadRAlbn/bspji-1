<?php

namespace App\Filament\Clusters\Pengujian\Resources\SertifikasiResource\Pages;

use App\Filament\Clusters\Pengujian\Resources\SertifikasiResource;
use App\Models\Sertifikasi;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Throwable;

class ListSertifikasis extends ListRecords
{
    protected static string $resource = SertifikasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Unggah Sertifikat'),
            Action::make('uploadMultiple')
                ->label('Unggah Beberapa')
                ->icon(Heroicon::OutlinedArrowUpTray)
                ->modalHeading('Unggah Beberapa Sertifikat')
                ->modalSubmitActionLabel('Unggah')
                ->authorize(fn (): bool => SertifikasiResource::getCreateAuthorizationResponse()->allowed())
                ->visible(fn (): bool => SertifikasiResource::canCreate())
                ->schema([
                    FileUpload::make('images')
                        ->label('Gambar Sertifikat')
                        ->helperText('Pilih satu atau beberapa gambar. Setiap gambar menjadi satu sertifikat.')
                        ->image()
                        ->multiple()
                        ->reorderable()
                        ->appendFiles()
                        ->maxParallelUploads(1)
                        ->disk('public')
                        ->directory('sertifikasi')
                        ->visibility('public')
                        ->storeFiles(false)
                        ->required(),
                ])
                ->action(fn (array $data) => $this->uploadImages($data['images'])),
        ];
    }

    private function uploadImages(array $images): void
    {
        $errorPath = $this->getMountedActionSchema()->getStatePath().'.images';

        foreach ($images as $image) {
            if (! $image instanceof TemporaryUploadedFile) {
                throw ValidationException::withMessages([$errorPath => 'Pilih gambar yang ingin diunggah.']);
            }
        }

        $paths = [];

        try {
            DB::transaction(function () use ($images, $errorPath, &$paths): void {
                foreach ($images as $image) {
                    if (! SertifikasiResource::canCreate()) {
                        throw ValidationException::withMessages([
                            $errorPath => 'Jumlah gambar melebihi kapasitas sertifikat yang tersedia. Kurangi gambar yang dipilih.',
                        ]);
                    }

                    $path = $image->storePublicly('sertifikasi', ['disk' => 'public']);

                    if ($path === false) {
                        throw ValidationException::withMessages([$errorPath => 'Gambar gagal disimpan. Silakan coba lagi.']);
                    }

                    $paths[] = $path;

                    if (! Storage::disk('public')->exists($path)) {
                        throw ValidationException::withMessages([$errorPath => 'Gambar gagal disimpan. Silakan coba lagi.']);
                    }

                    Sertifikasi::query()->create(['image' => $path]);
                }
            });
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($paths);

            throw $exception;
        }

        foreach ($images as $image) {
            try {
                $image->delete();
            } catch (Throwable $exception) {
                report($exception);
            }
        }

        Notification::make()
            ->success()
            ->title(count($images).' sertifikat berhasil diunggah.')
            ->send();
    }
}
