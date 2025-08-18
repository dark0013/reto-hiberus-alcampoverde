 const SPECIALTIES_API_URL = 'http://localhost/reto-hiberus-alcampoverde/specialties';

        document.addEventListener('DOMContentLoaded', () => {
            obtenerEspecialidades();
        });

      

        function validarFormularioPrincipal() {
            let isValid = true;
            limpiarErrores(['specialtyNameError']);

            const specialtyName = document.getElementById('specialtyName').value.trim();
            if (!specialtyName) {
                isValid = false;
                mostrarError('specialtyNameError', 'El nombre de la especialidad es requerido.');
            }
            return isValid;
        }

        function validarFormularioModal() {
            let isValid = true;
            limpiarErrores(['modalSpecialtyNameError']);

            const specialtyName = document.getElementById('modalSpecialtyName').value.trim();
            if (!specialtyName) {
                isValid = false;
                mostrarError('modalSpecialtyNameError', 'El nombre de la especialidad es requerido.');
            }
            return isValid;
        }

        function mostrarError(id, mensaje) { document.getElementById(id).textContent = mensaje; }
        function limpiarErrores(ids) { ids.forEach(id => mostrarError(id, '')); }

       
        async function obtenerEspecialidades() {
            try {
                const response = await fetch(SPECIALTIES_API_URL);
                if (!response.ok) throw new Error(`Error HTTP ${response.status}`);
                const especialidades = await response.json();
                mostrarEspecialidadesEnTabla(especialidades);
            } catch (error) {
                console.error('Error al obtener las especialidades:', error);
                alert('No se pudieron obtener las especialidades. Verifique la consola.');
            }
        }

        function mostrarEspecialidadesEnTabla(especialidades) {
            const tableBody = document.querySelector('#specialtiesTable tbody');
            tableBody.innerHTML = '';
            especialidades.forEach(esp => {
                const row = tableBody.insertRow();
                row.insertCell().textContent = esp.id;
                row.insertCell().textContent = esp.specialty;

                const accionesCell = row.insertCell();
                const verButton = document.createElement('button');
                verButton.innerHTML = '<i class="bi bi-eye"></i>  Ver';
                verButton.className = 'btn btn-sm btn-info';
                verButton.addEventListener('click', () => mostrarModalDetalles(esp));
                accionesCell.appendChild(verButton);
            });
        }

        function mostrarModalDetalles(especialidad) {
            document.getElementById('modalSpecialtyId').value = especialidad.id;
            document.getElementById('modalSpecialtyName').value = especialidad.specialty;
            limpiarErrores(['modalSpecialtyNameError']);
            const modal = new bootstrap.Modal(document.getElementById('specialtyModal'));
            modal.show();
        }

       
        document.getElementById('specialtyForm').addEventListener('submit', async function (event) {
            event.preventDefault();
            if (!validarFormularioPrincipal()) return;

            const formData = {
                specialty: document.getElementById('specialtyName').value.trim()
            };

            try {
                const response = await fetch(SPECIALTIES_API_URL, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(formData)
                });
                if (!response.ok) throw new Error(`Error del servidor: ${response.status}`);
                alert('Especialidad registrada correctamente.');
                this.reset();
                obtenerEspecialidades();
            } catch (error) {
                console.error('Error al registrar la especialidad:', error);
                alert('Error al registrar la especialidad. Verifique la consola.');
            }
        });

   
        document.getElementById('updateSpecialty').addEventListener('click', async () => {
            if (!validarFormularioModal()) return;

            const especialidadActualizada = {
                id: parseInt(document.getElementById('modalSpecialtyId').value),
                specialty: document.getElementById('modalSpecialtyName').value.trim()
            };

            try {
                const response = await fetch(SPECIALTIES_API_URL, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(especialidadActualizada)
                });
                if (!response.ok) throw new Error(`Error del servidor: ${response.status}`);
                alert('Especialidad actualizada correctamente.');
                bootstrap.Modal.getInstance(document.getElementById('specialtyModal')).hide();
                obtenerEspecialidades();
            } catch (error) {
                console.error('Error al actualizar la especialidad:', error);
                alert('Error al actualizar la especialidad. Verifique la consola.');
            }
        });

       
        document.getElementById('deleteSpecialty').addEventListener('click', async () => {
            const id = document.getElementById('modalSpecialtyId').value;
            if (!id || !confirm('¿Está seguro de que desea eliminar esta especialidad?')) return;

            try {
                const response = await fetch(`${SPECIALTIES_API_URL}/${id}`, { method: 'DELETE' });
                if (!response.ok) throw new Error(`Error del servidor: ${response.status}`);
                alert('Especialidad eliminada correctamente.');
                bootstrap.Modal.getInstance(document.getElementById('specialtyModal')).hide();
                obtenerEspecialidades();
            } catch (error) {
                console.error('Error al eliminar la especialidad:', error);
                alert('Error al eliminar la especialidad. Verifique la consola.');
            }
        });