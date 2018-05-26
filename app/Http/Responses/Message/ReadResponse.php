<?php

namespace App\Http\Responses\Message;

use App\Entities\Message;
use App\Http\Responses\BaseResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\MessageService;
use App\Transformers\MessageTransformer;
use Illuminate\Contracts\Support\Responsable;

class ReadResponse extends BaseResponse implements Responsable
{
    /**
     * @var MessageService
     */
    private $messageService;

    /**
     * @var Message
     */
    private $message;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        $request = $this->getRequest();
        $this->validate($request);

        $now = Carbon::now();
        $this->messageService->update($this->message, 'read_at', Carbon::now());

        $this->message->setReadAt($now);

        return response()->json(
            (new MessageTransformer())->transform($this->message),
            200
        );
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


        if (!$this->message || $this->message->getReadAt()) {
            abort(404);
        }
    }
}
