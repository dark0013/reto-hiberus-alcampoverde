<?php

class AppointmentDto
{
    private int $id;
    private string $identification;
    private string $name;
    private string $appointment_date;
    private string $specialtyId;


    public function __construct(int $id = 0, string $identification = '', string $name = '', string $appointment_date = '', string $specialtyId = '')
    {
        $this->id = $id;
        $this->identification = $identification;
        $this->name = $name;
        $this->appointment_date = $appointment_date;
        $this->specialtyId = $specialtyId;
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

    public function getSpecialtyId(): string
    {
        return $this->specialtyId;
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

    public function setSpecialtyId(string $specialtyId): void
    {
        $this->specialtyId = $specialtyId;
    }

}
