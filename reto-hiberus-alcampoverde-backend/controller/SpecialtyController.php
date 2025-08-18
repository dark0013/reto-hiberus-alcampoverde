<?php
require_once 'service/ISpecialtyService.php';
require_once 'model/dto/SpecialtyDto.php';
require_once 'model/entity/SpecialtyEntity.php';

class SpecialtyController
{
    private ISpecialtyService $service;

    public function __construct(ISpecialtyService $service)
    {
        $this->service = $service;
    }

    public function findSpecialtyById($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            $this->sendResponse(400, ["message" => "El ID de la especialidad no es válido."]);
            return;
        }

        $specialtyEntity = $this->service->findSpecialtyById((int) $id);

        if ($specialtyEntity) {
            $specialtyDto = $this->mapEntityToDto($specialtyEntity);
            $this->sendResponse(200, $specialtyDto);
        } else {
            $this->sendResponse(404, ["message" => "Especialidad no encontrada."]);
        }
    }

    public function findAllSpecialties()
    {
        $specialtyEntities = $this->service->findAllSpecialties();

        $specialtyDtos = array_map([$this, 'mapEntityToDto'], $specialtyEntities);

        $this->sendResponse(200, $specialtyDtos);
    }

    public function saveSpecialty(SpecialtyDto $specialty)
    {
        $specialtyEntity = $this->mapDtoToEntity($specialty);
        $success = $this->service->saveSpecialty($specialtyEntity);

        if ($success) {
            $this->sendResponse(201, ["message" => "Especialidad guardada exitosamente."]);
        } else {
            $this->sendResponse(500, ["message" => "Error al guardar la especialidad."]);
        }
    }

    public function updateSpecialty(SpecialtyDto $specialty)
    {
        $specialtyEntity = $this->mapDtoToEntity($specialty);
        $success = $this->service->updateSpecialty($specialtyEntity);

        if ($success) {

            $this->sendResponse(200, ["message" => "Especialidad actualizada exitosamente."]);
        } else {
            $this->sendResponse(500, ["message" => "Error al actualizar la especialidad."]);
        }
    }

    public function deleteSpecialty(int $id)
    {
        $success = $this->service->deleteSpecialty($id);

        if ($success) {
            $this->sendResponse(200, ["message" => "Especialidad eliminada exitosamente."]);
        } else {
            $this->sendResponse(500, ["message" => "Error al eliminar la especialidad."]);
        }
    }



    private function mapEntityToDto(SpecialtyEntity $entity): array
    {
        $dto = new SpecialtyDto();
        $dto->setId($entity->getId());
        $dto->setSpecialty($entity->getSpecialty());

        return [
            'id' => $dto->getId(),
            'specialty' => $dto->getSpecialty()
        ];
    }

    private function mapDtoToEntity(SpecialtyDto $dto): SpecialtyEntity
    {
        $entity = new SpecialtyEntity();
        $entity->setId($dto->getId());
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



