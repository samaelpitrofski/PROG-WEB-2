<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;


include_once('garcomController.php');
include_once('produtoController.php');

require_once './vendor/autoload.php';


$app = AppFactory::create();

$app->get('/produtos/listar', 
  function (Request $request, Response $response, $args) {
      
      $dao = new ProdutoDAO();        

      $data = $dao->listar();
      $payload = json_encode($data);
      
      $response->getBody()->write($payload);
      return $response
                ->withHeader('Content-Type', 'application/json');

              });

$app->post('/produtos/inserir', 
  function (Request $request, Response $response, $args) {

      $data = $request->getParsedBody();
      $produto = new Produto(0, $data['nome'], $data['preco']);
      
      $dao = new ProdutoDAO;
      $produto = $dao->inserir($produto);

      return $response
                ->withHeader('Content-Type', 'application/json');
              });


$app->delete('/produtos/deletar', 
  function (Request $request, Response $response, $args) {
    $id = $args['id'];

    $dao = new ProdutoDAO;
    $produto = $dao->deletar($id);

    return $response->withHeader('Content-Type', 'application/json');
              
});



$app->get('/garcom/listar', 
    function (Request $request, Response $response, $args) {
        
        $dao = new GarcomDAO();        

        $data = $dao->listar();
        $payload = json_encode($data);
        
        $response->getBody()->write($payload);
        return $response
                  ->withHeader('Content-Type', 'application/json');
                });

$app->post('/garcom/inserir', 
    function (Request $request, Response $response, $args) {

      $data = $request->getParsedBody();
      $garcom = new Garcom(0, $data['nome']);
      $dao = new garcomDAO;
      $garcom = $dao->inserir($garcom);
      return $response->withHeader('Content-Type', 'application/json');
    });
    

    



$app->run();
