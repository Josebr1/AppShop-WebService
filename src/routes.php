<?php
// Routes

$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
/**
 * rest/category/*
 *
 *
 * CRUD category
 *
 */

// /rest/category/get/all -> SELECT ALL
$app->get('/rest/category/all', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM categoria ORDER BY nome");
    $sth->execute();
    $result = $sth->fetchAll();
    return $this->response->withJson($result);
});

// /rest/category/get/id -> SELECT BY ID
$app->get('/rest/category/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM categoria WHERE id=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $result = $sth->fetchObject();
    return $this->response->withJson($result);
});


// /rest/category/get/id -> SELECT BY NAME
$app->get('/rest/category/name/[{nome}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("select * from categoria where lower(nome) like :nome");
    $sth->bindParam("nome", $args['nome']);
    $sth->execute();
    $result = $sth->fetchObject();
    return $this->response->withJson($result);
});

// /rest/category/add -> INSERT
$app->post('/rest/category/add', function ($request, $response) {
    $input = $request->getParsedBody();

    $sql = "INSERT categoria (nome, descricao, icone) VALUES(:nome, :descricao, :icone)";

    try {
        $sth = $this->db->prepare($sql);
        $sth->bindParam("nome", $input['nome']);
        $sth->bindParam("descricao", $input['descricao']);
        $sth->bindParam("icone", $input['icone']);
        $sth->execute();

        $result = $sth->rowCount();

        $status = "";

        if ($result == 1) {
            $status = "Categoria Adicionada com sucesso!";
        }

        return $this->response->withJson($status);
    } catch (PDOException $e) {
        return $this->response->withJson("Erro ao cadastrar categoria");
    }
});

// /rest/category/update/{id} -> UPDATE
$app->put('/rest/category/update', function ($request, $response, $args) {
    $input = $request->getParsedBody();

    $sql = "UPDATE categoria SET nome=:nome, descricao=:descricao, icone=:icone WHERE id=:id";

    $sth = $this->db->prepare($sql);
    $sth->bindParam("nome", $input['nome']);
    $sth->bindParam("descricao", $input['descricao']);
    $sth->bindParam("icone", $input['icone']);
    $sth->bindParam("id", $input['id']);

    $sth->execute();

    $result = $sth->rowCount();

    if ($result == 1) {
        $status = "Categoria atualizada com sucesso!";
    } else {
        $status = "Erro ao atualizar Categoria!";
    }
    return $this->response->withJson($status);
});

// /rest/category/delete/{id} -> DELETE
$app->delete('/rest/category/delete/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("DELETE FROM categoria WHERE id=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();

    $result = $sth->rowCount();

    if ($result == 1) {
        $status = "Categoria deletada com sucesso!";
    } else {
        $status = "Erro ao deletada Categoria!";
    }
    return $this->response->withJson($status);
});

/**
 * rest/product/*
 *
 *
 * CRUD product
 *
 */
// /rest/product/all -> SELECT ALL
$app->get('/rest/product/all', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM produto ORDER BY nome");
    $sth->execute();
    $result = $sth->fetchAll();
    return $this->response->withJson($result);
});

// /rest/product/{id} -> SELECT BY ID
$app->get('/rest/product/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM produto WHERE id=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $result = $sth->fetchObject();
    return $this->response->withJson($result);
});


// /rest/product/{name} -> SELECT BY NAME
$app->get('/rest/product/name/[{nome}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("select * from produto where lower(nome) like :nome");
    $sth->bindParam("nome", $args['nome']);
    $sth->execute();
    $result = $sth->fetchAll();
    return $this->response->withJson($result);
});


// /rest/product/category/{id} -> SELECT BY CATEGORY
$app->get('/rest/product/category/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("select * from produto where id_categoria =:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $result = $sth->fetchAll();
    return $this->response->withJson($result);
});

// /rest/product/add -> INSERT
$app->post('/rest/product/add', function ($request, $response) {
    $input = $request->getParsedBody();

    $sql = "INSERT produto (nome, descricao, preco, foto, id_categoria) VALUES(:nome, :descricao, :preco, :foto, :id_categoria)";

    try {
        $sth = $this->db->prepare($sql);
        $sth->bindParam("nome", $input['nome']);
        $sth->bindParam("descricao", $input['descricao']);
        $sth->bindParam("preco", $input['preco']);
        $sth->bindParam("foto", $input['foto']);
        $sth->bindParam("id_categoria", $input['id_categoria']);
        $sth->execute();

        $result = $sth->rowCount();

        $status = "";

        if ($result == 1) {
            $status = "produto Adicionada com sucesso!";
        }

        return $this->response->withJson($status);
    } catch (PDOException $e) {
        return $this->response->withJson("Erro ao produto categoria");
    }
});

