<form action="handle_registration.php" method="POST">
    <div class="container">
        <h1>Регистрация</h1>
        <p>Заполните данные для регистрации</p>
        <hr>

        <label for="name"><b>Name</b></label>
        <input type="text"
               name="name"
               id="name"
               placeholder="<?php if (empty($errors['name'])) { echo 'enter your name'; } else { echo $errors['name']; } ?>" required>

        <label for="email"><b>Email</b></label>
        <input type="text"
               name="email"
               id="email"
               placeholder="<?php if (empty($errors['email'])) { echo 'enter your email'; } else { echo $errors['email']; } ?>" required>

        <label for="psw"><b>Password</b></label>
        <input type="password"
               name="psw"
               id="psw"
               placeholder="<?php if (empty($errors['psw'])) { echo 'enter your password'; } else { echo $errors['psw']; } ?>" required>

        <label for="psw-repeat"><b>Repeat Password</b></label>
        <input type="password"
               name="psw-repeat"
               id="psw-repeat"
               placeholder="<?php if (empty($errors['psw-repeat'])) { echo 'repeat your password'; } else { echo $errors['psw-repeat']; } ?>" required>
        <hr>

        <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
        <button type="submit" class="registerbtn">Register</button>
    </div>

    <div class="container signin">
        <p>Already have an account? <a href="#">Sign in</a>.</p>
    </div>
</form>

<style>
    * {box-sizing: border-box}

    /* Add padding to containers */
    .container {
        padding: 16px;
    }

    /* Full-width input fields */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus, input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    /* Overwrite default styles of hr */
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    /* Set a style for the submit/register button */
    .registerbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .registerbtn:hover {
        opacity: 1;
    }

    /* Add a blue text color to links */
    a {
        color: dodgerblue;
    }

    /* Set a grey background color and center the text of the "sign in" section */
    .signin {
        background-color: #f1f1f1;
        text-align: center;
    }
</style>