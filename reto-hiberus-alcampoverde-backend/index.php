<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/repository/IPatientRepository.php';
require_once __DIR__ . '/repository/impl/PatientRepositoryImpl.php';
require_once __DIR__ . '/service/IPatientService.php';
require_once __DIR__ . '/service/impl/PatientServiceImpl.php';
require_once __DIR__ . '/controller/PatientController.php';
require_once __DIR__ . '/model/dto/PatientDto.php';
require_once __DIR__ . '/model/entity/PatientEntity.php';

require_once __DIR__ . '/model/dto/SpecialtyDto.php';
require_once __DIR__ . '/model/entity/SpecialtyEntity.php';
require_once __DIR__ . '/repository/ISpecialtyRepository.php';
require_once __DIR__ . '/repository/impl/SpecialtyRepositoryImpl.php';
require_once __DIR__ . '/service/ISpecialtyService.php';
require_once __DIR__ . '/service/impl/SpecialtyServiceImpl.php';
require_once __DIR__ . '/controller/SpecialtyController.php';

require_once __DIR__ . '/model/dto/AppointmentDto.php';
require_once __DIR__ . '/model/entity/AppointmentEntity.php';
require_once __DIR__ . '/repository/IAppointmentRepository.php';
require_once __DIR__ . '/repository/impl/AppointmentRepositoryImpl.php';
require_once __DIR__ . '/service/IAppointmentService.php';
require_once __DIR__ . '/service/impl/AppointmentServiceImpl.php';
require_once __DIR__ . '/controller/AppointmentController.php';




$repository = new PatientRepositoryImpl();
$service = new PatientServiceImpl($repository);
$controller = new PatientController($service);

$specialtyRepository = new SpecialtyRepositoryImpl();
$specialtyService = new SpecialtyServiceImpl($specialtyRepository);
$specialtyController = new SpecialtyController($specialtyService);

$appointmentRepository = new AppointmentRepositoryImpl();
$appointmentService = new AppointmentServiceImpl($appointmentRepository);
$appointmentController = new AppointmentController($appointmentService);


$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = $_SERVER['SCRIPT_NAME'];

$basePath = dirname($scriptName);
if (strpos($requestUri, $basePath) === 0) {
    $route = substr($requestUri, strlen($basePath));
} else {
    $route = $requestUri;
}


$route = trim(parse_url($route, PHP_URL_PATH), '/');


$uriSegments = explode('/', $route);


$resource = $uriSegments[0] ?? null;
$id = $uriSegments[1] ?? null;

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($resource === 'patients') {
        if ($id) {
            $controller->getPatientById($id);
        } else {
            $controller->getAllPatients();
        }
    } elseif ($resource === 'specialties') {
        if ($id) {
            $specialtyController->findSpecialtyById($id);
        } else {

            $specialtyController->findAllSpecialties();
        }
    } elseif ($resource === 'appointments') {
        $appointmentController->findAllAppointments();
    } else {

        http_response_code(404);
        echo json_encode(['message' => 'Endpoint no encontrado.']);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($resource === 'patients') {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if ($data === null || !isset($data['name']) || !isset($data['age'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Datos inválidos o incompletos. Se requieren "name" y "age".']);
            exit();
        }

        $patientDto = new PatientDto();
        $patientDto->setName($data['name']);
        $patientDto->setAge((int) $data['age']);
        $patientDto->setIdentification($data['identification'] ?? '');

        $controller->savePatient($patientDto);
    } elseif ($resource === 'specialties') {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if ($data === null || !isset($data['specialty'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Datos inválidos o incompletos. Se requiere "specialty".']);
            exit();
        }

        $specialtyDto = new SpecialtyDto();
        $specialtyDto->setSpecialty($data['specialty']);

        $specialtyController->saveSpecialty($specialtyDto);
    } elseif ($resource === 'appointments') {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);


        if (
            $data === null
            || !isset($data['appointment_date'])
            || !isset($data['name'])
            || !isset($data['identification'])
            || !isset($data['specialtyId'])
        ) {

            http_response_code(400);
            echo json_encode([
                'message' => 'Datos inválidos o incompletos. Se requieren "appointment_date", "name", "identification" y "specialtyId".'
            ]);
            exit();
        }

        $appointmentDto = new AppointmentDto();
        $appointmentDto->setAppointmentDate($data['appointment_date']);
        $appointmentDto->setName($data['name']);
        $appointmentDto->setIdentification($data['identification']);
        $appointmentDto->setSpecialtyId((int) $data['specialtyId']);

        $appointmentController->saveAppointment($appointmentDto);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'Endpoint no encontrado.']);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    if ($resource === 'patients') {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        if ($data === null || !isset($data['id']) || !isset($data['name']) || !isset($data['age'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Datos inválidos o incompletos. Se requieren "id", "name" y "age".']);
            exit();
        }

        $patientDto = new PatientDto();
        $patientDto->setId((int) $data['id']);
        $patientDto->setName($data['name']);
        $patientDto->setAge((int) $data['age']);
        $patientDto->setIdentification($data['identification'] ?? '');

        $controller->updatePatient($patientDto);

    } elseif ($resource === 'specialties') {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if ($data === null || !isset($data['id']) || !isset($data['specialty'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Datos inválidos o incompletos. Se requieren "id" y "specialty".']);
            exit();
        }

        $specialtyDto = new SpecialtyDto();
        $specialtyDto->setId((int) $data['id']);
        $specialtyDto->setSpecialty($data['specialty']);

        $specialtyController->updateSpecialty($specialtyDto);
    } elseif ($resource === 'appointments') {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if ($data === null || !isset($data['id']) || !isset($data['appointment_date']) || !isset($data['name']) || !isset($data['identification']) || !isset($data['specialtyId'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Datos inválidos o incompletos. Se requieren "id", "appointment_date", "name", "identification" y "specialtyId".']);
            exit();
        }

        $appointmentDto = new AppointmentDto();
        $appointmentDto->setId((int) $data['id']);
        $appointmentDto->setAppointmentDate($data['appointment_date']);
        $appointmentDto->setName($data['name']);
        $appointmentDto->setIdentification($data['identification']);
        $appointmentDto->setSpecialtyId((int) $data['specialtyId']);

        $appointmentController->updateAppointment($appointmentDto);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'Endpoint no encontrado.']);
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if ($resource === 'patients') {
        $controller->deletePatient($id);
    } elseif ($resource === 'specialties') {
        $specialtyController->deleteSpecialty($id);
    } elseif ($resource === 'appointments') {
        $appointmentController->deleteAppointment($id);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'Endpoint no encontrado.']);
    }
} else {

    http_response_code(405);
    echo json_encode(['message' => 'Método no permitido.']);
}
