<?php
require_once 'service/IAppointmentService.php';
require_once 'model/dto/AppointmentDto.php';
require_once 'model/entity/AppointmentEntity.php';
require_once 'model/entity/ResultAppointmentEntity.php';
require_once 'model/dto/ResultAppointmentDto.php';

class AppointmentController
{
    private IAppointmentService $appointmentService;

    public function __construct(IAppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    public function saveAppointment(AppointmentDto $appointment): void
    {
        $appointmentEntity = $this->mapDtoToEntity($appointment);
        $success = $this->appointmentService->saveAppointment($appointmentEntity);

        if ($success) {
            $this->sendResponse(201, ["message" => "Cita guardada exitosamente."]);
        } else {
            $this->sendResponse(500, ["message" => "Error al guardar la cita."]);
        }
    }

    public function updateAppointment(AppointmentDto $appointment): void
    {
        $appointmentEntity = $this->mapDtoToEntity($appointment);
        $success = $this->appointmentService->updateAppointment($appointmentEntity);

        if ($success) {
            $this->sendResponse(200, ["message" => "Cita actualizada exitosamente."]);
        } else {
            $this->sendResponse(500, ["message" => "Error al actualizar la cita."]);
        }
    }

    public function deleteAppointment(int $id): void
    {
        $success = $this->appointmentService->deleteAppointment($id);

        if ($success) {
            $this->sendResponse(200, ["message" => "Cita eliminada exitosamente."]);
        } else {
            $this->sendResponse(500, ["message" => "Error al eliminar la cita."]);
        }
    }

    public function findAllAppointments(): void
    {
        $appointmentEntities = $this->appointmentService->findAllAppointments();

        $appointmentDtos = array_map([$this, 'mapResultEntityToDto'], $appointmentEntities);

        $this->sendResponse(200, $appointmentDtos);
    }

    private function mapEntityToDto(AppointmentEntity $entity): array
    {
        $dto = new AppointmentDto();
        $dto->setId($entity->getId());
        $dto->setAppointmentDate($entity->getAppointmentDate());
        $dto->setName($entity->getName());
        $dto->setIdentification($entity->getIdentification());
        $dto->setSpecialtyId($entity->getSpecialtyId());

        return [
            'id' => $dto->getId(),
            'appointmentDate' => $dto->getAppointmentDate(),
            'name' => $dto->getName(),
            'identification' => $dto->getIdentification(),
            'specialtyId' => $dto->getSpecialtyId()
        ];
    }



    private function mapDtoToEntity(AppointmentDto $dto): AppointmentEntity
    {
        $entity = new AppointmentEntity();
        $entity->setId($dto->getId());
        $entity->setAppointmentDate($dto->getAppointmentDate());
        $entity->setName($dto->getName());
        $entity->setIdentification($dto->getIdentification());
        $entity->setSpecialtyId($dto->getSpecialtyId());



        return $entity;
    }

    private function mapResultEntityToDto(ResultAppointmentEntity $entity): array
    {
        $dto = new ResultAppointmentDto();
        $dto->setId($entity->getId());
        $dto->setAppointmentDate($entity->getAppointmentDate());
        $dto->setName($entity->getName());
        $dto->setIdentification($entity->getIdentification());
        $dto->setSpecialtyId($entity->getSpecialtyId());
        $dto->setSpecialty($entity->getSpecialty());

        return [
            'id' => $dto->getId(),
            'appointmentDate' => $dto->getAppointmentDate(),
            'name' => $dto->getName(),
            'identification' => $dto->getIdentification(),
            'specialtyId' => $dto->getSpecialtyId(),
            'specialty' => $dto->getSpecialty()
        ];
    }


    private function mapResultDtoToEntity(ResultAppointmentDto $dto): ResultAppointmentEntity
    {
        $entity = new ResultAppointmentEntity();
        $entity->setId($dto->getId());
        $entity->setAppointmentDate($dto->getAppointmentDate());
        $entity->setName($dto->getName());
        $entity->setIdentification($dto->getIdentification());
        $entity->setSpecialtyId($dto->getSpecialtyId());
        $entity->setSpecialty($dto->getSpecialty());

        return $entity;
    }

    private function sendResponse(int $statusCode, $data)
    {
        header("Content-Type: application/json");
        http_response_code($statusCode);
        echo json_encode($data);
    }
}
