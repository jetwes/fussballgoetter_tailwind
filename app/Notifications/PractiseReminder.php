<?php

namespace App\Notifications;

use App\Models\Practise;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class PractiseReminder extends Notification
{
    use Queueable;

    public function __construct(public Practise $practise) {}

    public function via(object $notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush(object $notifiable, Notification $notification): WebPushMessage
    {
        $date = $this->practise->date_of_practise;

        return (new WebPushMessage)
            ->title('Bist du '.$date->translatedFormat('l').' dabei?')
            ->body('Training am '.$date->format('d.m.').' um '.$date->format('H:i').' Uhr. Anmeldung bis '.$this->practise->registrationDeadline()->format('H:i').' Uhr.')
            ->icon('/img/icons/icon-192.png')
            ->badge('/img/icons/badge-96.png')
            ->tag('practise-'.$this->practise->id)
            ->renotify()
            ->data(['url' => route('home')]);
    }
}
