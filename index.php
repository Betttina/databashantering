<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GritStore - Fresh fruit delivered to your doorstep</title>
    <link rel="stylesheet" type="text/css" href="assets/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>

<body>
<header>
    <h1>GritStore - <i>Fresh fruit delivered to your doorstep</i></h1>
    <div>
        <ul style="display:flex;justify-content: left;gap:1rem; text-decoration: none;">
            <a href="./index.php">Start page</a>
            <a href="views/store/store_view.php">Store view</a>
            <a href="views/admin/admin_view.php">Admin view</a>
            <a href="views/store/order_confirmation.php">Order confirmation</a>
        </ul>
    </div>
</header>

<div class="orange">
    <img src="https://images.unsplash.com/photo-1597714026720-8f74c62310ba?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Italian Trulli">
</div>

<footer style="background-color: #333; color: #fff; padding: 20px;">
    <div class="footer-content" style="display: flex; justify-content: space-between; align-items: center;">
        <div class="footer-logo">
            <h3>GritStore</h3>
        </div>
        <div class="footer-links">
            <ul style="list-style: none; padding: 0; margin: 0; display: flex;">
                <li><a href="./index.php" style="text-decoration: none; color: #fff; margin-right: 20px;">Start page</a></li>
                <li><a href="views/store/store_view.php" style="text-decoration: none; color: #fff; margin-right: 20px;">Store view</a></li>
                <li><a href="views/store/order_confirmation.php" style="text-decoration: none; color: #fff; margin-right: 20px;">Order confirmation</a></li>
                <li><a href="views/admin/admin_view.php" style="text-decoration: none; color: #fff; margin-right: 20px;">Admin view</a></li>

            </ul>
        </div>
    </div>
    <div class="footer-copyright" style="text-align: center; margin-top: 10px;">
        &copy; <?php echo date("Y"); ?> GritStore. All rights reserved.
    </div>
</footer></body>

</html>