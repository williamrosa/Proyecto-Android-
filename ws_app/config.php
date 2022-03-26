<?php

    function conectar(){
        //Credenciales
        //servisor,usuario,contraseña
        $server = "localhost";
        $username = "root";
        $pasword = "";
        $bd = "miagenda";

        $idConexion = mysqli_connect($server,$username,$pasword,$bd);
        if(!$idConexion){
            $idConexion = msqli_error($idConexion);
        }
        return $idConexion;
    }

    function desconectar($idConexion){
        try {
           mysqli_close($idConexion);
           $estado=1;
        } catch ( Execption $e) {
            $estado=0;
        }
        return $estado;
    }

    function agregarContacto($nombre,$telefono){
        $idConexion= conectar();
        $sql ="INSERT INTO contactos (nombre,telefono) VALUES ('$nombre','$telefono')";
        if(mysqli_query($idConexion,$sql)){
            $estado= 1;
        }else{
            $estado = "ERROR: ". mysqli_error($idConexion);
        }
        desconectar($idConexion);
        return $estado;
    }

    function listarContacto($filtro){
        $idConexion = conectar();
        $datosFila = array();
        $consulta = "select id_contacto,nombre,telefono from contactos where (nombre LIKE '%$filtro%' or telefono LIKE '%$filtro%') order by nombre ASC";
        $query = mysqli_query($idConexion,$consulta);
        $nfilas = mysqli_num_rows($query);
        if ($nfilas!=0) {
            while ($aDatos = mysqli_fetch_array($query)) {
                $jsonfila = array();
                $id_contacto = $aDatos["id_contacto"];
                $nombre = $aDatos["nombre"];
                $telefono = $aDatos["telefono"];
                $jsonfila["id_contacto"]= $id_contacto;
                $jsonfila["nombre"]= $nombre;
                $jsonfila["telefono"]= $telefono;
                $datosFila[]=$jsonfila;
            }
        }
        desconectar($idConexion);
        return array_values($datosFila);
    }

    function modificarContacto($id_contacto,$nombre,$telefono){
        $idConexion= conectar();
        $sql ="UPDATE contactos SET nombre='$nombre',telefono='$telefono' WHERE id_contacto='$id_contacto'";
        if(mysqli_query($idConexion,$sql)){
            $estado= 1;
        }else{
            $estado = "ERROR: ". mysqli_error($idConexion);
        }
        desconectar($idConexion);
        return $estado;
    }

    function eliminarContacto($id_contacto){
        $idConexion= conectar();
        $sql ="DELETE FROM contactos  WHERE id_contacto='$id_contacto'";
        if(mysqli_query($idConexion,$sql)){
            $estado= 1;
        }else{
            $estado = "ERROR: ". mysqli_error($idConexion);
        }
        desconectar($idConexion);
        return $estado;
    }
?>