A Material Management API permite a gestão de materiais dentro de um sistema de inventário. Com ela, é possível realizar operações de criação, atualização, consulta e exclusão de materiais. A API foi projetada para facilitar o gerenciamento dos materiais, suas informações associadas (como categorias e fornecedores) e seu estoque.

A API é acessível via HTTP e retorna respostas em formato JSON.

Recursos da API
1. Adicionar Material (Create)
Endpoint: /material_create.php
Método: POST

Esse endpoint permite adicionar um novo material ao sistema, incluindo as informações associadas (como nome, descrição, categoria, fornecedor, preço e quantidade em estoque).

Exemplo de Requisição (JSON):

{
  "material_nome": "Caderno A4",
  "material_descricao": "Caderno de anotações tamanho A4",
  "categoria_id": 1,
  "fornecedor_id": 2,
  "preco": 5.99,
  "quantidade_estoque": 100
}


Exemplo de Resposta:
{
  "status": 200,
  "message": "Material adicionado com sucesso.",
  "material_id": 1
}


Erro de parâmetro:

{
  "status": 400,
  "message": "Parâmetros incompletos ou inválidos."
}


2. Consultar Material (Read)
Endpoint: /material_read.php
Método: GET

Esse endpoint permite consultar um material específico pelo seu código, retornando todas as informações associadas.

Exemplo de Requisição (URL):

GET /material_read.php?codigo_material=12345

Exemplo de Resposta:
Sucesso

{
  "status": 200,
  "message": "Material encontrado",
  "data": {
    "material_id": 1,
    "material_nome": "Caderno A4",
    "material_descricao": "Caderno de anotações tamanho A4",
    "categoria_nome": "Papelaria",
    "fornecedor_nome": "Fornecedor X",
    "material_preco": 5.99,
    "estoque_quantidade": 100
  }
}


{
  "status": 404,
  "message": "Material não encontrado"
}



Claro! Aqui está uma documentação reestruturada para o projeto Material Management API com foco nas operações de CRUD (Create, Read, Update, Delete) que você implementou:

Material Management API
Descrição
A Material Management API permite a gestão de materiais dentro de um sistema de inventário. Com ela, é possível realizar operações de criação, atualização, consulta e exclusão de materiais. A API foi projetada para facilitar o gerenciamento dos materiais, suas informações associadas (como categorias e fornecedores) e seu estoque.

A API é acessível via HTTP e retorna respostas em formato JSON.

Recursos da API
1. Adicionar Material (Create)
Endpoint: /material_create.php
Método: POST

Esse endpoint permite adicionar um novo material ao sistema, incluindo as informações associadas (como nome, descrição, categoria, fornecedor, preço e quantidade em estoque).

Exemplo de Requisição (JSON):

json
Copiar
{
  "material_nome": "Caderno A4",
  "material_descricao": "Caderno de anotações tamanho A4",
  "categoria_id": 1,
  "fornecedor_id": 2,
  "preco": 5.99,
  "quantidade_estoque": 100
}
Exemplo de Resposta:

Sucesso:
json
Copiar
{
  "status": 200,
  "message": "Material adicionado com sucesso.",
  "material_id": 1
}
Erro de parâmetro:
json
Copiar
{
  "status": 400,
  "message": "Parâmetros incompletos ou inválidos."
}
2. Consultar Material (Read)
Endpoint: /material_read.php
Método: GET

Esse endpoint permite consultar um material específico pelo seu código, retornando todas as informações associadas.

Exemplo de Requisição (URL):

bash
Copiar
GET /material_read.php?codigo_material=12345
Exemplo de Resposta:

Sucesso:
json
Copiar
{
  "status": 200,
  "message": "Material encontrado",
  "data": {
    "material_id": 1,
    "material_nome": "Caderno A4",
    "material_descricao": "Caderno de anotações tamanho A4",
    "categoria_nome": "Papelaria",
    "fornecedor_nome": "Fornecedor X",
    "material_preco": 5.99,
    "estoque_quantidade": 100
  }
}
Erro (material não encontrado):
json
Copiar
{
  "status": 404,
  "message": "Material não encontrado"
}
3. Atualizar Material (Update)
Endpoint: /material_update.php
Método: PUT

