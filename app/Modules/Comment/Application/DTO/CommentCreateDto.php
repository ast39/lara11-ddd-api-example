<?php

namespace App\Modules\Comment\Application\DTO;

use App\Dto\DtoClass;

class CommentCreateDto extends DtoClass
{
    public int $post_id;
    public int $author_id;
    public string $content;

    public ?string $status = null;

    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->post_id = $data['post_id'];
        $this->author_id = $data['author_id'];
        $this->content = $data['content'];

        if (array_key_exists('status', $data)) {
            $this->status = $data['status'];
        }
    }
}
