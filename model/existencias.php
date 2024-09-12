<?php
    include "conexion.php";

    class Bodega extends Conexion {

        public function productos($desde,$hasta,$bodega){
            $con = new Conexion();
            $sql = $con->conectarFomplus()->prepare("SELECT 
                spb.referencia REFERENCIA,
                spb.nombre NOMBRE,
                spb.costo COSTO,
                spb.porcentaje_iva IVA,
                (vspb.stock + mi.SALIDAS) STOCK_INICIAL,
                spb.stock STOCK_FOMPLUS,
                mi.ENTRADAS ENTRADAS,
                mi.SALIDAS SALIDAS
            FROM METROCERAMICA.dbo.vis_stock_por_bodegas spb
            INNER JOIN METROCERAMICA_OLD.dbo.vis_stock_por_bodegas vspb ON spb.referencia = vspb.referencia
            INNER JOIN (SELECT 
                        MOV_REFER REFERENCIA,
                        SUM(CASE WHEN MOV_TIPMOV in(01,02,03,04,05,06,07) THEN MOV_CANTID ELSE 0 END) ENTRADAS,
                        SUM(CASE WHEN MOV_TIPMOV in(51,52,53,54,55,56,57) THEN MOV_CANTID ELSE 0 END) SALIDAS
                        FROM METROCERAMICA.dbo.MOVINV2024
                        WHERE CAST(MOV_FECHA AS date) BETWEEN CAST('$desde 00:00:00' as datetime) AND CAST('$hasta 00:00:00' as datetime) AND MOV_BODEGA = {$bodega}
                        GROUP BY MOV_REFER
                        ) mi ON vspb.referencia = mi.REFERENCIA
            WHERE spb.codigo_bodega = {$bodega} AND vspb.codigo_bodega = {$bodega}
            GROUP BY spb.referencia,spb.nombre,spb.costo,spb.porcentaje_iva,spb.stock, vspb.stock, mi.ENTRADAS, mi.SALIDAS
            ORDER BY spb.referencia ASC");
            $sql->execute();
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public function moventradas($referencia,$desde,$hasta,$bodega){
            $con = new Conexion;
            $sql = $con->conectarFomplus()->prepare("SELECT 
                m.MOV_REFER, 
                m.MOV_FECHA,
                t.TIP_NOMBRE,
                m.MOV_PREFIJ,
                m.MOV_NUMDOC,
                m.MOV_CANTID,
                m.MOV_VALOR
            FROM METROCERAMICA.dbo.MOVINV2024 m
            INNER JOIN METROCERAMICA.dbo.TIPINV t ON m.MOV_TIPMOV = t.TIP_CODIGO
            WHERE m.MOV_TIPMOV IN ('01', '02', '03', '05', '06', '07') 
            AND MOV_FECHA BETWEEN CAST('$desde' as date) AND CAST('$hasta' as date) 
            AND MOV_BODEGA = '$bodega' AND MOV_ESTREG != 'S' AND MOV_ESTREG != 'A'
            AND MOV_REFER = '$referencia'
            ORDER BY MOV_FECHA");
            $sql->execute();
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public function movsalidas($referencia,$desde,$hasta,$bodega){
            $con = new Conexion;
            $sql = $con->conectarFomplus()->prepare("SELECT 
                m.MOV_REFER, 
                m.MOV_FECHA,
                t.TIP_NOMBRE,
                m.MOV_PREFIJ,
                m.MOV_NUMDOC,
                m.MOV_CANTID,
                m.MOV_VALOR
            FROM METROCERAMICA.dbo.MOVINV2024 m
            INNER JOIN METROCERAMICA.dbo.TIPINV t ON m.MOV_TIPMOV = t.TIP_CODIGO
            WHERE m.MOV_TIPMOV IN ('51', '52', '53', '55', '56', '57') 
            AND MOV_FECHA BETWEEN CAST('$desde' as date) AND CAST('$hasta' as date) 
            AND MOV_BODEGA = '$bodega' AND MOV_ESTREG != 'S' AND MOV_ESTREG != 'A'
            AND MOV_REFER = '$referencia'
            ORDER BY MOV_FECHA");
            $sql->execute();
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    }
?>