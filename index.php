<?php
session_start();
include 'functions/connect.php';
include 'functions/logout.php';
include 'functions/redirect_to.php';
include 'functions/sql_select_from_array.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <title>Minishop - <?php echo htmlspecialchars(htmlentities($_GET['page'])) ?></title>
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <header>
        <?php include ("header.php"); ?>
    </header>

    <div id="page_body">
        <div id="left_menu">
            <div id="categories">
                <h4>Parcourir par categorie</h4>
                <hr/>
                <?php include './modules/categories.php'; ?>
            </div>
        </div>
        <div id="content">
            <?php
                switch ($_GET['page']) {
                    case 'home':
                        include 'pages/home.php';
                        break;
                    case 'products':
                        include 'pages/list_products.php';
                        break;
                    case 'panier':
                        include 'pages/panier.php';
                        break;
                    case 'logout':
                        logout();
                        redirect_to('?page=home');
                        break;
                    case 'register':
                        include 'pages/register.php';
                        break;
                    case 'login':
                        include 'pages/login.php';
                        break;
                    case 'profile':
                        include 'pages/profile.php';
                        break;
                    case 'admin':
                        include 'pages/admin.php';
                        break;
                    case 'validation_panier':
                        include 'pages/validation_panier.php';
                        break;
                    default:
                        if (isset($_GET['page']))
                            include 'pages/404.php';
                        else
                            redirect_to('?page=home');
                        break;
                }
            ?>
        </div>
    </div>

    <footer>ft_minishop &copy, by schiad and wburgos</footer>

<script type="text/javascript" src="./js/main.js"></script>
</body>

</html>
