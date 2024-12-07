<?php

namespace App\Modules\User\Domain\Exceptions;

class UserException extends \Exception
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
     * Исключение - Юзер не найден
     *
     * @return self
     */
    public static function notFound(): self
    {
        return new self('Пользователь не найден', 404);
    }

    /**
     * Исключение - Дубль юзера
     *
     * @return self
     */
    public static function doubleLogin(): self
    {
        return new self('Пользователь с таким логином уже существует', 400);
    }
}
