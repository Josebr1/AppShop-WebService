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

