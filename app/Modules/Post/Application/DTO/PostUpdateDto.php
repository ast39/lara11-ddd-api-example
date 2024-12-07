<?php

namespace App\Modules\Post\Application\DTO;

use App\Dto\DtoClass;

class PostUpdateDto extends DtoClass
{
    public int $id;

    public int $author_id;
    public ?string $title = null;
    public ?string $content = null;

    public ?string $status = null;

    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->id = $data['id'];

        if (array_key_exists('author_id', $data)) {
            $this->author_id = $data['author_id'];
        }

        if (array_key_exists('title', $data)) {
            $this->title = $data['title'];
        }

        if (array_key_exists('content', $data)) {
            $this->content = $data['content'];
        }

        if (array_key_exists('status', $data)) {
            $this->status = $data['status'];
        }
    }
}
