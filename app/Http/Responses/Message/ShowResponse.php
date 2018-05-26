<?php

namespace App\Http\Responses\Message;

use App\Http\Responses\BaseResponse;
use App\Services\MessageService;
use App\Transformers\MessageTransformer;
use Illuminate\Contracts\Support\Responsable;

class ShowResponse extends BaseResponse implements Responsable
{

    /**
     * @var MessageService
     */
    private $messageService;

    /**
     * @var int
     */
    private $id;

    public function __construct(MessageService $messageService, int $id)
    {
        $this->messageService = $messageService;
        $this->id = $id;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        $message = $this->messageService->findById($this->id);

        if (!$message) {
            abort(404);
        }

        return response()->json(
            (new MessageTransformer())->transform($message),
            200
        );
    }
}
