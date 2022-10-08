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
      display: flex;
      align-content: center;
    }

    nav ul li a {
      background:
        <?php
        echo $_ENV["HOST_THEME_COLOR"];
        ?>
    }
  </style>
  <script type="module">
    import api from "./api.js"

    const migratePersonForm = document.getElementById("migrate-person")
    const migrateAllPersonForm = document.getElementById("migrate-all-person")

    migratePersonForm.addEventListener('submit', (e) => {
      const form = e.target
      e.preventDefault()

      handleMigration(form.action)
    });

    migrateAllPersonForm.addEventListener('submit', (e) => {
      const form = e.target
      e.preventDefault()
      //TODO funkcis na migraciu všetkých uzlov
      //Vytiahne z nejakej konfigurácie (cez php) do pola adresy všetkých uzlov
      //precyklí sa cez ne a následne odošle požiadavku na všetky uzly
      //promise response bude tiež pole s odpoveďami o tom či ostatné uzly dostali požiadavku
      //požiadavka - ukladanie neúspešných migrácií do queue nebude prítomná
      return false
    })

    async function handleMigration(url) {

      if (!confirm('Po stlačení tlačidla OK sa zmigruje databáza na hostiteľskom uzli.')) return false
      try {
        //TODO dorobiť volanie na /migrate-script.php
        const response = await api.get(url)
        alert(response)
      } catch (e) {
        alert(e)
      }

    }

  </script>
</head>

<body>
  <nav>

    <div class="system-info">

      <?php
      echo $_ENV["HOST_NAME"];
      ?>
    </div>
    <ul>
      <div>
        <!-- TODO dropdown with liks to other nodes -->
        <li><a href="/">Domov</a></li>
        <li><a href="info.php">Info</a></li>
        <!-- TODO PMA link -->
      </div>
      <div>
        <li>
          <form id="migrate-person-form" action="migrate-person.php" method="post">
            <button type="submit">Migrate host</button>
          </form>
        </li>
        <li>
          <form id="migrate-all-person-form" action="migrate-all-person.php" method="post">
            <button type="submit">Migrate all nodes</button>
          </form>
        </li>
      </div>
    </ul>
  </nav>