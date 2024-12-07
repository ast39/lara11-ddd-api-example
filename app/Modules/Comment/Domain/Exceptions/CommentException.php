<?php

namespace App\Modules\Comment\Domain\Exceptions;

class CommentException extends \Exception
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
     * Исключение - Комментарий не найден
     *
     * @return self
     */
    public static function notFound(): self
    {
        return new self('Комментарий не найден', 404);
    }

    /**
     * Исключение - Дубль комментария
     *
     * @return self
     */
    public static function doubleComment(): self
    {
        return new self('Комментарий с таким контентом уже существует', 400);
    }
}
