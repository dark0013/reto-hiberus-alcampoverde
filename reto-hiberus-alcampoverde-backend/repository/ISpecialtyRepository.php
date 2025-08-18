<?php
require_once 'model/entity/SpecialtyEntity.php';

interface ISpecialtyRepository
{
    function findSpecialtyById($id);
    function findAllSpecialties();
    function saveSpecialty(SpecialtyEntity $specialty);
    function updateSpecialty(SpecialtyEntity $specialty);
    function deleteSpecialty(int $id);

}