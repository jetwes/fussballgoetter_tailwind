<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Laravel\Facades\Image;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class AvatarUploader extends Component
{
    use WithFileUploads;

    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:8192', message: [
        'image' => 'Bitte nur .jpg, .png oder .webp Bilddateien hochladen!',
        'mimes' => 'Bitte nur .jpg, .png oder .webp Bilddateien hochladen!',
        'max' => 'Das Bild darf maximal 8 MB groß sein.',
    ])]
    public ?TemporaryUploadedFile $photo = null;

    public function updatedPhoto(): void
    {
        try {
            $this->validate();
        } catch (ValidationException $exception) {
            $this->photo?->delete();
            $this->photo = null;

            throw $exception;
        }
    }

    /**
     * @param  array{x:int,y:int,width:int,height:int}|null  $crop  Ausschnitt in Pixeln des Originalbildes
     */
    public function save(?array $crop = null): void
    {
        $this->validate(['photo' => 'required|image']);

        $image = Image::decodePath($this->photo->getRealPath());

        if ($crop && ($crop['width'] ?? 0) > 0 && ($crop['height'] ?? 0) > 0) {
            $image->crop(
                (int) $crop['width'],
                (int) $crop['height'],
                max(0, (int) $crop['x']),
                max(0, (int) $crop['y']),
            );
        }

        $encoded = $image->cover(240, 240)->encode(new JpegEncoder(quality: 90));

        $filename = Str::uuid().'.jpg';
        Storage::disk('avatars')->put($filename, (string) $encoded);

        $user = auth()->user();
        $old = $user->avatar;
        $user->avatar = '/user/avatars/'.$filename;
        $user->save();

        if ($old && Str::startsWith($old, '/user/avatars/')) {
            Storage::disk('avatars')->delete(basename($old));
        }

        $this->photo->delete();
        $this->reset('photo');

        // Seite neu laden, damit auch der Header das neue Bild zeigt.
        session()->flash('success-message', 'Dein Profilbild wurde gespeichert.');
        $this->redirectRoute('profile', navigate: true);
    }

    public function cancel(): void
    {
        $this->photo?->delete();
        $this->reset('photo');
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.avatar-uploader', [
            'user' => auth()->user(),
        ]);
    }
}
