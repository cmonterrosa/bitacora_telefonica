<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
            <div class="row">
                <h3>Bitácora</h3>
            </div>
            <div class="row">

                 <p>
                    <a href="create.php" class="btn btn-success">Nuevo</a>
                </p>

                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Apellidos</th>
                      <th>Correo</th>
                      <th>Teléfono</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   include 'database.php';
                   $pdo = Database::connect();
                   $sql = 'SELECT * FROM llamadas ORDER BY id DESC';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['nombre'] . '</td>';
                            echo '<td>'. $row['apellidos'] . '</td>';
                            echo '<td>'. $row['email'] . '</td>';
                            echo '<td>'. $row['telefono'] . '</td>';
                             echo '<td><a class="btn" href="read.php?id='.$row['id'].'">Leer</a></td>';
                            echo '</tr>';
                   }
                   Database::disconnect();
                  ?>
                  </tbody>
            </table>
        </div>
    </div> <!-- /container -->
  </body>
</html>
