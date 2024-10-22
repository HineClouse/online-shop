<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформить заказ</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            margin-bottom: .5rem;
        }
        input[type="text"], input[type="tel"], textarea {
            width: 100%;
            padding: .5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: .75rem 1.5rem;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center">Оформить заказ</h2>
    <form action="/create-order" method="POST">
        <div class="form-group">
            <label for="name">Имя</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="family">Фамилия</label>
            <input type="text" id="family" name="family" required>
        </div>
        <div class="form-group">
            <label for="city">Город</label>
            <input type="text" id="city" name="city" required>
        </div>
        <div class="form-group">
            <label for="address">Адрес</label>
            <input type="text" id="address" name="address" required>
        </div>
        <div class="form-group">
            <label for="phone">Телефон</label>
            <input type="tel" id="phone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="comment">Комментарий</label>
            <textarea id="comment" name="comment"></textarea>
        </div>
        <button type="submit">Оформить заказ</button>
    </form>
</div>
</body>
</html>
