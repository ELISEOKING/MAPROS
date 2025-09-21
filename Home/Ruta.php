<?php
require_once("../Conexion/Conexion.php");
include_once("../Home/Ruta.Logica.php");
Connetion::Conexcion();
$result = Actualizar::MostrarMultimedia();
$resultado = Actualizar::MostrarTipo();
Actualizar::AgregarMultimedia();
$variable = Actualizar::MostrarContendio();
$tiposMap = [];
foreach ($resultado as $tipo) {
    $tiposMap[$tipo['idTipo']] = $tipo['nombre'];
}
Actualizar::EditarMultimedia();
if (isset($_POST['btn_eliminar']) && isset($_POST['idMultimedia'])) {
    Actualizar::EliminarMultimedia($_POST['idMultimedia']);
}

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>crud dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!----css3---->
    <link rel="stylesheet" href="../css/custom.css">


    <!--google fonts -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


    <!--google material icon-->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">

</head>

<body>


    <div class="wrapper">


        <div class="body-overlay"></div>

        <!-------------------------sidebar------------>
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0a47CvuB459su5Io-M3ptqwXeTd2qYeDKuA&s" class="img-fluid" /><span></span></h3>
            </div>
            <ul class="list-unstyled components">
                <li class="">
                    <a href="../Home/admin.php" class="dashboard"><i class="material-icons">dashboard</i>
                        <span>Dashboard</span></a>
                </li>

                <li class="">
                    <a href="../Home/Contenido.php"><i class="material-icons">date_range</i><span>CONTENIDO</span></a>
                </li>

                <li class="active">
                    <a href="../Home/Ruta.php"><i class="material-icons">library_books</i><span>RUTA
                        </span></a>
                </li>


            </ul>


        </nav>




        <!--------page-content---------------->

        <div id="content">

            <!--top--navbar----design--------->

            <div class="top-navbar">
            <div class="xp-topbar">
                <div class="row">
                    <div class="col-2 col-md-1 col-lg-1 order-2 order-md-1 align-self-center">
                        <div class="xp-menubar">
                            <span class="material-icons text-white">signal_cellular_alt</span>
                        </div>
                    </div>
                </div>
            </div>
                <div class="xp-breadcrumbbar text-center">
                    <h4 class="page-title">Dashboard</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Multimedia</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>

            </div>



            <!--------main-content------------->

            <div class="main-content">
                <div class="row">

                    <div class="col-md-12">
                        <div class="table-wrapper">
                            <div class="table-title">
                                <div class="row">
                                    <div class="col-sm-6 p-0 d-flex justify-content-lg-start justify-content-center">
                                        <h2 class="ml-lg-2">Administrar Multimedia</h2>
                                    </div>
                                    <div class="col-sm-6 p-0 d-flex justify-content-lg-end justify-content-center">
                                        <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal">
                                            <i class="material-icons">&#xE147;</i>
                                            <span>Agregar Contenido</span>
                                        </a>
                                        <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal">
                                            <i class="material-icons">&#xE15C;</i>
                                            <span>Eliminar</span>
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <table class="table table-striped table-hover" id="tablaContenido">
                                <thead>
                                    <tr>
                                        <th>✔</th>
                                        <th>ID Ruta</th>
                                        <th>Archivo</th>
                                        <th>Tipo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($result as $value) {
                                        echo '<tr>
                                    <td>
                                        <span class="custom-checkbox">
                                            <input type="checkbox" id="checkbox' . $value['idMultimedia'] . '" name="options[]" value="' . $value['idMultimedia'] . '">
                                            <label for="checkbox' . $value['idMultimedia'] . '"></label>
                                        </span>
                                    </td>

                                     <td>' . $value['idRuta'] . '</td>';


                                        if (file_exists($value['ruta'])) {
                                            echo '<td><a href="' . $value['ruta'] . '" target="_blank" class="btn btn-primary">Ver más</a></td>';
                                        } else {
                                            echo '<td><span class="text-danger">Archivo no encontrado</span></td>';
                                        }


                                        echo '<td>' . (isset($tiposMap[$value['idTipo']]) ? htmlspecialchars($tiposMap[$value['idTipo']]) : 'Desconocido') . '</td>';



                                        echo '<td>
                                            <a href="#editEmployeeModal" class="edit" data-toggle="modal" 
                                            data-id="' . $value['idMultimedia'] . '" data-tipo="' . $value['idTipo'] . '">
                                                <i class="material-icons" data-toggle="tooltip" title="Editar">&#xE254;</i>
                                            </a>
                                            <a href="#deleteEmployeeModal" class="delete" data-toggle="modal" 
                                            data-id="' . $value['idMultimedia'] . '">
                                                <i class="material-icons" data-toggle="tooltip" title="Eliminar">&#xE872;</i>
                                            </a>
                                        </td>
                                    </tr>';
                                    }
                                    ; ?>
                                </tbody>
                            </table>
                        </div>


                    <!-- Add Modal HTML -->
                    <div id="addEmployeeModal" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="Ruta.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Agregar Multimedia</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Tipo de Contenido</label>
                                            <select class="form-control" name="idContenido" required>
                                                <?php
                                                foreach ($variable as $value) {
                                                    echo '<option value="' . htmlspecialchars($value['idContenido']) . '">'
                                                        . htmlspecialchars($value['accion']) . '</option>';

                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Tipo de multimedia</label>
                                            <select class="form-control" name="tipo" required>
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value="image">Imagen</option>
                                                <option value="video">Video</option>
                                                <option value="documento">Documento</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Subir archivo</label>
                                            <input type="file" class="form-control" name="archivo" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-success"
                                            name="btn_agregar">Agregar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                    <!-- Edit Modal HTML -->
                    <div id="editEmployeeModal" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="Ruta.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Editar Multimedia</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="idMultimedia" id="edit-id">
                                        <div class="form-group">
                                            <label>Tipo de multimedia</label>
                                            <select class="form-control" name="tipo" id="edit-tipo" required>
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <option value="image">Imagen</option>
                                                <option value="video">Video</option>
                                                <option value="documento">Documento</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Cambiar archivo</label>
                                            <input type="file" class="form-control" name="archivo">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-info" name="btn_edit">Guardar
                                            Cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                    <!-- Delete Modal HTML -->
                    <div id="deleteEmployeeModal" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="Ruta.php" method="POST">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Eliminar Multimedia</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Estás seguro que deseas eliminar este archivo?</p>
                                        <p class="text-warning"><small>Esta acción no se puede deshacer.</small></p>
                                        <input type="hidden" name="idMultimedia" id="delete-id">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger"
                                            name="btn_eliminar">Eliminar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <!---footer---->


                </div>


            </div>
        </div>



        <script src="../js/jquery-3.3.1.slim.min.js"></script>
        <script src="../js/popper.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/jquery-3.3.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


        <script type="text/javascript">

            $(document).ready(function () {
                $(".xp-menubar").on('click', function () {
                    $('#sidebar').toggleClass('active');
                    $('#content').toggleClass('active');
                });

                $(".xp-menubar,.body-overlay").on('click', function () {
                    $('#sidebar,.body-overlay').toggleClass('show-nav');
                });

            });

            $(document).on("click", ".edit", function () {
                var id = $(this).data('id');
                var tipo = $(this).data('tipo');

                $("#edit-id").val(id);
                $("#edit-tipo").val(tipo);
            });

            $('#deleteEmployeeModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                $(this).find('input[name="idMultimedia"]').val(id);
            });
            $(document).ready(function () {
                $('#tablaContenido').DataTable({
                    pageLength: 6,
                    lengthChange: false,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                    }
                });
            });
        </script>

</body>

</html>