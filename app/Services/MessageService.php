<?php

namespace App\Services;


use App\Entities\Message;
use App\Repositories\MessageRepositoryContract;

class MessageService extends BaseService
{

    /**
     * @var MessageRepositoryContract
     */
    private $messageRepository;

    /**
     * MessageService constructor.
     * @param MessageRepositoryContract $messageRepository
     */
    public function __construct(MessageRepositoryContract $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    /**
     *
     * Retrieve a list of all message
     *
     * @param int $limit
     * @param int $page
     * @return mixed
     */
    public function all(int $limit, int $page)
    {
        return $this->messageRepository->all($limit, $page);
    }

    /**
     * Retrieve a list of archived message
     *
     * @param int $limit
     * @param int $page
     * @return mixed
     */
    public function archive(int $limit, int $page)
    {
        return $this->messageRepository->archive($limit, $page);
    }

    /**
     * @param $id
     * @return Message|null
     */
    public function findById($id): ?Message
    {
        return $this->messageRepository->findById($id);
    }

    /**
     * Update specific field value
     *
     * @param Message $message
     * @param string $field
     * @param mixed $value
     */
    public function update(Message $message, string  $field, $value): void
    {
        $this->messageRepository->update($message, $field, $value);
    }
}
