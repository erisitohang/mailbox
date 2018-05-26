<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Responses\Message\ArchivedResponse;
use App\Http\Responses\Message\ArchiveResponse;
use App\Http\Responses\Message\IndexResponse;
use App\Http\Responses\Message\ReadResponse;
use App\Http\Responses\Message\ShowResponse;
use App\Services\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    private $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * List messages
     * Retrieve a paginateable list of all messages. Show if messages were read already.
     *
     * @return IndexResponse
     *
     */
    public function index()
    {
        return new IndexResponse($this->messageService);
    }

    /**
     * List archived messages
     * Retrieve a paginateable list of all archived messages. Show if messages were read already.
     *
     * @return ArchivedResponse
     */
    public function archived()
    {
        return new ArchivedResponse($this->messageService);
    }

    /**
     * Show message
     * Retrieve message by id, include read status and if message is achived.
     *
     * @param $id
     * @return ShowResponse
     */
    public function show($id)
    {
        return new ShowResponse($this->messageService, (int)$id);
    }

    /**
     * Read message
     * This action “reads” a message and marks it as read in database.
     *
     * @param Request $request
     * @return ReadResponse
     */
    public function read(Request $request)
    {
        return new ReadResponse($this->messageService);
    }

    /**
     * Archive message
     * This action sets a message to archived.
     *
     * @param Request $request
     * @return ArchiveResponse
     */
    public function archive(Request $request)
    {
        return new ArchiveResponse($this->messageService);
    }
}