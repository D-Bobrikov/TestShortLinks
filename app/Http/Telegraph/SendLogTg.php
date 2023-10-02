<?php

namespace App\Http\Telegraph;

use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Models\TelegraphChat;

class SendLogTg extends WebhookHandler
{
    public function start(): void
    {
        $this->chat->html('Привет, я буду присылать тебе логи !')->send();
    }

    public function sendLog(string $message): void
    {
        sleep(1);
        $chat = TelegraphChat::find(1);

        $chat->html($message)->send();
    }
}
