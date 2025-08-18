<?php
class SpecialtyEntity
{
    private int $id;
    private string $specialty;

    public function __construct(int $id = 0, string $specialty = '')
    {
        $this->id = $id;
        $this->specialty = $specialty;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getSpecialty(): string
    {
        return $this->specialty;
    }

    public function setSpecialty(string $specialty): void
    {
        $this->specialty = $specialty;
    }
}
