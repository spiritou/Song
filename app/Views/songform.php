<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Song</h1>
    <input type="text" id="songName" placeholder="Enter song name">
    <button id="addBtn">add</button>
    <ul id="songList"></ul>
    <button id="LogoutBtn">Logout</button>
    <script>
         const APP_URL = "<?= $_ENV['APP_URL'] ?>";
    </script>
    <script src="js/song.js"></script>
    <script src="js/logout.js"></script>
</body>
</html>