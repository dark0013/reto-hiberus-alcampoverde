
        const PATIENTS_API_URL = 'http://localhost/reto-hiberus-alcampoverde-backend/patients';

        document.addEventListener('DOMContentLoaded', () => {
            obtenerPacientes();
        });

    

        function validarFormularioPrincipal() {
            let isValid = true;
            limpiarErrores(['identificationError', 'nameError', 'ageError']);

            const identification = document.getElementById('identification').value.trim();
            if (!identification) { isValid = false; mostrarError('identificationError', 'La identificación es requerida.'); }
            else if (!/^[0-9]+$/.test(identification)) { isValid = false; mostrarError('identificationError', 'Debe contener solo números.'); }

            const name = document.getElementById('name').value.trim();
            if (!name) { isValid = false; mostrarError('nameError', 'El nombre es requerido.'); }

            const age = document.getElementById('age').value.trim();
            if (!age) { isValid = false; mostrarError('ageError', 'La edad es requerida.'); }
            else if (!/^[0-9]+$/.test(age) || parseInt(age) < 0) { isValid = false; mostrarError('ageError', 'La edad debe ser un número válido.'); }

            return isValid;
        }

        function validarFormularioModal() {
            let isValid = true;
            limpiarErrores(['modalIdentificationError', 'modalNameError', 'modalAgeError']);

            const identification = document.getElementById('modalIdentification').value.trim();
            if (!identification) { isValid = false; mostrarError('modalIdentificationError', 'La identificación es requerida.'); }
            else if (!/^[0-9]+$/.test(identification)) { isValid = false; mostrarError('modalIdentificationError', 'Debe contener solo números.'); }

            const name = document.getElementById('modalName').value.trim();
            if (!name) { isValid = false; mostrarError('modalNameError', 'El nombre es requerido.'); }

            const age = document.getElementById('modalAge').value.trim();
            if (!age) { isValid = false; mostrarError('modalAgeError', 'La edad es requerida.'); }
            else if (!/^[0-9]+$/.test(age) || parseInt(age) < 0) { isValid = false; mostrarError('modalAgeError', 'La edad debe ser un número válido.'); }

            return isValid;
        }

        function mostrarError(id, mensaje) { document.getElementById(id).textContent = mensaje; }
        function limpiarErrores(ids) { ids.forEach(id => mostrarError(id, '')); }

      
        async function obtenerPacientes() {
            try {
                const response = await fetch(PATIENTS_API_URL);
                if (!response.ok) throw new Error(`Error HTTP ${response.status}`);
                const pacientes = await response.json();
                mostrarPacientesEnTabla(pacientes);
            } catch (error) {
                console.error('Error al obtener los pacientes:', error);
                alert('No se pudieron obtener los pacientes. Verifique la consola.');
            }
        }

        function mostrarPacientesEnTabla(pacientes) {
            const tableBody = document.querySelector('#patientsTable tbody');
            tableBody.innerHTML = '';
            pacientes.forEach(paciente => {
                const row = tableBody.insertRow();
                row.insertCell().textContent = paciente.id;
                row.insertCell().textContent = paciente.name;
                row.insertCell().textContent = paciente.identification;
                row.insertCell().textContent = paciente.age;

                const accionesCell = row.insertCell();
                const verButton = document.createElement('button');
                verButton.innerHTML = '<i class="bi bi-eye"></i> Ver';
                verButton.className = 'btn btn-sm btn-info';
                verButton.addEventListener('click', () => mostrarModalDetalles(paciente));
                accionesCell.appendChild(verButton);
            });
        }

        function mostrarModalDetalles(paciente) {
            document.getElementById('modalPatientId').value = paciente.id;
            document.getElementById('modalIdentification').value = paciente.identification;
            document.getElementById('modalName').value = paciente.name;
            document.getElementById('modalAge').value = paciente.age;
            limpiarErrores(['modalIdentificationError', 'modalNameError', 'modalAgeError']);
            const modal = new bootstrap.Modal(document.getElementById('patientModal'));
            modal.show();
        }

       
        document.getElementById('patientForm').addEventListener('submit', async function (event) {
            event.preventDefault();
            if (!validarFormularioPrincipal()) return;

            const formData = {
                identification: document.getElementById('identification').value,
                name: document.getElementById('name').value,
                age: parseInt(document.getElementById('age').value)
            };

            try {
                const response = await fetch(PATIENTS_API_URL, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(formData)
                });
                if (!response.ok) throw new Error(`Error del servidor: ${response.status}`);
                alert('Paciente registrado correctamente.');
                this.reset();
                obtenerPacientes();
            } catch (error) {
                console.error('Error al registrar al paciente:', error);
                alert('Error al registrar al paciente. Verifique la consola.');
            }
        });

      
        document.getElementById('updatePatient').addEventListener('click', async () => {
            if (!validarFormularioModal()) return;

            const pacienteActualizado = {
                id: parseInt(document.getElementById('modalPatientId').value),
                identification: document.getElementById('modalIdentification').value.trim(),
                name: document.getElementById('modalName').value.trim(),
                age: parseInt(document.getElementById('modalAge').value)
            };

            try {
                const response = await fetch(PATIENTS_API_URL, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(pacienteActualizado)
                });
                if (!response.ok) throw new Error(`Error del servidor: ${response.status}`);
                alert('Paciente actualizado correctamente.');
                bootstrap.Modal.getInstance(document.getElementById('patientModal')).hide();
                obtenerPacientes();
            } catch (error) {
                console.error('Error al actualizar al paciente:', error);
                alert('Error al actualizar al paciente. Verifique la consola.');
            }
        });

        
        document.getElementById('deletePatient').addEventListener('click', async () => {
            const id = document.getElementById('modalPatientId').value;
            if (!id || !confirm('¿Está seguro de que desea eliminar a este paciente?')) return;

            try {
                const response = await fetch(`${PATIENTS_API_URL}/${id}`, { method: 'DELETE' });
                if (!response.ok) throw new Error(`Error del servidor: ${response.status}`);
                alert('Paciente eliminado correctamente.');
                bootstrap.Modal.getInstance(document.getElementById('patientModal')).hide();
                obtenerPacientes();
            } catch (error) {
                console.error('Error al eliminar al paciente:', error);
                alert('Error al eliminar al paciente. Verifique la consola.');
            }
        });