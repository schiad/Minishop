<?php
session_start();
$mysqli = db_connect();

$query = 'SELECT * FROM products';

if (isset($_GET['cat'])) {
    $query .= ', product_category WHERE products.product_id = product_category.product_id AND product_category.category_id = \'' . $_GET['cat'] . '\'';
}

$products = mysqli_query($mysqli, $query) or die("Error : " . mysqli_error($mysqli));

echo '<h2>';
if (isset($_GET['cat_name'])) {
    echo 'Produits « ' . urldecode($_GET['cat_name']) . ' »';
} else {
    echo 'Tous nos produits';
}
echo '</h2>';

while ($product = mysqli_fetch_array($products)) {
    if (!$product['active']) {
        continue;
    }
    $format = '.jpg';
    if (file_exists('img/' . $product["ref"] . '.png')) {
        $format = '.png';
    }

    $file = 'img/' . $product['ref'] . $format;

    $add_to_cart_url = '?page=products&add_to_cart=' . $product['product_id'];

    if (isset($_GET['cat'])) {
        $add_to_cart_url .= '&cat=' . $_GET['cat'] . '&cat_name=' . urlencode($_GET['cat_name']);
    }

    ?>

    <div class="product_display">
        <img width="150" height="150" src="<?php echo $file ?>" /><br/>
        <p>
            <?php echo $product['name'] . '<p class="price_tag">$' . $product['price'] . '</p>'?>
        </p>
        <p>
            <a href="<?php echo $add_to_cart_url ?>">I need this shit.</a>
        </p>
    </div>

<?php
}

mysqli_close($mysqli);
?>