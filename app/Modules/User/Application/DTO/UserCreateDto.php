<?php

namespace App\Modules\User\Application\DTO;

use App\Dto\DtoClass;

class UserCreateDto extends DtoClass
{
    public string $login;
    public string $password;
    public string $first_name;
    public string $position;

    public ?string $second_name = null;
    public ?string $last_name = null;
    public ?string $refresh_token = null;
    public ?string $refresh_token_expired_at = null;
    public ?bool $is_root = null;
    public ?bool $is_blocked = null;


    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->login = $data['login'];
        $this->password = $data['password'];
        $this->first_name = $data['first_name'];

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

        if (array_key_exists('is_root', $data)) {
            $this->is_root = $data['is_root'];
        }

        if (array_key_exists('is_blocked', $data)) {
            $this->is_blocked = $data['is_blocked'];
        }
    }
}
