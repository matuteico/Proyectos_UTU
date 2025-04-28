<?php
require_once("db\connection.php");

class AdminModel {
    private $conexion;

    public function __construct() {
        $this->conexion = getConnection(); // Llamada a la función de conexión
    }

    public function altaUsuario($email, $nombre, $passwd, $celular, $email_a) {

        $sql_check = "SELECT 1 FROM Usuario WHERE email = ?";
        $stmt_check = $this->conexion->prepare($sql_check);
        $stmt_check->bind_param("s", $email); 
        $stmt_check->execute();
        $result = $stmt_check->get_result();
    
        if ($result->num_rows > 0) {
            echo "<script>alert('El email ingresado ya existe.');</script>";
            return false;
        }
    
        $sql_insert = "INSERT INTO Usuario (email, nombre, passwd, celular, tipoU, baja, email_a) 
                       VALUES (?, ?, ?, ?, 'Tecnico', 0, ?)";
    
        $stmt_insert = $this->conexion->prepare($sql_insert);
        $stmt_insert->bind_param("sssss", $email, $nombre, $passwd, $celular, $email_a);
        
        return $stmt_insert->execute();
    }
    
    public function bajaUsuario($email) {
        // Primero, busca si el usuario existe con el email proporcionado
        $query = "SELECT email FROM Usuario WHERE email = ? AND tipoU = 'Tecnico'";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
    
        // Si el correo no existe
        if ($stmt->num_rows === 0) {
            $stmt->close();
            return false; 
        }
    
        $updateQuery = "UPDATE Usuario SET baja = 1 WHERE email = ?";
        $updateStmt = $this->conexion->prepare($updateQuery);
        $updateStmt->bind_param("s", $email);
    
        $resultado = $updateStmt->execute();
        $updateStmt->close();
    
        return $resultado; 
    }
    
    public function buscarUsuario($email) {
        $query = "SELECT email, nombre, celular, baja FROM Usuario WHERE email = ? AND tipoU = 'Tecnico'";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
    
 
        $result = $stmt->get_result();
    
        
        if ($result->num_rows === 0) {
            $stmt->close();
            return false; 
        }
    
        $datos = $result->fetch_assoc();
    
        $stmt->close();
    
        return $datos;
    }
    
    public function actualizarUsuario($email, $nombre, $passwd, $celular, $baja) { 
        if (!empty($passwd)) {
            $passwd = MD5($passwd); 
        }
    
        $query = "UPDATE Usuario 
                  SET nombre = ?, passwd = ?, celular = ?, baja = ? WHERE email = ?";
    
        $stmt = $this->conexion->prepare($query);
    
        $stmt->bind_param("sssis", $nombre, $passwd, $celular, $baja, $email);
    
        $resultado = $stmt->execute();
        $stmt->close();
        
        return $resultado; 
    }
    
    public function cargarAsigna(){


        $sql  = "SELECT A.id_p, A.email_c, A.email_t, P.servicio_id, P.comentarios, P.estado
         FROM Asigna A JOIN Pedido P ON A.id_p = P.id_P";
 
          $stmt = $this->conexion->prepare($sql); 
          $stmt->execute(); 
           $result = $stmt->get_result();
 
           $pedidos = [];
           while ($row = $result->fetch_assoc()) {
            $pedidos[] = $row; 
         }
  
            $stmt->close();
            return $pedidos; 
 
    }

