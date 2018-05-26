<?php

namespace App\Transformers;

use App\Entities\Message;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

class MessageTransformer extends TransformerAbstract
{
    public function transform(Message $message)
    {

        $isRead = $message->getReadAt() !== null || false;
        $isArchived = $message->getArchivedAt() !== null || false;
        return [
            'uid' => $message->getId(),
            'sender' => $message->getSender(),
            'subject' => $message->getSubject(),
            'message' => $message->getMessage(),
            'time_sent' => $message->getCreatedAt()->getTimestamp(),
            'is_read' => $isRead,
            'is_archived' => $isArchived,
        ];
    }

    public function transformCollection($messages)
    {
        $resource = new Collection($messages, new MessageTransformer());

        $manager = new Manager();

        return $manager->createData($resource)->toArray()['data'];
    }
}