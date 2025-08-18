<?php
require_once 'model/entity/AppointmentEntity.php';
require_once 'model/entity/ResultAppointmentEntity.php';

class AppointmentRepositoryImpl implements IAppointmentRepository
{
    public function saveAppointment(AppointmentEntity $appointment)
    {
        try {
            $conn = DBConnection::getConnection();

            $stmt = $conn->prepare("INSERT INTO tbl_adm_medical_appointment (identification, name, appointment_date, specialty_id) VALUES (:identification, :name, :appointment_date, :specialty_id)");
            $stmt->bindValue(':identification', $appointment->getIdentification(), PDO::PARAM_STR);
            $stmt->bindValue(':name', $appointment->getName(), PDO::PARAM_STR);
            $stmt->bindValue(':appointment_date', $appointment->getAppointmentDate(), PDO::PARAM_STR);
            $stmt->bindValue(':specialty_id', $appointment->getSpecialtyId(), PDO::PARAM_INT);

            return $stmt->execute();

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function updateAppointment(AppointmentEntity $appointment)
    {
        try {
            $conn = DBConnection::getConnection();

            $stmt = $conn->prepare("UPDATE tbl_adm_medical_appointment SET identification = :identification, name = :name, appointment_date = :appointment_date, specialty_id = :specialty_id WHERE id = :id");
            $stmt->bindValue(':identification', $appointment->getIdentification(), PDO::PARAM_STR);
            $stmt->bindValue(':name', $appointment->getName(), PDO::PARAM_STR);
            $stmt->bindValue(':appointment_date', $appointment->getAppointmentDate(), PDO::PARAM_STR);
            $stmt->bindValue(':specialty_id', $appointment->getSpecialtyId(), PDO::PARAM_INT);
            $stmt->bindValue(':id', $appointment->getId(), PDO::PARAM_INT);

            return $stmt->execute();

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function deleteAppointment(int $id)
    {
        try {
            $conn = DBConnection::getConnection();

            $stmt = $conn->prepare("DELETE FROM tbl_adm_medical_appointment WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function findAllAppointments()
    {
        try {
            $conn = DBConnection::getConnection();

            $stmt = $conn->prepare("SELECT appointment.id, 
                                                  appointment.identification, 
                                                  appointment.name, 
                                                  appointment.appointment_date, 
                                                  appointment.specialty_id, 
                                                  specialty.specialty
                                             FROM tbl_adm_medical_appointment appointment
                                             JOIN tbl_adm_patient patient on appointment.identification = patient.identification
                                             JOIN tbl_adm_specialty specialty on appointment.specialty_id = specialty.id");
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $appointments = [];


            foreach ($results as $row) {
                $appointment = new ResultAppointmentEntity();
                $appointment->setId((int) $row['id']);
                $appointment->setName($row['name']);
                $appointment->setIdentification($row['identification']);
                $appointment->setAppointmentDate($row['appointment_date']);
                $appointment->setSpecialtyId((int) $row['specialty_id']);
                $appointment->setSpecialty($row['specialty']);

                $appointments[] = $appointment;
            }

            return $appointments;

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }


    }
}