    public function cargarNoAsigna(){

     $sqlP = "SELECT * FROM Pedido WHERE estado = 'Pendiente'";
    
        $stmt = $this->conexion->prepare($sqlP); 
        $stmt->execute(); 
        $result = $stmt->get_result();
    
        $pendientes = []; 
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $pendientes[] = $row; 
            }
        }
    
        $stmt->close();
        return $pendientes; 
    }
    

    public function obtenerDatosPedido($id_p) {
        $sql = "SELECT email_c, servicio_id FROM Pedido WHERE id_p = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_p);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); 
        }
        return null; 
    }
    
    public function esTecnico($email_t) {
        $sql = "SELECT tipoU FROM Usuario WHERE email = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $email_t);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();
    
        $stmt->close();
    
        if ($usuario && $usuario['tipoU'] === 'Tecnico') {
            return true;
        } else {
            echo "<script>alert('El correo debe ser de un tecnico.'); 
    window.location.href='gestionA.php';</script>";
    return false;
        }
    }


    public function existeAsignacion($id_p) {
        $sql = "SELECT COUNT(*) as total FROM Asigna WHERE id_p = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_p);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        $stmt->close();
    
        return $row['total'] > 0;
    }
    


    public function altaAsigna($id_p, $email_c, $email_t, $servicio_id) {
        if (empty($id_p) || empty($email_c) || empty($email_t) || empty($servicio_id)) {
            echo "<script>alert('Datos incompletos para la asignacion.'); 
            window.location.href='gestionA.php';</script>";
        }
    
        $sqlInsert = "INSERT INTO Asigna (id_p, email_c, email_t, servicio_id) VALUES (?, ?, ?, ?)";
        $stmtInsert = $this->conexion->prepare($sqlInsert);
        $stmtInsert->bind_param("issi", $id_p, $email_c, $email_t, $servicio_id);
    
        if (!$stmtInsert->execute()) {
            echo "<script>alert('Error al asignar pedido.'); 
            window.location.href='gestionA.php';</script>";
        }
    
        $sqlUpdate = "UPDATE Pedido SET estado = 'En Proceso' WHERE id_p = ?";
        $stmtUpdate = $this->conexion->prepare($sqlUpdate);
        $stmtUpdate->bind_param("i", $id_p);
    
        if (!$stmtUpdate->execute()) {
            echo "<script>alert('Error al actualizar el estado del pedido.'); 
            window.location.href='gestionA.php';</script>";
        }

        $stmtInsert->close();
        $stmtUpdate->close();
    
        return true; 
    }

    public function cargarV(){
         $sql = "SELECT id_v, id_p, h_ini, h_fin, dia FROM Visita, Horario WHERE Visita.id_h = Horario.id_h AND baja = 0";

        $stmt = $this->conexion->prepare($sql); 
        $stmt->execute(); 
        $result = $stmt->get_result();
    
        $visitas = []; 
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $visitas[] = $row; 
            }
        }
    
        $stmt->close();
        return $visitas; 
    }


    private function obtenerEmailTecnico($id_p) {

        $sql = "SELECT email_t FROM Asigna WHERE id_p = ? LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            die("Error en la preparación: " . $this->conexion->error);
        }
        
        $stmt->bind_param("i", $id_p);
        
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['email_t'];
        }

        return null;
    }
    


    public function verificarVisitaExistente($id_p, $id_h, $dia) {
    $email_t = $this->obtenerEmailTecnico($id_p);
    
    if (!$email_t) {
        return false;
    }
    $sql = "SELECT DISTINCT Visita.* 
            FROM Visita 
            JOIN Asigna ON Visita.id_p = Asigna.id_p 
            WHERE Asigna.email_t = ? AND Visita.id_h = ? AND Visita.dia = ? AND Visita.baja = 0";
    
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("sis", $email_t, $id_h, $dia);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0;
}

    
    

    public function verificarPedidoEnAsigna($id_p) {
        $sql = "SELECT * FROM Asigna WHERE id_p = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_p);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    
    public function insertarVisita($id_p, $id_h, $dia) {
        $sql = "INSERT INTO Visita (id_p, id_h, dia, baja) VALUES (?, ?, ?, 0)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("iis", $id_p, $id_h, $dia);
        
        return $stmt->execute();
    }


    public function buscarClientes($email){
    $query = "SELECT email, nombre, celular FROM Usuario WHERE email = ? AND tipoU = 'Cliente'";
    $stmt = $this->conexion->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();


    $result = $stmt->get_result();

    
    if ($result->num_rows === 0) {
        $stmt->close();
        return false; 
    }

    $datos = $result->fetch_assoc();

    $stmt->close();

    return $datos;



    }

    public function actVisitas($id_p, $id_h, $dia, $baja, $id_v) {
        
        $queryCheck = "SELECT COUNT(*) FROM Asigna WHERE id_p = ?";
        $stmtCheck = $this->conexion->prepare($queryCheck);
        $stmtCheck->bind_param("i", $id_p);
        $stmtCheck->execute();
        $stmtCheck->bind_result($count);
        $stmtCheck->fetch();
        $stmtCheck->close();
        
        if ($count == 0) {
            echo "<script>alert('El ID de pedido ingresado no pertenece a la tabla Asigna.');</script>";
            return false;
        }
    
        $query = "UPDATE Visita SET id_p = ?, id_h = ?, dia = ?, baja = ? WHERE id_v = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("iisii", $id_p, $id_h, $dia, $baja, $id_v);
        $resultado = $stmt->execute();
        $stmt->close();
        
        return $resultado;
    }
    


    
    public function buscarVisita($id_v) {
        $sql = "SELECT * FROM Visita WHERE id_v = ? AND baja = 0";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_v); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $stmt->close();
            return false; 
        }
    
        $datosV = $result->fetch_assoc();
    
        $stmt->close();
    
        return $datosV;
    






    
    }

    
}




















    

    
?>