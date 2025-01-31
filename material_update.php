<?php
// Incluir a conexão com o banco de dados
include 'db_conect.php';

// Cabeçalhos para permitir requisições externas e resposta em JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT');

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

// Obtendo os dados enviados via PUT
$data = getJsonData();

// Verificando se os dados necessários foram fornecidos
if (isset($data['material_id'], $data['material_nome'], $data['material_descricao'], $data['categoria_id'], $data['fornecedor_id'], $data['preco'], $data['quantidade_estoque'])) {
    $material_id = $data['material_id'];

    try {
        // Verificando se o material existe
        $sql_check = "SELECT id FROM materiais WHERE id = :material_id";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->bindParam(':material_id', $material_id, PDO::PARAM_INT);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            // Atualizando as informações do material
            $sql_update_material = "
                UPDATE materiais
                SET nome = :nome, descricao = :descricao, categoria_id = :categoria_id, fornecedor_id = :fornecedor_id, preco = :preco
                WHERE id = :material_id";
            $stmt_update_material = $pdo->prepare($sql_update_material);
            $stmt_update_material->bindParam(':nome', $data['material_nome'], PDO::PARAM_STR);
            $stmt_update_material->bindParam(':descricao', $data['material_descricao'], PDO::PARAM_STR);
            $stmt_update_material->bindParam(':categoria_id', $data['categoria_id'], PDO::PARAM_INT);
            $stmt_update_material->bindParam(':fornecedor_id', $data['fornecedor_id'], PDO::PARAM_INT);
            $stmt_update_material->bindParam(':preco', $data['preco'], PDO::PARAM_STR);
            $stmt_update_material->bindParam(':material_id', $material_id, PDO::PARAM_INT);
            $stmt_update_material->execute();

            // Atualizando a quantidade no estoque
            $sql_update_estoque = "UPDATE estoque SET quantidade = :quantidade WHERE material_id = :material_id";
            $stmt_update_estoque = $pdo->prepare($sql_update_estoque);
            $stmt_update_estoque->bindParam(':quantidade', $data['quantidade_estoque'], PDO::PARAM_INT);
            $stmt_update_estoque->bindParam(':material_id', $material_id, PDO::PARAM_INT);
            $stmt_update_estoque->execute();

            http_response_code(HTTP_OK);
            echo json_encode([
                'status' => HTTP_OK,
                'message' => 'Material atualizado com sucesso.',
                'material_id' => $material_id
            ]);
        } else {
            http_response_code(HTTP_NOT_FOUND);
            echo json_encode([
                'status' => HTTP_NOT_FOUND,
                'message' => 'Material não encontrado.'
            ]);
        }
    } catch (PDOException $e) {
        error_log("Erro ao atualizar material: " . $e->getMessage());
        http_response_code(HTTP_INTERNAL_SERVER_ERROR);
        echo json_encode([
            'status' => HTTP_INTERNAL_SERVER_ERROR,
            'message' => 'Erro ao atualizar material: ' . $e->getMessage()
        ]);
    }
} else {
    http_response_code(HTTP_BAD_REQUEST);
    echo json_encode([
        'status' => HTTP_BAD_REQUEST,
        'message' => 'Parâmetros incompletos ou inválidos.'
    ]);
}
?>
