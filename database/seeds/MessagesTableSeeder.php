<?php

use App\Repositories\MessageRepositoryContract;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class MessagesTableSeeder extends Seeder
{
    private  $messageRepository;

    public function __construct(MessageRepositoryContract $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function run()
    {
        $path = storage_path("app/messages_sample.json");
        if (File::exists($path)) {
            $content = File::get($path);
            $jsonArray = json_decode($content);
            foreach ($jsonArray->messages as $item) {
               $entity = new \App\Entities\Message(
                    $item->sender,
                    $item->subject,
                    $item->message
                );
                $entity->setId($item->uid);
                $entity->setCreatedAt(\Carbon\Carbon::createFromTimestamp($item->time_sent));
                $this->messageRepository->create($entity);
            }
        }
    }
}