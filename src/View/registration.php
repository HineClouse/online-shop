<div class="main">
    <form action="/registration" method="POST">
        <h1>Регистрация</h1>
        <p>Заполните данные для регистрации</p>

        <?php if (isset($errors['general'])): ?>
            <div class="error-message"><?php echo htmlspecialchars($errors['general']); ?></div>
        <?php endif; ?>

        <div class="form-group">
            <label for="name">Имя:</label>
            <input type="text"
                   name="name"
                   id="name"
                   value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"
                   placeholder="Введите ваше имя"
                   required>
            <?php if (isset($errors['name'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($errors['name']); ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email"
                   name="email"
                   id="email"
                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                   placeholder="Введите ваш email"
                   required>
            <?php if (isset($errors['email'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($errors['email']); ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password"
                   name="password"
                   id="password"
                   placeholder="Введите пароль"
                   required>
            <?php if (isset($errors['password'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($errors['password']); ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Подтверждение пароля:</label>
            <input type="password"
                   name="password_confirmation"
                   id="password_confirmation"
                   placeholder="Повторите пароль"
                   required>
            <?php if (isset($errors['password_confirmation'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($errors['password_confirmation']); ?></div>
            <?php endif; ?>
        </div>

        <p class="terms">Создавая аккаунт, вы соглашаетесь с нашими <a href="#" class="link">Условиями и Политикой конфиденциальности</a>.</p>

        <div class="wrap">
            <button type="submit">Зарегистрироваться</button>
        </div>
    </form>

    <div class="signin">
        <p>Уже есть аккаунт? <a href="/login" class="link">Войти</a></p>
    </div>
</div>

<style>
    /* Общие стили */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: system-ui, -apple-system, sans-serif;
        line-height: 1.5;
        min-height: 100vh;
        background: #f3f3f3;
        flex-direction: column;
        margin: 0;
    }

    /* Основной контейнер */
    .main {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        width: 100%;
        max-width: 500px;
        margin: 2rem;
    }

    /* Заголовки */
    h1 {
        color: #4CAF50;
        margin-bottom: 1rem;
        text-align: center;
    }

    h3 {
        color: #333;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    /* Формы */
    .form-group {
        margin-bottom: 1.5rem;
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
        color: #555;
        font-weight: 500;
    }

    input {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        background: #f8f8f8;
        transition: all 0.3s ease;
    }

    input:focus {
        border-color: #4CAF50;
        background: #fff;
        outline: none;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
    }

    /* Кнопки */
    button {
        width: 100%;
        padding: 0.75rem;
        border: none;
        border-radius: 8px;
        background-color: #4CAF50;
        color: white;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    button:hover {
        background-color: #45a049;
        transform: translateY(-1px);
    }

    /* Ссылки */
    .link {
        color: #4CAF50;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .link:hover {
        color: #45a049;
        text-decoration: underline;
    }

    /* Сообщения об ошибках */
    .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        padding: 0.5rem;
        background-color: rgba(220, 53, 69, 0.1);
        border-radius: 4px;
    }

    /* Дополнительные элементы */
    .terms {
        font-size: 0.875rem;
        color: #666;
        margin: 1rem 0;
        text-align: center;
    }

    .signin {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e0e0e0;
        text-align: center;
    }

    /* Адаптивность */
    @media (max-width: 600px) {
        .main {
            margin: 1rem;
            padding: 1.5rem;
        }
    }
</style>