<?php

namespace App\Modules\Post\Application\DTO;

use App\Dto\DtoClass;

class PostCreateDto extends DtoClass
{
    public int $author_id;
    public string $title;
    public string $content;

    public ?string $status = null;

    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->author_id = $data['author_id'];
        $this->title = $data['title'];
        $this->content = $data['content'];

        if (array_key_exists('status', $data)) {
            $this->status = $data['status'];
        }
    }
}
