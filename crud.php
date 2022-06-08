<?php
include_once "conexao.php";

$acao = $_GET['acao'];

if (isset($_GET['cpf_cliente'])) {
    $cpf_cliente = $_GET['cpf_cliente'];
}

    switch ($acao){
        case 'inserir':
            $nome_cliente = $_POST['nome'];
            $email_cliente = $_POST['email'];
            $cpf_cliente = $_POST['cpf'];
            $produto_vendido = $_POST['produto'];

            $sql = "INSERT INTO users (user_name, user_email, user_date, user_mensagem) VALUES ('$nome_cliente', '$email_cliente', '$produto_vendido', '$cpf_cliente')";

            if (!mysqli_query($conn, $sql)) {
                die ("Erro ao inserir informações" . mysqli_error($conn)); 
            }  else {
                echo "<script language='javascript' type='text/javascript'>
                alert('Dados cadastrados com sucesso!')
                window.location.href='crud.php?acao=selecionar'</script>";
            }
            break;

         case 'montar':
            $cpf_cliente = $_GET['cpf_cliente'];
            $sql = 'SELECT * FROM users WHERE cpf_cliente =' .$cpf_cliente;
            $resultado = mysqli_query($conexao, $sql) or die ("Erro ao retornar dados");
            
             echo "<form method = 'post' name = 'dados' action='crud.php?acao=atualizar' onSubmit='return enviardados();'>";
            echo "<table width='588' border ='0' align = 'center'>";

            while ($registro = mysqli_fetch_array($resultado)) {
                echo "<tr>";
                echo "<td width='118'><font size='1' face='Verdana, Arial, Helvetica, sans-serif'>Código:</font></td> ";
                echo "<td width='460'>";
                echo "<input name='nome_cliente' type='text' class='formbutton' id ='nome_cliente' size='5' maxlenght='10' value=" . $nome_cliente . " readonly> ";
                echo "</td>";
                echo "</tr>";
                
                echo "<tr>";
                echo "<td width='118'><font size='1' face='Verdana, Arial, Helvetica, sans-serif'></font size='1'>Nome<strong>:</strong></font></font></td> ";
                echo "<td rowspan='2'><font size='2'>";
                echo "<style>textarea{resize:none;}<\style>";
                echo " <input name='email_cliente' type='text' class='formbutton' id='email_cliente' size='52' maxlenght='150' value=". $registro['user_email'] . " ";
                echo "</font></td>";
                echo "</tr>";
                echo "<tr>";
                
                echo "<tr>";
                echo "<td width='118'><font size='1' face='Verdana, Arial, Helvetica, sans-serif'>Email:</font></td> ";
                echo "<td width='460'>";
                echo " <input name='produto_vendido' type='text' class='formbutton' id='produto_vendido' size='52' maxlenght='150' value=". $registro['user_email'] . " ";
                echo "</td>";
                echo "</tr>";
                
                 echo "<tr>";
                echo "<td width='118'><font size='1' face='Verdana, Arial, Helvetica, sans-serif'>Data:</font></td> ";
                echo "<td width='460'>";
                echo " <input name='cpf_cliente' type='text' class='formbutton' id='cpf_cliente' size='52' maxlenght='150' value=". $registro['user_date'] . " ";
                echo "</td>";
                echo "</tr>";
/*      
                echo "<tr>";
                echo "<td> <face='Verdana, Arial, Helvetica, sans-serif'></font size='1'>Mensagem<strong>:</strong></font></font></td> ";
                echo "<td rowspan='2'><font size='2'>";
                echo "<textarea name='mensagem' cols'50' rows='8' class='formbutton'>".htmlspecialchars($registro['user_mensagem']) . "</textarea>";
                echo "</font></td>";
                echo "</tr>";
                echo "<tr>";
*/          
                 echo "<tr>";
                echo " <td height='22'></td>";
                echo " <td>";
                echo "<input name ='Submit' type='submit' class='formobjects' value='Atualizar'>" ;
                echo " <button type='submit' formaction='crud.php?acao=selecionar'>Selecionar</button>";
                echo " <input name='Reset' type='reset' class='formobjects' value='Limpar campos'>";
                echo "  </td>";
                echo "  </tr>";
                
                echo "</table>";
                echo "</form>   ";
            }

            mysqli_close($conexao);
            break;

        case 'atualizar':
            
            $nome_cliente = $_POST['nome_cliente'];
            $email_cliente = $_POST['email_cliente'];
            $cpf_cliente = $_POST['cpf_cliente'];
            $produto_vendido = $_POST['produto_vendido'];            
            
             $sql = "UPDATE users SET user_name = '".$nome_cliente."',user_email ='".$email_cliente."',user_data ='".$cpf_cliente."',user_mensagem='".$produto_vendido."'WHERE cpf_cliente='".$codigo."'";
        
        if(!mysqli_query($conn, $sql)){
            die('</br>Erro no comando SQL UPDATE'.mysqli_error($conn));
        } else{
            echo "<script language='javascript' type='text/javascript'>
            alert('Atualizado com sucesso.')
            window.location.herf='crud.php?acao=selecionar'</script>";
        }
        mysqli_close($conn);
        
            break;

        case 'deletar':
            $sql = "DELETE FROM users WHERE cpf_cliente = '" . $cpf_cliente . "'";
            if (!mysqli_query($conn, $sql)) {
                die('Error: ' . mysqli_error($conn));
            } else {
                echo "<script language='javascript' type='text/javascript'>
                alert('Dados excluidos com sucesso!')
                window.location.href='crud.php?acao=selecionar'</script>";
            }
           
           
            mysqli_close($conn);
        header("Location:crud.php?acao=selecionar");
            break;

        case 'selecionar':
            echo "<meta charset='utf-8'>";
            echo "<center><table border=1>";
            echo "<tr>";
            echo "<th>NOME</th>";
            echo "<th>E-MAIL</th>";
            echo "<th>Produto</th>";
            echo "<th>Cpf</th>";
            echo "</tr>";

            $sql = "SELECT * FROM users";
            $resultado = mysqli_query($conn, $sql) or die("Erro ao retornar dados");

            echo "<CENTER>Registros cadastrados na base de dados.<br/><CENTER>";
            echo "<br/>";

            while ($registro = mysqli_fetch_array($resultado)) {
                $nome_cliente = $registro['nome_cliente'];
                $email_cliente = $registro['email_cliente'];
                $cpf_cliente = $registro['cpf_cliente'];
                $produto_vendido = $registro['produto_vendido'];

                    echo "<tr>";
                    echo "<td>" . $id . "</td>";
                    echo "<td>" . $nome_cliente . "</td>";
                    echo "<td>" . $email_cliente . "</td>";
                    echo "<td>" . $cpf_cliente . "</td>";
                    echo "<td>" . $produto_vendido . "</td>";
                    echo "<td>
                            <a href='crud.php?acao=deletar&cpf_cliente=$cpf_cliente'>
                                <img src='delete.png' alt='Deletar' title='Deletar usuário'>
                            </a>
                            <a href='crud.php?acao=montar&cpf_cliente=$cpf_cliente'>
                                <img src='update.png' alt='Atualizar' title='Atualizar registro'>
                            </a>
                            <a href='index.php'>
                                <img src='insert.png' alt='Inserir' title='Inserir registro'>
                            </a> ";
                    echo "</tr>";
            }
            mysqli_close($conn);

            break;

        default:
            header("location:crud.php?acao=selecionar");
            break;
    }
?>
