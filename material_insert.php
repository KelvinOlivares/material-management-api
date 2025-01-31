<?php
// Incluir a conexão com o banco de dados
include 'db_conect.php';

// Cabeçalhos para permitir requisições externas e resposta em JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

// Definindo constantes para os códigos HTTP
define('HTTP_OK', 200);
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

// Obtendo os dados enviados via POST
$data = getJsonData();

// Verificando se os dados necessários foram fornecidos
if (isset($data['material_nome'], $data['material_descricao'], $data['categoria_id'], $data['fornecedor_id'], $data['preco'], $data['quantidade_estoque'])) {
    try {
        // Preparando a consulta para inserir o novo material
        $sql = "INSERT INTO materiais (nome, descricao, categoria_id, fornecedor_id, preco) 
                VALUES (:nome, :descricao, :categoria_id, :fornecedor_id, :preco)";
        $stmt = $pdo->prepare($sql);
        
        // Bind dos parâmetros
        $stmt->bindParam(':nome', $data['material_nome'], PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $data['material_descricao'], PDO::PARAM_STR);
        $stmt->bindParam(':categoria_id', $data['categoria_id'], PDO::PARAM_INT);
        $stmt->bindParam(':fornecedor_id', $data['fornecedor_id'], PDO::PARAM_INT);
        $stmt->bindParam(':preco', $data['preco'], PDO::PARAM_STR);

        // Executando a inserção
        $stmt->execute();

        // Obtendo o ID do material recém-inserido
        $material_id = $pdo->lastInsertId();

        // Inserindo a quantidade no estoque
        $sql_estoque = "INSERT INTO estoque (material_id, quantidade) VALUES (:material_id, :quantidade)";
        $stmt_estoque = $pdo->prepare($sql_estoque);
        $stmt_estoque->bindParam(':material_id', $material_id, PDO::PARAM_INT);
        $stmt_estoque->bindParam(':quantidade', $data['quantidade_estoque'], PDO::PARAM_INT);
        $stmt_estoque->execute();

        http_response_code(HTTP_OK);
        echo json_encode([
            'status' => HTTP_OK,
            'message' => 'Material inserido com sucesso.',
            'material_id' => $material_id
        ]);
    } catch (PDOException $e) {
        error_log("Erro ao inserir material: " . $e->getMessage());
        http_response_code(HTTP_INTERNAL_SERVER_ERROR);
        echo json_encode([
            'status' => HTTP_INTERNAL_SERVER_ERROR,
            'message' => 'Erro ao inserir material: ' . $e->getMessage()
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
