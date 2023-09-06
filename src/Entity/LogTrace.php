<?php

namespace App\Entity;

class LogTrace
{
    private \DateTimeImmutable $date;
    private string $type;
    private string $message;

    /**
     * @param \DateTimeImmutable $date
     * @param string $type
     * @param string $message
     */
    public function __construct(\DateTimeImmutable $date, string $type, string $message)
    {
        $this->date = $date;
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }


}
