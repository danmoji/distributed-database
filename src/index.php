<html>

<head>
    <title>Hello World</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            width: 100%;
        }

        nav {
            width: 100%;
            height: 80px;
            background-color: 
            <?php
                echo $_ENV["THEME_COLOR"];
            ?>;
        }
    </style>
</head>

<body>
    <nav>
        <div class="system-info">
            <?php
                echo 'My TENANT ID is ' . $_ENV["TENANT_ID"] . '!';

                /*TODO spravit jeden env spoločný kde načítaš všetky systémové premenné a do compose file daj iba unique tenant id */
            ?>
        </div>
    </nav>

</body>

</html>