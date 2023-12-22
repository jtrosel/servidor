<?php
require('../../resources/conexion.php');

/**
 * @var string Metodo de conexion recibido en el servidor
 */
$method = $_SERVER['REQUEST_METHOD']; // GET | POST | PUT | DELETE

/**
 * @var array Array de respuesta del servidor
 */
$response = [];

/**
 * @var array Array de errores
 */
$errors = [];
switch ($method) {
    case 'GET':
        // Solicitudes GET para obtener informacion
        $query = "SELECT * FROM users WHERE status_id = 1";
        if ($result = mysqli_query($mysqli, $query)) {
            if (mysqli_num_rows($result) > 0) {

                while ($datos = mysqli_fetch_array($result)) {
                    $data[] = $datos;
                }

                $response['status'] = true;
                $response['message'] = 'Se han encontrado usuarios';
                $response['data'] = $data;
            } else {
                $response['status'] = false;
                $response['message'] = 'No hay usuarios';
                echo json_encode($response, JSON_UNESCAPED_UNICODE);
                http_response_code(204);
                return;
            }
        } else {
            $errors[] = 'No se logro conectar a la BD';
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            http_response_code(500);
            return;
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        return;
    case 'POST':
        // Solicitudes POST para recibir informacion

        /**
         * Validaciones
         */
        if (isset($_POST['first_name'])) {
            $first_name = mysqli_real_escape_string($mysqli, $_POST['first_name']);
        } else {
            $errors[] = 'El campo primer nombre es obligatorio';
        }
        if (isset($_POST['middle_name'])) {
            $middle_name = mysqli_real_escape_string($mysqli, $_POST['middle_name']);
        } else {
            $errors[] = 'El campo segundo nombre es obligatorio';
        }
        if (isset($_POST['lastname'])) {
            $lastname = mysqli_real_escape_string($mysqli, $_POST['lastname']);
        } else {
            $errors[] = 'El campo primer apellido es obligatorio';
        }
        if (isset($_POST['second_lastname'])) {
            $second_lastname = mysqli_real_escape_string($mysqli, $_POST['second_lastname']);
        } else {
            $errors[] = 'El campo segundo apellido es obligatorio';
        }
        if (isset($_POST['document'])) {
            $document = mysqli_real_escape_string($mysqli, $_POST['document']);
        } else {
            $errors[] = 'El campo cedula es obligatorio';
        }

        /**
         * Si existen errores entonces se devuelven los errores y codigo 400
         */
        if (sizeof($errors) > 0) {
            $response['status'] = false;
            $response['codeNumber'] = false;
            $response['errors'] = $errors;
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            http_response_code(400);
            return;
        }

        /**
         * Query para crear un nuevo user
         */
        $query = "INSERT INTO users (id, first_name, middle_name, lastname, second_lastname, document, status_id) 
                    VALUES (NULL, '$first_name', '$middle_name', '$lastname', '$second_lastname', '$document', 1)";

        // SI se logra insertar el registro, el mensaje sera exitoso
        if (mysqli_query($mysqli, $query)) {
            $response['status'] = true;
            $response['message'] = 'Se ha registrado el usuario exitosamente';
        } else {
            $errors[] = 'No se logro registrar el usuario';
            $response['status'] = false;
            $response['errors'] = $errors;
        }

        // Siempre se va a ejecutar
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        return;
    default:
        // Metodo invalido 405
        http_response_code(405);
        return;
}
