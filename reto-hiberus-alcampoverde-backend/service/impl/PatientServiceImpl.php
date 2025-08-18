<?php
require_once 'repository/IPatientRepository.php';
require_once 'service/IPatientService.php';

class PatientServiceImpl implements IPatientService
{
    private IPatientRepository $repository;
    public function __construct(IPatientRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findPatientById($id): ?PatientEntity
    {
        /*   if (!is_numeric($id) || $id <= 0) {
              throw new InvalidArgumentException("El ID del paciente debe ser un número positivo.");
          } */
        return $this->repository->findPatientById($id);
    }

    public function findAllPatient(): array
    {
        return $this->repository->findAllPatient();
    }

    public function savePatient(PatientEntity $patient): bool
    {
        return $this->repository->savePatient($patient);
    }

    public function updatePatient(PatientEntity $patient): bool
    {

        return $this->repository->updatePatient($patient);
    }

    public function deletePatient(int $id): bool
    {
        return $this->repository->deletePatient($id);
    }
}
