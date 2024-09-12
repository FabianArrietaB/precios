<?php
    include "conexion.php";

    class Usuarios extends Conexion {

        public function ingresousuario($usuario, $password){
            $conexion = Conexion::conectar();
            $sql =  "SELECT * FROM usuarios WHERE user_nombre = '$usuario' AND user_password = '$password'";
            $respuesta = mysqli_query($conexion, $sql);
            if(mysqli_num_rows($respuesta) > 0){
                $datosUsuario = mysqli_fetch_array($respuesta);
                if($datosUsuario['user_estado'] == 1 ){
                    $_SESSION['usuario']['preusuario'] = $datosUsuario['user_nombre'];
                    $_SESSION['usuario']['preid'] = $datosUsuario['id_usuario'];
                    $_SESSION['usuario']['prerol'] = $datosUsuario['id_rol'];
                    $_SESSION['usuario']['presede'] = $datosUsuario['id_sede'];
                    $_SESSION['usuario']['prearea'] = $datosUsuario['id_area'];
                    return 1;
                }else{
                    return 0;
                }
            }else{
                return 0;
            }
        }

        public function agregarusuario($datos){
            $conexion = Conexion::conectar();
            $sql = "INSERT INTO usuarios (id_operador, id_persona, id_sede, id_rol, id_area, user_nombre, user_password) VALUES( ?, ?, ?, ?, ?, ?, ?)";
            $query = $conexion->prepare($sql);
            $query->bind_param("iiiiiss", $datos['idoperador'], $datos['idpersona'], $datos['idsede'], $datos['idrol'], $datos['idarea'], $datos['usuario'], $datos['password']);
            $respuesta = $query->execute();
            return $respuesta;
        }

        public function detalleusuario($idusuario){
            $conexion = Conexion::conectar();
            $sql ="SELECT
                u.id_usuario  AS idusuario,
                u.id_persona  AS idpersona,
                p.per_nombre  AS nombre,
                u.user_nombre AS usuario,
                u.user_password AS password,
                u.id_rol      AS idrol,
                r.rol_nombre  AS rol,
                u.id_area     AS idarea,
                u.id_sede     AS idsede,
                u.user_estado AS estado
                FROM usuarios AS u
                INNER JOIN roles AS r ON u.id_rol = r.id_rol
                INNER JOIN personas AS p ON p.id_persona = u.id_persona
                INNER JOIN areas AS a ON a.id_area = u.id_area
                INNER JOIN sedes AS s ON s.id_sede = u.id_sede
                WHERE u.id_usuario ='$idusuario'";
            $respuesta = mysqli_query($conexion,$sql);
            $usuario = mysqli_fetch_array($respuesta);
            $datos = array(
                'idusuario' => $usuario['idusuario'],
                'idpersona' => $usuario['idpersona'],
                'password'  => $usuario['password'],
                'idarea'    => $usuario['idarea'],
                'idsede'    => $usuario['idsede'],
                'idrol'     => $usuario['idrol'],
                'usuario'   => $usuario['usuario'],
                'nombre'    => $usuario['nombre'],
            );
            return $datos;
        }

        public function editarusuario($datos){
            $conexion = Conexion::conectar();
            $sql = "UPDATE usuarios SET id_rol = ?,
                                        id_sede = ?,
                                        id_area = ?,
                                        user_nombre = ?,
                                        user_password = ?
                                        WHERE id_usuario = ?";
            $query = $conexion->prepare($sql);
            $query->bind_param('iiissi',
                                $datos['idrol'],
                                $datos['idsede'],
                                $datos['idarea'],
                                $datos['usuario'],
                                $datos['password'],
                                $datos['idusuario']);
            $respuesta = $query->execute();
            return $respuesta;
        }

        public function eliminarusuario($idusuario){
            $conexion = Conexion::conectar();
            $sql = "DELETE FROM usuarios WHERE id_usuario=?";
            $query = $conexion->prepare($sql);
            $query->bind_param('i', $idusuario);
            $respuesta = $query->execute();
            $query->close();
            return $respuesta;
        }

        public function detallepass($idusuario){
            $conexion = Conexion::conectar();
            $sql ="SELECT
                u.id_usuario  AS usuarioid
                FROM usuarios AS u
                WHERE u.id_usuario ='$idusuario'";
            $respuesta = mysqli_query($conexion,$sql);
            $usuario = mysqli_fetch_array($respuesta);
            $datos = array(
                'usuarioid' => $usuario['usuarioid'],
            );
            return $datos;
        }

        public function cambiocontraseña($datos){
            $conexion = Conexion::conectar();
            $sql = "UPDATE usuarios SET user_password = ? WHERE id_usuario = ?";
            $query = $conexion->prepare($sql);
            $query->bind_param('si', $datos['newpassword'], $datos['usuarioid']);
            $respuesta = $query->execute();
            $query->close();
            return $respuesta;
        }

        public function activarusuario($idusuario, $estado){
            if($estado == 1){
                $estado = 0;
            }else{
                $estado = 1;
            }
            $conexion = Conexion::conectar();
            $sql = "UPDATE usuarios SET user_estado = ? WHERE id_usuario = ?";
            $query = $conexion->prepare($sql);
            $query->bind_param('ii', $estado, $idusuario);
            $respuesta = $query->execute();
            $query->close();
            return $respuesta;
        }
    }
?>