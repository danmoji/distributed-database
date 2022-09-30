<html>
<head>
    <title>Hello World</title>
    <link rel="stylesheet" href="style.css">
    <style>
        nav {
          background-color: 
            <?php
                echo $_ENV["HOST_THEME_COLOR"];
            ?>;
        }
    </style>
</head>

<body>
    <nav>
        <div class="system-info">
            <?php
                echo 'My TENANT ID is ' . $_ENV["HOST_ID"] . '!';

                /*TODO jeden env spoločný kde načítaš všetky systémové premenné a do compose file daj iba unique tenant id */
                /*TODO SQL connections */
                
            ?>

        </div>
    </nav>

    <main>
        <form action="get-data.php" method="post">
            <h3>Formulár</h3>
            <label for="name">
                Meno
                <input type="text" name="name" id="name">
            </label>
            <button type="submit">Odoslať</button>
        </form>
        <br>
        <br>
        <?php
            // print "<pre>";
            // print_r($_ENV);
            // print "</pre>";
        ?>
    </main>

</body>

</html>