<?php

namespace Modules\Tip\Services;

use Modules\Core\app\Contracts\BaseService;
use Modules\Tip\Actions\CreateTipAction;
use Modules\Tip\Actions\DeleteTipAction;
use Modules\Tip\Actions\UpdateTipAction;
use Modules\Tip\Models\Tip;

class TipService extends BaseService
{
    public function __construct(private CreateTipAction $createAction, private UpdateTipAction $updateAction, private DeleteTipAction $deleteAction) {}

    public function create(array $data)
    {

        return $this->execute(function () use ($data) {
            $this->createAction->handle($data);
        });
    }

    public function update(Tip $tip, array $data)
    {
        return $this->execute(function () use ($tip, $data) {
            return $this->updateAction->handle($tip, $data);
        });
    }

    public function delete(Tip $tip)
    {
        return $this->execute(function () use ($tip) {
            return $this->deleteAction->handle($tip);
        });
    }
}
