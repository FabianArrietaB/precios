let modal = $('#modalupdateprecio');

const formatterPeso = new Intl.NumberFormat('es-CO', {
    style: 'currency',
    currency: 'COP',
    minimumFractionDigits: 0
})

$('#proveedor').keyup(function (event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
        if($("#proveedor").val() == ""){
            Swal.fire({
                title: "Respuesta",
                text: 'Nombre o Documento es Requerido',
                icon: 'warning'
            });
        }else{
            buscarproductos()
        }
    }
});

$(document).ready(function () {
    (function($) {
        $('#FiltrarContenido').keyup(function () {
            var ValorBusqueda = new RegExp($(this).val(), 'i');
            $('.BusquedaRapida tr').hide();
            $('.BusquedaRapida tr').filter(function () {
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

function buscarproductos(){
    proveedor = $("#proveedor").val();
    $.ajax({
        url : "../controller/precios/consulta.php",
        data: {'proveedor': proveedor},
        type : 'GET',
        dataType: 'json',
        success: function (data) {
            let tbl = '';
            var estado = '';
            var css_estado = '';
            $("#proveedor").val(data[0].proovedor);
            Swal.fire({
                title: "Productos Cargados",
                icon: 'success',
                showConfirmButton: false,
                timer: 1000
            });
            data.forEach((item) => {
            if(item.activo == 1){
                estado = 'INACTIVO'
                css_estado = 'text-danger text-center'
            }else{
                estado = 'ACTIVO'
                css_estado = 'text-success text-center'
            }
            tbl += `
            <tr ondblclick="todas('${item.refere}')" class="bg-white border-b">
                <td style="width: 50%"  class="text-center">${item.refere} - ${item.nombre}</td>
                <td style="width: 20%" class="text-center">${item.marca}</td>
                <td style="width: 20%" class="text-center">${item.proveedor}</td>
                <td style="width: 10%" class="${css_estado}">${estado}</td>
            </tr>
            `
            });
            document.getElementById(`tblproductos`).innerHTML = tbl
        }
    });
}

function todas(refere){
    listaprecios(refere);
    stock(refere);
}

function listaprecios(refere){
    $.ajax({
        url: "../controller/precios/listaprecios.php",
        type: "GET",
        data: {'refere': refere},
        dataType: 'json',
        success:function(data){
            let tbl = '';
            Swal.fire({
                title: "Listas Cargadas",
                icon: 'success',
                showConfirmButton: false,
                timer: 1000
            });
            data.forEach((item) => {
                tbl += `
                <tr ondblclick="precio('${item.refere}', '${item.producto}', '${item.codigo}', '${item.nombre}', ${item.valor})" class="bg-white border-b">
                    <td style="width: 10%" class="text-center">${item.codigo}</td>
                    <td style="width: 10%" class="text-center">${item.nombre}</td>
                    <td style="width: 10%" class="text-center">${formatterPeso.format(Number(item.valor))}</td>
                </tr>
                `
            });
            document.getElementById(`tblprecios`).innerHTML = tbl
        }
    });
    return false;
}

function stock(refere){
    $.ajax({
        url: "../controller/precios/stock.php",
        type: "GET",
        data: {'refere': refere},
        dataType: 'json',
        success:function(data){
            let tbl = '';
            data.forEach((item) => {
                tbl += `
                <tr class="bg-white border-b">
                    <td style="width: 10%" class="text-center">${item.bodega}</td>
                    <td style="width: 10%" class="text-center">${item.stock}</td>
                </tr>
                `
            });
            document.getElementById(`tblstock`).innerHTML = tbl
        }
    });
    return false;
}

function  precio(refere, producto, codigo, nombre, valor){
    var title = `
        <h5 class="modal-title" role="title" id="exampleModalLabel">Editar Precios de lista ${nombre} de ${producto}</h5>
    `
    var bodi = `
            <div class="row">
                <div hidden class="col-12">
                    <div class="input-group input-group-sm  mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default"><strong>Codigo Lista</strong></span>
                        <input id="liscod" name="liscod" readonly value="${codigo}" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
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
    document.getElementById(`title`).innerHTML = title
    document.getElementById(`body`).innerHTML = bodi
    modal.modal('show')
}

function updateprecio(){
    $.ajax({
        type: "POST",
        data: $('#frmupdateprecio').serialize(),
        url: "../controller/precios/update.php",
        success:function(respuesta){
            respuesta = respuesta.trim();
            console.log(respuesta)
            addhistorial()
        }
        
    });
    return false;
}

function addhistorial(){
    $.ajax({
        type: "POST",
        data: $('#frmupdateprecio').serialize(),
        url: "../controller/precios/historial.php",
        success:function(respuesta){
            respuesta = respuesta.trim();
            console.log(respuesta)
            if(respuesta == 1){
                $('#frmupdateprecio').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Precio Actualizado Exitosamente',
                    showConfirmButton: false,
                    timer: 1500
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error al Actualizar!',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        }
    });
    return false;
}