<?php

namespace App\Modules\Auth\Domain\Service;

use App\Modules\Auth\AuthDto;
use App\Modules\Auth\Domain\AuthFilter;
use App\Modules\Auth\Jobs\ChangePassword;
use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * AuthChange service
 */
class AuthChange extends BaseService
{
    private $filter;

    public function __construct(AuthFilter $filter)
    {
        $this->filter = $filter;
    }

    public function __invoke(array $data): Payload
    {
        $authDto = $this->makeDto($data, new AuthDto);
        $user = Auth::user();

        if (!$this->filter->forChangePassword($authDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }
        if (!Hash::check($authDto->password, $user->password)) {
            return $this->newPayload(Payload::STATUS_AUTH_CHANGE_PASSWORD_FAILED);
        }
        $authDto->password = Hash::make($authDto->new_password);
        $authDto->new_password = $authDto->new_password_confirmation  = null;

        ChangePassword::dispatchNow($authDto->password, $user->id);

        return $this->newPayload(Payload::STATUS_AUTH_CHANGE_PASSWORD_SUCCESS);
    }
}
