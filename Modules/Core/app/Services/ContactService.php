<?php

namespace Modules\Core\Services;

use Modules\Core\Actions\CreateContactAction;
use Modules\Core\app\Contracts\BaseService;
use Modules\Core\app\Contracts\ServiceResponse;

class ContactService extends BaseService
{
    public function __construct(
        private CreateContactAction $createContactAction,
    ) {}

    public function createContact(array $data): ServiceResponse
    {
        return $this->execute(
            fn () => $this->createContactAction->handle($data),
            'Failed to create contact',
            'Contact created successfully'
        );
    }
}

