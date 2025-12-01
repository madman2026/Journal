<?php

namespace Modules\Core\Services;

use Modules\Core\Actions\GetLandingPageDataAction;
use Modules\Core\app\Contracts\BaseService;
use Modules\Core\app\Contracts\ServiceResponse;

class LandingPageService extends BaseService
{
    public function __construct(
        private GetLandingPageDataAction $getLandingPageDataAction,
    ) {}

    public function getLandingPageData(): ServiceResponse
    {
        return $this->execute(
            fn () => $this->getLandingPageDataAction->handle(),
            'Failed to load landing page data',
            'Landing page data loaded successfully',
            useTransaction: false
        );
    }
}

