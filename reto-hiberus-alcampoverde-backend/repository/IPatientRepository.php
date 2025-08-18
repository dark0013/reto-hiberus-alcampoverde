<?php
require_once 'model/entity/PatientEntity.php';

interface IPatientRepository
{
    function findPatientById($id);
    function findAllPatient();
    function savePatient(PatientEntity $patient);
    function updatePatient(PatientEntity $patient);
    function deletePatient(int $id);

}