<?php
require_once("Conexion/Conexion.php");
$conn = Connetion::Conexcion();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $conn->prepare("SELECT c.accion, d.descripcion, t.nombre AS tipo, r.ruta
             FROM contenidos c
             LEFT JOIN descripcion d ON c.idDescripcion = d.idDescripcion
             LEFT JOIN multimedia m ON c.idContenido = m.idContenido
             LEFT JOIN tipo t ON m.idTipo = t.idTipo
             LEFT JOIN rutas r ON m.idRuta = r.idRuta
             WHERE c.idContenido = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contenido</title>

  <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Righteous&display=swap" rel="stylesheet">

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Montserrat', sans-serif;
      background: linear-gradient(to right, #0C2E8A, rgb(0, 7, 99));
      color: #fff;
      padding: 20px;
    }

    .main-container {
      max-width: 1200px;
      margin: auto;
      background-color: rgba(0, 0, 0, 0.4);
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
    }

    h1 {
      font-family: 'Righteous', cursive;
      font-size: 40px;
      margin-bottom: 10px;
      text-align: center;
    }

    .descripcion-general {
      font-size: 18px;
      text-align: center;
      margin-bottom: 30px;
      color: #ddd;
    }

    .media-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 20px;
    }

    .media-card {
      background-color: rgba(0, 0, 0, 0.5);
      padding: 15px;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.4);
      transition: transform 0.3s ease;
    }

    .media-card:hover {
      transform: scale(1.02);
    }

    img,
    video {
      width: 100%;
      height: auto;
      border-radius: 8px;
      margin-top: 10px;
    }

    a {
      text-decoration: none;
      color: #ffd;
      font-weight: bold;
      display: block;
      margin-top: 10px;
    }

    a:hover {
      color: #fff;
    }

    .boton-atras {
      text-align: center;
      margin-top: 35px;
    }

    .boton-atras button {
      padding: 12px 25px;
      font-size: 18px;
      border: none;
      border-radius: 8px;
      background-color: #444;
      color: white;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .boton-atras button:hover {
      background-color: #666;
    }

    .descripcion-general {
      font-size: 18px;
      text-align: justify;
      margin-bottom: 30px;
      color: #ddd;
      white-space: pre-line;

    }
  </style>
</head>

<body>
  <div class="main-container">
    <?php
    if ($result && count($result) > 0) {
      $titulo = htmlspecialchars($result[0]['accion']);
      $descripcion = htmlspecialchars($result[0]['descripcion']);
      echo "<h1>$titulo</h1>";
      echo "<p class='descripcion-general'>" . nl2br($descripcion) . "</p>";


      echo '<div class="media-grid">';
      foreach ($result as $row) {
        $tipo = strtolower($row['tipo']);
        $ruta = str_replace('../', '', $row['ruta']);
        $rutaSegura = htmlspecialchars($ruta);

        echo '<div class="media-card">';
        echo '<a href="' . $rutaSegura . '" target="_blank">';

        if ($tipo === "imagen" || $tipo === "image") {
          echo '<img src="' . $rutaSegura . '" alt="Imagen">';
        } elseif ($tipo === "video") {
          echo '<video controls><source src="' . $rutaSegura . '" type="video/mp4">Tu navegador no soporta video.</video>';
        } elseif ($tipo === "documento") {
          echo '<p>Haz clic para ver el documento</p>';
        } else {
          echo '<p>Tipo de contenido no disponible</p>';
        }

        echo '</a>';
        echo '</div>';
      }
      echo '</div>';
    } else {
      echo "<p>No se encontró contenido.</p>";
    }
    ?>
    <div class="boton-atras">
      <a href="index.php"><button>Atrás</button></a>
    </div>
  </div>
</body>

</html>