// /rest/product/update/{id} -> UPDATE
$app->put('/rest/product/update', function ($request, $response, $args) {
    $input = $request->getParsedBody();

    $sql = "UPDATE produto SET nome=:nome, descricao=:descricao, preco=:preco, foto=:foto, id_categoria=:id_categoria WHERE id=:id";

    $sth = $this->db->prepare($sql);
    $sth->bindParam("nome", $input['nome']);
    $sth->bindParam("descricao", $input['descricao']);
    $sth->bindParam("preco", $input['preco']);
    $sth->bindParam("foto", $input['foto']);
    $sth->bindParam("id_categoria", $input['id_categoria']);
    $sth->bindParam("id", $input['id']);

    $sth->execute();

    $result = $sth->rowCount();

    if ($result == 1) {
        $status = "produto atualizada com sucesso!";
    } else {
        $status = "Erro ao atualizar produto!";
    }
    return $this->response->withJson($status);
});

// /rest/product/delete/{id} -> DELETE
$app->delete('/rest/product/delete/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("DELETE FROM produto WHERE id=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();

    $result = $sth->rowCount();

    if ($result == 1) {
        $status = "produto deletada com sucesso!";
    } else {
        $status = "Erro ao deletada produto!";
    }
    return $this->response->withJson($status);
});

/**
 * rest/user/*
 *
 *
 * CRUD user
 *
 */
// /rest/user/all -> SELECT ALL
$app->get('/rest/user/all', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM usuario ORDER BY nome");
    $sth->execute();
    $result = $sth->fetchAll();
    return $this->response->withJson($result);
});

// /rest/user/{id} -> SELECT BY ID
$app->get('/rest/user/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM usuario WHERE user_id=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $result = $sth->fetchAll();
    return $this->response->withJson($result);
});

// /rest/user/result/row{id} -> SELECT BY ID
$app->get('/rest/user/result/row/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM usuario WHERE user_id=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $result = $sth->rowCount();
    return $this->response->withJson($result);
});


// /rest/user/{name} -> SELECT BY NAME
$app->get('/rest/user/name/[{nome}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("select * from usuario where lower(nome) like :nome");
    $sth->bindParam("nome", $args['nome']);
    $sth->execute();
    $result = $sth->fetchAll();
    return $this->response->withJson($result);
});


// /rest/user/add -> INSERT
$app->post('/rest/user/add', function ($request, $response) {
    $input = $request->getParsedBody();

    $sql = "INSERT usuario (user_id, nome, email, telefone) VALUES(:user_id, :nome, :email, :telefone)";

    try {
        $sth = $this->db->prepare($sql);
        $sth->bindParam("user_id", $input['user_id']);
        $sth->bindParam("nome", $input['nome']);
        $sth->bindParam("email", $input['email']);
        $sth->bindParam("telefone", $input['telefone']);
        $sth->execute();

        $result = $sth->rowCount();

        $status = "";

        if ($result == 1) {
            $status = "usuario Adicionada com sucesso!";
        }

        return $this->response->withJson($status, 200);
    } catch (PDOException $e) {
        return $this->response->withJson("Erro ao add usuario" . $e->getMessage(), 500);
    }
});

// /rest/user/update/{id} -> UPDATE
$app->put('/rest/user/update', function ($request, $response, $args) {
    $input = $request->getParsedBody();

    $sql = "UPDATE usuario SET nome=:nome, telefone=:telefone WHERE user_id=:user_id";

    $sth = $this->db->prepare($sql);
    $sth->bindParam("nome", $input['nome']);
    $sth->bindParam("telefone", $input['telefone']);
    $sth->bindParam("user_id", $input['user_id']);

    $sth->execute();

    $result = $sth->rowCount();

    if ($result == 1) {
        $status = "usuario atualizada com sucesso!";
    } else {
        $status = "Erro ao atualizar usuario!";
    }
    return $this->response->withJson($status);
});

// /rest/user/delete/{id} -> DELETE
$app->delete('/rest/user/delete/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("DELETE FROM usuario WHERE user_id=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();

    $result = $sth->rowCount();

    if ($result == 1) {
        $status = "usuario deletada com sucesso!";
    } else {
        $status = "Erro ao deletada usuario!";
    }
    return $this->response->withJson($status);
});

/**
 * rest/merchandise/purchased/*
 *
 *
 * CRUD purchased -> Item Comprado
 *
 */