Esse endpoint permite atualizar as informações de um material existente, como nome, descrição, categoria, fornecedor, preço e quantidade no estoque.

Exemplo de Requisição (JSON):

{
  "material_id": 1,
  "material_nome": "Caderno Universitário",
  "material_descricao": "Caderno de anotações universitário tamanho A4",
  "categoria_id": 1,
  "fornecedor_id": 2,
  "preco": 6.50,
  "quantidade_estoque": 150
}

Exemplo de Resposta:

Sucesso:

{
  "status": 200,
  "message": "Material atualizado com sucesso.",
  "material_id": 1
}

Material não encontrado:

{
  "status": 404,
  "message": "Material não encontrado"
}

Erro de parâmetro:

{
  "status": 400,
  "message": "Parâmetros incompletos ou inválidos"
}


4. Deletar Material (Delete)
Endpoint: /material_delete.php
Método: DELETE

Esse endpoint permite deletar um material do sistema, incluindo a remoção das entradas associadas no estoque.

Exemplo de Requisição (JSON):

{
  "material_id": 1
}


Sucesso:

{
  "status": 200,
  "message": "Material deletado com sucesso."
}

Material não encontrado:

{
  "status": 404,
  "message": "Material não encontrado."
}

Erro de parâmetro:

{
  "status": 400,
  "message": "Parâmetro 'material_id' é obrigatório."
}

método: GET
Rota: http://localhost/material_read.php?codigo_material=12345

Conclusão:
A Material Management API é uma solução simples e eficaz para gerenciar materiais em um sistema de inventário. Ela oferece todas as operações básicas (CRUD), permitindo gerenciar as informações de materiais de maneira rápida e segura. A API pode ser estendida para atender a necessidades específicas de negócios, como autenticação de usuários e controle avançado de estoque.

1. Criar Material (Create)
Método HTTP: POST
Descrição: Este método será usado para criar um novo material no sistema. Você envia os dados do material no corpo da requisição e o servidor cria esse material no banco de dados.
Endpoint: /material_create.php
Exemplo de Requisição:

json
Copiar
{
  "material_nome": "Caneta Azul",
  "material_descricao": "Caneta esferográfica de tinta azul",
  "categoria_id": 2,
  "fornecedor_id": 1,
  "preco": 2.50,
  "quantidade_estoque": 200
}
Método HTTP a ser usado: POST

2. Consultar Material (Read)
Método HTTP: GET
Descrição: Este método será usado para consultar os dados de um material específico. Você envia o código do material ou ID no parâmetro da URL, e o servidor retorna as informações desse material.
Endpoint: /material_read.php
Exemplo de Requisição:

bash
Copiar
GET /material_read.php?codigo_material=12345
Método HTTP a ser usado: GET

3. Atualizar Material (Update)
Método HTTP: PUT
Descrição: Este método será usado para atualizar as informações de um material existente. O corpo da requisição conterá os dados que você deseja atualizar, como preço, nome, descrição ou quantidade.
Endpoint: /material_update.php
Exemplo de Requisição:

json
Copiar
{
  "material_id": 1,
  "material_nome": "Caneta Universitária",
  "material_descricao": "Caneta esferográfica de tinta preta",
  "categoria_id": 2,
  "fornecedor_id": 1,
  "preco": 3.00,
  "quantidade_estoque": 150
}
Método HTTP a ser usado: PUT

4. Deletar Material (Delete)
Método HTTP: DELETE
Descrição: Este método será usado para excluir um material do sistema. A requisição deve passar o ID do material no corpo ou como parâmetro, e o servidor removerá o material do banco de dados.
Endpoint: /material_delete.php
Exemplo de Requisição:

json
Copiar
{
  "material_id": 1
}
Método HTTP a ser usado: DELETE

Resumo dos Métodos HTTP Usados 
