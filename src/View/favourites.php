<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
<main id="cart" style="max-width:960px">
    <div class="back"><a href="/catalog ">&#11178; В каталог</a></div>
    <h1>Избранное</h1>
    <div class="container-fluid">
        <div class="row align-items-start">
            <div class="col-12 col-sm-8 items">
                <!--1--> <?php foreach ($productsInFavourites as $product): ?>
                    <div class="cartItem row align-items-start">
                        <div class="col-3 mb-2"><img class="w-100" src="<?php echo $product['image']; ?>"
                                                     alt="art image"></div>
                        <div class="col-5 mb-2"><h6 class=""><?php echo $product['name']; ?></h6>
                            <p class="pl-1 mb-0"><?php echo $product['description']; ?></p></div>
                        <div class="col-2"><p
                                    class="cartItemQuantity p-1 text-center"><?php echo $product['amount']; ?></p></div>
                        <div class="col-2"><p id="cartItem1Price"> <?php echo "{$product['price']}руб" ?> </p></div>
                        <form action="/deleteFromWishlist" method="POST">
                            <button type="submit">Удалить из Избранного <input type="hidden" id="product-id"
                                                                               name="product-id"
                                                                               value="<?= $product['id']?>" required>
                            </button>
                        </form>
                    </div>
                    <hr>                <?php endforeach; ?>            </div>
        </div>
    </div>
</main>
<footer class="container"></footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
<style>    #cart {
        max-width: 1440px;
        padding-top: 60px;
        margin: auto;
    }

    .form div {
        margin-bottom: 0.4em;
    }

    .cartItem {
        --bs-gutter-x: 1.5rem;
    }

    .cartItemQuantity, .proceed {
        background: #f4f4f4;
    }

    .items {
        padding-right: 30px;
    }

    #btn-checkout {
        min-width: 100%;
    }

    /* stasysiia.com */
    @import url("https://fonts.googleapis.com/css2?family=Exo&display=swap");
    body {
        background-color: #fff;
        font-family: "Exo", sans-serif;
        font-size: 22px;
        margin: 0;
        padding: 0;
        color: #111111;
        justify-content: center;
        align-items: center;
    }

    a {
        color: #0e1111;
        text-decoration: none;
    }

    .btn-check:focus + .btn-primary, .btn-primary:focus {
        color: #fff;
        background-color: #111;
        border-color: transparent;
        box-shadow: 0 0 0 0.25rem rgb(49 132 253 / 50%);
    }

    button:hover, .btn:hover {
        box-shadow: 5px 5px 7px #c8c8c8, -5px -5px 7px white;
    }

    button:active {
        box-shadow: 2px 2px 2px #c8c8c8, -2px -2px 2px white;
    }

    /*PREVENT BROWSER SELECTION*/
    a:focus, button:focus, input:focus, textarea:focus {
        outline: none;
    }

    /*main*/
    main:before {
        content: "";
        display: block;
        height: 88px;
    }

    h1 {
        font-size: 2.4em;
        font-weight: 600;
        letter-spacing: 0.15rem;
        text-align: center;
        margin: 30px 6px;
    }

    h2 {
        color: rgb(37, 44, 54);
        font-weight: 700;
        font-size: 2.5em;
    }

    h3 {
        border-bottom: solid 2px #000;
    }

    h5 {
        padding: 0;
        font-weight: bold;
        color: #92afcc;
    }

    p {
        color: #333;
        font-family: "Roboto", sans-serif;
        margin: 0.6em 0;
    }

    h1, h2, h4 {
        text-align: center;
        padding-top: 16px;
    }

    /* yukito bloody */
    .back {
        position: relative;
        top: -30px;
        font-size: 16px;
        margin: 10px 10px 3px 15px;
    }

    .inline {
        display: inline-block;
    }

    .shopnow, .contact {
        background-color: #000;
        padding: 10px 20px;
        font-size: 30px;
        color: white;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.5s;
        cursor: pointer;
    }

    .shopnow:hover {
        text-decoration: none;
        color: white;
        background-color: #c41505;
    }

    /* for button animation*/
    .shopnow span {
        cursor: pointer;
        display: inline-block;
        position: relative;
        transition: all 0.5s;
    }

    .shopnow span:after {
        content: url("https://badux.co/smc/codepen/caticon.png");
        position: absolute;
        font-size: 30px;
        opacity: 0;
        top: 2px;
        right: -6px;
        transition: all 0.5s;
    }

    .shopnow:hover span {
        padding-right: 25px;
    }

    .shopnow:hover span:after {
        opacity: 1;
        top: 2px;
        right: -6px;
    }

    #product .container .row .pr4 {
        padding-right: 15px;
    }

    #product .container .row .pl4 {
        padding-left: 15px;
    }

    button {
        text-align: center;
        font-size: 14px;
        width: 30%;
        float: right;
    }</style>