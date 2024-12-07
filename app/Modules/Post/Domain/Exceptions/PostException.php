<?php

namespace App\Modules\Post\Domain\Exceptions;

class PostException extends \Exception
{
    /**
     * @var mixed
     */
    protected $message;

    /**
     * @var int|mixed
     */
    protected $code = 400;


    public function __construct($message = null, $code = null)
    {
        if ($message) {
            $this->message = $message;
        }
        if ($code) {
            $this->code = $code;
        }

        parent::__construct($this->message, $this->code);
    }

    /**
     * Исключение - Пост не найден
     *
     * @return self
     */
    public static function notFound(): self
    {
        return new self('Пост не найден', 404);
    }

    /**
     * Исключение - Дубль поста
     *
     * @return self
     */
    public static function doublePost(): self
    {
        return new self('Пост с таким названием уже существует', 400);
    }
}
