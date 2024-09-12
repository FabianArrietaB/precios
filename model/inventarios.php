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

        public function stock(){
            $con = new Conexion();
            $sql = $con->conectarFomplus()->prepare('SELECT DISTINCT
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
            WHERE spb.codigo_bodega IN (0001, 0019, 0018) AND spb.desactivado != 1');
            $sql->execute();
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    }
?>