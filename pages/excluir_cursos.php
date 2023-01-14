<?php
    $id = intval($_GET['id']);
    include('lib/conexao.php');
    include('lib/protect.php');
    protect(1);

    $mysql_query = $mysqli->query("SELECT imagem FROM cursos WHERE id = '$id'") or die($mysqli->error);
    $curso = $mysql_query->fetch_assoc();

    if(unlink($curso['imagem'])) {
        $mysqli->query("DELETE FROM cursos WHERE id = '$id'") or die($mysqli->error);
    }

    die("<script>Location.href=\"index.php?gerenciar_cursos\";</script>");
?>