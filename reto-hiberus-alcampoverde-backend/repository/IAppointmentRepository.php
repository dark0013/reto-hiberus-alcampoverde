<?php

interface IAppointmentRepository
{
    function saveAppointment(AppointmentEntity $appointment);
    function updateAppointment(AppointmentEntity $appointment);
    function deleteAppointment(int $id);
    function findAllAppointments();
}

