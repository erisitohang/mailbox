<?php

namespace App\Http\Responses\Message;

use App\Http\Responses\BaseResponse;
use App\Services\MessageService;
use App\Transformers\MessageTransformer;
use Illuminate\Contracts\Support\Responsable;

class ArchivedResponse extends BaseResponse implements Responsable
{
    /**
     * @var MessageService
     */
    private $messageService;

    /**
     * ArchivedResponse constructor.
     * @param MessageService $messageService
     */
    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        /** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
        $paginator = $this->messageService->archive(
            $this->getLimit(),
            $this->getPage()
        );

        $resource = (new MessageTransformer())->transformCollection($paginator);

        $paginator->setCollection(collect($resource));

        return response()->json($paginator, 200);
    }
}
