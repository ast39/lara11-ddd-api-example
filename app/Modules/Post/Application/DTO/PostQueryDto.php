<?php

namespace App\Modules\Post\Application\DTO;

use App\Dto\DtoClass;

class PostQueryDto extends DtoClass
{
    public ?int $author_id = null;
    public ?string $query = null;

    public function __construct(array $data)
    {
        parent::__construct($data);

        if (array_key_exists('author_id', $data)) {
            $this->author_id = $data['author_id'];
        }

        if (array_key_exists('query', $data)) {
            $this->query = $data['query'];
        }
    }
}
