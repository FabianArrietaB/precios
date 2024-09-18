<?php
    include "conexion.php";

    class Inventario extends Conexion {

        public function productos(){
            $con = new Conexion();
            $sql = $con->conectarFomplus()->prepare('SELECT DISTINCT 
                m.INV_REFER REFERENCIA,
                m.INV_CODIGO CODIGO,
                m.INV_NOMBRE NOMBRE,
                m.INV_UNDMED UNDMED,
                spb.codigo_bodega CODALM,
                a.ALM_NOMBRE BODEGA,
                spb.stock STOCK,
                m.INV_VALCOM COSTO,
                m.INV_PORIVA IVA,
                (m.INV_VALCOM + (m.INV_VALCOM * (m.INV_PORIVA / 100))) COSTO_IVA,
                m.INV_VALVEN PREVENTA,
                m.INV_FECCOM FECCOMPRA,
                spb.desactivado ESTADO
            FROM METROCERAMICA.dbo.MAEINV m
            INNER JOIN METROCERAMICA.dbo.LISPRE l ON m.INV_REFER = l.PRE_REFER
            INNER JOIN METROPOLIS_EXT.dbo._stock_por_bodegas spb ON m.INV_REFER = spb.referencia
            INNER JOIN METROCERAMICA.dbo.MAEALM a ON spb.codigo_bodega = a.ALM_CODIGO
            WHERE l.PRE_VALOR = 0 AND spb.stock != 0 AND l.PRE_CODIGO IN (0, 1, 2)
            ORDER BY m.INV_REFER');
            $sql->execute();
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public function stock($desde, $hasta, $bodega){
            if($desde != "" && $hasta != "" && $bodega != ""){
                $con = new Conexion();
                $sql = $con->conectarFomplus()->prepare("SELECT DISTINCT
                    m.INV_REFER REFERENCIA,
                    m.INV_CODIGO CODIGO,
                    m.INV_NOMBRE NOMBRE,
                    m.INV_UNDMED UNDMED,
                    m.INV_VALCOM VALORCOMPRA,
                    m.INV_VALVEN VALORVENTA,
                    m.INV_FECCOM FECCOMPRA,
                    spb.stock STOCK,
                    spb.codigo_bodega CODALM,
                    a.ALM_NOMBRE BODEGA,
                    spb.costo COSTO_STOCK
                FROM METROCERAMICA.dbo.MAEINV m
                INNER JOIN METROPOLIS_EXT.dbo.[_stock_por_bodegas] spb ON m.INV_REFER = spb.referencia
                INNER JOIN METROCERAMICA.dbo.MAEALM a ON spb.codigo_bodega = a.ALM_CODIGO
                WHERE spb.desactivado != 1
                AND CAST(m.INV_FECCOM AS date) BETWEEN CAST('$desde 00:00:00' as datetime) AND CAST('$hasta 00:00:00' as datetime)
                AND spb.codigo_bodega = '$bodega'");
                $sql->execute();
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            } else if($desde != "" && $hasta != "" && $bodega == ""){
                $con = new Conexion();
                $sql = $con->conectarFomplus()->prepare("SELECT DISTINCT
                    m.INV_REFER REFERENCIA,
                    m.INV_CODIGO CODIGO,
                    m.INV_NOMBRE NOMBRE,
                    m.INV_UNDMED UNDMED,
                    m.INV_VALCOM VALORCOMPRA,
                    m.INV_VALVEN VALORVENTA,
                    m.INV_FECCOM FECCOMPRA,
                    spb.stock STOCK,
                    spb.codigo_bodega CODALM,
                    a.ALM_NOMBRE BODEGA,
                    spb.costo COSTO_STOCK
                FROM METROCERAMICA.dbo.MAEINV m
                INNER JOIN METROPOLIS_EXT.dbo.[_stock_por_bodegas] spb ON m.INV_REFER = spb.referencia
                INNER JOIN METROCERAMICA.dbo.MAEALM a ON spb.codigo_bodega = a.ALM_CODIGO
                WHERE spb.desactivado != 1
                AND CAST(m.INV_FECCOM AS date) BETWEEN CAST('$desde 00:00:00' as datetime) AND CAST('$hasta 00:00:00' as datetime)");
                $sql->execute();
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            }else if($desde == "" && $hasta == "" && $bodega != ""){
                $con = new Conexion();
                $sql = $con->conectarFomplus()->prepare("SELECT DISTINCT
                    m.INV_REFER REFERENCIA,
                    m.INV_CODIGO CODIGO,
                    m.INV_NOMBRE NOMBRE,
                    m.INV_UNDMED UNDMED,
                    m.INV_VALCOM VALORCOMPRA,
                    m.INV_VALVEN VALORVENTA,
                    m.INV_FECCOM FECCOMPRA,
                    spb.stock STOCK,
                    spb.codigo_bodega CODALM,
                    a.ALM_NOMBRE BODEGA,
                    spb.costo COSTO_STOCK
                FROM METROCERAMICA.dbo.MAEINV m
                INNER JOIN METROPOLIS_EXT.dbo.[_stock_por_bodegas] spb ON m.INV_REFER = spb.referencia
                INNER JOIN METROCERAMICA.dbo.MAEALM a ON spb.codigo_bodega = a.ALM_CODIGO
                WHERE spb.desactivado != 1
                AND spb.codigo_bodega = '$bodega'");
                $sql->execute();
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            }else{
                $con = new Conexion();
                $sql = $con->conectarFomplus()->prepare("SELECT DISTINCT
                    m.INV_REFER REFERENCIA,
                    m.INV_CODIGO CODIGO,
                    m.INV_NOMBRE NOMBRE,
                    m.INV_UNDMED UNDMED,
                    m.INV_VALCOM VALORCOMPRA,
                    m.INV_VALVEN VALORVENTA,
                    m.INV_FECCOM FECCOMPRA,
                    spb.stock STOCK,
                    spb.codigo_bodega CODALM,
                    a.ALM_NOMBRE BODEGA,
                    spb.costo COSTO_STOCK
                FROM METROCERAMICA.dbo.MAEINV m
                INNER JOIN METROPOLIS_EXT.dbo.[_stock_por_bodegas] spb ON m.INV_REFER = spb.referencia
                INNER JOIN METROCERAMICA.dbo.MAEALM a ON spb.codigo_bodega = a.ALM_CODIGO
                WHERE spb.desactivado != 1");
                $sql->execute();
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
            return $data;
        }

        public function apolo(){
            $con = new Conexion();
            $sql = $con->conectarBD()->prepare('SELECT 
                ap.id,
                ap.codigo CODIGO,
                ap.nombre NOMBRE,
                ap.referencia_fomplus FOMPLUS,
                m.INV_NOMBRE NOMFOMPLUS,
                ap.referencia_triunfo TRIUNFO,
                ap.referencia_world WORLD,
                ap.stock STOCK,
                ap.costo COSTO,
                ap.iva IVA,
                ap.undmed UNDMED
            FROM METROPOLIS_EXT.dbo.[apolo_invtriunfo] ap
            INNER JOIN METROCERAMICA.dbo.MAEINV m ON ap.referencia_fomplus = m.INV_REFER');
            $sql->execute();
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public function apolo2(){
            $con = new Conexion();
            $sql = $con->conectarBD()->prepare('SELECT 
                ap.id,
                ap.codigo CODIGO,
                ap.nombre NOMBRE,
                ap.referencia_fomplus FOMPLUS,
                ap.referencia_triunfo TRIUNFO,
                ap.referencia_world WORLD,
                ap.stock STOCK,
                ap.costo COSTO,
                ap.iva IVA,
                ap.undmed UNDMED
            FROM METROPOLIS_EXT.dbo.[apolo_invtriunfo] ap
            WHERE ap.referencia_fomplus IS NULL');
            $sql->execute();
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public function addreferencia($codigo, $referencia){
            $con = new Conexion();
            $sql = $con->conectarBD()->prepare('UPDATE METROPOLIS_EXT.dbo.[apolo_invtriunfo] SET referencia_fomplus = ? WHERE codigo = ?');
            $sql->execute(array($referencia, $codigo));
            if($sql != null){
                return 1;
            }else{
                return 0;
            }
        }

        public function addapolo($datos){
            $con = Conexion::conectarapolo();
            $sql = "UPDATE articulos SET referencia_externa = ? WHERE id = ?";
            $query = $con->prepare($sql);
            $query->bind_param('si', $datos['referencia'], $datos['codigo']);
            $respuesta = $query->execute();
            return $respuesta;
        }

        public function consulta($referencia){
            $con = new Conexion();
            $sql = $con->conectarFomplus()->prepare("SELECT INV_NOMBRE FROM MAEINV WHERE INV_REFER = ?");
            $sql->execute(array($referencia));
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            return $data['INV_NOMBRE'];
        }

        public function rename($datos){
            $con = Conexion::conectarapolo();
            $sql = "UPDATE articulos SET nombre = ? WHERE referencia_externa = ?";
            $query = $con->prepare($sql);
            $query->bind_param('ss', $datos['nombre'], $datos['referencia']);
            $respuesta = $query->execute();
            return $respuesta;
        }

        public function rename2($nombre, $referencia){
            $con = new Conexion();
            $sql = $con->conectarBD()->prepare('UPDATE METROPOLIS_EXT.dbo.[apolo_invtriunfo] SET nombre = ? WHERE referencia_fomplus = ?');
            $sql->execute(array($nombre, $referencia));
            if($sql != null){
                return 1;
            }else{
                return 0;
            }
        }
    }
?>