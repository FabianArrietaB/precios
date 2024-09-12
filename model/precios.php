<?php
    date_default_timezone_set('America/Bogota');
    include "conexion.php";
    class Precios extends Conexion {

        public function productos($proveedor){
            $con = new Conexion();
            $newproveedor = '%'. $proveedor . '%';
            $sql = $con->conectarFomplus()->prepare("SELECT
                p.INV_REFER   referencia,
                p.INV_CODIGO  codigo,
                p.INV_NOMBRE  nombre,
                p.INV_CLASE   clase,
                p.INV_GRUPO   grupo,
                p.INV_LINEA   linea,
                p.INV_MARCA   marca,
                m.MAR_NOMBRE  marca_nombre,
                p.INV_FECCOM  fecha_compra,
                p.INV_VALCOM  valor_compra,
                p.INV_VALVEN  valor_venta,
                p.INV_PROVEE  nitproveedor,
                pr.CLI_NOMBRE proveedor,
                p.INV_ACTIVO  activo
            FROM METROCERAMICA.dbo.MAEINV p
            LEFT JOIN METROCERAMICA.dbo.MAECXP pr ON p.INV_PROVEE = pr.CLI_CEDULA
            LEFT JOIN METROCERAMICA.dbo.MAEMAR m ON m.MAR_CODIGO = p.INV_MARCA
            WHERE m.MAR_NOMBRE LIKE ?
            ORDER BY p.INV_REFER ASC");
            $sql->execute(array($newproveedor));
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public function hisprecios($datos){
            $conexion = Conexion::conectar();
            $sql = "INSERT INTO histprecios (
                id_operador,
                pre_refere,
                pre_produc,
                pre_lista,
                pre_preant,
                pre_prenew) VALUES( ?, ?, ?, ?, ?, ?)";
            $query = $conexion->prepare($sql);
            $query->bind_param("isssss",
                    $datos['idoperador'],
                    $datos['refere'],
                    $datos['produc'],
                    $datos['lista'],
                    $datos['precio'],
                    $datos['newprecio']);
            $respuesta = $query->execute();
            return $respuesta;
        }
    }
?>