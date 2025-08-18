<?php
require_once 'core/DBConnection.php';
require_once 'repository/IPatientRepository.php';
require_once 'model/entity/PatientEntity.php';

class PatientRepositoryImpl implements IPatientRepository
{
    public function findPatientById($id): ?PatientEntity
    {
        try {
            $conn = DBConnection::getConnection();

            $stmt = $conn->prepare("SELECT * FROM tbl_adm_patient WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $patient = new PatientEntity();
                $patient->setId((int) $result['id']);
                $patient->setName($result['name']);
                $patient->setAge((int) $result['age']);
                $patient->setIdentification($result['identification']);

                return $patient;
            } else {
                return null;
            }

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function findAllPatient(): array
    {
        try {
            $conn = DBConnection::getConnection();

            $stmt = $conn->prepare("SELECT id, name, age, identification FROM tbl_adm_patient");
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $patients = [];


            foreach ($results as $row) {
                $patient = new PatientEntity();
                $patient->setId((int) $row['id']);
                $patient->setName($row['name']);
                
                $patient->setAge((int) $row['age']);
                $patient->setIdentification($row['identification']);

                $patients[] = $patient;
            }

            return $patients;

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }


    public function savePatient(PatientEntity $patient): bool
    {
        try {
            $conn = DBConnection::getConnection();

            $stmt = $conn->prepare("INSERT INTO tbl_adm_patient (name, age, identification) VALUES (:name, :age, :identification)");
            $stmt->bindValue(':name', $patient->getName(), PDO::PARAM_STR);
            $stmt->bindValue(':age', $patient->getAge(), PDO::PARAM_INT);
            $stmt->bindValue(':identification', $patient->getIdentification(), PDO::PARAM_STR);

            return $stmt->execute();

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function updatePatient(PatientEntity $patient): bool
    {
        try {
            $conn = DBConnection::getConnection();

            $stmt = $conn->prepare("UPDATE tbl_adm_patient SET name = :name, age = :age, identification = :identification WHERE id = :id");
            $stmt->bindValue(':name', $patient->getName(), PDO::PARAM_STR);
            $stmt->bindValue(':age', $patient->getAge(), PDO::PARAM_INT);
            $stmt->bindValue(':identification', $patient->getIdentification(), PDO::PARAM_STR);
            $stmt->bindValue(':id', $patient->getId(), PDO::PARAM_INT);

            return $stmt->execute();

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function deletePatient(int $id): bool
    {
        try {
            $conn = DBConnection::getConnection();

            $stmt = $conn->prepare("DELETE FROM tbl_adm_patient WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
