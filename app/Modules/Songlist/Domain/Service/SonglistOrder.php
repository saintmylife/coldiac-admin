<?php

namespace App\Modules\Songlist\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Songlist\Domain\SonglistFilter;
use App\Modules\Songlist\Repository\SonglistRepositoryInterface;
use App\Modules\Songlist\SonglistDto;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

/**
 * SonglistOrder service
 */
class SonglistOrder extends BaseService
{
    private $filter;
    private $songlistRepo;

    public function __construct(SonglistFilter $filter, SonglistRepositoryInterface $songlistRepo)
    {
        $this->filter = $filter;
        $this->songlistRepo = $songlistRepo;
    }

    public function __invoke(int $id, array $data): Payload
    {
        $songlistDto = $this->makeDto($data, new SonglistDto);
        $songlistDto->id = $id;

        try {
            $songlist = $this->songlistRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }

        if (!$this->filter->forUpdateOrder($songlistDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }
        $dataForUpdate = [
            'order' => $songlistDto->order
        ];

        $update = $this->songlistRepo->update($dataForUpdate, $id);

        return $this->newPayload(Payload::STATUS_UPDATED, compact('data'));
    }
}
