<?php
    include('lib/conexao.php');
    include('lib/protect.php');
    protect(1);

    $sql_relatorios = "SELECT r.id, u.nome, c.titulo, r.data_compra, r.valor FROM relatorio r, usuarios u, cursos c WHERE u.id = r.id_usuario AND c.id = r.id_curso";
    $sql_query = $mysqli->query($sql_relatorios) or die($mysqli->error);
    $num_relatorios = $sql_query->num_rows;
?>

<!-- Page-header start -->
<div class="page-header card">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Relatórios</h4>
                    <span>Vizualize os gastos do usuario no sistema</span>
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
                    <li class="breadcrumb-item"><a href="#!">Relatorio</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Page-header end -->
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Relatorio</h5>
                    <span>Examine o relatorio de compras do sistema</span>
                </div>
                <div class="card-block table-border-style">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Usuario</th>
                                    <th>Curso</th>
                                    <th>Data</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($num_relatorios == 0) {?>
                                <tr>
                                    <td colspan="5">Nenhum relatorio foi encontrado</td>
                                </tr>
                                <?php } else {
                                    
                                    while($relatorio = $sql_query->fetch_assoc()) {

                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $relatorio['id'];?></th>
                                            <td><?php echo $relatorio['nome'];?></td>
                                            <td><?php echo $relatorio['titulo'];?></td>
                                            <td><?php echo date("d/m/Y H:i", strtotime($relatorio['data_compra']));?></td>
                                            <td>R$ <?php echo number_format($relatorio['valor'], 2, ',', '.');?></td>
                                        </tr>
                                        <?php 
                                    }
                                }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>