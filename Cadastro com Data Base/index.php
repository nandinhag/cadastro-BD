<?php
require_once 'classe-pessoa.php';
$p = 'newPessoa' ("crudpdo","localhost","root","");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>C a d a s t r o !</title>
</head>
<body>
    <?php
    if(isset($_POST['nome']))

    {
        if(isset($_GET['id_up'])&& !empty($_GET['id_up']))
        {
        $id_upd= addslashes($_GET['id_up']);
        $nome = addslashes($_POST['nome']);
        $telefone = addslashes($_POST['telefone']);
        $email = addslashes($_POST ['email']);
        if (!empty($nome) && !empty($telefone) && !empty($email))
      {
        $p -> atualizarDados ($id_upd,$nome,$telefone,$email);
        header("location: index.php");
        }
        else
        {
            ?>
            <div class= "aviso">
                <img src="alert.png">
                <h4>Preencha todos os campos!</h4>
            </div>
        <?php
        }
    }
    else
    {
        $nome = addslashes($_POST['nome']);
        $telefone = addslashes($_POST['telefone']);
        $email = addslashes($_POST ['email']);
        if (!empty($nome) && !empty($telefone) && !empty($email))
        { 
            if (!$p -> cadastrarPessoa($nome, $telefone, $email))
        {
                ?>
                <div class="aviso">
                    <img src="alert.png">
                    <h4>Email já está cadastrado!</h4>
                </div>
            <?php
            }
            else{
                ?>
                <div class="aviso">
                    <img src="certinho.png">
                    <h4>Cadastro realizado com sucesso!</h4>
                </div>
            <?php 
            }
        }
    }
}

    ?>
    <?php
    if(isset($_GET['id_up']))
    {
        $id_update = addslashes($_GET['id_up']);
        $res = $p ->buscarDadosPessoa($id_update);
    }
    ?>
    <section id="esquerda">
    <form method="POST">
        <h2>CADASTRO DE ALUNOS</h2>
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" value="<?php if(isset($res)){echo $res ['nome'];} ?>" >
        <label for="">Telefone:</label> 
        <input type="text" name="telefone" id="telefone" value="<?php if(isset($res)){echo $res ['telefone'];} ?>" > 
    <label> E-mail: </label> 
        <input type="text" name="email" id="email" value="<?php if(isset($res)){echo $res ['email'];} ?>" > 
        <input type="submit" value="<?php if (isset($res)) {echo "ATUALIZAR";} else {echo "CADASTRAR";} ?>" >
     </form>
    </section>
    <section id="direita">
        <table>
            <tr id="titulo">
                <td>NOME</td>
                <td>TELEFONE</td>
                <td colspan="2"> EMAIL</td>
</tr>
        <?php
    $dados = $p -> buscarDados();
if (count($dados) > 0)
{
    for ($i=0; $i < count ($dados); $i++)
    {
        echo "<tr>";
        foreach ($dados[$i] as $k => $v)
        {
            if ($k != "id")
            {
                echo "<td>".$v."</td>";
            }
        }
        ?>
        <td>
        <a href="index.php?id_up=<?php echo $dados [$i]['id'];?>">Editar</a>
        <a href="index.php?id=<?php echo $dados [$i]['id'];?>">Excluir</a>
        </td>
        <?php
        echo "</tr>";
    }
}
else
{
    ?>
    </table>
    <div class="aviso">
    <h4>Ainda não há pessoas cadastradas!</h4>
    </div>
    <?php
}?>
</section>
</body>
</html>
<?php
if(isset($_GET['id']))
{
    $id_pessoa = addslashes($_GET['id']);
    $p->excluirPessoa($id_pessoa);
    header("location: index.php"); 
}
?>