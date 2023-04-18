<?php
require_once('api/entities/dto/usuario.php');

if (isset($_GET['action'])) {
    session_start();
    $usuario = new Usuario;
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;
        switch ($_GET['action']) {
            case 'getUser':
                if (isset($_SESSION['alias_usuario'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['alias_usuario'];
                } else {
                    $result['exception'] = 'Alias de usuario indefinido';
                }
                break;
            case 'logOut':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión eliminada correctamente';
                } else {
                    $result['exception'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;
            case 'readProfile':
                if ($result['dataset'] = $usuario->readProfile()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
            case 'editProfile':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setNombre($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$usuario->setApellido($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$usuario->setAlias($_POST['alias'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif ($usuario->editProfile()) {
                    $result['status'] = 1;
                    $_SESSION['alias_usuario'] = $usuario->getAlias();
                    $result['message'] = 'Perfil modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $usuario->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' coincidencias';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setNombre($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$usuario->setApellido($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$usuario->setAlias($_POST['alias'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif (!$usuario->setTipo_usuario($_POST['tipo_usuario'])) {
                    $result['exception'] = 'Estado invalido';
                } elseif (!$usuario->setEstado_usuario($_POST['Estado_usuario'])) {
                    $result['exception'] = 'Estado invalido';    
                } elseif ($usuario->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$usuario->setId($_POST['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($result['dataset'] = $usuario->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setId($_POST['id'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif (!$usuario->setNombre($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$usuario->setApellido($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$usuario->setEstado_usuario($_POST['Estado_usuario'])) {
                    $result['exception'] = 'Estado Invalido';
                } elseif (!$usuario->setTipo_usuario($_POST['Tipo_usuario'])) {
                    $result['exception'] = 'Estado Invalido';    
                } elseif ($usuario->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario modificado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if ($_POST['id_usuario'] == $_SESSION['id_usuario']) {
                    $result['exception'] = 'No se puede eliminar a sí mismo';
                } elseif (!$usuario->setId($_POST['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$usuario->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif ($usuario->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario eliminado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el administrador no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readUsers':
                if ($usuario->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Debe autenticarse para ingresar';
                } else {
                    $result['exception'] = 'Debe crear un usuario para comenzar';
                }
                break;
            case 'signup':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->setNombre($_POST['nombres'])) {
                    $result['exception'] = 'Nombres incorrectos';
                } elseif (!$usuario->setApellido($_POST['apellidos'])) {
                    $result['exception'] = 'Apellidos incorrectos';
                } elseif (!$usuario->setCorreo($_POST['correo'])) {
                    $result['exception'] = 'Correo incorrecto';
                } elseif (!$usuario->setAlias($_POST['usuario'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif (!$usuario->setTipo_usuario($_POST['tipo_usuario'])) {
                    $result['exception'] = 'Estado invalido';
                } elseif (!$usuario->setEstado_usuario($_POST['estado_usuario'])) {
                    $result['exception'] = 'Estado invalido';    
                } elseif ($usuario->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario registrado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'login':
                $_POST = Validator::validateForm($_POST);
                if (!$usuario->checkUser($_POST['alias'])) {
                    $result['exception'] = 'Alias incorrecto';
                } elseif ($usuario->checkPassword($_POST['clave'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                    $_SESSION['id_usuario'] = $usuario->getId();
                    $_SESSION['alias_usuario'] = $usuario->getAlias();
                } else {
                    $result['exception'] = 'Clave incorrecta';
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible fuera de la sesión';
        }
    }
    header('content-type: application/json; charset=utf-8');
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
