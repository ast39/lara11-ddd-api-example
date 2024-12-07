<?php

namespace App\Modules\User\Application\DTO;

use App\Dto\DtoClass;

class UserUpdateDto extends DtoClass
{
    const NULLABLE_FIELDS = ['second_name', 'surname', 'refresh_token', 'refresh_token_expired_at'];


    public int $id;

    public ?string $password;
    public ?string $position = null;
    public ?string $first_name = null;
    public ?string $second_name = null;
    public ?string $last_name = null;
    public ?string $refresh_token = null;
    public ?string $refresh_token_expired_at = null;
    public ?bool $is_blocked = null;


    public function __construct(array $data)
    {
        parent::__construct($data, self::NULLABLE_FIELDS);

        $this->id = $data['id'];

        if (array_key_exists('password', $data)) {
            $this->password = $data['password'];
        }

        if (array_key_exists('position', $data)) {
            $this->position = $data['position'];
        }

        if (array_key_exists('first_name', $data)) {
            $this->first_name = $data['first_name'];
        }

        if (array_key_exists('second_name', $data)) {
            $this->second_name = $data['second_name'];
        }

        if (array_key_exists('last_name', $data)) {
            $this->last_name = $data['last_name'];
        }

        if (array_key_exists('refresh_token', $data)) {
            $this->refresh_token = $data['refresh_token'];
        }

        if (array_key_exists('refresh_token_expired_at', $data)) {
            $this->refresh_token_expired_at = $data['refresh_token_expired_at'];
        }

        if (array_key_exists('is_blocked', $data)) {
            $this->is_blocked = $data['is_blocked'];
        }
    }
}
