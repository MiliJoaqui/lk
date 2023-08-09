<!DOCTYPE html>
<html lang="es">

<head>
    <title>Stock de productos</title>
    <!-- Incluir Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Incluir Datatables CSS -->
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.6/b-2.4.1/fc-4.3.0/datatables.min.css" rel="stylesheet">
    <!-- Incluir estilos css -->
    <link rel="stylesheet" href="styles.css">
    <!-- Incorporar fuente de letras -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Quicksand:wght@300&display=swap"
        rel="stylesheet">
    <?php
    /*     
        //guardar en una variable el archivo csv obteniendola a través de la url
        $archivocsv = $_GET['opcion'];
        //definir una matriz para almacenar los datos
        $matrizDatos = [];

        //si el archivo existe, se lo recorre para guardarlo en la matriz
        if (file_exists($archivocsv)) {
            // Abrir el archivo en modo lectura
            if (($archivo = fopen($archivocsv, 'r')) !== FALSE) {
                // Leer cada línea del archivo
                while (($fila = fgetcsv($archivo, 1000, ',')) !== FALSE) {
                    // Agregar la fila a la matriz de datos
                    $matrizDatos[] = $fila;
                }
                // Cerrar el archivo
                fclose($archivo);
            } else {
                echo 'No se pudo abrir el archivo.';
            }
        } else {
            echo 'El archivo no existe.';
        }
      */
    ?>

    <?php
    // Leer los archivos CSV y almacenar los datos en matrices
    $opDro = $_GET['opcionDro'];
    $opFar = $_GET['opcionFar'];
    $productos = array_map('str_getcsv', file($opDro));
    $farmacias = array_map('str_getcsv', file($opFar));

    // Crear una nueva matriz con el stock de cada producto en cada farmacia
    $matriz_combinada = array();

    foreach ($productos as $producto) {
        $codigo_barra = $producto[1];
        $codigo_laboratorio = $producto[2];
        $nombre_producto = $producto[3];
        $nombre_laboratorio = $producto[4];
        $stock_drogueria = $producto[0];

        $stock_en_farmacias = array();
        foreach ($farmacias as $stock_farmacia) {
            if ($stock_farmacia[1] == $codigo_barra) {
                $nombre_farmacia = $stock_farmacia[0];
                $stock_farmacia = $stock_farmacia[2];
                $stock_en_farmacias[$nombre_farmacia] = $stock_farmacia;
            }
        }

        $matriz_combinada[] = array_merge(
            array(
                'Código de barra' => $codigo_barra,
                'Código de laboratorio' => $codigo_laboratorio,
                'Nombre de producto' => $nombre_producto,
                'Nombre de laboratorio' => $nombre_laboratorio,
                'Stock total' => $stock_drogueria
            ),
            $stock_en_farmacias
        );
    }

    // Crear una lista de nombres de farmacias sin duplicados (agarra el array y hace que no se duplique los nombres de las farmacias, hace que no se repita 99 veces el nombre de una misma farmacia)
    $farmacias_sin_duplicados = array_unique(array_column($farmacias, 0));
    ?>
</head>

<body class="pg-stock">
    <div class="element-titulo">
        <!-- Titulo principal -->
        <h1 class="tituloStock">Stock de productos</h1>
        <a href="index.php" type="button" class="btn-back btn btn-light"> Atrás </a>
    </div>
    <a href="facturacion.php" type="button" class="btn-facturacion btn btn-outline-dark"> Facturar </a>
    <div>
        <?php
        // Obtener el valor del parámetro "lab" de la URL
        $nomLab = isset($_GET['nombre']) ? $_GET['nombre'] : 'Laboratorio desconocido';

        // Mostrar el valor como título de la página
        echo '<h2 class="nombreLab">' . htmlspecialchars($nomLab) . '</h2>'; ?>

    </div>


    <!-- Contenido principal: tabla de stock -->
    <div class="container">
        <div class="table-responsive fixed-columns element">
            <table id="tabla-principal" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>codigo de producto</th>
                        <th>Producto</th>
                        <th>Droguería</th>
                        <?php
                        // Generar las 120 columnas automáticamente
                        foreach ($farmacias_sin_duplicados as $nombre_farmacia) {
                            echo '<th class="farmacia">' . $nombre_farmacia . '</th>';
                            echo '<th class="factura">' . 'F' . '</th>';
                        }
                        ?>
                    </tr>
                </thead>
                <?php
                // Mostrar la tabla
                echo '<tbody>';
                $id = 1; // Inicializar el ID en 1
                foreach ($matriz_combinada as $fila) {
                    echo '<tr>';
                    echo '<td>' . $fila['Código de barra'] . '</td>';
                    echo '<td>' . $fila['Nombre de producto'] . '</td>';
                    echo '<td>' . $fila['Stock total'] . '</td>';

                    // Mostrar el stock en cada farmacia sin repetir los nombres
                    foreach ($farmacias_sin_duplicados as $nombre_farmacia) {
                        echo '<td class="farmacia">' . ($fila[$nombre_farmacia] ?? 0) . '</td>';

                        // Fecha de facturación 
                        $fechaFacturacion = "2023-07-31"; // Formato YYYY-MM-DD
                
                        // Fecha actual
                        $fechaActual = date("Y-m-d");

                        // Convertir las fechas a objetos DateTime para poder calcular la diferencia
                        $fechaFacturacionObj = new DateTime($fechaFacturacion);
                        $fechaActualObj = new DateTime($fechaActual);

                        // Calcular la diferencia en días entre las fechas
                        $diferenciaDias = $fechaFacturacionObj->diff($fechaActualObj)->days;

                        // Verificar si han pasado menos de 10 días
                        if ($diferenciaDias <= 10) {
                            echo '<td class="factura">' . 'si' . '</td>'; // La fecha de facturación fue hace 10 días o menos
                        } else {
                            echo '<td class="factura">' . 'no' . '</td>'; // La fecha de facturación fue hace más de 10 días
                        }
                        /* echo '<td>' . '--'. '</td>'; */


                    }
                }
                echo "</tbody>";
                ?>
            </table>
        </div>
    </div>

    <!-- Incluir jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Incluir Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Incluir Datatables JS -->
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.6/b-2.4.1/fc-4.3.0/datatables.min.js"></script>

    <script>
        // Inicializar Datatables
        $(document).ready(function () {
            var miTabla = $('#tabla-principal').DataTable({
                scrollX: true, // Habilitar el desplazamiento horizontal
                lengthChange: false,
                fixedColumns: {
                    leftColumns: 3 // Fijar las dos primeras columnas a la izquierda
                }
            });
        });
    </script>

</body>

</html>