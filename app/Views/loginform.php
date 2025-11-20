<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Login</h1>
    <form id="loginForm">
        <div>
            <label for="name">Name</label><br>
            <input type="text" id="name" name="name" required autofocus>
        </div>
        <div>
            <label for="password">Password</label><br>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
    </form>

    <!-- Link to Javascript file -->
    <script src="<?= $_ENV['APP_URL'] ?>/js/login.js"></script>
</body>
</html>