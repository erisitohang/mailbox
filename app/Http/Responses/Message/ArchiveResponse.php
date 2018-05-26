<?php

namespace App\Http\Responses\Message;

use App\Entities\Message;
use App\Http\Responses\BaseResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\MessageService;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;

class ArchiveResponse extends BaseResponse implements Responsable
{
    /**
     * @var MessageService
     */
    private $messageService;

    /**
     * @var Message
     */
    private $message;

    /**
     * ArchiveResponse constructor.
     * @param MessageService $messageService
     */
    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function toResponse($request)
    {
        $request = $this->getRequest();
        $this->validate($request);

        $this->messageService->update($this->message, 'archived_at', Carbon::now());

        $response = new Response(null);
        return $response->setStatusCode(204);
    }

    /**
     * @param Request $request
     */
    private function validate(Request $request)
    {
        $fields = [
            'id' => 'required|numeric',
        ];

        $this->validator($request, $fields);

        $id = $request->get('id');

        $this->message = $this->messageService->findById($id);
        if (!$this->message || $this->message->getArchivedAt()) {
            abort(404);
        }
    }
}
