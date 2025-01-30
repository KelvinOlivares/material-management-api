<?php
// Incluir a conexão com o banco de dados
include 'db_conect.php';

// Cabeçalhos para permitir requisições externas e resposta em JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

// Definindo constantes para os códigos HTTP
define('HTTP_OK', 200);
define('HTTP_NOT_FOUND', 404);
define('HTTP_BAD_REQUEST', 400);
define('HTTP_INTERNAL_SERVER_ERROR', 500);

// Verificando se o código do material foi passado como parâmetro na URL
if (isset($_GET['codigo_material']) && !empty($_GET['codigo_material'])) {
    $codigo_material = $_GET['codigo_material'];

    // Validação do formato do código_material (exemplo de alfanumérico)
    if (!preg_match('/^[a-zA-Z0-9]+$/', $codigo_material)) {
        http_response_code(HTTP_BAD_REQUEST);
        echo json_encode(['status' => HTTP_BAD_REQUEST, 'message' => 'Parâmetro "codigo_material" inválido.']);
        exit();
    }

    // SQL para buscar os dados completos do material, incluindo categorias, fornecedores, estoque e movimentações
    $sql = "
        SELECT 
            m.id AS material_id,
            m.nome AS material_nome,
            m.descricao AS material_descricao,
            c.nome AS categoria_nome,
            f.nome AS fornecedor_nome,
            m.preco AS material_preco,
            e.quantidade AS estoque_quantidade,
            mo.id AS movimentacao_id,
            mo.tipo AS movimentacao_tipo,
            mo.quantidade AS movimentacao_quantidade,
            mo.data_movimentacao AS movimentacao_data,
            u.nome AS usuario_nome
        FROM 
            materiais m
        JOIN 
            categorias c ON m.categoria_id = c.id
        JOIN 
            fornecedores f ON m.fornecedor_id = f.id
        JOIN 
            estoque e ON m.id = e.material_id
        LEFT JOIN 
            movimentacoes mo ON m.id = mo.material_id
        LEFT JOIN 
            usuarios u ON mo.usuario_id = u.id
        WHERE 
            m.`Código do material` = :codigo_material
        ORDER BY 
            m.id, mo.data_movimentacao DESC;
    ";
    
    try {
        // Preparando a consulta
        $stmt = $pdo->prepare($sql);
        // Bind do parâmetro
        $stmt->bindParam(':codigo_material', $codigo_material, PDO::PARAM_STR);
        // Executando a consulta
        $stmt->execute();

        // Verificando se o material foi encontrado
        if ($stmt->rowCount() > 0) {
            // Buscando os dados completos
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            http_response_code(HTTP_OK);
            echo json_encode([
                'status' => HTTP_OK,
                'message' => 'Material encontrado',
                'data' => $dados
            ]);
        } else {
            http_response_code(HTTP_NOT_FOUND);
            echo json_encode([
                'status' => HTTP_NOT_FOUND,
                'message' => 'Material não encontrado'
            ]);
        }
    } catch (PDOException $e) {
        error_log("Erro ao buscar material: " . $e->getMessage());
        http_response_code(HTTP_INTERNAL_SERVER_ERROR);
        echo json_encode([
            'status' => HTTP_INTERNAL_SERVER_ERROR,
            'message' => 'Erro ao buscar material: ' . $e->getMessage()
        ]);
    }
} else {
    http_response_code(HTTP_BAD_REQUEST);
    echo json_encode([
        'status' => HTTP_BAD_REQUEST,
        'message' => 'Parâmetro "codigo_material" é obrigatório.'
    ]);
}
?>
