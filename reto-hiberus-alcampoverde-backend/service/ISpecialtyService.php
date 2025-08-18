<?php
require_once 'model/entity/SpecialtyEntity.php';

interface ISpecialtyService
{
    function findSpecialtyById($id);
    function findAllSpecialties();
    function saveSpecialty(SpecialtyEntity $specialty);
    function updateSpecialty(SpecialtyEntity $specialty);
    function deleteSpecialty(int $id);
}