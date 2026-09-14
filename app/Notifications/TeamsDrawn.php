<?php

namespace App\Notifications;

use App\Models\Draw;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class TeamsDrawn extends Notification
{
    use Queueable;

    public function __construct(public Draw $draw) {}

    public function via(object $notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush(object $notifiable, Notification $notification): WebPushMessage
    {
        return (new WebPushMessage)
            ->title('Die Teams sind ausgelost!')
            ->body(count($this->draw->teams()).' Teams – schau nach, wo du spielst.')
            ->icon('/img/icons/icon-192.png')
            ->badge('/img/icons/badge-96.png')
            ->tag('draw-'.$this->draw->id)
            ->data(['url' => route('shuffle', $this->draw->practise_id)]);
    }
}
