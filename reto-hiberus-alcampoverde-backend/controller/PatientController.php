<?php
require_once 'service/IPatientService.php';
require_once 'model/dto/PatientDto.php';
require_once 'model/entity/PatientEntity.php';

class PatientController
{
    private IPatientService $patientService;

    public function __construct(IPatientService $patientService)
    {
        $this->patientService = $patientService;
    }


    public function getPatientById($id)
    {

        if (!is_numeric($id) || $id <= 0) {
            $this->sendResponse(400, ["message" => "El ID del paciente no es válido."]);
            return;
        }

        $patientEntity = $this->patientService->findPatientById((int) $id);

        if ($patientEntity) {
            $patientDto = $this->mapEntityToDto($patientEntity);
            $this->sendResponse(200, $patientDto);
        } else {
            $this->sendResponse(404, ["message" => "Paciente no encontrado."]);
        }
    }

    public function getAllPatients()
    {
        $patientEntities = $this->patientService->findAllPatient();

        $patientDtos = array_map([$this, 'mapEntityToDto'], $patientEntities);

        $this->sendResponse(200, $patientDtos);
    }

    public function savePatient(PatientDto $patientDto)
    {
        $patientEntity = $this->mapDtoToEntity($patientDto);
        $success = $this->patientService->savePatient($patientEntity);

        if ($success) {
            $this->sendResponse(201, ["message" => "Paciente guardado exitosamente."]);
        } else {
            $this->sendResponse(500, ["message" => "Error al guardar el paciente."]);
        }
    }

    public function updatePatient(PatientDto $patientDto): void
    {

        $patientEntity = $this->mapDtoToEntity($patientDto);
        $success = $this->patientService->updatePatient($patientEntity);

        if ($success) {

            $this->sendResponse(200, ["message" => "Paciente actualizado exitosamente."]);
        } else {
            $this->sendResponse(500, ["message" => "Error al actualizar el paciente."]);
        }
    }

    public function deletePatient(int $id): void
    {
        $success = $this->patientService->deletePatient($id);

        if ($success) {
            $this->sendResponse(200, ["message" => "Paciente eliminado exitosamente."]);
        } else {
            $this->sendResponse(500, ["message" => "Error al eliminar el paciente."]);
        }
    }

    private function mapEntityToDto(PatientEntity $entity): array
    {
        $dto = new PatientDto();
        $dto->setId($entity->getId());
        $dto->setName($entity->getName());
        $dto->setAge($entity->getAge());
        $dto->setIdentification($entity->getIdentification());

        return [
            'id' => $dto->getId(),
            'name' => $dto->getName(),
            'age' => $dto->getAge(),
            'identification' => $dto->getIdentification()
        ];
    }

    private function mapDtoToEntity(PatientDto $dto): PatientEntity
    {
        $entity = new PatientEntity();
        $entity->setId($dto->getId());
        $entity->setName($dto->getName());
        $entity->setAge($dto->getAge());
        $entity->setIdentification($dto->getIdentification());

        return $entity;
    }


    private function sendResponse(int $statusCode, $data)
    {
        header("Content-Type: application/json");
        http_response_code($statusCode);
        echo json_encode($data);
    }
}