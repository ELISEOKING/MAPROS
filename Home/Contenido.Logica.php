<?php
require_once("../Conexion/Conexion.php");

class Contenidos
{

    static public function MostrarContenido()
    {
        $conn = Connetion::Conexcion();
        $stmt = $conn->prepare("SELECT c.*, d.descripcion FROM contenidos c INNER JOIN descripcion d ON c.idDescripcion = d.idDescripcion");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    static public function AgregarContenido()
    {
        if (isset($_POST['btn_agregar'])) {
            $conn = Connetion::Conexcion();

            $accion = $_POST['titulo'];
            $descripcion = $_POST['idDescripcion'];
            $fecha = $_POST['fecha_seleccion'];


            $stmt_check = $conn->prepare("SELECT idDescripcion FROM descripcion WHERE descripcion = :descripcion");
            $stmt_check->bindParam(':descripcion', $descripcion);
            $stmt_check->execute();

            if ($stmt_check->rowCount() > 0) {
                $row = $stmt_check->fetch(PDO::FETCH_ASSOC);
                $idDescripcion = $row['idDescripcion'];
            } else {
                $stmt_desc = $conn->prepare("INSERT INTO descripcion (descripcion) VALUES (:descripcion)");
                $stmt_desc->bindParam(':descripcion', $descripcion);
                $stmt_desc->execute();
                $idDescripcion = $conn->lastInsertId();
            }
            $fecha = date('Y-m-d H:i:s');
            $stmt = $conn->prepare("INSERT INTO contenidos (accion, idDescripcion, fecha_seleccion) 
                        VALUES (:accion, :idDescripcion, :fecha)");
            $stmt->bindParam(':accion', $accion);
            $stmt->bindParam(':idDescripcion', $idDescripcion);
            $stmt->bindParam(':fecha', $fecha);

            if ($stmt->execute()) {
                echo "<script>alert('Contenido agregado correctamente'); window.location.href='Contenido.php';</script>";
            } else {
                echo "<script>alert('Error al agregar');</script>";
            }
        }
    }

    static public function EditarContenido()
    {
        if (isset($_POST['btn_editar'])) {
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $conn = Connetion::Conexcion();

                $id = $_POST['idContenido'];
                $accion = $_POST['titulo'];
                $descripcion = $_POST['idDescripcion'];
                $fecha = $_POST['fecha_seleccion'];


                $stmtGetDescripcion = $conn->prepare("SELECT idDescripcion FROM contenidos WHERE idContenido = :id");
                $stmtGetDescripcion->bindParam(':id', $id);
                $stmtGetDescripcion->execute();
                $data = $stmtGetDescripcion->fetch(PDO::FETCH_ASSOC);

                if ($data) {
                    $idDescripcion = $data['idDescripcion'];


                    $stmtDescripcion = $conn->prepare("UPDATE descripcion SET descripcion = :descripcion WHERE idDescripcion = :idDescripcion");
                    $stmtDescripcion->bindParam(':descripcion', $descripcion);
                    $stmtDescripcion->bindParam(':idDescripcion', $idDescripcion);
                    $stmtDescripcion->execute();

                    $stmtContenido = $conn->prepare("UPDATE contenidos 
                                 SET accion = :accion, fecha_seleccion = :fecha 
                                 WHERE idContenido = :id");

                    $stmtContenido->execute([
                        ':accion' => $accion,
                        ':fecha' => date('Y-m-d H:i:s'),
                        ':id' => $id
                    ]);

                    echo "<script>alert('Contenido modificado correctamente'); window.location.href='Contenido.php';</script>";
                } else {
                    echo "<script>alert('Contenido no encontrado');</script>";
                }
            }
        }
    }
    static public function EliminarContenido()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_eliminar']) && isset($_POST['idContenido'])) {
            $conn = Connetion::Conexcion();
            $id = $_POST['idContenido'];


            $stmt1 = $conn->prepare("DELETE FROM multimedia WHERE idContenido = :id");
            $stmt1->bindParam(':id', $id);
            $stmt1->execute();


            $stmt2 = $conn->prepare("DELETE FROM contenidos WHERE idContenido = :id");
            $stmt2->bindParam(':id', $id);
            $stmt2->execute();
            if ($stmt1->execute()) {
                echo "<script>alert('Contenido eliminado correctamente'); window.location.href='Contenido.php';</script>";
            } else {
                echo "<script>alert('Error al eliminar');</script>";
            }
        }
    }


}