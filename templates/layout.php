<html>

<head>
    <meta charset="utf-8" />
    <title>Lazy brain</title>
    <meta name="description" content="" />
    <link rel="stylesheet" href="../public/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gruppo&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet">
    <script type="text/javascript" src=""></script>
</head>

<body>
    <header>
        <h1>Lazy brain</h1>
    </header>
    <section class="container">
        <nav>
            <div class="menu">
                <ul>
                    <li>
                        <a href="/">Lista Notatek</a>
                    </li>
                    <li>
                        <a href="?action=create">Nowa Notatka</a>
                    </li>
                </ul>
            </div>
        </nav>
        <article class="main-content">
            <?php require_once("./templates/pages/$page.php"); ?>

        </article>
    </section>
</body>

<footer>
    <h3>STOPKA</h3>
</footer>

</html>