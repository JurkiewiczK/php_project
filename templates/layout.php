<html>

<head>
    <meta charset="utf-8" />
    <title>Memo</title>
    <meta name="" content="" />
    <link rel="stylesheet" href="public/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gruppo&display=swap" rel="stylesheet">
    <script type="text/javascript" src=""></script>
</head>

<body>
    <header>
        <h1>memo</h1>
    </header>
    <section class="container">
        <nav>
            <div class="menu">
                <ul>
                    <li>
                        <a href="/php_project">memo</br>list</a>
                    </li>
                    <li>
                        <a href="/php_project/?action=create">new</br>memo</a>
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
    <h3>JurkiewiczK 2022 &reg;</h3>
</footer>

</html>