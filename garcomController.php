<?php

include_once('garcom.php');
include_once('garcomDAO.php');

class garcomController {

    // Cadastrar garcom
    public function inserir($request, $response, $args) {

        $data = $request->getParsedBody();
        $garcom = new Garcom(0, $data['nome']);
        $dao = new garcomDAO;
        $garcom = $dao->inserir($garcom);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }

    // Lista os garcom cadastrados

    public function listar($request, $response, $args){

        $dao= new garcomDAO;    
        $garcom = $dao->listar();
    
        return $response
                  ->withHeader('Content-Type', 'application/json');
    }

    public function buscarPorId($request, $response, $args) {
        $id = $args['id'];
        
        $dao= new garcomDAO;    
        $garcom = $dao->buscarPorId($id);
        
        return $response
                  ->withHeader('Content-Type', 'application/json');
    }
    
   
    public function atualizar($request, $response, $args) {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $garcom = new Garcom($id, $data['nome']);
    
        $dao = new garcomDAO;
        $garcom = $dao->atualizar($garcom);
    
        return $response
                  ->withHeader('Content-Type', 'application/json');
    }
    
   
    public function deletar($request, $response, $args) {
        $id = $args['id'];
    
        $dao = new garcomDAO;
        $garcom = $dao->deletar($id);
    
        return $response
                  ->withHeader('Content-Type', 'application/json');
    }
}