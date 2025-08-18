<?php
require_once 'core/DBConnection.php';
require_once 'repository/ISpecialtyRepository.php';
require_once 'model/entity/SpecialtyEntity.php';

class SpecialtyRepositoryImpl implements ISpecialtyRepository
{
    public function findSpecialtyById($id): ?SpecialtyEntity
    {
        try {
            $conn = DBConnection::getConnection();

            $stmt = $conn->prepare("SELECT * FROM tbl_adm_specialty WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $specialty = new SpecialtyEntity();
                $specialty->setId((int) $result['id']);
                $specialty->setSpecialty($result['specialty']);

                return $specialty;
            } else {
                return null;
            }

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function findAllSpecialties(): array
    {
        try {
            $conn = DBConnection::getConnection();

            $stmt = $conn->prepare("SELECT id, specialty FROM tbl_adm_specialty");
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $specialties = [];


            foreach ($results as $row) {
                $specialty = new SpecialtyEntity();
                $specialty->setId((int) $row['id']);
                $specialty->setSpecialty($row['specialty']);

                $specialties[] = $specialty;
            }

            return $specialties;

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }


    }


    public function saveSpecialty(SpecialtyEntity $specialty)
    {
        try {
            $conn = DBConnection::getConnection();

            $stmt = $conn->prepare("INSERT INTO tbl_adm_specialty (specialty) VALUES (:specialty)");
            $stmt->bindValue(':specialty', $specialty->getSpecialty(), PDO::PARAM_STR);

            return $stmt->execute();

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function updateSpecialty(SpecialtyEntity $specialty)
    {
        try {
            $conn = DBConnection::getConnection();

            $stmt = $conn->prepare("UPDATE tbl_adm_specialty SET specialty = :specialty WHERE id = :id");
            $stmt->bindValue(':specialty', $specialty->getSpecialty(), PDO::PARAM_STR);
            $stmt->bindValue(':id', $specialty->getId(), PDO::PARAM_INT);

            return $stmt->execute();

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function deleteSpecialty(int $id)
    {
        try {
            $conn = DBConnection::getConnection();

            $stmt = $conn->prepare("DELETE FROM tbl_adm_specialty WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
