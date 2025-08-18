<?php

class ResultAppointmentDto
{
    private int $id;
    private string $identification;
    private string $name;
    private string $appointment_date;
    private int $specialty_id;
    private string $specialty;


    public function __construct(
        int $id = 0,
        string $identification = '',
        string $name = '',
        string $appointment_date = '',
        int $specialty_id = 0,
        string $specialty = ''
    ) {
        $this->id = $id;
        $this->identification = $identification;
        $this->name = $name;
        $this->appointment_date = $appointment_date;
        $this->specialty_id = $specialty_id;
        $this->specialty = $specialty;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getIdentification(): string
    {
        return $this->identification;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAppointmentDate(): string
    {
        return $this->appointment_date;
    }

    public function getSpecialtyId(): int
    {
        return $this->specialty_id;
    }

    public function getSpecialty(): string
    {
        return $this->specialty;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setIdentification(string $identification): void
    {
        $this->identification = $identification;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setAppointmentDate(string $appointment_date): void
    {
        $this->appointment_date = $appointment_date;
    }

    public function setSpecialtyId(int $specialty_id): void
    {
        $this->specialty_id = $specialty_id;
    }

    public function setSpecialty(string $specialty): void
    {
        $this->specialty = $specialty;
    }
}