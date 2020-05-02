<?php

namespace Idy\Idea\Domain\Model;

use Idy\Idea\Domain\Exception\InvalidEmailDomainException;

class Author
{
    const EMAIL_PATTERN = "/^([a-zA-Z0-9_\-\.]+)@[a-zA-Z0-9\.]*idy\.local$/";

    private $name;
    private $email;

    /**
     * Author constructor.
     * @param $name
     * @param $email
     * @throws InvalidEmailDomainException
     */
    public function __construct($name, $email)
    {
        $this->name = $name;
        $this->email = $email;

        $this->isEmailAllowed();
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function email()
    {
        return $this->email;
    }

    /**
     * @return bool
     * @throws InvalidEmailDomainException
     */
    public function isEmailAllowed()
    {
        if (preg_match(self::EMAIL_PATTERN, $this->email)) {
            return true;
        }

        throw new InvalidEmailDomainException('author email domain must end in @idy.local');
    }

}