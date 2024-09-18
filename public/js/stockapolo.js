$(document).ready(function(){
    getPagination('#productos');
    tblapolo();
    tblapolo2();
});

let modal = $('#modalupdate');


const formatterPeso = new Intl.NumberFormat('es-CO', {
    style: 'currency',
    currency: 'COP',
    minimumFractionDigits: 0
})

function round(value, decimals) {
    return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}

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

$(document).ready(function () {
    (function($) {
        $('#FiltrarContenido').keyup(function () {
            var ValorBusqueda = new RegExp($(this).val(), 'i');
            $('.BusquedaRapida tr').hide();
            $('.BusquedaRapida tr').filter(function () {
                return ValorBusqueda.test($(this).text());
            }).show()
            getPagination('#productos');
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


function getPagination(table) {
    var lastPage = 1;
    $('#maxRows').on('change', function(evt) {
    //$('.paginationprev').html('');						// reset pagination
    lastPage = 1;
        $('.pagination')
        .find('li')
        .slice(1, -1)
        .remove();
        var trnum = 0; // reset tr counter
        var maxRows = parseInt($(this).val()); // get Max Rows from select option
        if (maxRows >= 5000) {
            $('.pagination').hide();
        } else {
            $('.pagination').show();
        }
        console.log(maxRows);
        var totalRows = $(table + ' tbody tr').length; // numbers of rows
        $(table + ' tr:gt(0)').each(function() {
        // each TR in  table and not the header
        trnum++; // Start Counter
            if (trnum > maxRows) {
            // if tr number gt maxRows
                $(this).hide(); // fade it out
            }
            if (trnum <= maxRows) {
                $(this).show();
            } // else fade in Important in case if it ..
        }); //  was fade out to fade it in
        if (totalRows > maxRows) {
        // if tr total rows gt max rows option
            var pagenum = Math.ceil(totalRows / maxRows); // ceil total(rows/maxrows) to get ..
            //	numbers of pages
            for (var i = 1; i <= pagenum; ) {
            // for each page append pagination li
                $('.pagination #prev')
                .before(
                    '<li class="page-item" data-page="' + i + '">\
                        <a class="page-link">' + i++ + '<span class="sr-only">(current)</span></a>\
                    </li>'
                ).show();
            } // end for i
        } // end if row count > max rows
        $('.pagination [data-page="1"]').addClass('active'); // add active class to the first li
        $('.pagination li').on('click', function(evt) {
            // on click each page
            evt.stopImmediatePropagation();
            evt.preventDefault();
            var pageNum = $(this).attr('data-page'); // get it's number
            var maxRows = parseInt($('#maxRows').val()); // get Max Rows from select option
            if (pageNum == 'prev') {
                if (lastPage == 1) {
                    return;
                }
            pageNum = --lastPage;
            }
            if (pageNum == 'next') {
                if (lastPage == $('.pagination li').length - 2) {
                    return;
                }
            pageNum = ++lastPage;
            }
            lastPage = pageNum;
            var trIndex = 0; // reset tr counter
            $('.pagination li').removeClass('active'); // remove active class from all li
            $('.pagination [data-page="' + lastPage + '"]').addClass('active'); // add active class to the clicked
            // $(this).addClass('active');					// add active class to the clicked
            limitPagging();
            $(table + ' tr:gt(0)').each(function() {
            // each tr in table not the header
            trIndex++; // tr index counter
            // if tr index gt maxRows*pageNum or lt maxRows*pageNum-maxRows fade if out
                if (
                    trIndex > maxRows * pageNum ||
                    trIndex <= maxRows * pageNum - maxRows
                ){
                    $(this).hide();
                } else {
                    $(this).show();
                } //else fade in
            }); // end of for each tr in table
        }); // end of on click pagination list
        limitPagging();
    })
    .val(5)
    .change();
    // end of on select change
    // END OF PAGINATION
}

function limitPagging(){
// alert($('.pagination li').length)
    if($('.pagination li').length > 7 ){
        if( $('.pagination li.active').attr('data-page') <= 3 ){
            $('.pagination li:gt(5)').hide();
            $('.pagination li:lt(5)').show();
            $('.pagination [data-page="next"]').show();
        }if ($('.pagination li.active').attr('data-page') > 3){
            $('.pagination li:gt(0)').hide();
            $('.pagination [data-page="next"]').show();
            for( let i = ( parseInt($('.pagination li.active').attr('data-page'))  -2 )  ; i <= ( parseInt($('.pagination li.active').attr('data-page'))  + 2 ) ; i++ ){
                $('.pagination [data-page="'+i+'"]').show();
            }
        }
    }
}

$(function() {
    // Just to append id number for each row
    $('table tr:eq(0)').prepend('<th> ID </th>');
    var id = 0;
    $('table tr:gt(0)').each(function() {
        id++;
        $(this).prepend('<td>' + id + '</td>');
    });
});

function importarproductos() {
    var excel = $("#productos").val();
    if(excel === ""){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'No se ha seleccionado un archivo',
            showConfirmButton: false,
            timer: 2000
        });
    }
    $.ajax({
        url : "../controller/inventarios/importar.php",
        method:     "POST",
        data: new FormData($('#form_file')[0]),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            Swal.fire({
                icon: 'info',
                title: 'Cargando Datos',
                showConfirmButton: false,
                timer: 8000
            });
        },
        success: function (resp){
            Swal.fire({
                icon: 'success',
                title: 'Datos Cargados',
                text: 'Se cargaron ' + resp.productos + " Productos",
                showConfirmButton: false,
                timer: 5000
            });
        }
    });
    return false;
}

function tblapolo(){
    $.ajax({
        url : "../controller/inventarios/apolo.php",
        type : 'GET',
        dataType: 'json',
        success: function (data) {
            //console.log(data);
            let tbl = '';
            data.forEach((item, index) => {
                if(item.NOMBRE == item.NOMFOMPLUS){
                    clase = 'text-success'
                }else{
                    clase = 'text-danger'
                }
                if(item === ""){
                    tbl += '<tr><td colspan="4">No hay datos</td></tr>';
                }else{
                    tbl += `
                    <tr>
                            <td style="width: 5%" class="text-center">${++index}</td>
                            <td style="width: 15%" class="text-center">${item.FOMPLUS}</td>
                            <td style="width: 35%" class="text-center ${clase} ">${item.NOMFOMPLUS}</td>
                            <td style="width: 10%" class="text-center">${item.CODIGO}</td>
                            <td style="width: 35%" class="text-center ${clase} ">${item.NOMBRE}</td>
                            <td style="width: 10%" class="text-center text-info">${round(item.STOCK, 2)}</td>
                    </tr>
                `
                }
            });
            document.getElementById('tblstockapolo').innerHTML = tbl
        }
    });
}

function tblapolo2(){
    $.ajax({
        url : "../controller/inventarios/apolo2.php",
        type : 'GET',
        dataType: 'json',
        success: function (data) {
            //console.log(data);
            let tbl = '';
            data.forEach((item, index) => {
                if(item.FOMPLUS == null){
                    referencia = 'No Asignada';
                }else{
                    referencia = item.FOMPLUS;
                }
                if(item === ""){
                    tbl += '<tr><td colspan="4">No hay datos</td></tr>';
                }else{
                    producto = (item.NOMBRE.replace("\"", ""))
                    tbl += `
                    <tr ondblclick="detalle('${item.CODIGO}', '${producto}')">
                            <td style="width: 5%" class="text-center">${++index}</td>
                            <td style="width: 15%" class="text-center">${item.CODIGO}</td>
                            <td style="width: 35%" class="text-center">${item.NOMBRE}</td>
                            <td style="width: 10%" class="text-center text-info">${round(item.STOCK, 2)}</td>
                            <td style="width: 35%" class="text-center">${referencia}</td>
                    </tr>
                `
                }
            });
            document.getElementById('tblsinreferencia').innerHTML = tbl
        }
    });
}

function detalle(codigo, producto){
    var title = `
        <h5 class="modal-title" role="title" id="exampleModalLabel">Agregar Referencia a ${producto}</h5>
    `
    var bodi = `
            <div class="row item-center">
                <div class="col-12">
                    <div class="input-group input-group-sm  mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default"><strong>CODIGO APOLO</strong></span>
                        <input id="codigo" name="codigo" readonly value="${codigo}" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-sm  mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default"><strong>PRODUCTO</strong></span>
                        <input id="nombre" name="nombre" value="${producto}" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-sm  mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default"><strong>REFERENCIA FOMPLUS</strong></span>
                        <input id="referencia" name="referencia" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
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

function update(){
    $.ajax({
        type: "POST",
        data: $('#frmupdate').serialize(),
        url: "../controller/inventarios/addreferencia.php",
        success:function(respuesta){
            respuesta = respuesta.trim();
            console.log(respuesta)
            if(respuesta > 0){
                addapolo();
            }else{
                swal.fire({
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

function addapolo(){
    $.ajax({
        type: "POST",
        data: $('#frmupdate').serialize(),
        url: "../controller/inventarios/addapolo.php",
        success:function(respuesta){
            respuesta = respuesta.trim();
            console.log(respuesta)
            if(respuesta > 0){
                swal.fire({
                    icon: 'success',
                    title: 'Referencia Aagregada Exitosamente',
                    showConfirmButton: false,
                    timer: 1500
                });
                tblapolo2();
            }else{
                swal.fire({
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