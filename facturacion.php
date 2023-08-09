<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <!-- Incorporar Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Facturación</title>

    <?php 
    include("conexion.php");
    $con=conectar();
    ?>
</head>

<body class="pg-fac">
    <div class="contenido-fac">
        <h1>Facturación</h1>
        <div class="datos-fac">
            <h5><strong>Cliente: </strong>JUFEC S.A</h5>
            <h5><strong>Dirección: </strong>Catamarca 658</h5>
            <h5><strong>Laboratorio: </strong></h5>
            <label for="nombre">Nombre:</label>
            <input id="nombre" class="entrada" type="text" placeholder="Nombre" aria-label="Nombre">
            <label for="direccion">Dirección:</label>
            <input id="direccion" class="entrada" type="text" placeholder="Dirección" aria-label="Dirección">
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>

</html>