<?php

namespace App\Http\Responses;


use App\Services\MessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class BaseResponse
{
    const PAGE = 'page';
    const LIMIT = 'limit';

    /**
     * This method is the temporary solution to resolve the issue
     * Issue: https://github.com/laravel/lumen-framework/issues/667
     * TODO! Remove this line after the issue is resolved
     */
    protected function getRequest()
    {
        return app(Request::class);
    }

    /**
     * Get request limit
     *
     * @return int
     */
    protected function getLimit(): int
    {
        $limit = Input::get(self::LIMIT);

        if (!$limit || $limit > MessageService::MAX_LIMIT) {
            $limit = MessageService::LIMIT;
        }

        return (int) $limit;
    }

    /**
     * Get request page
     *
     * @return int
     */
    protected function getPage(): int
    {
        $page = Input::get(self::PAGE);

        if ($page) {
            $page = Input::get(self::PAGE);
        }

        return (int) $page;
    }

    /**
     * @param Request $request
     * @param $fields
     */
    protected function validator(Request $request, $fields)
    {
        $input = $request->input();
        $validator = \Validator::make($input, $fields);
        if ($validator->fails()) {
            abort(404);
        }
    }
}
