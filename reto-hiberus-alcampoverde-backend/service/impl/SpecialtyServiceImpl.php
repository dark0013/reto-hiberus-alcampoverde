<?php
class SpecialtyServiceImpl implements ISpecialtyService
{
    private ISpecialtyRepository $repository;
    public function __construct(ISpecialtyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findSpecialtyById($id)
    {
        return $this->repository->findSpecialtyById($id);
    }

    public function findAllSpecialties()
    {
        return $this->repository->findAllSpecialties();
    }

    public function saveSpecialty(SpecialtyEntity $specialty)
    {
        return $this->repository->saveSpecialty($specialty);
    }

    public function updateSpecialty(SpecialtyEntity $specialty)
    {
        return $this->repository->updateSpecialty($specialty);
    }

    public function deleteSpecialty(int $id)
    {
        return $this->repository->deleteSpecialty($id);
    }

}