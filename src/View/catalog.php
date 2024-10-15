<div class="container">
    <h3>Catalog</h3>
    <div class="card-deck">
        <?php foreach($products as $product): ?>
        <div class="card text-center">
            <a href="#">
                <div class="card-header">
                    Hit!
                </div>
                <img class="card-img-top" src="<?php echo $product['image'];?>" alt="Card image">
                <div class="card-body">
                    <p class="card-text text-muted"><?php echo $product['name'];?></p>
                    <a href="#"><h5 class="card-title"><?php echo $product['description'];?></h5></a>
                    <div class="card-footer">
                        <?php echo $product['price'];?>
                    </div>
                </div>
            </a>
        </div>
            <form action="/add-product" method="POST">
                <div class="container">
                    <h1>Корзина</h1>
                    <hr>

                    <label for="name"><b>Product-id</b></label>
                    <label><?php if (isset($errors['product-id'])): ?>
                            <?php print_r($errors['product-id'] ?? null); ?>
                        <?php endif ?>
                    </label>
                    <input type="hidden"
                           name="product-id"
                           id="product-id"
                           value="<?= $product['id']?>
                           placeholder="Enter product-id" required>

                    <label for="name"><b>Amount</b></label>
                    <label>
                        <?php print_r($errors['amount'] ?? null); ?>
                    </label>
                    <input type="text"
                           name="amount"
                           id="amount"
                           placeholder="Enter amount" required>
                    <hr>
                    <button type="submit" class="registerbtn">Добавить корзину</button>
                </div>

                <div class="container signin">
                    <p>Already have an account? <a href="#">Sign in</a>.</p>
                </div>
            </form>
        <?php endforeach ?>


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
