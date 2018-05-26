<?php

namespace Tests\EndPoints;


use App\Entities\Message;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Laravel\Lumen\Testing\DatabaseMigrations;

class MessageTest extends \TestCase
{
    use DatabaseMigrations;

    const MESSAGE_ID = 1;
    const MESSAGE_DATA = ['uid', 'sender', 'subject', 'message', 'time_sent', 'is_read', 'is_archived'];

    private $isMessageCreated = false;
    private $headers = [];

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->headers['Authorization'] = 'Basic ' . base64_encode('admin' . ':' . 'admin');
    }

    /**
     * Test List all messages
     */
    public function testIndexMessage()
    {
        $this->createMessage();

        $this->json('GET', '/api/v1/message', [], $this->headers)
            ->seeJsonStructure([
                'data' => ['*' => self::MESSAGE_DATA],
                'next_page_url'
            ]);
    }

    /**
     * Test move message to archive
     */
    public function testArchiveMessage()
    {
        $this->createMessage();

        $this->json('PUT', '/api/v1/message/archive', ['id' => self::MESSAGE_ID], $this->headers)
            ->assertResponseStatus(204);

        $this->json('GET', '/api/v1/message/archived', [], $this->headers)
            ->seeJsonContains(['is_archived' => true]);
    }

    /**
     * Test move message to archive
     */
    public function testShowMessage()
    {
        $this->createMessage();

        $this->json('GET', '/api/v1/message/' . self::MESSAGE_ID, [], $this->headers)
            ->assertResponseStatus(200);
    }

    /**
     * Test move message to archive
     */
    public function testReadMessage()
    {
        $this->createMessage();

        $this->json('PUT', '/api/v1/message/read', ['id' => self::MESSAGE_ID], $this->headers)
            ->seeJsonContains(['is_read' => true]);
    }

    private function createMessage()
    {
        if ($this->isMessageCreated) {
            return;
        }

        $message = new Message(
            'Eri',
            'Subject',
            'Message'
        );

        $message->setId(self::MESSAGE_ID);

        EntityManager::persist($message);
        EntityManager::flush();

        $this->isMessageCreated = true;
    }
}
