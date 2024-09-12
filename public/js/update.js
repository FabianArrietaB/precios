$(document).ready(function(){
    tblreferencias();
});

let modal = $('#modalupdateprecio');
let precios = $('#modallistaprecios');

const formatterPeso = new Intl.NumberFormat('es-CO', {
    style: 'currency',
    currency: 'COP',
    minimumFractionDigits: 0
})

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [year, month, day].join('-');
}

//BARRA SEARCH
$(document).ready(function () {
    (function($) {
        $('#filtro').keyup(function () {
            var ValorBusqueda = new RegExp($(this).val(), 'i');
            $('#tblreferencias tr').hide();
            $('#tblreferencias tr').filter(function () {
                return ValorBusqueda.test($(this).text());
            }).show();
        })
    }(jQuery));
});

//ORDER BY
const getCellValue = (tr, idx) => tr.children[idx].innerText || tr.children[idx].textContent;

const comparer = (idx, asc) => (a, b) => ((v1, v2) => 
    v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2)
)(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));

// do the work...
document.querySelectorAll('th').forEach(th => th.addEventListener('click', (() => {
    const table = th.closest('table');
    const tbody = table.querySelector('tbody');
    Array.from(tbody.querySelectorAll('tr'))
    .sort(comparer(Array.from(th.parentNode.children).indexOf(th), this.asc = !this.asc))
    .forEach(tr => tbody.appendChild(tr) );
})));

function tblreferencias(){
    $.ajax({
        url : "../controller/inventarios/productos.php",
        type : 'GET',
        dataType: 'json',
        success: function (data) {
            //console.log(data);
            let tbl = '';
            let producto = '';
            data.forEach((item, index) => {
                if(item.ESTADO === 0){
                    estado = 'INACTIVO'
                }else{
                    estado = 'ACTIVO'
                }
                producto = (item.NOMBRE.replace("\"", ""))
                tbl += `
                    <tr ondblclick="listaprecios('${item.REFERENCIA}', '${producto}', '${item.COSTO}', '${item.IVA}', '${item.COSTO_IVA}', '${item.FECCOMPRA}')" class="bg-white border-b">
                        <td style="width: 5%" class="text-center">${++index}</td>
                        <td style="width: 10%" class="text-center">${item.REFERENCIA}</td>
                        <td class="text-center" style="width: 25%" >${item.NOMBRE}</td>
                        <td class="text-center" style="width: 15%" >${item.BODEGA}</td>
                        <td class="text-center" style="width: 5%" >${item.STOCK}</td>
                        <td class="text-center" style="width: 10%" >${Math.round(item.COSTO)}</td>
                        <td class="text-center" style="width: 5%" >${Math.round(item.IVA)} %</td>
                        <td class="text-center" style="width: 10%" >${Math.round(item.COSTO_IVA)}</td>
                        <td class="text-center" style="width: 15%" >${formatDate(item.FECCOMPRA)}</td>
                    </tr>
                `
            });
            document.getElementById('tblreferencias').innerHTML = tbl
        }
    });
}

