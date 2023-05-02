<?php
    require_once "../config/DB.php";
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $db = DB::getInstance();
    $cart = $db->getActiveUserCart($_SESSION['user']->getId());
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/custom-styles.css">
        <title>Order details - ShopyShop</title>
    </head>
    <body>
        <?php include_once '../includes/navbar.php' ?>

        <h1 class="text-center text-primary my-3">Order details</h1>
        <hr>
        <div class="container">
            <form action="../scripts/checkout.php" method="post">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="delivery_address" name="delivery_address" placeholder="Delivery address" required>
                    <label for="delivery_address" class="form-label">Delivery address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="recipient_fullname" name="recipient_fullname" placeholder="Recipient full name" required>
                    <label for="recipient_fullname" class="form-label">Recipient full name</label>
                </div>
                <h3 class="text-center">Payment method:</h3>
                <div class="form-check my-3">
                    <input type="radio" class="form-check-input" name="payment" value="0" id="paymentOnRetreival">
                    <label for="paymentOnRetreival" class="form-check-label">On retreival</label>
                </div>
                <div class="form-check my-3">
                    <input type="radio" class="form-check-input" name="payment" value="1" id="paymentWithCard">
                    <button type="button" class="d-none" id="hiddenButton" data-bs-toggle="collapse" data-bs-target="#cardDetails" aria-expanded="false" aria-controls="cardDetails"></button>
                    <label for="paymentWithCard" class="form-check-label">Enter card data</label>
                </div>
                <div class="form-group collapse" id="cardDetails">
                    <!--DUMMY DATA. THIS DOES NOTHING AND ADDED ONLY FOR LOOK.-->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="card_number" name="card_number" placeholder="Card number">
                        <label for="card_number" class="form-label">Card number</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="card_expiration_date" name="card_expiration_date" placeholder="Card expiration date">
                        <label for="card_expiration_date" class="form-label">MM/DD</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="card_cvv" name="card_cvv" placeholder="Card CVV">
                        <label for="card_cvv" class="form-label">CVV</label>
                    </div>
                </div>
                <p class="my-4">Total: <span class="text-warning"><?php echo $_GET['total']?>₴</span></p>
                <button type="submit" class="btn btn-success">Checkout</button>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            const paymentWithCard = document.getElementById('paymentWithCard');
            const paymentOnRetreival = document.getElementById('paymentOnRetreival');
            const hiddenButton = document.getElementById('hiddenButton');
            
            function toggleCardDetails(state) {
                const cardDetails = document.getElementById('cardDetails');
                if (state != cardDetails.classList.contains('show')) {
                    hiddenButton.click();
                }
            }

            paymentWithCard.addEventListener('change', () => {
                toggleCardDetails(true);
            });

            paymentOnRetreival.addEventListener('change', () => {
                toggleCardDetails(false);
            });

        </script>
    </body>
</html>