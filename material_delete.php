<?php
// Incluir a conexão com o banco de dados
include 'db_conect.php';

// Cabeçalhos para permitir requisições externas e resposta em JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE');

// Definindo constantes para os códigos HTTP
define('HTTP_OK', 200);
define('HTTP_NOT_FOUND', 404);
define('HTTP_BAD_REQUEST', 400);
define('HTTP_INTERNAL_SERVER_ERROR', 500);

// Função para validar e obter dados JSON
function getJsonData() {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!is_array($data)) {
        return null;
    }
    return $data;
}

// Obtendo os dados enviados via DELETE
$data = getJsonData();

// Verificando se o ID do material foi enviado
if (isset($data['material_id'])) {
    $material_id = $data['material_id'];

    try {
        // Verificando se o material existe
        $sql_check = "SELECT id FROM materiais WHERE id = :material_id";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->bindParam(':material_id', $material_id, PDO::PARAM_INT);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            // Deletando o material da tabela de estoque
            $sql_delete_estoque = "DELETE FROM estoque WHERE material_id = :material_id";
            $stmt_delete_estoque = $pdo->prepare($sql_delete_estoque);
            $stmt_delete_estoque->bindParam(':material_id', $material_id, PDO::PARAM_INT);
            $stmt_delete_estoque->execute();

            // Deletando o material da tabela de materiais
            $sql_delete_material = "DELETE FROM materiais WHERE id = :material_id";
            $stmt_delete_material = $pdo->prepare($sql_delete_material);
            $stmt_delete_material->bindParam(':material_id', $material_id, PDO::PARAM_INT);
            $stmt_delete_material->execute();

            http_response_code(HTTP_OK);
            echo json_encode([
                'status' => HTTP_OK,
                'message' => 'Material deletado com sucesso.'
            ]);
        } else {
            http_response_code(HTTP_NOT_FOUND);
            echo json_encode([
                'status' => HTTP_NOT_FOUND,
                'message' => 'Material não encontrado.'
            ]);
        }
    } catch (PDOException $e) {
        error_log("Erro ao deletar material: " . $e->getMessage());
        http_response_code(HTTP_INTERNAL_SERVER_ERROR);
        echo json_encode([
            'status' => HTTP_INTERNAL_SERVER_ERROR,
            'message' => 'Erro ao deletar material: ' . $e->getMessage()
        ]);
    }
} else {
    http_response_code(HTTP_BAD_REQUEST);
    echo json_encode([
        'status' => HTTP_BAD_REQUEST,
        'message' => 'Parâmetro "material_id" é obrigatório.'
    ]);
}
?>