function listaprecios(refere, producto, costo, iva, costoiva, fecha){
    var title = `
        <h5 class="modal-title" role="title" id="exampleModalLabel">Editar Precios de Producto <strong>${producto} - ${refere}</strong></h5>
    `
    var bodi = `
            <div class="row item-center">
                <div class="col-md-3">
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Precio Compra</span>
                        </div>
                        <input disable type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="${formatterPeso.format(Number(costo))}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Iva</span>
                        </div>
                        <input disable type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="${Math.round(iva)} %">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Costo + Iva</span>
                        </div>
                        <input disable type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="${formatterPeso.format(Number(costoiva))}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">UltCompra</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="${formatDate(fecha)}">
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="row student text-center" style="align-items: center">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped font-small">
                            <thead>
                                <tr>
                                    <th scope="col" >NOMBRE</th>
                                    <th scope="col" >PRECIO</th>
                                </tr>
                            </thead>
                            <tbody id="tblprecios">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            `
    document.getElementById('title').innerHTML = title
    document.getElementById('body').innerHTML = bodi
    $.ajax({
        url: "../controller/precios/listaprecios.php",
        type: "GET",
        data: {'refere': refere},
        dataType: 'json',
        success:function(data){
            let tbl = '';
            data.forEach((item) => {
                if(item.valor <= 0){
                    valor = item.valor,
                    clase = 'text-danger'
                }else{
                    valor = item.valor,
                    clase = ''
                }
                producto = (item.producto.replace("\"", ""))
                tbl += `
                <tr ondblclick="precio('${item.refere}', '${producto}', '${item.codigo}', '${item.nombre}', '${item.valor}', '${costo}', '${iva}', '${costoiva}', '${fecha}')" class="bg-white border-b">
                    <td style="width: 10%" class="text-center">${item.nombre}</td>
                    <td style="width: 10%" class="text-center ${clase}">${formatterPeso.format(Number(valor))}</td>
                </tr>
                `
            });
            document.getElementById('tblprecios').innerHTML = tbl
        }
    });
    precios.modal('show')
}

function  precio(refere, producto, codigo, nombre, valor,costo, iva, costoiva, fecha){
    var title = `
        <h5 class="modal-title" role="title" id="exampleModalLabel">Editar Precios de ${producto}</h5>
    `
    var bodi = `
            <div class="row item-center">
                <div hidden class="col-12">
                    <div class="input-group input-group-sm  mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default"><strong>Codigo Lista</strong></span>
                        <input id="liscod" name="liscod" readonly value="${codigo}" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                        <input id="costo" name="costo" readonly value="${costo}" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                        <input id="iva" name="iva" readonly value="${iva}" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                        <input id="costoiva" name="costoiva" readonly value="${costoiva}" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                        <input id="fecha" name="fecha" readonly value="${fecha}" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div hidden class="col-12">
                    <div class="input-group input-group-sm  mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default"><strong>Referecia</strong></span>
                        <input id="refere" name="refere" readonly value="${refere}" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div hidden class="col-12">
                    <div class="input-group input-group-sm  mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default"><strong>Referecia</strong></span>
                        <input id="producto" name="producto" readonly value="${producto}" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-sm  mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default"><strong>Nombre</strong></span>
                        <input id="lista" name="lista" readonly value="${nombre}" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-sm  mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default"><strong>Precio Actual</strong></span>
                        <input readonly id="precio" name="precio" value="${valor}" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-sm  mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default"><strong>Nuevo Precio</strong></span>
                        <input id="newprecio" name="newprecio" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-grid gap-2">
                        <button class="btn btn-success" data-bs-dismiss="modal">Actualizar</button>
                    </div>
                </div>
            </div>
            `
    document.getElementById(`title_update`).innerHTML = title
    document.getElementById(`body_update`).innerHTML = bodi
    modal.modal('show')
    precios.modal('hide')
}

function updateprecio(){
    refere = $("#refere").val();
    producto = $("#producto").val();
    costo = $("#costo").val();
    iva = $("#iva").val();
    costoiva = $("#costoiva").val();
    fecha = $("#fecha").val();
    //console.log(refere)
    $.ajax({
        type: "POST",
        data: $('#frmupdateprecio').serialize(),
        url: "../controller/precios/update.php",
        success:function(respuesta){
            respuesta = respuesta.trim();
            console.log(respuesta)
            addhistorial(refere, producto, costo, iva, costoiva, fecha)
        }
    });
    return false;
}

function addhistorial(refere, producto, costo, iva, costoiva, fecha){
    $.ajax({
        type: "POST",
        data: $('#frmupdateprecio').serialize(),
        url: "../controller/precios/historial.php",
        success:function(respuesta){
            respuesta = respuesta.trim();
            console.log(respuesta)
            if(respuesta > 0){
                swal.fire({
                    icon: 'success',
                    title: 'Precio Actualizado Exitosamente',
                    showConfirmButton: false,
                    timer: 1500
                });
                listaprecios(refere, producto, costo, iva, costoiva, fecha);
            }else{
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error al Eliminar!',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        }
    });
}

