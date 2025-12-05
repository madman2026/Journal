<?php

namespace Modules\Core\Services;

use Modules\Core\Actions\GetEventsListAction;
use Modules\Core\Actions\GetNewsListAction;
use Modules\Core\app\Contracts\BaseService;
use Modules\Core\app\Contracts\ServiceResponse;

class ContentService extends BaseService
{
    public function __construct(
        private GetNewsListAction $getNewsListAction,
        private GetEventsListAction $getEventsListAction,
    ) {}

    public function getNewsList(int $perPage = 20): ServiceResponse
    {
        return $this->execute(
            fn () => $this->getNewsListAction->handle($perPage),
            'Failed to load news list',
            'News list loaded successfully',
            useTransaction: false
        );
    }

    public function getEventsList(int $perPage = 20): ServiceResponse
    {
        return $this->execute(
            fn () => $this->getEventsListAction->handle($perPage),
            'Failed to load events list',
            'Events list loaded successfully',
            useTransaction: false
        );
    }
}
