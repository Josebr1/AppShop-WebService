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
    $result = $sth->fetchAll();
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

