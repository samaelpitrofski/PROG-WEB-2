<?php
require_once('Produto.php');

class ProdutoDAO {
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

        public function inserir(Produto $produto)
        {
            $qInserir = "INSERT INTO produto(nome, preco) VALUES (:nome, :preco)";            
            $stmt = $this->pdo->prepare($qInserir);
            $stmt->bindParam(":nome",$produto->nome);
            $stmt->bindParam(":preco",$produto->preco);
            $stmt->execute();
            
        }

        public function listar()
        {
		    $query = 'SELECT * FROM produto';
	    	$stmt  = $this->pdo->prepare($query);
    		$stmt ->execute();
            $produtos=array();	
		    while($row = $stmt ->fetch(PDO::FETCH_OBJ)){
			    $produtos[] = new Produto($row->id, $row->nome, $row->preco);
            }
            return $produtos;
        }

        public function buscarPorId($id)
        {
 		    $query = 'SELECT * FROM produto WHERE id=:id';		
		    $stmt = $this->pdo->prepare($query);
		    $stmt ->bindParam ('id', $id);
		    $stmt ->execute();
            $result = $stmt ->fetch(PDO::FETCH_OBJ);

            // Verifica se ID existe no banco
            if(!isset($result->id)) {
                return "Produto não cadstrado";
            }else {
                return new Produto($result->id, $result->nome, $result->preco);           
            }
        }

        public function atualizar(Produto $produto)
        {
            $qAtualizar = "UPDATE produto SET nome=:nome, preco=:preco WHERE id=:id";            
           
            $stmt  = $this->pdo->prepare($qAtualizar);
            $stmt ->bindParam(":nome",$produto->nome);
            $stmt ->bindParam(":preco",$produto->preco);
            $stmt ->bindParam(":id",$produto->id);
            $$stmt ->execute();    
            return($produto);    
        }

        public function deletar($id)
        {
            $qDeletar = "DELETE from produto WHERE id=:id";            
            $produto = $this->buscarPorId($id);
            $stmt  = $this->pdo->prepare($qDeletar);
            $stmt ->bindParam(":id",$id);
            $stmt->execute();
            return $produto;
        }

    }