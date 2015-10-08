<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>

    <title>Nuevo registro de llamada</title>

    <!-- datetime picker -->
<!--    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="js/jquery-1.8.3.min.js" charset="UTF-8"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>-->
</head>


<script type="text/javascript">

//    $('#fechahora').datetimepicker({
//        language:  'es',
//        weekStart: 1,
//        todayBtn:  1,
//		autoclose: 1,
//		todayHighlight: 1,
//		startView: 1,
//		minView: 0,
//		maxView: 1,
//		forceParse: 0
//    });
</script>






<?php

    require 'database.php';

    if ( !empty($_POST)) {
        // keep track validation errors
        $nombreError = null;
        $apellidosError = null;
        $emailError = null;
        $telefonoError = null;
        $motivoError = null;

        // keep track post values
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $motivo = $_POST['motivo'];
        $timestamp = date('Y-m-d G:i:s');

        // validate input
        $valid = true;
        if (empty($nombre)) {
            $nombreError = 'Por favor introduzca su nombre';
            $valid = false;
        }

        if (empty($apellidos)) {
            $apellidosError = 'Por favor introduzca sus apellidos';
            $valid = false;
        }

        if (empty($email)) {
            $emailError = 'Por favor introduzca su correo';
            $valid = false;
        } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
            $emailError = 'Por favor introduzca un correo válido';
            $valid = false;
        }

        if (empty($telefono)) {
            $telefonoError = 'Por favor introduzca un número telefónico';
            $valid = false;
        }

        if (empty($motivo)) {
            $motivoError = 'Por favor introduzca el motivo de la llamada';
            $valid = false;
        }

        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO llamadas (nombre, apellidos, email,telefono, motivo, fechahora) values(?, ?, ?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($nombre, $apellidos, $email,$telefono, $motivo, $timestamp));
            Database::disconnect();
            header("Location: index.php");
        }
    }
?>



<body>
    <div class="container">

                <div class="span10 offset1">
                    <div class="row">
                        <h3>Registro de nueva llamada</h3>
                    </div>

                    <form class="form-horizontal" action="create.php" method="post">

                      <div class="control-group <?php echo !empty($nombreError)?'error':'';?>">
                        <label class="control-label">Nombre(s):</label>
                        <div class="controls">
                            <input name="nombre" type="text"  placeholder="Nombre(s)" value="<?php echo !empty($nombre)?$nombre:'';?>">
                            <?php if (!empty($nombreError)): ?>
                                <span class="help-inline"><?php echo $nombreError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>

                      <div class="control-group <?php echo !empty($apellidosError)?'error':'';?>">
                        <label class="control-label">Apellidos:</label>
                        <div class="controls">
                            <input name="apellidos" type="text" placeholder="Apellidos" value="<?php echo !empty($apellidos)?$apellidos:'';?>">
                            <?php if (!empty($apellidosError)): ?>
                                <span class="help-inline"><?php echo $apellidosError;?></span>
                            <?php endif;?>
                        </div>
                      </div>

                      <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
                        <label class="control-label">Correo electrónico:</label>
                        <div class="controls">
                            <input name="email" type="text" placeholder="Correo electrónico" value="<?php echo !empty($email)?$email:'';?>">
                            <?php if (!empty($emailError)): ?>
                                <span class="help-inline"><?php echo $emailError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($telefonoError)?'error':'';?>">
                        <label class="control-label">Número telefónico:</label>
                        <div class="controls">
                            <input name="telefono" type="text"  placeholder="Número telefónico" value="<?php echo !empty($telefono)?$telefono:'';?>">
                            <?php if (!empty($telefonoError)): ?>
                                <span class="help-inline"><?php echo $telefonoError;?></span>
                            <?php endif;?>
                        </div>
                      </div>

                      <div class="control-group <?php echo !empty($motivoError)?'error':'';?>">
                        <label class="control-label">Motivo de la llamda:</label>
                        <div class="controls">
                            <textarea name="motivo" rows="10" cols="50" placeholder="Motivo de la llamada"><?php echo !empty($motivo)?$motivo:'';?></textarea>
                            <?php if (!empty($motivoError)): ?>
                                <span class="help-inline"><?php echo $motivoError;?></span>
                            <?php endif;?>
                        </div>
                      </div>


                      <!-- datatime picker -->

<!--                       <div class="control-group">
                            <label class="control-label">DateTime Picking</label>
                                <div class="controls input-append date form_datetime" data-date="1979-09-16T05:25:07Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                                    <input size="16" type="text" value="" readonly>
                                            <span class="add-on"><i class="icon-remove"></i></span>
                                            <span class="add-on"><i class="icon-th"></i></span>
                                </div>
				<input type="hidden" id="fechahora" value="" /><br/>
                        </div>-->


                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Crear</button>
                          <a class="btn" href="index.php">Atrás</a>
                        </div>
                    </form>
                </div>

    </div> <!-- /container -->
  </body>
</html>
