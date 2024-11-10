<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Общие стили */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        /* Стили для сообщений */
        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert-info {
            background-color: #cce5ff;
            color: #004085;
        }

        /* Структура карточек */
        .card-deck {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card {
            width: 30%;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card-body {
            padding: 20px;
            background-color: #fff;
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #333;
        }

        .card-text {
            font-size: 1rem;
            color: #555;
            margin-bottom: 20px;
        }

        .price, .amount, .sum-product {
            display: flex;
            justify-content: space-between;
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 10px;
        }

        .btn {
            padding: 10px;
            font-size: 1rem;
            text-transform: uppercase;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-danger {
            background-color: #f44336;
            color: white;
        }

        .btn-danger:hover {
            background-color: #d32f2f;
        }

        .btn-warning {
            background-color: #ff9800;
            color: white;
        }

        .btn-warning:hover {
            background-color: #f57c00;
        }

        /* Общая сумма */
        .total-sum {
            border-top: 2px solid #f1f1f1;
            padding-top: 20px;
            font-size: 1.5rem;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #333;
        }

        /* Стили для пустой корзины */
        .empty-cart {
            text-align: center;
            padding: 30px;
            background-color: #f7f7f7;
            border-radius: 10px;
        }

        .empty-cart a {
            text-decoration: none;
            color: #ff9800;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error'] ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success'] ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (empty($products)): ?>
        <div class="empty-cart">
            <h3>Ваша корзина пуста.</h3>
            <p>Перейдите в <a href="/catalog">каталог</a> для выбора товаров.</p>
        </div>
    <?php else: ?>
        <div class="card-deck">
            <?php foreach ($products as $product): ?>
                <div class="card">
                    <img class="card-img-top" src="<?= htmlspecialchars($product->getImage()) ?>" alt="<?= htmlspecialchars($product->getName()) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product->getName()) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($product->getDescription()) ?></p>
                        <div class="price">
                            <span>Цена:</span>
                            <span><?= htmlspecialchars($product->getPrice()) ?> руб.</span>
                        </div>
                        <div class="amount">
                            <span>Количество:</span>
                            <span><?= htmlspecialchars($product->getAmount()) ?></span>
                        </div>
                        <div class="sum-product">
                            <span>Итого:</span>
                            <span><?= number_format($product->getPrice() * $product->getAmount(), 2) ?> руб.</span>
                        </div>
                        <form action="/delete-from-cart" method="POST">
                            <input type="hidden" name="productId" value="<?= $product->getId() ?>">
                            <button type="submit" class="btn btn-danger w-100">Удалить из корзины</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="total-sum">
            <span>Общая сумма:</span>
            <span><?= number_format($totalSum, 2) ?> руб.</span>
            <form action="/order" method="POST">
                <button type="submit" class="btn btn-warning w-100">Оформить заказ</button>
            </form>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
