<?php

require_once("../controlador/conexion_db.php");
/** @var $conn \PDO */
try{




    $queryString = "SELECT C.idComentario AS idComentario, U.ID AS UsuarioID, C.Comentario, C.fechaPublicacion, U.nombre, U.email
    FROM comentarios AS C
    INNER JOIN usuario AS U ON C.UsuarioID = U.id";
    $objQuery = $conn->prepare($queryString);
    $objQuery->execute();
    $comentariosxd = $objQuery->fetchAll(\PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    if (empty($comentariosxd)) {
        http_response_code(404);
        $response = [
            'status' => 404,
            'message' => 'No se encontraron resultados',
        ];
        echo json_encode($response);
        die();
    }

    http_response_code(200);
    echo json_encode($comentariosxd);
    die();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error interno del servidor: ' . $e->getMessage()]);
}

?>