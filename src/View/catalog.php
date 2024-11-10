<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Наш каталог</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Общие стили */
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #ffecd2, #fcb69f); /* Градиентный фон */
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #333;
            text-align: center;
            margin-bottom: 40px;
        }

        .card {
            border: 2px solid #ffc107;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.2);
        }

        .card-img-top {
            height: 250px;
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
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
            color: #777;
            margin-bottom: 20px;
        }

        .btn {
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-outline-dark {
            border: 1px solid #343a40;
            color: #343a40;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }

        .btn-outline-dark:hover {
            background-color: #343a40;
            color: white;
        }

        .btn-warning {
            background-color: #ffc107;
            border: none;
            color: #333;
            padding: 10px 20px;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-outline-danger {
            border: 1px solid #dc3545;
            color: #dc3545;
            padding: 10px 20px;
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: white;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
        }

        .col {
            flex: 1 1 calc(33.33% - 30px);
            max-width: 330px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            font-weight: 600;
            color: #555;
        }

        .form-control {
            font-size: 1rem;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #ffc107;
        }

        /* Мобильная адаптивность */
        @media (max-width: 768px) {
            .col {
                flex: 1 1 calc(50% - 20px);
            }
        }

        @media (max-width: 576px) {
            .col {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>

<div class="container mt-5 pb-5">
    <h2>Наш каталог</h2>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($products as $product): ?>
            <div class="col">
                <div class="card h-100">
                    <img class="card-img-top rounded-top" src="<?= htmlspecialchars($product->getImage()) ?>" alt="<?= htmlspecialchars($product->getName()) ?>">
                    <div class="card-body">
                        <h5 class="card-title text-center text-dark"><?= htmlspecialchars($product->getName()) ?></h5>
                        <p class="card-text text-muted"><?= htmlspecialchars($product->getDescription()) ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-dark font-weight-bold"><?= htmlspecialchars($product->getPrice()) ?> ₽</span>
                            <button class="btn btn-sm btn-outline-dark">Подробнее</button>
                        </div>
                    </div>
                </div>

                <!-- Форма добавления в корзину -->
                <form action="/add-product" method="POST" class="mt-3">
                    <input type="hidden" name="product-id" value="<?= $product->getId() ?>">
                    <div class="form-group">
                        <label for="amount" class="form-label">Количество</label>
                        <input type="number" name="amount" id="amount" class="form-control" placeholder="Количество" required>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 mt-2">Добавить в корзину</button>
                </form>

                <!-- Форма добавления в избранное -->
                <form action="/add-to-favourites" method="POST" class="mt-2">
                    <input type="hidden" name="productId" value="<?= $product->getId() ?>">
                    <input type="hidden" name="amount" value="1">
                    <input type="hidden" name="price" value="<?= $product->getPrice() ?>">
                    <button type="submit" class="btn btn-outline-danger w-100">Добавить в избранное</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
