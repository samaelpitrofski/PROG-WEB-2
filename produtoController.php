<?php

include_once('produto.php');
include_once('produtoDAO.php');

class ProdutoController {

    
    public function inserir($request, $response, $args) {

        $data = $request->getParsedBody();
        $produto = new Produto(0, $data['nome'], $data['preco']);
        $dao = new ProdutoDAO;
        $produto = $dao->inserir($produto);
        return $response->withHeader('Content-Type', 'application/json');
    }
    
    
    public function listar($request, $response, $args){

        $dao= new ProdutoDAO;    
        $produtos = $dao->listar();

        return $response->withHeader('Content-Type', 'application/json');
    }
    
   
    public function buscarPorId($request, $response, $args) {
        $id = $args['id'];
        
        $dao= new ProdutoDAO;    
        $produto = $dao->buscarPorId($id);
        
        return $response->withHeader('Content-Type', 'application/json');
    }
    

    public function atualizar($request, $response, $args) {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $produto = new Produto($id, $data['nome'], $data['preco']);
    
        $dao = new ProdutoDAO;
        $produto = $dao->atualizar($produto);
    
        return $response->withHeader('Content-Type', 'application/json');
    }
    
    public function deletar($request, $response, $args) {
        $id = $args['id'];
        $dao = new garcomDAO;
        $garcom = $dao->deletar($id);
        return $response->withHeader('Content-Type', 'application/json');
    }
}