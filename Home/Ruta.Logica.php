<?php
require_once("../Conexion/Conexion.php");

class Actualizar
{
    static public function AgregarMultimedia()
    {
        if (isset($_POST['btn_agregar'])) {
            $conn = Connetion::Conexcion();

            $idContenido = $_POST['idContenido'];
            if (!$idContenido || !is_numeric($idContenido)) {
                echo "<script>alert('Debe seleccionar una acción válida.');</script>";
                return;
            }


            $tipo = $_POST['tipo'];
            $nombreArchivo = $_FILES['archivo']['name'];
            $archivoTemporal = $_FILES['archivo']['tmp_name'];
            $baseCarpeta = "../Multimedia/";


            switch ($tipo) {
                case 'image':
                    $subcarpeta = "Imagenes/";
                    $idTipo = 1;
                    break;
                case 'video':
                    $subcarpeta = "Videos/";
                    $idTipo = 2;
                    break;
                case 'documento':
                    $subcarpeta = "documentos/";
                    $idTipo = 3;
                    break;
                default:
                    $subcarpeta = "otros/";
                    $idTipo = null;
            }
            $carpeta = $baseCarpeta . $subcarpeta;
            if (!is_dir($carpeta)) {
                mkdir($carpeta, 0777, true);
            }

            $ruta = $carpeta . basename($nombreArchivo);

            if (move_uploaded_file($archivoTemporal, $ruta)) {
                $stmt2 = $conn->prepare("INSERT INTO rutas (ruta) VALUES (:ruta)");
                $stmt2->bindParam(':ruta', $ruta);
                $stmt2->execute();
                $idRuta = $conn->lastInsertId();



                $stmt3 = $conn->prepare("INSERT INTO multimedia (idTipo, idContenido, idRuta) VALUES (:idTipo, :idContenido, :idRuta)");
                $stmt3->bindParam(':idTipo', $idTipo);
                $stmt3->bindParam(':idContenido', $idContenido);
                $stmt3->bindParam(':idRuta', $idRuta);
                $stmt3->execute();

                echo "<script>alert('Multimedia agregada correctamente'); window.location.href='Ruta.php';</script>";
            } else {
                echo "<script>alert('Error al subir el archivo');</script>";
            }
        }
    }

    static public function MostrarContendio()
    {
        $conn = Connetion::Conexcion();
        $stmt = $conn->prepare('SELECT idContenido,accion FROM contenidos');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function EditarMultimedia()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST['btn_edit'])) {
                $conn = Connetion::Conexcion();

                $idMultimedia = $_POST['idMultimedia'];
                $tipo = $_POST['tipo'];
                $idTipo = null;

                switch ($tipo) {
                    case 'image':
                        $idTipo = 1;
                        $subcarpeta = "Imagenes/";
                        break;
                    case 'video':
                        $idTipo = 2;
                        $subcarpeta = "Videos/";
                        break;
                    case 'documento':
                        $idTipo = 3;
                        $subcarpeta = "documentos/";
                        break;
                    default:
                        echo "<script>alert('Tipo de multimedia inválido');</script>";
                        return;
                }

                $stmtInfo = $conn->prepare("SELECT idRuta FROM multimedia WHERE idMultimedia = :id");
                $stmtInfo->bindParam(':id', $idMultimedia);
                $stmtInfo->execute();
                $info = $stmtInfo->fetch(PDO::FETCH_ASSOC);

                if (!$info) {
                    echo "<script>alert('Registro no encontrado');</script>";
                    return;
                }

                $idRuta = $info['idRuta'];


                if (!empty($_FILES['archivo']['name'])) {
                    $nombreArchivo = $_FILES['archivo']['name'];
                    $archivoTemporal = $_FILES['archivo']['tmp_name'];
                    $carpeta = "../Multimedia/" . $subcarpeta;

                    if (!is_dir($carpeta))
                        mkdir($carpeta, 0777, true);

                    $ruta = $carpeta . basename($nombreArchivo);

                    if (move_uploaded_file($archivoTemporal, $ruta)) {

                        $stmtRuta = $conn->prepare("UPDATE rutas SET ruta = :ruta WHERE idRuta = :idRuta");
                        $stmtRuta->bindParam(':ruta', $ruta);
                        $stmtRuta->bindParam(':idRuta', $idRuta);
                        $stmtRuta->execute();
                    } else {
                        echo "<script>alert('Error al subir nuevo archivo');</script>";
                        return;
                    }
                }

                $stmt = $conn->prepare("UPDATE multimedia SET idTipo = :idTipo WHERE idMultimedia = :id");
                $stmt->bindParam(':idTipo', $idTipo);
                $stmt->bindParam(':id', $idMultimedia);
                $stmt->execute();

                echo "<script>alert('Multimedia actualizada correctamente'); window.location.href='Ruta.php';</script>";
            }
        }
    }
    static public function MostrarMultimedia()
    {


        $conn = Connetion::Conexcion();
        $stmt = $conn->prepare("
    SELECT m.idMultimedia, m.idTipo, m.idRuta, r.ruta 
    FROM multimedia m
    INNER JOIN rutas r ON m.idRuta = r.idRuta
");
        $stmt->execute();
        $result1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result1;

    }

    static public function MostrarTipo(){

        $conn = Connetion::Conexcion();
        $stmt = $conn->prepare("SELECT idTipo,nombre FROM tipo");
        $stmt ->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;

    }
    static public function EliminarMultimedia($idMultimedia)
    {
        $conn = Connetion::Conexcion();


        $stmt = $conn->prepare("
        SELECT r.ruta, r.idRuta 
        FROM multimedia m 
        INNER JOIN rutas r ON m.idRuta = r.idRuta 
        WHERE m.idMultimedia = :idMultimedia
    ");
        $stmt->bindParam(':idMultimedia', $idMultimedia, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$resultado) {
            echo "<script>alert('Multimedia no encontrada');</script>";
            return false;
        }

        $rutaArchivo = $resultado['ruta'];
        $idRuta = $resultado['idRuta'];


        $stmtDelMultimedia = $conn->prepare("DELETE FROM multimedia WHERE idMultimedia = :idMultimedia");
        $stmtDelMultimedia->bindParam(':idMultimedia', $idMultimedia);
        $stmtDelMultimedia->execute();


        if (file_exists($rutaArchivo)) {
            unlink($rutaArchivo);
        }


        $stmtDelRuta = $conn->prepare("DELETE FROM rutas WHERE idRuta = :idRuta");
        $stmtDelRuta->bindParam(':idRuta', $idRuta);
        $stmtDelRuta->execute();

        echo "<script>alert('Multimedia eliminada correctamente'); window.location.href='Ruta.php';</script>";
        return true;
    }

}