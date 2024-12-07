<?php


namespace App\Exceptions;

class AuthException extends \Exception
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
     * Исключение - Отказано в доступе
     *
     * @return self
     */
    public static function notAccess(): self
    {
        return new self('error.global.403', 404);
    }
}
