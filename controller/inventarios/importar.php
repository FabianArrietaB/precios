<?php
        include('../../vendor/autoload.php');
        include "../../model/conexion.php";

        use PhpOffice\PhpSpreadsheet\IOFactory;
        //CONEXION A BASE DA DATOS
        $con = new Conexion();
        $conexion = $con->conectarBD();
        // CREANDO EL ARCHIVO
        $excel = $_FILES['productos']['tmp_name'];
        // CARGANDO EL ARCHIVO
        $spreadsheet = IOFactory::load($excel);
        // SELECCIONAR LA PRIMERA HOJA
        $hoja = $spreadsheet->getActiveSheet();
        // TOTAL DE FILAS Y COLUMNAS
        $filas = $hoja->getHighestRow();
        $columnas = $hoja->getHighestColumn();
        // CREAR EL INDICE DEL ARCHIVO
        $index = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($columnas);
        //CONVIRTIENDO EN DATOS
        $data = array();

        for ($fila = 2; $fila <= $filas; $fila++) {

                $data[] = array(
                        'CODIGO'   => $hoja->getCell("A$fila")->GetValue(),
                        'NOMBRE'   => $hoja->getCell("B$fila")->GetValue(),
                        'FOMPLUS'  => $hoja->getCell("C$fila")->GetValue(),
                        'TRIUNFO'  => $hoja->getCell("D$fila")->GetValue(),
                        'WORDL'    => $hoja->getCell("E$fila")->GetValue(),
                        'STOCK'    => $hoja->getCell("F$fila")->GetValue(),
                        'COSTO'    => $hoja->getCell("G$fila")->GetValue(),
                        'IVA'      => $hoja->getCell("H$fila")->GetValue(),
                        'UNDMED'   => $hoja->getCell("I$fila")->GetValue()
                );
        }

        $productos = 0;

        // INSERTAR PRODUCTOS
        foreach ($data as $value) {
        $stmt = $conexion->prepare("INSERT INTO apolo_invtriunfo (codigo,
                                                                nombre,
                                                                referencia_fomplus,
                                                                referencia_triunfo,
                                                                referencia_world,
                                                                stock,
                                                                costo,
                                                                iva,
                                                                undmed)
                                                        VALUES  (:CODIGO,
                                                                :NOMBRE,
                                                                :FOMPLUS,
                                                                :TRIUNFO,
                                                                :WORDL,
                                                                :STOCK,
                                                                :COSTO,
                                                                :IVA,
                                                                :UNDMED);");
                $stmt -> bindParam(":CODIGO",   $value['CODIGO'],     PDO::PARAM_STR);
                $stmt -> bindParam(":NOMBRE",   $value['NOMBRE'],     PDO::PARAM_STR);
                $stmt -> bindParam(":FOMPLUS",  $value['FOMPLUS'],    PDO::PARAM_STR);
                $stmt -> bindParam(":TRIUNFO",  $value['TRIUNFO'],    PDO::PARAM_STR);
                $stmt -> bindParam(":WORDL",    $value['WORDL'],      PDO::PARAM_STR);
                $stmt -> bindParam(":STOCK",    $value['STOCK'],      PDO::PARAM_STR);
                $stmt -> bindParam(":COSTO",      $value['COSTO'],        PDO::PARAM_STR);
                $stmt -> bindParam(":IVA",      $value['IVA'],        PDO::PARAM_STR);
                $stmt -> bindParam(":UNDMED",   $value['UNDMED'],     PDO::PARAM_STR);

                /*en esta condicion verificamos que si
                la cumple vaya contabilizando los productos */
                $productos += ($stmt->execute()) ? 1 : 0;
        }

        header('Content-Type: application/json');
        echo json_encode(array('productos' => $productos, 'data' => $data));

?>