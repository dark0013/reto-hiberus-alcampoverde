        const API_URL = 'http://localhost/reto-hiberus-alcampoverde-backend/appointments';
        const SPECIALTIES_URL = 'http://localhost/reto-hiberus-alcampoverde-backend/specialties';

        document.addEventListener('DOMContentLoaded', () => {
            cargarEspecialidades();
            obtenerCitas();
        });
        
        async function cargarEspecialidades() {
            try {
                const response = await fetch(SPECIALTIES_URL);
                if (!response.ok) {
                    throw new Error(`Error HTTP ${response.status} al cargar especialidades.`);
                }
                const especialidades = await response.json();
                
                const selectFormulario = document.getElementById('specialtyId');
                const selectModal = document.getElementById('modalSpecialtyId');

                selectFormulario.innerHTML = '<option value="">Seleccione una especialidad</option>';
                selectModal.innerHTML = ''; 

                especialidades.forEach(esp => {
                    const option = document.createElement('option');
                    option.value = esp.id;
                    option.textContent = esp.specialty;
                    selectFormulario.appendChild(option);
                    selectModal.appendChild(option.cloneNode(true));
                });

            } catch (error) {
                console.error('Error al cargar especialidades:', error);
                alert('No se pudieron cargar las especialidades. Asegúrese de que el servidor API esté funcionando y que la configuración de CORS sea correcta.');
            }
        }
        
       

        function validarFormularioPrincipal() {
            let isValid = true;
            limpiarErrores(['identificationError', 'nameError', 'appointmentDateError', 'specialtyIdError']);
            
            const identification = document.getElementById('identification').value.trim();
            if (!identification) { isValid = false; mostrarError('identificationError', 'La identificación es requerida.'); }
            else if (!/^[0-9]+$/.test(identification)) { isValid = false; mostrarError('identificationError', 'Debe contener solo números.'); }
            
            const name = document.getElementById('name').value.trim();
            if (!name) { isValid = false; mostrarError('nameError', 'El nombre es requerido.'); }

            const appointmentDate = document.getElementById('appointmentDate').value;
            if (!appointmentDate) { isValid = false; mostrarError('appointmentDateError', 'La fecha es requerida.'); }
            else {
                const today = new Date(); today.setHours(0, 0, 0, 0);
                const selectedDate = new Date(appointmentDate + 'T00:00:00');
                if (selectedDate < today) { isValid = false; mostrarError('appointmentDateError', 'La fecha no puede ser anterior a hoy.'); }
            }

            const specialtyId = document.getElementById('specialtyId').value;
            if (!specialtyId) { isValid = false; mostrarError('specialtyIdError', 'Debe seleccionar una especialidad.'); }

            return isValid;
        }

        function validarFormularioModal() {
            let isValid = true;
            limpiarErrores(['modalIdentificationError', 'modalNameError', 'modalAppointmentDateError', 'modalSpecialtyIdError']);

            const identification = document.getElementById('modalIdentification').value.trim();
            if (!identification) { isValid = false; mostrarError('modalIdentificationError', 'La identificación es requerida.'); }
            else if (!/^[0-9]+$/.test(identification)) { isValid = false; mostrarError('modalIdentificationError', 'Debe contener solo números.'); }

            const name = document.getElementById('modalName').value.trim();
            if (!name) { isValid = false; mostrarError('modalNameError', 'El nombre es requerido.'); }

            const appointmentDate = document.getElementById('modalAppointmentDate').value;
            if (!appointmentDate) { isValid = false; mostrarError('modalAppointmentDateError', 'La fecha es requerida.'); }
            else {
                const today = new Date(); today.setHours(0, 0, 0, 0);
                const selectedDate = new Date(appointmentDate + 'T00:00:00');
                if (selectedDate < today) { isValid = false; mostrarError('modalAppointmentDateError', 'La fecha no puede ser anterior a hoy.'); }
            }

            const specialtyId = document.getElementById('modalSpecialtyId').value;
            if (!specialtyId) { isValid = false; mostrarError('modalSpecialtyIdError', 'Debe seleccionar una especialidad.'); }

            return isValid;
        }

        function mostrarError(id, mensaje) { document.getElementById(id).textContent = mensaje; }
        function limpiarErrores(ids) { ids.forEach(id => mostrarError(id, '')); }

        async function obtenerCitas() {
            try {
                const response = await fetch(API_URL);
                if (!response.ok) throw new Error(`Error HTTP ${response.status}`);
                const citas = await response.json();
                mostrarCitasEnTabla(citas);
            } catch (error) {
                console.error('Error al obtener las citas:', error);
            }
        }

        function mostrarCitasEnTabla(citas) {
            const tableBody = document.querySelector('#appointmentsTable tbody');
            tableBody.innerHTML = ''; 
            citas.forEach(cita => {
                const row = tableBody.insertRow();
                row.insertCell().textContent = cita.id;
                row.insertCell().textContent = new Date(cita.appointmentDate).toLocaleDateString('es-ES');
                row.insertCell().textContent = cita.name;
                row.insertCell().textContent = cita.identification;
                row.insertCell().textContent = cita.specialty; 

                const accionesCell = row.insertCell();
                const verButton = document.createElement('button');
                verButton.innerHTML = '<i class="bi bi-eye"></i> Ver';
                verButton.className = 'btn btn-sm btn-info';
                verButton.addEventListener('click', () => mostrarModalDetalles(cita));
                accionesCell.appendChild(verButton);
            });
        }

        function mostrarModalDetalles(cita) {
            document.getElementById('modalAppointmentId').value = cita.id;
            document.getElementById('modalIdentification').value = cita.identification;
            document.getElementById('modalName').value = cita.name;
            document.getElementById('modalAppointmentDate').value = cita.appointmentDate.split(' ')[0];
            document.getElementById('modalSpecialtyId').value = cita.specialtyId;
            limpiarErrores(['modalIdentificationError', 'modalNameError', 'modalAppointmentDateError', 'modalSpecialtyIdError']);
            const modal = new bootstrap.Modal(document.getElementById('appointmentModal'));
            modal.show();
        }

        document.getElementById('appointmentForm').addEventListener('submit', async function (event) {
            event.preventDefault();
            if (!validarFormularioPrincipal()) return;

            const formData = {
                identification: document.getElementById('identification').value,
                name: document.getElementById('name').value,
                appointment_date: document.getElementById('appointmentDate').value,
                specialtyId: document.getElementById('specialtyId').value
            };

            try {
                const response = await fetch(API_URL, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(formData)
                });
                if (!response.ok) throw new Error(`Error del servidor: ${response.status}`);
                alert('Cita agendada correctamente.');
                this.reset();
                obtenerCitas();
            } catch (error) {
                console.error('Error al agendar la cita:', error);
                alert('Error al agendar la cita. Verifique la consola.');
            }
        });

        document.getElementById('updateAppointment').addEventListener('click', async () => {
            if (!validarFormularioModal()) return;

            const citaActualizada = {
                id: parseInt(document.getElementById('modalAppointmentId').value),
                identification: document.getElementById('modalIdentification').value.trim(),
                name: document.getElementById('modalName').value.trim(),
                appointment_date: document.getElementById('modalAppointmentDate').value,
                specialtyId: document.getElementById('modalSpecialtyId').value
            };

            try {
                const response = await fetch(API_URL, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(citaActualizada)
                });
                if (!response.ok) throw new Error(`Error del servidor: ${response.status}`);
                alert('Cita actualizada correctamente.');
                bootstrap.Modal.getInstance(document.getElementById('appointmentModal')).hide();
                obtenerCitas();
            } catch (error) {
                console.error('Error al actualizar la cita:', error);
                alert('Error al actualizar la cita. Verifique la consola.');
            }
        });

        document.getElementById('deleteAppointment').addEventListener('click', async () => {
            const id = document.getElementById('modalAppointmentId').value;
            if (!id || !confirm('¿Está seguro de que desea eliminar esta cita?')) return;
            
            try {
                const response = await fetch(`${API_URL}/${id}`, { method: 'DELETE' });
                if (!response.ok) throw new Error(`Error del servidor: ${response.status}`);
                alert('Cita eliminada correctamente.');
                bootstrap.Modal.getInstance(document.getElementById('appointmentModal')).hide();
                obtenerCitas();
            } catch (error) {
                console.error('Error al eliminar la cita:', error);
                alert('Error al eliminar la cita. Verifique la consola.');
            }
        });