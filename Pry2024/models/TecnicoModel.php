<?php

require_once("db\connection.php");

class TecnicoModel {
    private $conexion;

    public function __construct() {
        $this->conexion = getConnection(); 
    }


  public function cargarP($email){
    $sql = "SELECT A.id_p, A.email_c, A.servicio_id, P.comentarios, P.estado 
    FROM Pedido P, Asigna A WHERE P.id_p = A.id_p 
     AND A.email_t = ?";

     $stmt = $this->conexion->prepare($sql);
     $stmt->bind_param("s", $email);
     $stmt->execute(); 
     $result = $stmt->get_result(); 
 
     $pedidos = [];
     while ($row = $result->fetch_assoc()) {
         $pedidos[] = $row; 
     }
     
     $stmt->close();
     return $pedidos;
 }

 public function cargarV($email){
    $sql = "SELECT Visita.id_v, Visita.id_p, h_ini, h_fin, dia FROM Visita, Horario, Asigna 
    WHERE Visita.id_h = Horario.id_h AND Visita.id_p = Asigna.id_p AND Asigna.email_t = ? AND baja = 0";

   $stmt = $this->conexion->prepare($sql); 
   $stmt->bind_param("s", $email);

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

public function buscarPedidoEnVisita($id_p) {
    $sql = "SELECT Pedido.estado, Pedido.comentarios FROM Visita, Pedido 
    WHERE Visita.id_p = Pedido.id_p AND Visita.id_p = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("i", $id_p); 
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return null;
}

public function actualizarEstadoYComentarios($id_p, $nuevoEstado, $comentarios) {
    
    $sql = "UPDATE Pedido SET estado = ?, comentarios = ? WHERE id_p = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("ssi", $nuevoEstado, $comentarios, $id_p);
    
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}


public function darBajaVisita($id_p) {
    $sql = "UPDATE Visita SET baja = 1 WHERE id_p = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("i", $id_p);
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





}






?>