<?php


namespace App\Models;

use DateTime;

class Comment
{
    public function __construct(
        private string $name,
        private string $email,
        private string $title,
        private string $content,
        private ?DateTime $createdAt = null
    ) {
        $this->createdAt = $createdAt ?? new DateTime();
    }

    // Геттеры и сеттеры для свойств
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
}
