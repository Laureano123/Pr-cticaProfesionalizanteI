<?php
class BaseDeDatos{
    private static $servidor = "localhost:3307";
    private static $usuario = "root";
    private static $contraseña = "";
    private static $bd = "sistemaexamenes";
    protected $conexion;
    protected $sql;

    protected function openConnection(){
        $this->conexion = new mysqli(self::$servidor, self::$usuario, self::$contraseña, self::$bd);
    }

    protected function closeConnection(){
        $this->conexion->close();
    }

    public function validarUsuario($usuario="", $contraseña=""){
        $this->openConnection();
        
        $sql = "SELECT *
        FROM usuarios
        WHERE username = '$usuario'
        AND password = '$contraseña'";

        $resultado = mysqli_query($this->conexion, $sql);

        $this->closeConnection();

        if(mysqli_num_rows($resultado) > 0){
            return true;
        }else{
            return false;
        }
    }

    public function validarPermiso($usuario="", $contraseña=""){
        $this->openConnection();
        
        $sql = "SELECT permisos
        FROM usuarios
        WHERE username = '$usuario'
        AND password = '$contraseña'";

        $resultado = mysqli_query($this->conexion, $sql);

        $this->closeConnection();

        if(mysqli_num_rows($resultado) > 0){
            $fila = mysqli_fetch_assoc($resultado);
            $permisos = $fila['permisos'];
        }
        
        return $permisos;
    }
    
    public function usuarioRepetido($usuario){
        $this->openConnection();
        
        $sql = "SELECT *
        FROM usuarios
        WHERE username = '$usuario'";

        $resultado = mysqli_query($this->conexion, $sql);

        if(mysqli_num_rows($resultado) > 0){
            return true;
        }else{
            return false;
        }

        $this->closeConnection(); 
    }
    
    public function registrarUsuario($usuario, $contraseña, $permisos){
        $this->openConnection();
        
        $sql = "INSERT INTO usuarios (username, password, permisos)
        VALUES ('$usuario', '$contraseña', $permisos)";

        $resultado = mysqli_query($this->conexion, $sql);

        $this->closeConnection();
    }

    public function crearClase($nombre_curso, $curso_id, $profesor_dni){
        $this->openConnection();
        
        $sql = "INSERT INTO clase (curso_id, espacio_curricular) VALUES ($curso_id, '$nombre_curso')";
        $resultado = mysqli_query($this->conexion, $sql);
        
        if ($resultado) {
            $id_clase = mysqli_insert_id($this->conexion);
        
            $sql = "INSERT INTO clase_profesor (dni_profesor, id_clase) VALUES ('$profesor_dni', $id_clase)";
            $resultado = mysqli_query($this->conexion, $sql);
        
            $sql = "INSERT INTO clase_alumno (dni_alumno, id_clase)
            SELECT Alumnos.dni_alumno, $id_clase
            FROM Alumnos
            JOIN Cursos ON Alumnos.curso_id = Cursos.id
            WHERE Cursos.id = $curso_id";
            $resultado = mysqli_query($this->conexion, $sql);
        }
        

        $this->closeConnection();
    }

    public function getCursos(){
        $this->openConnection();

        $sql = "SELECT id, curso, division, carrera, anio FROM Cursos";
        $resultado = mysqli_query($this->conexion, $sql);

        $this->closeConnection();

        return $resultado;
    }

    public function getProfesores(){
        $this->openConnection();

        $sql = "SELECT nombre, apellido, dni_profesor FROM Profesores";
        $resultado = mysqli_query($this->conexion, $sql);

        $this->closeConnection();

        return $resultado;
    }

