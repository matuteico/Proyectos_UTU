<?php
require_once("db/connection.php");

class UserModel {
    private $conexion;

    public function __construct() {
        $this->conexion = getConnection(); 
    }

    public function login($usu, $psw) {
        $psw = MD5($psw);
        $sql = "SELECT * FROM Usuario WHERE email = ? AND passwd = ? AND baja = 0";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ss", $usu, $psw);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }

    public function register($email, $nombre, $passwd, $celular) {
        
        if (preg_match('/\d/', $nombre) || !ctype_digit($celular) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;  
        }
    
       
        $sql_check = "SELECT 1 FROM Usuario WHERE email = ?";
        $stmt_check = $this->conexion->prepare($sql_check);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $result = $stmt_check->get_result();
    
        if ($result->num_rows > 0) {
            echo "<script>alert('El email ingresado ya existe.');</script>";
            return false; 
        }
    
     
        $passwd = MD5($passwd);  
        $sql_insert = "INSERT INTO Usuario (email, nombre, passwd, celular, tipoU, baja) 
                       VALUES (?, ?, ?, ?, 'Cliente', 0)"; 
    
        $stmt_insert = $this->conexion->prepare($sql_insert);
        $stmt_insert->bind_param("sssi", $email, $nombre, $passwd, $celular);
        
     
        return $stmt_insert->execute();
    }



    public function modC($email, $nombre, $passwd, $celular) {

        if (preg_match('/\d/', $nombre) || !ctype_digit($celular) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;  
        }  
        $passwd = MD5($passwd);     
        $sql_insert = "UPDATE Usuario SET nombre = ?, passwd = ?, celular = ? WHERE email = ?"; 
    
        $stmt_insert = $this->conexion->prepare($sql_insert);
    
        $stmt_insert->bind_param("ssss", $nombre, $passwd, $celular, $email);
    
        return $stmt_insert->execute();
    }
    


    
    public function cargarC($email) {
        $sql = "SELECT * FROM Usuario WHERE email = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $datosC = $result->fetch_assoc();
    
        $stmt->close();
        return $datosC; 
    }
    



    public function altaP($s_id, $email, $comentarios) {
        $sql = "INSERT INTO Pedido (email_c, servicio_id, f_reg, comentarios, estado) 
        VALUES (?, ?, NOW(), ?, 'Pendiente')";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sis", $email, $s_id, $comentarios);
        
        return $stmt->execute();
    }

    public function obtenerPedidos($email, $offset = 0, $limit = 10) {
        $sql = "SELECT P.id_p, S.servicio_tipo, P.f_reg, P.comentarios, P.estado
                FROM Pedido P
                JOIN Servicio S ON P.servicio_id = S.servicio_id
                WHERE P.email_c = ?
                LIMIT ?, ?";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sii", $email, $offset, $limit); 
        $stmt->execute(); 
        $result = $stmt->get_result(); 
    
        $pedidos = [];
        while ($row = $result->fetch_assoc()) {
            $pedidos[] = $row;
        }
        
        $stmt->close();
        return $pedidos; 
    }

    public function buscarPedidoPorId($id, $email) {
        $query = "SELECT P.id_p, P.servicio_id, S.servicio_tipo, P.comentarios
                  FROM Pedido P
                  JOIN Servicio S ON P.servicio_id = S.servicio_id
                  WHERE P.email_c = ? AND P.id_p = ?";
        
        $stmt = $this->conexion->prepare($query);
    
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $this->conexion->error);
        }
          
        $stmt->bind_param("si", $email, $id);  
        
        $stmt->execute();
        
        $result = $stmt->get_result();
    
        $pedido = $result->fetch_assoc(); 
    
        $stmt->close();

        return $pedido;
    }
    
        
    public function actualizarPedido($id, $servicio_id, $comentario) {
        $query = "UPDATE Pedido SET servicio_id = ?, comentarios = ? WHERE id_p = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("isi", $servicio_id, $comentario, $id);
        
        $resultado = $stmt->execute();
        $stmt->close();
    
        return $resultado;
    }


public function cargarV($email){
$sql = "SELECT DISTINCT V.id_p, A.email_t, CONCAT(H.h_ini, '-', H.h_fin) AS h_e, V.dia 
FROM Visita V
JOIN Asigna A ON V.id_p = A.id_p
JOIN Horario H ON V.id_h = H.id_h
WHERE A.email_c = ? AND V.baja = 0";

$stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $email); 
        $stmt->execute(); 
        $result = $stmt->get_result(); 
    
        $visitas = [];
        while ($row = $result->fetch_assoc()) {
            $visitas[] = $row;
        }
        
        $stmt->close();
        return $visitas; 


}



}    
?>
