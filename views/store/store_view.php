<?php
require_once __DIR__ . '/../../models/model.php';
require_once __DIR__ . '/../../models/products.php';
require_once __DIR__ . '/../../models/media.php';

// Skapa en databasanslutning
$connection = getDatabaseConnection();

// Hämta säljbara produkter från databasen
$saleableProducts = getProduct($connection);

$media = new Media(null, null, null); ?>

    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Store view</title>
        <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

    </head>

<body>
<header>
    <h1>GritStore - <i>Fresh fruit delivered to your doorstep</i></h1>
    <div>
        <ul style="display:flex;justify-content: left;gap:1rem; text-decoration: none;">
            <a href="../../index.php">Start page</a>

            <a href="../store/store_view.php">Store view</a>
            <a href="../admin/admin_view.php">Admin view</a>
            <a href="../store/order_confirmation_2.php">Order confirmation</a>
        </ul>
    </div>
</header>

<div class="container">

    <section class="product-section">
        <h2>Product gallery</h2>
        <div class="product-grid">
            <?php foreach ($saleableProducts as $product): ?>
                <div class="product-card">
                    <h3 class="product-name"><?php echo $product->getName(); ?></h3>
                    <?php $mediaPath = $media->getMediaPathById($connection, $product->getMedia()); ?>
                    <?php if ($mediaPath): ?>
                        <img class="product-image" src="<?php echo $mediaPath; ?>" alt="<?php echo $product->getName(); ?>">
                    <?php else: ?>
                        <p>No image for this product</p>
                    <?php endif; ?>
                    <p class="product-price">Price: <?php echo $product->getPrice(); ?> kr</p>

                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="order-section" style="padding:0 0 0 4rem;">
        <!-- Order form -->
        <form method="POST" action="../../controllers/process_order.php">
            <h2>Order form</h2>
            <?php foreach ($saleableProducts as $product) { ?>
                <div class="product-item">
                    <label for="product_<?php echo $product->getId(); ?>">
                        <input type="checkbox" id="product_<?php echo $product->getId(); ?>"
                               name="products[<?php echo $product->getId(); ?>]"
                               value="<?php echo $product->getId(); ?>">
                        <?php echo $product->getName(); ?>
                    </label>
                    <div class="product-quantity">
                        <label for="quantity_<?php echo $product->getId(); ?>"></label><input type="number"
                                                                                              id="quantity_<?php echo $product->getId(); ?>"
                                                                                              name="quantity[<?php echo $product->getId(); ?>]"
                                                                                              value="0"
                                                                                              min="0">

                    </div>
                </div>
            <?php } ?>


            <!-- Personal information fields -->
            <div class="personal-info">
                <label for="firstname">Firstname:</label>
                <input type="text" id="firstname" name="firstname" required>
                <label for="surname">Surname:</label>
                <input type="text" id="surname" name="surname" required>
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
                <label for="phone">Phone number:</label>
                <input type="tel" id="phone" name="phone" required>
                <label for="ssn">SSN:</label>
                <input type="text" id="ssn" name="ssn" required>
                <label for="address">Street address:</label>
                <input type="text" id="address" name="address" required>
                <label for="city">City:</label>
                <input type="text" id="city" name="city" required>
                <label for="zip">Zip code:</label>
                <input type="text" id="zip" name="zip" required>
            </div>

            <input type="submit" value="Place Order">
        </form>
    </section>


</div>
</body></html>