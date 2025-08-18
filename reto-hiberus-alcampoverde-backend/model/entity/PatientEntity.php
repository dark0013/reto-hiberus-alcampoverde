<?php
class PatientEntity
{
    private int $id;
    private string $name;
    private int $age;
    private string $identification;


    public function __construct(int $id = 0, string $name = '', int $age = 0, string $identification = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
        $this->identification = $identification;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function getIdentification(): string
    {
        return $this->identification;
    }

    public function setIdentification(string $identification): void
    {
        $this->identification = $identification;
    }

}