    public function getClases(){
        $this->openConnection();
        
        $sql = "SELECT Clase.id, Clase.espacio_curricular, Cursos.curso, Cursos.division, Cursos.carrera, Cursos.anio, Profesores.apellido, Profesores.nombre
        FROM Clase
        JOIN Cursos ON Clase.curso_id = Cursos.id
        LEFT JOIN clase_profesor ON Clase.id = clase_profesor.id_clase
        LEFT JOIN Profesores ON clase_profesor.dni_profesor = Profesores.dni_profesor";
        $resultado = mysqli_query($this->conexion, $sql);

        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $id_clase = $fila['id'];
                $nombre_espacio_curricular = $fila['espacio_curricular'];
                $curso = $fila['curso'];
                $division = $fila['division'];
                $carrera = $fila['carrera'];
                $anio = $fila['anio'];
                $nombre_profesor = $fila['nombre'];
                $apellido_profesor = $fila['apellido'];

                echo '<a href="clase.php?id=' . $id_clase . '" class="tarjeta-enlace">';
                echo '<div class="tarjeta">';
                echo '<h2>' .$nombre_espacio_curricular ." - " .$curso . $division . " " .$carrera . " " .$anio .'</h2>';
                echo '<p>' . "Prof. ". $nombre_profesor . " " .$apellido_profesor .'</p>';
                echo '</div>';
                echo '</a>';
            }
        }

        $this->closeConnection(); 
    }

    public function getClasesProfesor($nombre){
        $this->openConnection();

        $nombre_usuario = $nombre; 

        
        $sql = "SELECT dni_profesor FROM profesores WHERE email = '$nombre_usuario'";
        $resultado = mysqli_query($this->conexion, $sql);

        if (mysqli_num_rows($resultado) > 0) {
            
            $fila = mysqli_fetch_assoc($resultado);
            $dni_profesor = $fila['dni_profesor'];
        }
        $sql = "SELECT Clase.id, Clase.espacio_curricular, Cursos.curso, Cursos.division, Cursos.carrera, Cursos.anio, Profesores.nombre, Profesores.apellido
        FROM Clase
        JOIN Cursos ON Clase.curso_id = Cursos.id
        JOIN clase_profesor ON Clase.id = clase_profesor.id_clase
        JOIN Profesores ON clase_profesor.dni_profesor = Profesores.dni_profesor
        WHERE clase_profesor.dni_profesor = '$dni_profesor'";
        $resultado = mysqli_query($this->conexion, $sql);

        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $id_clase = $fila['id'];
                $nombre_espacio_curricular = $fila['espacio_curricular'];
                $curso = $fila['curso'];
                $division = $fila['division'];
                $carrera = $fila['carrera'];
                $anio = $fila['anio'];
                $nombre_profesor = $fila['nombre'];
                $apellido_profesor = $fila['apellido'];

                echo '<a href="clase.php?id=' . $id_clase . '" class="tarjeta-enlace">';
                echo '<div class="tarjeta">';
                echo '<h2>' .$nombre_espacio_curricular ." - " .$curso . $division . " " .$carrera . " " .$anio .'</h2>';
                echo '<p>' . "Prof. ". $nombre_profesor . " " .$apellido_profesor .'</p>';
                echo '</div>';
                echo '</a>';
            }
        }

        $this->closeConnection(); 
    
    }

    public function getClasesAlumno($nombre){
        $this->openConnection();

        $nombre_usuario = $nombre; 

        // Verifica si el usuario es un alumno
        $sql = "SELECT dni_alumno FROM alumnos WHERE email = '$nombre_usuario'";
        $resultado = mysqli_query($this->conexion, $sql);

        if (mysqli_num_rows($resultado) > 0) {
            // El usuario es un alumno
            $fila = mysqli_fetch_assoc($resultado);
            $dni_alumno = $fila['dni_alumno'];

            // Consulta para obtener las clases asignadas al alumno
            $sql = "SELECT Clase.id, Clase.espacio_curricular, Cursos.curso, Cursos.division, Cursos.carrera, Cursos.anio, Profesores.nombre AS nombre_profesor, Profesores.apellido AS apellido_profesor
            FROM Clase
            JOIN Cursos ON Clase.curso_id = Cursos.id
            JOIN clase_alumno ON Clase.id = clase_alumno.id_clase
            JOIN Alumnos ON clase_alumno.dni_alumno = Alumnos.dni_alumno
            JOIN clase_profesor ON Clase.id = clase_profesor.id_clase
            JOIN Profesores ON clase_profesor.dni_profesor = Profesores.dni_profesor
            WHERE clase_alumno.dni_alumno = '$dni_alumno'";

            // Muestra las clases asignadas al alumno junto con sus datos
            // Aquí puedes generar divs o cualquier otro formato para mostrar las clases
        }
        $resultado = mysqli_query($this->conexion, $sql);

        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $id_clase = $fila['id'];
                $nombre_espacio_curricular = $fila['espacio_curricular'];
                $curso = $fila['curso'];
                $division = $fila['division'];
                $carrera = $fila['carrera'];
                $anio = $fila['anio'];
                $nombre_profesor = $fila['nombre_profesor'];
                $apellido_profesor = $fila['apellido_profesor'];

                echo '<a href="clase.php?id=' . $id_clase . '" class="tarjeta-enlace">';
                echo '<div class="tarjeta">';
                echo '<h2>' .$nombre_espacio_curricular ." - " .$curso . $division . " " .$carrera . " " .$anio .'</h2>';
                echo '<p>' . "Prof. ". $nombre_profesor . " " .$apellido_profesor .'</p>';
                echo '</div>';
                echo '</a>';
            }
        }
        $this->closeConnection(); 
    
    }

    public function mostrarTituloClase($id_clase){
        $this->openConnection();
        
        $sql = "SELECT Clase.espacio_curricular, Cursos.curso, Cursos.division, Cursos.carrera, Cursos.anio, Profesores.nombre AS nombre_profesor, Profesores.apellido AS apellido_profesor
        FROM Clase
        JOIN Cursos ON Clase.curso_id = Cursos.id
        JOIN clase_profesor ON Clase.id = clase_profesor.id_clase
        JOIN Profesores ON clase_profesor.dni_profesor = Profesores.dni_profesor
        WHERE Clase.id = $id_clase";
        $resultado = mysqli_query($this->conexion, $sql);

        if ($resultado) {
            $fila = mysqli_fetch_assoc($resultado);
        
            $nombre_espacio_curricular = $fila['espacio_curricular'];
            $curso = $fila['curso'];
            $division = $fila['division'];
            $carrera = $fila['carrera'];
            $anio = $fila['anio'];
            $nombre_profesor = $fila['nombre_profesor'];
            $apellido_profesor = $fila['apellido_profesor'];

            echo '<h2>' .$nombre_espacio_curricular ." - " .$curso . $division . " " .$carrera . " " .$anio .'</h2>';
            echo '<p>' . "Prof. ". $nombre_profesor . " " .$apellido_profesor .'</p>';

        }

        $this->closeConnection();
    }
}
?>