<?php

require $_SERVER['DOCUMENT_ROOT'] . '\videoclub\lib\functions\session_functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '\videoclub\lib\functions\db_functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '\videoclub\lib\functions\user_functions.php';

require $_SERVER['DOCUMENT_ROOT'] . '\videoclub\lib\model\Usuario.php';
require $_SERVER['DOCUMENT_ROOT'] . '\videoclub\lib\model\Pelicula.php';
require $_SERVER['DOCUMENT_ROOT'] . '\videoclub\lib\model\Actor.php';

// Check if the user has registered
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../../index.php?redirected=true");
}

$user = $_SESSION['user'];
if ($user->getRol() !== 1) {
    header("Location: ../../index.php?redirected=true");
}

$titleCheck = false;
$generoCheck = false;
$paisCheck = false;
$anyoCheck = false;
$cartelCheck = false;
$idCheck = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Use isset() to check if the value is set, and consider 0 as valid
    if (!isset($_POST['id'])) {
        $idCheck = true;
    }

    if (!isset($_POST['titulo']) || trim($_POST['titulo']) === '') {
        $titleCheck = true;
    }

    if (!isset($_POST['genero']) || trim($_POST['genero']) === '') {
        $generoCheck = true;
    }

    if (!isset($_POST['pais']) || trim($_POST['pais']) === '') {
        $paisCheck = true;
    }

    if (!isset($_POST['anyo']) || trim($_POST['anyo']) === '') {
        $anyoCheck = true;
    }

    if (!isset($_POST['cartel']) || trim($_POST['cartel']) === '') {
        $cartelCheck = true;
    }

    // If any error occurred then redirect
    if ($titleCheck || $generoCheck || $paisCheck || $anyoCheck || $cartelCheck || $idCheck) {
        header('Location: ../../../pages/adminPages/updateMoviePage.php?redir&titulo=' . urlencode(trim($_POST['titulo'])) . '&genero=' . urlencode($_POST['genero']) . '&pais=' . urlencode($_POST['pais']) . '&anyo=' . urlencode($_POST['anyo']) . '&cartel=' . urlencode($_POST['cartel']));
        exit;
    }

    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
    $genero = filter_input(INPUT_POST, 'genero', FILTER_SANITIZE_SPECIAL_CHARS);
    $pais = filter_input(INPUT_POST, 'pais', FILTER_SANITIZE_SPECIAL_CHARS);
    $anyo = filter_input(INPUT_POST, 'anyo', FILTER_SANITIZE_SPECIAL_CHARS);
    $cartel = filter_input(INPUT_POST, 'cartel', FILTER_SANITIZE_SPECIAL_CHARS);

    updateMovie($id, $titulo, $genero, $pais, $anyo, $cartel);
}
?>
