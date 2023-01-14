<?php
    include('lib/conexao.php');
    include('lib/enviarArquivo.php');
    include('lib/protect.php');
    protect(1);

    $id = intval($_GET['id']);

    if(isset($_POST['enviar'])){
        $titulo = $mysqli->escape_string($_POST['titulo']);
        $descricao_curta = $mysqli->escape_string($_POST['descricao_curta']);
        $preco = $mysqli->escape_string($_POST['preco']);
        $conteudo = $mysqli->escape_string($_POST['conteudo']);

        $erro = array();
        if(empty($titulo)) 
            $erro[] = "preencha o titulo";
        
        if(empty($descricao_curta)) 
            $erro[] = "preencha a descricão curta";
        
        if(empty($preco)) 
            $erro[] = "preencha o preco";
        
        if(empty($conteudo)) 
            $erro[] = "preencha o conteudo";

        
        if(count($erro) == 0){
            $imagem_alterada = false;
            if(isset($_FILES['imagem']) && isset($_FILES['imagem']['size']) && $_FILES['imagem']['size'] > 0){
                $deu_certo = enviarArquivo($_FILES['imagem']['error'], $_FILES['imagem']['size'], $_FILES['imagem']['name'], $_FILES['imagem']['tmp_name']);
                $imagemAlterada = true;
            } else {
                $deu_certo = true;
            }

            if($deu_certo !== false) {
                if($imagem_alterada) 
                    $sql_code = "UPDATE cursos SET
                        titulo = '$titulo',
                        descricao_curta = '$descricao_curta',
                        conteudo = '$conteudo',
                        preco = '$preco',
                        imagem = '$deu_certo'
                    WHERE id = '$id';";
                else 
                    $sql_code = "UPDATE cursos SET 
                        titulo = '$titulo',
                        descricao_curta = '$descricao_curta',
                        conteudo = '$conteudo', 
                        preco = '$preco'
                    WHERE id = '$id';";
                

                $inserido = $mysqli->query($sql_code);
                if (!$inserido)
                    $erro[] = "Falha ao inserir os dados " . $mysqli->error;
                else
                    die("<script>location.href=\"index.php?p=gerenciar_cursos\";</script>");


            } else 
                $erro[] = "Falha ao enviar a imagem";
            
        }

    }

$sql_query = $mysqli->query("SELECT * FROM cursos WHERE id = '$id'") or die($mysqli->error);
$curso = $sql_query->fetch_assoc();
?>
<div class="page-header card">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Cadastrar Curso</h4>
                    <span>Preencha todos os dados do curso e clique em cadastrar</span>
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
                        <a href="index.php?gerenciar_cursos">
                            Gerenciar Cursos
                        </a>
                    </li>
                    <li class="breadcrumb-item">Editar Curso</li>
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
                    <h5>Formulario de Cadastro</h5>
                </div>
                <div class="card-block">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Titulo</label>
                                    <input value="<?php echo $curso['titulo'];?>" type="text" name="titulo" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="">Descrição Curta</label>
                                    <input value="<?php echo $curso['descricao_curta'];?>" type="text" name="descricao_curta" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="">Imagem</label>
                                    <input type="file" name="imagem" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Preço</label>
                                    <input value="<?php echo $curso['preco'];?>" type="text" name="preco" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Conteudo</label>
                                    <textarea type="text" name="conteudo" class="form-control" rows="10"><?php echo $curso['conteudo'];?></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <a href="index.php?p=gerenciar_cursos" class="btn btn-primary btn-round"><i class="ti-arrow-left"></i> Cancelar</a>
                                <button name="enviar" type="submit" class="btn btn-success btn-round float-right"><i class="ti-save"></i> Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>