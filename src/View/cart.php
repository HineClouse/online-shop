<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "User not logged in."; // Отладочный вывод
    header("Location:/login");
    exit();
}

$user_id = $_SESSION['user_id'];
var_dump($user_id); // Отладочный вывод

$pdo = new PDO("pgsql:host=postgres;port=5432;dbname=mydb", 'user', 'pwd');
$stmt = $pdo->prepare("SELECT products.name AS productName, products.image AS image, products.description, products.price, users.name AS userName, user_products.amount
    FROM user_products
    JOIN users ON users.id = user_products.user_id
    JOIN products ON products.id = user_products.product_id
    WHERE user_products.user_id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформление заказа</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .card-body {
            padding: 1.5rem;
        }
        .card-title {
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }
        .card-text {
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }
        .card {
            transition: box-shadow .3s ease-in-out;
            border-radius: 10px;
            overflow: hidden;
            border: 2px solid #ffc107;
        }
        .card:hover {
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.2);
        }
        .text-muted {
            color: #6c757d !important;
        }
        .price, .amount {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
        }
    </style>
</head>
<body>
<div class="container mt-5 pb-5">
    <h2 class="text-center text-uppercase font-weight-bold mb-5">Оформление заказа</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($products as $product): ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0 rounded-lg">
                    <img class="card-img-top rounded-top" src="<?php echo $product['image_link']; ?>" alt="Card image">
                    <div class="card-body">
                        <h5 class="card-title text-center text-dark font-weight-bold"><?php echo $product['product_name']; ?></h5>
                        <p class="card-text text-muted"><?php echo $product['description']; ?></p>
                        <div class="price">
                            <span class="text-muted">Цена:</span>
                            <span class="text-dark font-weight-bold"><?php echo $product['price']; ?> руб.</span>
                        </div>
                        <div class="amount">
                            <span class="text-muted">Количество:</span>
                            <span class="text-dark font-weight-bold"><?php echo $product['amount']; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
