<?php
include("connect_db.php");


if(isset($_GET['a'])){

date_default_timezone_set('America/Sao_Paulo');
$date = date("Y/m/d");
$titulo = $_POST['titulo'];
$semana = $_POST['semana'];

//Aqui inclui uma tarefa
$sql = "INSERT INTO tasks (id, descricao, complete, data_criacao, d_semana)
VALUES (NULL, '{$titulo}', '0', '{$date}', '{$semana}')";

if (mysqli_query($conn, $sql)) {
  echo ("<SCRIPT LANGUAGE='JavaScript'>
  window.alert('Tarefa adicionada com sucesso!!!')
  window.location.href='index.php';
  </SCRIPT>");
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}



}

//Aqui deleta uma tarefa
if(isset($_GET['r'])){

    if($_GET['r'] == '1'){

    $id = $_GET['i'];

    $sql_r = "DELETE FROM tasks WHERE id='{$id}' AND d_semana = 0";
    
    if (mysqli_query($conn, $sql_r)) {
      echo ("<SCRIPT LANGUAGE='JavaScript'>
      window.alert('Tarefa removida com sucesso!!!')
      window.location.href='index.php';
      </SCRIPT>");
    } else {
      echo "Error: " . $sql_r . "<br>" . mysqli_error($conn);
    }
    }else{
        //Aqui deleta todas as tarefas
        $sql_d = "DELETE FROM tasks WHERE d_semana = 0";

        if (mysqli_query($conn, $sql_d)) {
          echo ("<SCRIPT LANGUAGE='JavaScript'>
          window.alert('Todas as tarefas removidas com sucesso!!!')
          window.location.href='index.php';
          </SCRIPT>");
        } else {
          echo "Error: " . $sql_d . "<br>" . mysqli_error($conn);
        }
    }
}

//Aqui desmarca e marca o checklist
if(isset($_GET['check'])){
    $id_check = $_GET['i'];

$queryy = "SELECT * FROM tasks WHERE id='{$id_check}'";
$dadosy = mysqli_query($conn, $queryy) or die(mysql_error());
$linhay = mysqli_fetch_assoc($dadosy);


    if($linhay['complete'] == 1){

        $sql_c = "UPDATE tasks SET complete = '0' WHERE id='{$id_check}'";
        if (mysqli_query($conn, $sql_c)) {
            echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Tarefa desmarcada!!')
            window.location.href='index.php#d{$id_check}';
            </SCRIPT>");
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
    }else{
        $sql_c = "UPDATE tasks SET complete = '1' WHERE id='{$id_check}'";

        if (mysqli_query($conn, $sql_c)) {
            echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Tarefa marcada!!')
            window.location.href='index.php#d{$id_check}';
            </SCRIPT>");
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
    }
  
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>

</head>
<body>
    
    <div class="container">   
        <div class="row">
            <div style="margin-bottom: 20px;" class="central mr-auto ml-auto
            text-center">
                <form action="index.php?a=1" method="POST">
                    <input class="form" type="text" name="titulo" autocomplete="off" required maxlength="30">
                    <button class="btn_nav btn btn-success" name="btn">Add</button>
                    <center><select name="semana" id="semana" class="form-select" style="text-align: center; max-width: 200px;">
                      <option value="0" selected>Não Repetir</option>
                      <option value="1">Segunda-Feira</option>
                      <option value="2">Terça-Feira</option>
                      <option value="3">Quarta-Feira</option>
                      <option value="4">Quinta-Feira</option>
                      <option value="5">Sexta-Feira</option>
                      <option value="6">Sábado</option>
                      <option value="0">Domingo</option>
                      <option value="9">Todos os dias</option>
                    </select></center>
                </form>

            </div>

            <div style="margin-bottom: 20px;" class="bg_cent central mr-auto ml-auto
            text-center">
                <label class="display-6 h">Lista de Tarefas | Do dia</label>
              
                <hr>

                <ul class="list-group">
    <?php
  
$diaDaSemana = date('N');
$query_s = "SELECT * FROM tasks WHERE d_semana = '{$diaDaSemana}' OR d_semana = 9 ORDER BY id DESC";
$dados_s = mysqli_query($conn, $query_s) or die(mysql_error());
$linha_s = mysqli_fetch_assoc($dados_s);
$total_s = mysqli_num_rows($dados_s);
   
	if($total_s > 0) { 
   
    do{ // se o número de resultados for maior que zero, mostra os dados e inicia o loop que vai mostrar todos os dados
      ?>
        <li class="list-group-item" id="d<?php echo $linha_s['id'];?>"><div class="elements"><input type="checkbox" <?php if($linha_s['complete'] == 1){echo 'checked';}?> name="check" class="form-check-input"><label class="list"><?php echo $linha_s['descricao'];?></label></div><div class="butns"><a href="index.php?check=6&i=<?php echo $linha_s['id'];?>"><?php if($linha_s['complete'] == 0){echo '<button class="btn_nav btn btn_dell btn-success" style="margin-right:10px;" name="btn">Marcar</button>';}else{ echo '<button class="btn_nav btn btn_dell btn-warning" style="margin-right:10px;" name="btn">Desmarcar</button>';}?></a></div></li>
      <?php    
// finaliza o loop que vai mostrar os dados

    }while($linha_s = mysqli_fetch_assoc($dados_s));
  
	// fim do if
	} 
  if($total_s == 0){ ?>
    <li class="list-group-item"><label>Nenhuma atividade encontrada..</label></li>

<?php } 
                  
?>
                   </ul>
            </div>

            <BR><BR>
            <div style="margin-bottom: 20px;" class="bg_cent central mr-auto ml-auto
            text-center">
                <label class="display-6 h">Lista de Tarefas | Especiais</label>
                
                <a href="index.php?r=2"> <button class="btn_task btn btn-danger">Limpar tudo</button></a>

                <hr>

                <ul class="list-group">
    <?php
 $query = "SELECT * FROM tasks WHERE d_semana = 0 ORDER BY id DESC";
 $dados = mysqli_query($conn, $query) or die(mysql_error());
 $linha = mysqli_fetch_assoc($dados);
 $total = mysqli_num_rows($dados);
    
   if($total > 0) { 
     do{ // se o número de resultados for maior que zero, mostra os dados e inicia o loop que vai mostrar todos os dados
       ?>
         <li class="list-group-item" id="d<?php echo $linha['id'];?>"><div class="elements"><input type="checkbox" <?php if($linha['complete'] == 1){echo 'checked';}?> name="check" class="form-check-input"><label class="list"><?php echo $linha['descricao'];?></label></div><div class="butns"><a href="index.php?r=1&i=<?php echo $linha['id'];?>" ><button class="btn_dell btn btn-secondary">Remover</button></a><a href="index.php?check=6&i=<?php echo $linha['id'];?>"><?php if($linha['complete'] == 0){echo '<button class="btn_nav btn btn_dell btn-success" style="margin-right:10px;" name="btn">Marcar</button>';}else{ echo '<button class="btn_nav btn btn_dell btn-warning" style="margin-right:10px;" name="btn">Desmarcar</button>';}?></a></div></li>
       <?php    
 // finaliza o loop que vai mostrar os dados
 
     }while($linha = mysqli_fetch_assoc($dados));
   
   // fim do if
   }

  if($total == 0){ ?>
    <li class="list-group-item"><label>Nenhuma atividade encontrada..</label></li>

<?php } 
 mysqli_close($conn);?>
                   </ul>
            </div>
        </div>
    </div>

</body>
</html>
