<?php
    include('lib/conexao.php');
    include('lib/protect.php');
    protect(1);

    $id = intval($_GET['id']);

    if(isset($_POST['enviar'])){
        $nome = $mysqli->escape_string($_POST['nome']);
        $email = $mysqli->escape_string($_POST['email']);
        $creditos = $mysqli->escape_string($_POST['creditos']);
        $senha = $mysqli->escape_string($_POST['senha']);
        $rsenha = $mysqli->escape_string($_POST['rsenha']);
        $admin = $mysqli->escape_string($_POST['admin']);

        $erro = array();
        if(empty($nome)) 
            $erro[] = "preencha o nome";
        if(empty($email)) 
            $erro[] = "preencha o e-mail";
        if(empty($creditos)) 
            $creditos = 0;
        if($rsenha !== $senha) 
            $erro[] = "as senhas nao batem";
        
        if(count($erro) == 0){
            $sql_code = "UPDATE usuarios 
            SET nome = '$nome',
                email = '$email',
                creditos = '$creditos',
                admin = '$admin'
            WHERE id = '$id';";

            if(!empty($senha)) {
                $senha = password_hash($senha, PASSWORD_DEFAULT);
                $sql_code = "UPDATE usuarios 
                SET nome = '$nome',
                    email = '$email',
                    senha = '$senha',
                    creditos = '$creditos',
                    admin = '$admin'
                WHERE id = '$id';";
            }

            $mysqli->query($sql_code) or die($mysqli->error);
            die("<script>location.href=\"index.php?p=gerenciar_usuarios\";</script>");
        }

    }

$sql_query = $mysqli->query("SELECT * FROM usuarios WHERE id = '$id'") or die($mysqli->error);
$usuario = $sql_query->fetch_assoc();

?>
<div class="page-header card">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Editar Usuario</h4>
                    <span>Preencha todos os dados do usuario e clique em cadastrar</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.php">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="index.php?p=gerenciar_usuarios">
                            Gerenciar Usuarios
                        </a>
                    </li>
                    <li class="breadcrumb-item">Editar Usuario</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Page-header end -->
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <?php if(isset($erro) && count($erro)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach($erro as $e) echo "$e<br>";?>
                </div>
                <?php 
            }
            ?>
            
            <div class="card">
                <div class="card-header">
                    <h5>Formulario de Edição</h5>
                </div>
                <div class="card-block">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Nome</label>
                                    <input type="text" value="<?php echo $usuario['nome'];?>" name="nome" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">E-mail</label>
                                    <input type="text" value="<?php echo $usuario['email'];?>" name="email" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Creditos</label>
                                    <input type="text" value="<?php echo $usuario['creditos'];?>" name="creditos" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Senha</label>
                                    <input type="text" name="senha" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Repita a Senha</label>
                                    <input type="text" name="rsenha" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">tipo</label>
                                    <select name="admin" class="form-control">
                                        <option value="0">Usuário</option>
                                        <option <?php if($usuario['admin']) echo "selected";?> value="1">Administrador</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <a href="index.php?p=gerenciar_usuarios" class="btn btn-primary btn-round"><i class="ti-arrow-left"></i> Cancelar</a>
                                <button name="enviar" type="submit" class="btn btn-success btn-round float-right"><i class="ti-save"></i> Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>