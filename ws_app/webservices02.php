<?php
    require("config.php");
    $datos = array();
    $accion ="";
    if (isset($_POST["accion"])) {
        $accion =$_POST["accion"];
    }

    if ($accion=="registrar") {
        $nombre = $_POST["nombre"];
        $telefono = $_POST["telefono"];
        if (agregarContacto($nombre,$telefono)==1) {
            $datos["estado"]=1;
            $datos["resultado"] = "Datos almacenados con exito";
        }else{
            $datos["estado"]=0;
            $datos["resultado"] = "ERROR no se almacenaron los datos";
        }
        
    }elseif ($accion=="listar_contactos") {
        $filtro ="";
        if (isset($_POST["filtro"])) {
            $filtro =$_POST["filtro"];
        }        
        $datos["estado"]= 1;
        $datos["resultado"]= listarContacto($filtro);

    }elseif ($accion=="modificar") {
        $id_contacto =$_POST["id_contacto"];
        $nombre = $_POST["nombre"];
        $telefono = $_POST["telefono"];
        if (modificarContacto($id_contacto,$nombre,$telefono)==1) {
            $datos["estado"]=1;
            $datos["resultado"] = "Datos modificados con exito";
        }else{
            $datos["estado"]=0;
            $datos["resultado"] = "ERROR no se modificaron los datos";
        }
        
    }elseif ($accion=="eliminar") {
        $id_contacto =$_POST["id_contacto"];
        if (eliminarContacto($id_contacto)==1) {
            $datos["estado"]=1;
            $datos["resultado"] = "Datos eliminados con exito";
        }else{
            $datos["estado"]=0;
            $datos["resultado"] = "ERROR no se eliminaron los datos";
        }
    }

    echo json_encode($datos);
?>