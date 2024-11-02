<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина</title>
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
        .price, .amount, .sum-product, .total-sum {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
        }
        .total-sum {
            border-top: 2px solid #ffc107;
            padding-top: 20px;
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
<div class="container mt-5 pb-5">
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
        <div class="alert alert-info">
            Ваша корзина пуста. Перейдите в <a href="/catalog">каталог</a> для выбора товаров.
        </div>
    <?php else: ?>
        <div class="card-deck">
            <?php foreach ($products as $product): ?>
                <div class="card">
                    <img class="card-img-top rounded-top"
                         src="<?= htmlspecialchars($product->getImage()) ?>"
                         alt="<?= htmlspecialchars($product->getName()) ?>">
                    <div class="card-body">
                        <h5 class="card-title text-center text-dark font-weight-bold">
                            <?= htmlspecialchars($product->getName()) ?>
                        </h5>
                        <p class="card-text text-muted">
                            <?= htmlspecialchars($product->getDescription()) ?>
                        </p>
                        <div class="price">
                            <span class="text-muted">Цена:</span>
                            <span class="text-dark font-weight-bold">
                                    <?= htmlspecialchars($product->getPrice()) ?> руб.
                                </span>
                        </div>
                        <div class="amount">
                            <span class="text-muted">Количество:</span>
                            <span class="text-dark font-weight-bold">
                                    <?= htmlspecialchars($product->getAmount()) ?>
                                </span>
                        </div>
                        <div class="sum-product">
                            <span class="text-muted">Итого:</span>
                            <span class="text-dark font-weight-bold">
                                    <?= number_format($product->getPrice() * $product->getAmount(), 2) ?> руб.
                                </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="total-sum mt-4">
            <span>Общая сумма:</span>
            <span><?= number_format($totalSum, 2) ?> руб.</span>
            <form action="/order" method="GET" class="mt-2">
                <button type="submit" class="btn btn-warning w-100 mt-2">
                    Оформить заказ
                </button>
            </form>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
