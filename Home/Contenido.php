<?php
require_once("../Conexion/Conexion.php");
include_once("../Home/Contenido.Logica.php");
Connetion::Conexcion();
Contenidos::EditarContenido();
$result = Contenidos::MostrarContenido();

Contenidos::AgregarContenido();

if (isset($_POST['btn_eliminar']) && isset($_POST['idContenido'])) {
    Contenidos::EliminarContenido();
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

                <li class="active">
                    <a href="../Home/Contenido.php"><i class="material-icons">date_range</i><span>CONTENIDO</span></a>
                </li>

                <li class="">
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
                        <li class="breadcrumb-item"><a href="#">Asunto</a></li>
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
                                        <h2 class="ml-lg-2">Administrar Asunto</h2>
                                    </div>
                                    <div class="col-sm-6 p-0 d-flex justify-content-lg-end justify-content-center">
                                        <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal">
                                            <i class="material-icons">&#xE147;</i> <span>Agregar Contenido</span></a>
                                        <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal">
                                            <i class="material-icons">&#xE15C;</i> <span>Eliminar</span></a>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped table-hover" id="tablaContenido">
                                <thead>
                                    <tr>
                                        <th>
                                        </th>
                                        <th>ID</th>
                                        <th>TITULO</th>
                                        <th>Descripcion</th>
                                        <th>Fecha</th>
                                        <th>ACCION</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    foreach ($result as $value) {
                                        echo '<tr>
                                        <td>
                                            <span class="custom-checkbox">
                                                <input type="checkbox" id="checkbox' . $value['idContenido'] . '" name="options[]" value="' . $value['idContenido'] . '">
                                                <label for="checkbox' . $value['idContenido'] . '"></label>
                                            </span>
                                        </td>
                                        <td>' . $value['idContenido'] . '</td>
                                        <td>' . $value['accion'] . '</td>
                                        <td>' . $value['descripcion'] . '</td>
                                        <td>' . $value['fecha_seleccion'] . '</td>
                                        <td>
                                            <a href="#editEmployeeModal" class="edit" data-toggle="modal">
                                                <i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i>
                                            </a>
                                            <a href="#deleteEmployeeModal" class="delete" data-toggle="modal">
                                                <i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i>
                                            </a>
                                        </td>
                                    </tr>';

                                    }
                                    ?>
                                </tbody>

                            </table>
                        </div>



                        <!-- Add Modal HTML -->
                        <div id="addEmployeeModal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="Contenido.php" method="POST">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Agregar Contenido</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Titulo</label>
                                                <input type="text" class="form-control" name="titulo" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Descripción</label>
                                                <textarea class="form-control" name="idDescripcion" rows="4"
                                                    required></textarea>
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
                                    <form action="Contenido.php" method="POST">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Editar Contenido</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="idContenido" id="edit_idContenido">
                                            <div class="form-group">
                                                <label>Titulo</label>
                                                <input type="text" class="form-control" name="titulo" id="edit_accion"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label>Descripción</label>
                                                <textarea class="form-control" name="idDescripcion"
                                                    id="edit_idDescripcion" rows="4" required></textarea>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn btn-default" data-dismiss="modal"
                                                value="Cancel">
                                            <input type="submit" class="btn btn-info" value="Guardar Cambios"
                                                name="btn_editar">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <!-- Delete Modal HTML -->
                        <div id="deleteEmployeeModal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="Contenido.php" method="POST">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Eliminar Contenido</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Estás seguro de que deseas eliminar este contenido?</p>
                                            <input type="hidden" id="delete-id" name="idContenido">
                                            <p class="text-warning"><small>Esta acción no se puede deshacer.</small></p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn btn-default" data-dismiss="modal"
                                                value="Cancelar">
                                            <button type="submit" class="btn btn-danger"
                                                name="btn_eliminar">Eliminar</button>
                                        </div>
                                    </form>
                                </div>
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
                var row = $(this).closest("tr");
                var id = row.find("input[type='checkbox']").val();
                var titulo = row.find("td:eq(2)").text().trim();
                var descripcion = row.find("td:eq(3)").text().trim();
                var fecha = row.find("td:eq(4)").text().trim();

                $("#edit_idContenido").val(id);
                $("#edit_accion").val(titulo);
                $("#edit_idDescripcion").val(descripcion);
                $("#edit_fecha").val(fecha);
            });
            $(document).on("click", ".delete", function () {
                var id = $(this).closest("tr").find("input[type='checkbox']").val();
                $("#delete-id").val(id);
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