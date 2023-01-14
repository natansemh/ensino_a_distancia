<?php
    $id = intval($_GET['id']);
    include('lib/conexao.php');
    include('lib/protect.php');
    protect(1);

    $mysql_query = $mysqli->query("DELETE FROM usuarios WHERE id = '$id'") or die($mysqli->error);

    die("<script>location.href=\"index.php?gerenciar_usuarios\";</script>");
?>