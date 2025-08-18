<?php
require_once 'model/entity/PatientEntity.php';

interface IPatientService
{
    function findPatientById($id): ?PatientEntity;
    function findAllPatient(): array;
    function savePatient(PatientEntity $patient);
    function updatePatient(PatientEntity $patient);
    function deletePatient(int $id);
}