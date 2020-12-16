<?php
require_once('garcom.php');

class GarcomDao{

    private $pdo;
    
    public function __construct(){ 
        $servername = "localhost";
        $username = "root";
        $password = "";
        $databasename = "app_pdv";       
        try{
            $this->pdo = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
            // set the PDO error mode to exception
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES,false);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    

    public function inserir(Garcom $garcom)
    {
        $qInserir = "INSERT INTO garcom(nome) VALUES (:nome)";            
        $stmt = $this->pdo->prepare($qInserir);
        $stmt->bindParam(":nome",$garcom->nome);
        
        $stmt->execute();
        
        return $garcom;
    }


   
    public function listar()
    {
        $query = ("SELECT * FROM garcom");
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $garcom=array();	
        while($row = $stmt->fetch(PDO::FETCH_OBJ)){
            $garcom[] = new garcom($row->id, $row->nome);
            
        }
        return $garcom;
    }

    public function buscarPorId($id)
    {
        $query = ("SELECT * FROM garcom WHERE id=:id");		
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam ('id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        
        if(!isset($result->id)) {
            return "Garcom não cadastrado";
        } else {
            return new Garcom($result->id, $result->nome);           
        }
    }     

    public function atualizar(Garcom $garcom)
    {
        $qAtualizar = ("UPDATE garcom SET nome=:nome WHERE id=:id");            
        $stmt = $this->pdo->prepare($qAtualizar);
        $stmt->bindParam(":nome",$garcom->nome);
        $stmt->bindParam(":id",$$garcom->id);
        $stmt->execute();    
        return($garcom);
    }

    public function deletar($id)
    {
        $qDeletar = "DELETE from garcom WHERE id=:id";            
        $garcom = $this->buscarPorId($id);
        $stmt = $this->pdo->prepare($qDeletar);
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        return $garcom;
    }
}