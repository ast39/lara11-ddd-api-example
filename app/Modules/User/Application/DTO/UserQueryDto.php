<?php

namespace App\Modules\User\Application\DTO;

use App\Dto\DtoClass;

class UserQueryDto extends DtoClass
{
    public ?string $query = null;

    public function __construct(array $data)
    {
        parent::__construct($data);

        if (array_key_exists('query', $data)) {
            $this->query = $data['query'];
        }
    }
}
