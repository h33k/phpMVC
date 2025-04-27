<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP MVC</title>
</head>
<body>
    <style>
        body {
            font-family: "Segoe UI Historic", sans-serif;
        }
        p {
            margin: 0;
        }
        .book {
            margin-bottom: 20px;
        }
    </style>
    <h1>Hello there. Here is some books for example:</h1>
    <?php
    if ($books) {
        foreach($books as $book): ?>
            <div class="book">
                <p>title: <strong><?= $book['title'] ?></strong></p>
                <p>author: <strong><?= $book['author'] ?></strong></p>
                <p>year: <strong><?= $book['published_year'] ?></strong></p>
                <p>genre: <strong><?= $book['genre'] ?></strong></p>
            </div>
        <?php endforeach;
    } else {
        echo "<p>Looks like your books table is empty</p>";
    }
    ?>
</body>
</html>