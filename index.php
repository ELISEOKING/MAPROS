<?php
require_once("Conexion/Conexion.php");
$conn = Connetion::Conexcion();
$stmt = $conn->prepare("
SELECT a.idContenido, a.accion, c.ruta, tt.nombre
FROM contenidos AS a
INNER JOIN multimedia AS b ON a.idContenido = b.idContenido
INNER JOIN rutas AS c ON c.idRuta = b.idRuta
INNER JOIN tipo AS tt ON tt.idTipo = b.idTipo
WHERE c.idRuta = (
    SELECT MIN(c2.idRuta)
    FROM multimedia AS b2
    INNER JOIN rutas AS c2 ON c2.idRuta = b2.idRuta
    WHERE b2.idContenido = a.idContenido
);
");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Instituto Superior Tecnológico Isabel la Católica</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/home.css">
  <style>

  </style>
</head>

<body>

  <header class="fixed top-0 left-0 w-full bg-gray-800 text-white shadow-md z-10 py-4">
    <div class="max-w-screen-xl mx-auto px-4 flex justify-center items-center h-15">
      <img src="img/icono.png" alt="Logo" class="h-14 w-14 mr-2">
      <h1 class="text-xl font-bold">Instituto Superior Tecnológico Isabel la Católica</h1>
    </div>
  </header>

  <main>
    <div class="carousel" id="carousel">
      <?php
      $contador = 1;
      foreach ($result as $row) {
        echo '<div class="card" id="card' . $contador . '" data-id="card' . $contador . '" tabindex="0">';
        echo '<h3>"'. $row["accion"] . '"</h3>';
        $j = 0;
        for ($j = 0; $j < 1; $j++) {

          if ((!isset($row['ruta']) || $row['nombre']=='Video')) {
            
          echo '<img src="./img/user.png" alt="">';
          } else {
            $subcadenas = explode("/", $row["ruta"]);
            echo '<img src="./Multimedia/' . $subcadenas[2] . '/' . $subcadenas[3] . '" alt="">';
          }

        }
        echo '</div>';
        $contador++;
      }
      ?>
    </div>

    <div class="wrapper">
      <ul class="bg-bubbles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
      </ul>
    </div>

  </main>


  <footer class="w-full bg-gray-800 text-white mt-auto z-10 relative">
    <div class="max-w-screen-xl mx-auto px-4 py-4">
      <div class="flex justify-center items-center h-16">
        <h1 class="text-xl font-bold">© Todos los derechos reservados Instituto Isabel la Católica 2025</h1>
      </div>
    </div>
  </footer>

  <!-- Fondo para popup -->
  <div id="popup-bg"></div>

  <?php
  $contador = 1;
  foreach ($result as $row) {
    echo '<div id="popup-card' . $contador . '" class="popup" role="dialog" aria-modal="true" aria-labelledby="popup-title' . $contador . '" aria-describedby="popup-desc' . $contador . '">';
    echo '<h2 id="popup-title' . $contador . '">' . htmlspecialchars($row["accion"]) . '</h2>';
    echo '<p id="popup-desc' . $contador . '">INFORMACION SOBRE : "' . htmlspecialchars($row["accion"]) . '"</p>';
    echo '<a href="pagina.php?id=' . $row["idContenido"] . '"><button>Ir a la página</button></a>';
    echo '<button class="popup-close" onclick="closePopup()" aria-label="Cerrar ventana">Cerrar</button>';
    echo '</div>';
    $contador++;
  }
  ?>



  <script src="js/carrusel.js">
  </script>
</body>

</html>