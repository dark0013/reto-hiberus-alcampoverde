<?php
require_once 'repository/IAppointmentRepository.php';
require_once 'service/IAppointmentService.php';

class AppointmentServiceImpl implements IAppointmentService
{

    private IAppointmentRepository $repository;
    public function __construct(IAppointmentRepository $repository)
    {
        $this->repository = $repository;
    }


    public function saveAppointment(AppointmentEntity $appointmentEntity): bool
    {
        return $this->repository->saveAppointment($appointmentEntity);
    }

    public function updateAppointment(AppointmentEntity $appointmentEntity): bool
    {
        return $this->repository->updateAppointment($appointmentEntity);
    }

    public function deleteAppointment(int $id): bool
    {
        return $this->repository->deleteAppointment($id);
    }

    public function findAllAppointments(): array
    {
        return $this->repository->findAllAppointments();
    }

}