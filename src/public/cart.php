<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location:/login");
}

$user_id = $_SESSION['user_id'];

$pdo = new PDO("pgsql:host=postgres;port=5432;dbname=mydb", 'user', 'pwd');

$stmt = $pdo->prepare("SELECT products.name AS product_name, products.image_link, products.description, products.price, users.name AS user_name, user_products.amount 
        FROM user_products 
        JOIN users ON users.id = user_products.user_id 
        JOIN products ON products.id = user_products.product_id 
        WHERE user_products.user_id = :user_id");

$stmt->execute(['user_id' => $user_id]);
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
    <div class="container">
        <h3>Оформление заказа</h3>
        <div class="card-deck">
            <?php foreach($products as $product): ?>
                <div class="card text-center">
                    <a href="#">
                        <div class="card-header">
                            Hit!
                        </div>
                        <img class="card-img-top" src="<?php echo $product['image_link'];?>" alt="Card image">
                        <div class="card-body">
                            <p class="card-text text-muted"><?php echo $product['product_name'];?></p>
                            <a href="#"><h5 class="card-title"><?php echo $product['description'];?></h5></a>
                            <div class="card-footer"><div class="card-header">
                                    Цена:
                                </div>
                                <?php echo $product['price'];?>
                        </div>
                            <div class="card-footer"><div class="card-header">
                                    Количество:
                                </div>
                                    <?php echo $product['amount'];?>
                            </div>
                            </>
                    </a>
                </div>
            <?php endforeach;?>
        </div>
    </div>


<style>
    body {
        font-style: sans-serif;
    }

    a {
        text-decoration: none;
    }

    a:hover {
        text-decoration: none;
    }

    h3 {
        line-height: 3em;
    }

    .card {
        max-width: 16rem;
    }

    .card:hover {
        box-shadow: 1px 2px 10px lightgray;
        transition: 0.2s;
    }

    .card-header {
        font-size: 13px;
        color: gray;
        background-color: white;
    }

    .text-muted {
        font-size: 11px;
    }

    .card-footer{
        font-weight: bold;
        font-size: 18px;
        background-color: white;
    }
</style>

?>