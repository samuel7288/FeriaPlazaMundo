<?php 
session_start();
if(isset($_SESSION['usuario'])){
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Categorías</title>
    <?php require_once "menu.php"; ?>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
    <div class="categories-dashboard">
        <div class="dashboard-header">
            <h1 class="text-center mb-0">
                <i class="fas fa-tags me-2"></i>
                Gestión de Categorías
            </h1>
        </div>

        <div class="content-wrapper">
            <div class="form-card">
                <h3 class="mb-4"><i class="fas fa-plus-circle me-2"></i>Nueva Categoría</h3>
                <form id="frmCategorias">
                    <div class="mb-3">
                        <label class="form-label">Nombre de la Categoría</label>
                        <input type="text" class="form-control" name="categoria" id="categoria" 
                               placeholder="Ingrese el nombre de la categoría">
                    </div>
                    <button type="button" class="btn btn-primary w-100" id="btnAgregaCategoria">
                        <i class="fas fa-save me-2"></i>Agregar Categoría
                    </button>
                </form>
            </div>

            <div class="table-card">
                <div class="loading">
                    <i class="fas fa-spinner fa-spin me-2"></i>Procesando...
                </div>
                <div id="tablaCategoriaLoad"></div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="actualizaCategoria" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>
                        Actualizar Categoría
                    </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="frmCategoriaU">
                        <input type="hidden" id="idcategoria" name="idcategoria">
                        <div class="mb-3">
                            <label class="form-label">Nombre de la Categoría</label>
                            <input type="text" id="categoriaU" name="categoriaU" 
                                   class="form-control" placeholder="Actualizar nombre de categoría">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnActualizaCategoria" class="btn btn-warning">
                        <i class="fas fa-save me-2"></i>Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#tablaCategoriaLoad').load("categorias/tablaCategorias.php");

            $('#btnAgregaCategoria').click(function(){
                vacios=validarFormVacio('frmCategorias');

                if(vacios > 0){
                    alertify.alert("Debes llenar todos los campos!!");
                    return false;
                }

                datos=$('#frmCategorias').serialize();
                $('.loading').show();
                $.ajax({
                    type:"POST",
                    data:datos,
                    url:"../procesos/categorias/agregaCategoria.php",
                    success:function(r){
                        $('.loading').hide();
                        if(r==1){
                            $('#frmCategorias')[0].reset();
                            $('#tablaCategoriaLoad').load("categorias/tablaCategorias.php");
                            alertify.success("Categoria agregada con exito :D");
                            $('#tablaCategoriaLoad').addClass('animate__animated animate__fadeIn');
                        }else{
                            alertify.error("No se pudo agregar categoria");
                        }
                    }
                });
            });
        });

        $(document).ready(function(){
            $('#btnActualizaCategoria').click(function(){
                datos=$('#frmCategoriaU').serialize();
                $('.loading').show();
                $.ajax({
                    type:"POST",
                    data:datos,
                    url:"../procesos/categorias/actualizaCategoria.php",
                    success:function(r){
                        $('.loading').hide();
                        if(r==1){
                            $('#tablaCategoriaLoad').load("categorias/tablaCategorias.php");
                            alertify.success("Actualizado con exito :)");
                        }else{
                            alertify.error("no se pudo actaulizar :(");
                        }
                    }
                });
            });
        });

        function agregaDato(idCategoria,categoria){
            $('#idcategoria').val(idCategoria);
            $('#categoriaU').val(categoria);
        }

        function eliminaCategoria(idcategoria){
            alertify.confirm('¿Desea eliminar esta categoria?', function(){ 
                $('.loading').show();
                $.ajax({
                    type:"POST",
                    data:"idcategoria=" + idcategoria,
                    url:"../procesos/categorias/eliminarCategoria.php",
                    success:function(r){
                        $('.loading').hide();
                        if(r==1){
                            $('#tablaCategoriaLoad').load("categorias/tablaCategorias.php");
                            alertify.success("Eliminado con exito!!");
                        }else{
                            alertify.error("No se pudo eliminar :(");
                        }
                    }
                });
            }, function(){ 
                alertify.error('Cancelo !')
            });
        }
    </script>
<?php 
}else{
    header("location:../index.php");
}
?>