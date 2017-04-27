<?php
$link = db_connect();

if (isset($_GET['action']) && $_GET['action'] === 'success') {
    ?>
    <p class="success">Votre commande a bien été enregistrée !</p>
    <p><a href="?page=home">Retour à l'accueil</a></p>
    <p><a href="?page=products">Continuez les achats</a></p>
<?php
}

else if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0 && isset($_POST['action']) && $_POST['action'] === 'validation') {
    $cart = array_count_values($_SESSION['cart']);

    $res = sql_select_from_array($link, $_SESSION['cart'], 'product_id, stock, price', 'products', 'product_id', 'i');

    $total = 0;
    while ($product = mysqli_fetch_array($res)) {
        $qte = $cart[$product['product_id']];
        $total += $product['price'] * $qte;
    }

    $query = "INSERT INTO commands (user_id, total_price) VALUES('" . $_SESSION['user_id'] . "', '" . $total . "');";
    $res = mysqli_query($link, $query) or die(mysqli_error($link));
    $command_id = mysqli_insert_id($link);
    $query = '';
    foreach ($cart as $item => $qte) {
        $query .= "INSERT INTO commands_products (command_id, product_id, qte) VALUES('" . $command_id . "', '" . $item . "', '". $qte . "');";
    }
    mysqli_multi_query($link, $query) or die(mysqli_error($link));
    $_SESSION['cart'] = [];
    redirect_to('?page=validation_panier&action=success');
} else {
    redirect_to('?page=panier');
}