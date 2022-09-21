<?php

namespace App\Entity;

class File 
{
    protected $file;

    public function getFile(): string
    {
        return $this->file;
    }

    public function setFile(string $file): void
    {
        $this->file = $file;
    }
}