// /rest/purchased/all -> SELECT ALL
$app->get('/rest/purchased/all', function ($request, $response, $args) {
    $sth = $this->db->prepare("select * from item_comprado order by data_compra");
    $sth->execute();
    $result = $sth->fetchAll();
    return $this->response->withJson($result);
});

// /rest/purchased/{id} -> SELECT BY ID PEDIDO
$app->get('/rest/purchased/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM item_comprado WHERE id_pedido=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $result = $sth->fetchAll();
    return $this->response->withJson($result);
});


// /rest/purchased/user/{id_user} -> SELECT ALL BY USER ID
$app->get('/rest/purchased/user/[{id_user}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM item_comprado WHERE user_id=:id_user");
    $sth->bindParam("id_user", $args['id_user']);
    $sth->execute();
    $result = $sth->fetchAll();
    return $this->response->withJson($result);
});

// /rest/user/purchased/user/{id_user} -> SELECT ALL BY USER ID ORDER
$app->get('/rest/purchased/order/[{id_user}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("select usuario.nome, item_comprado.pedido, item_comprado.endereco, item_comprado.status from usuario, item_comprado where usuario.user_id = :id_user and item_comprado.user_id = :id_user order by data_compra desc limit 5");
    $sth->bindParam("id_user", $args['id_user']);
    $sth->execute();
    $result = $sth->fetchAll();
    return $this->response->withJson($result);
});

// /rest/purchased/add -> INSERT
$app->post('/rest/purchased/add', function ($request, $response) {
    $input = $request->getParsedBody();

    $sql = "INSERT item_comprado (pedido, endereco, valor_total, forma_pagamento, status, user_id) VALUES(:pedido, :endereco, :valor_total, :forma_pagamento, :status, :user_id)";

    try {
        $sth = $this->db->prepare($sql);
        $sth->bindParam("pedido", $input['pedido']);
        $sth->bindParam("endereco", $input['endereco']);
        $sth->bindParam("valor_total", $input['valor_total']);
        $sth->bindParam("forma_pagamento", $input['forma_pagamento']);
        $sth->bindParam("status", $input['status']);
        $sth->bindParam("user_id", $input['user_id']);
        $sth->execute();

        $result = $sth->rowCount();

        $status = "";

        if ($result == 1) {
            $status = "item_comprado Adicionada com sucesso!";
        }

        return $this->response->withJson($status);
    } catch (PDOException $e) {
        return $this->response->withJson("Erro ao add item_comprado" . $e->getMessage(), 500);
    }
});

// /rest/purchased/update/{id_pedido} -> UPDATE PEDIDO COMPLETO
$app->put('/rest/purchased/update/[{id_pedido}]', function ($request, $response, $args) {
    $input = $request->getParsedBody();

    $sql = "UPDATE item_comprado SET pedido=:pedido, endereco=:endereco, valor_total=:valor_total, status=:status WHERE id_pedido=:id_pedido";

    try {
        $sth = $this->db->prepare($sql);
        $sth->bindParam("pedido", $input['pedido']);
        $sth->bindParam("endereco", $input['endereco']);
        $sth->bindParam("valor_total", $input['valor_total']);
        $sth->bindParam("status", $input['status']);
        $sth->bindParam("id_pedido", $args['id_pedido']);

        $sth->execute();

        $status = "item_comprado atualizada com sucesso!";

        return $this->response->withJson($status);
    } catch (Exception $e) {
        return $this->response->withJson("Error" . $e);
    }


});

// /rest/purchased/update/{id_pedido} -> UPDATE PEDIDO STATUS
$app->put('/rest/purchased/update/status/[{id_pedido}]', function ($request, $response, $args) {
    $input = $request->getParsedBody();

    $sql = "UPDATE item_comprado SET statu=:statu WHERE id_pedido=:id_pedido";

    $sth = $this->db->prepare($sql);
    $sth->bindParam("statu", $input['statu']);
    $sth->bindParam("id_pedido", $args['id_pedido']);

    $sth->execute();

    $result = $sth->rowCount();

    if ($result == 1) {
        $status = "item_comprado atualizada com sucesso!";
    } else {
        $status = "Erro ao atualizar item_comprado!";
    }
    return $this->response->withJson($status);
});


// /rest/purchased/delete/{id} -> DELETE
$app->delete('/rest/purchased/delete/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("DELETE FROM item_comprado WHERE id_pedido=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();

    $result = $sth->rowCount();

    if ($result == 1) {
        $status = "item_comprado deletada com sucesso!";
    } else {
        $status = "Erro ao deletada item_comprado!";
    }
    return $this->response->withJson($status);
});
