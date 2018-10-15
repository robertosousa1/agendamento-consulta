<?php

session_start();

include_once("../bd/connection.php");

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {
    $result_events = "DELETE FROM consultas WHERE id = $id";
    $resultado_events = mysqli_query($connection, $result_events);

    if (mysqli_affected_rows($connection)) {
        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>O Evento apagado com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        header("Location: ../index.php");
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao apagar o evento <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        header("Location: ../index.php");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao apagar o evento <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    header("Location: ../index.php");
}

