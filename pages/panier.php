<?php
session_start();
$mysqli = db_connect();

echo '<p>';
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    $query = 'SELECT * FROM products';
    foreach ($_SESSION['cart'] as $index => $product_id) {
        if ($index === 0) {
            $query .= ' WHERE product_id = ' . intval($product_id);
        } else {
            $query .= ' OR product_id = ' . intval($product_id);
        }
    }

    $res = mysqli_query($mysqli, $query) or die("Error : " . mysqli_error($mysqli));

    echo '<p>Votre panier contient les articles suivants:</p>';
    $total_price = 0;
    while ($product = mysqli_fetch_array($res)) {
        if (!$product['active']) {
            continue;
        }
        $qte = array_count_values($_SESSION['cart'])[$product['product_id']];
        $total_price += $product['price'] * $qte;

        $format = '.jpg';
        if (file_exists('img/' . $product["ref"] . '.png')) {
            $format = '.png';
        }

        $file = 'img/' . $product['ref'] . $format;
        ?>

        <div class="product_display">
            <img width="150" height="150" src="<?php echo $file ?>" /><br/>
            <p>
                <?php echo $product['name'] . '<p class="price_tag">$' . $product['price'] . '</p>' ?>
                <p>Quantité: <?php echo $qte ?></p>
                <a href="?page=panier&del=<?php echo $product['product_id'] ?>">Enlever du panier</a>
            </p>
        </div>
        <?php
    }

    echo '<p>TOTAL: $' . $total_price . '</p>';

    if (isset($_SESSION['loggued_on_user'])) {
        ?>
        <form action="?page=validation_panier" method="post">
            <input type="hidden" name="action" value="validation"/>
            <button type="submit">Valider ma commande</button>
        </form>
        <?php
    } else {
        echo '<p>Veuillez vous enregistrer et vous connectez pour pouvoir valider votre commande.</p>';
    }
} else {
    echo '<p>Votre panier est vide ...</p>';
    echo '<a href="?page=products">Voir tous les produits</a>';
}

mysqli_close($mysqli);