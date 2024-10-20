<div class="container mt-5 pb-5">
    <h2 class="text-center text-uppercase font-weight-bold mb-5">Наш каталог</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($products as $product): ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0 rounded-lg" style="border: 2px solid #ffc107;">
                    <img class="card-img-top rounded-top" src="<?php echo $product['image']; ?>" alt="Card image">
                    <div class="card-body">
                        <h5 class="card-title text-center text-dark font-weight-bold"><?php echo $product['name']; ?></h5>
                        <p class="card-text text-muted"><?php echo $product['description']; ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-dark font-weight-bold"><?php echo $product['price']; ?></span>
                            <button class="btn btn-sm btn-outline-dark">Подробнее</button>
                        </div>
                    </div>
                </div>
                <form action="/add-product" method="POST" class="mt-3">
                    <input type="hidden" name="product-id" value="<?= $product['id'] ?>">
                    <div class="form-group">
                        <label for="amount" class="form-label">Количество</label>
                        <input type="number" name="amount" id="amount" class="form-control" placeholder="Количество" required>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 mt-2">Добавить в корзину</button>
                </form>
                <form action="/add-to-favourites" method="POST" class="mt-2">
                    <input type="hidden" name="productId" value="<?= $product['id']?>">
                    <input type="hidden" name="amount" value="1">
                    <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                    <button type="submit" class="btn btn-outline-danger w-100">Добавить в избранное</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(to right, #ffecd2, #fcb69f);
        color: #333;
    }
    .container {
        max-width: 1200px;
        margin: 0 auto;
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
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
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    .card-text {
        font-size: 1rem;
        margin-bottom: 1.5rem;
    }
    .btn-outline-dark {
        border: 1px solid #343a40;
        color: #343a40;
    }
    .btn-outline-dark:hover {
        background-color: #343a40;
        color: white;
    }
    .btn-warning {
        background-color: #ffc107;
        border: none;
        color: #333;
    }
    .btn-warning:hover {
        background-color: #e0a800;
    }
    .btn-outline-danger {
        border: 1px solid #dc3545;
        color: #dc3545;
    }
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
    .card {
        transition: box-shadow .3s ease-in-out;
        border-radius: 10px;
        overflow: hidden;
    }
    .card:hover {
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.2);
    }
    .text-muted {
        color: #6c757d !important;
    }
</style>
