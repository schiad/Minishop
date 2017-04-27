<?php
session_start();

$co = db_connect();

if (isset($_GET['add_to_cart'])) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $query = 'SELECT product_id FROM products WHERE product_id = ' . intval($_GET['add_to_cart']);
    $res = mysqli_query($co, $query) or die(mysqli_error($co));
    if (mysqli_num_rows($res) > 0) {
        $_SESSION['cart'][] = $_GET['add_to_cart'];
    }
}

$nb_articles = 0;

if (isset($_SESSION['cart'])) {
    if (isset($_GET['del'])) {
        if(($key = array_search($_GET['del'], $_SESSION['cart'])) !== false) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
    }

    $nb_articles = count($_SESSION['cart']);
}

echo '<span id="panier_link"><a href="?page=panier">Votre panier</a> (' . $nb_articles . ' articles)</span>';

mysqli_close($co);