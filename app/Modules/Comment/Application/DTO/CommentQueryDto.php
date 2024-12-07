<?php

namespace App\Modules\Comment\Application\DTO;

use App\Dto\DtoClass;

class CommentQueryDto extends DtoClass
{
    public ?int $post_id = null;
    public ?int $author_id = null;
    public ?string $query = null;

    public function __construct(array $data)
    {
        parent::__construct($data);

        if (array_key_exists('post_id', $data)) {
            $this->post_id = $data['post_id'];
        }

        if (array_key_exists('author_id', $data)) {
            $this->author_id = $data['author_id'];
        }

        if (array_key_exists('query', $data)) {
            $this->query = $data['query'];
        }
    }
}
