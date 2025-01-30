Este repositório contém uma API simples desenvolvida em PHP que permite consultar informações sobre materiais, incluindo detalhes sobre categorias, fornecedores, estoque e movimentações. A API utiliza um banco de dados relacional com tabelas interligadas para fornecer informações completas sobre os materiais.

## Funcionalidades

- **Consulta de Materiais**: Permite a busca de um material específico, fornecendo dados completos, como nome, descrição, categoria, fornecedor, preço, estoque disponível e movimentações realizadas.
- **Relacionamento entre Tabelas**: A consulta inclui dados inter-relacionados de várias tabelas, como `materiais`, `categorias`, `fornecedores`, `estoque`, `movimentacoes` e `usuarios`.
- **Resposta em JSON**: A API retorna dados em formato JSON, facilitando o consumo por front-ends ou outras aplicações.
- **Controle de erros**: A API retorna códigos de status HTTP adequados para diferentes situações (200, 400, 404, 500).

---

GET /material_api.php?codigo_material=ABC123


Retorno da api:

{
    "status": 200,
    "message": "Material encontrado",
    "data": [
        {
            "material_id": 1,
            "material_nome": "Laptop HP",
            "material_descricao": "Laptop com 8GB de RAM e 512GB SSD",
            "categoria_nome": "Eletrônicos",
            "fornecedor_nome": "Fornecedor A",
            "material_preco": 3000.00,
            "estoque_quantidade": 50,
            "movimentacao_id": 1,
            "movimentacao_tipo": "entrada",
            "movimentacao_quantidade": 20,
            "movimentacao_data": "2025-01-30 10:00:00",
            "usuario_nome": "João Silva"
        }
    ]
}


PI em PHP para gerenciar informações sobre materiais, incluindo detalhes como categoria, fornecedor, estoque disponível e movimentações. Permite realizar consultas detalhadas dos materiais, suas movimentações (entradas e saídas) e dados relacionados, retornando as informações em formato JSON. Ideal para sistemas de gestão de inventário e controle de estoque.
