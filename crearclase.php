<?php 
require("session.php");
require_once("conexion.php");
$asd = new BaseDeDatos();
$cursos = $asd->getCursos();
$profesores = $asd->getProfesores();
?>
<form action="crearclase.php" method="POST">
  <label for="nombre">Nombre del espacio curricular:</label>
  <input type="text" id="nombre" name="nombre" required><br>

  <label for="profesor">Seleccionar profesor:</label>
  <select id="profesor" name="profesor">
    <?php
    while ($fila = mysqli_fetch_assoc($profesores)) {
        echo '<option value="' . $fila['dni_profesor'] . '">';
        echo $fila['nombre'] . ' ' . $fila['apellido'];
        echo '</option>';
    }
    ?>
    </select>
    <br>

  <label for="curso">Seleccionar curso:</label>
  <select id="curso" name="curso">
    <?php
    while ($fila = mysqli_fetch_assoc($cursos)) {
        echo '<option value="' . $fila['id'] . '">';
        echo $fila['curso'] . ' ' . $fila['division'] . ' ' . $fila['carrera'] . ' ' . $fila['anio'];
        echo '</option>';
    }
    ?>
  </select>
  <br>

  <button type="submit">Crear Clase</button>
</form>



<?php 
if(isset($_POST['nombre'])){
$nombre_curso = $_POST['nombre'];
$curso_id = $_POST['curso'];
$profesor_dni = $_POST['profesor'];
$asd->crearClase($nombre_curso, $curso_id, $profesor_dni);
echo "Clase creada";
unset($_POST['nombre']);
}
?>
<br>
<a href="logout.php">Salir</a>