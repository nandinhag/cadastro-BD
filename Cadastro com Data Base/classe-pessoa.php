<?php
class Pessoa{
    private $pdo;
    public function __construct($dbname, $host, $user, $senha)
    {
    try
{
$this->pdo = new PDO("mysql:dbname=".$dbname.";$host=".$host, $user, $senha);
}
catch(PDOException $e)
{
    echo "Erro com o banco de dados:". $e->getMessage();
    exit();
}
    }
    
public function buscarDados()
{
$res= array();
$cmd = $this->pdo->query ("SELECT * FROM  pessoa ORDER BY nome");
$res = $cmd->fetchAll(PDO::FETCH_ASSOC);
return $res;
}
//FUNÇAO PARA CADASTRAR OS DADOS NO BD
public function cadastrarPessoa ($nome, $telefone, $email)
{
$cmd = $this -> pdo -> prepare ("SELECT id from pessoa WHERE email = :e");
$cmd ->bindValue (":e", $email);
$cmd -> execute();
if ($cmd -> rowCount() > 0) //email ja cadastrado 
{
    return false;
}else //nao cadastrado o email
{
    $cmd = $this ->pdo-> prepare ("INSERT INTO pessoa (nome, telefone, email ) VALUES (:n, :t,:e)" );
    $cmd -> bindValue (":n", $nome);
    $cmd -> bindValue (":t", $telefone);
    $cmd -> bindValue (":e", $email);
    $cmd ->  execute(); 
    return true;
  }
}
//EXCLUIIR DADOS DO BD
public function excluirPessoa($id)
{
    $cmd = $this->pdo->prepare ("DELETE FROM pessoa WHERE id = :id");
    $cmd -> bindValue (":id", $id);
    $cmd -> execute ();
}

//PROCURAR DADOS DE UMA PESSOA NO BD
public function buscarDadosPessoa($id)
{
    $res = array();
    $cmd = $this->pdo->prepare ("SELECT * FROM pessoa WHERE id = :id");
    $cmd->bindValue(":id", $id);
    $cmd->execute();
    $res = $cmd->fetch(PDO::FETCH_ASSOC);
    return $res;
}

// ATUALIZAR DADOS DO BD
public function atualizarDados($id, $nome, $telefone, $email)
{
$cmd = $this -> pdo -> prepare ("UPDATE pessoa SET nome = :n, telefone = :t, email = :e WHERE id = :id");
$cmd -> bindValue (":n", $nome);
$cmd -> bindValue (":t", $telefone);
$cmd -> bindValue (":e", $email);
$cmd -> bindValue (":id", $id);
$cmd -> execute ();        
   }
}                          
    ?>