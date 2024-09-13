$(document).ready(function(){
    getPagination('#existencias');
});

document.addEventListener('DOMContentLoaded', () => {
    const hasta = document.getElementById('hasta')
    // formato ISO yyyy-mm-ddThh:mm:ss.ffffff
    hasta.value = new Date().toISOString().split('T')[0]
})

let modal = $('#modaldocumentos');

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
    $("#maxRows option:eq(0)").attr("selected","selected");
    $('.pagination').hide();
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
        if (maxRows == 0) {
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

function existencias(){
    desde = $("#desde").val();
    hasta = $("#hasta").val();
    bodega = $("#sede").val();
    console.log(desde, hasta, bodega)
    $.ajax({
        url : "../controller/inventarios/existencias.php",
        type : 'GET',
        data : {desde : desde, hasta : hasta, bodega : bodega},
        dataType: 'json',
        beforeSend: function() {
            Swal.fire({
                icon: 'info',
                title: 'Cargando Informacion',
                showConfirmButton: false,
                timer: 8000
            });
            document.getElementById('tblexistencias').innerHTML = '';
        },
        success: function(data) {
            //selecciono el select
            miSelect = document.getElementById("maxRows");
            //defino selected la primera option
            miSelect.selectedIndex = 0;
            console.log(data);
            if (data.length != 0) {
                let tbl = '';
                data.forEach((item, index) => {
                    producto = (item.NOMBRE.replace("\"", ""))
                    tbl += `
                        <tr">
                            <td style="width: 5%" class="text-center">${++index}</td>
                            <td style="width: 10%" class="text-center">${item.REFERENCIA}</td>
                            <td style="width: 25%" class="text-center">${item.NOMBRE}</td>
                            <td style="width: 10%" class="text-center">${formatterPeso.format(Math.round(item.COSTO))}</td>
                            <td style="width: 5%" class="text-center">${Math.round(item.IVA * 100)} %</td>
                            <td style="width: 5%" class="text-center">${item.UNDMED}</td>
                            <td style="width: 10%" class="text-center text-info">${round(item.STOCK_INICIAL, 2)}</td>
                            <td style="width: 10%" class="text-center text-success">${round(item.STOCK_FOMPLUS, 2)}</td>
                            <td style="width: 10%" class="text-center text-warning" ondblclick="entradas('${item.REFERENCIA}', '${producto}', '${desde}', '${hasta}', '${bodega}')">${round(item.ENTRADAS, 2)}</td>
                            <td style="width: 10%" class="text-center text-danger" ondblclick="salidas('${item.REFERENCIA}', '${producto}', '${desde}', '${hasta}', '${bodega}')">${round(item.SALIDAS, 2)}</td>
                        </tr>
                    `
                });
                Swal.fire({
                    icon: 'success',
                    title: 'Informacion Cargada',
                    showConfirmButton: false,
                    timer: 2000
                });
                document.getElementById('tblexistencias').innerHTML = tbl;
            }
        }
    });
}

function entradas(referencia, producto, desde, hasta, bodega){
    var title = `
        <h5 class="modal-title" role="title" id="exampleModalLabel">Movimientos Entradas de <strong>${producto} - ${referencia}</strong></h5>
    `
    var body = `
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="row student text-center" style="align-items: center">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped font-small">
                            <thead>
                                <tr>
                                    <th scope="col" >FECHA DOC</th>
                                    <th scope="col" >MOVIMIENTO</th>
                                    <th scope="col" >PREFIJO</th>
                                    <th scope="col" >DOCUMENTO</th>
                                    <th scope="col" >UND MEDIDA</th>
                                    <th scope="col" >CANTIDAD</th>
                                    <th scope="col" >VALOR UND</th>
                                    <th scope="col" >VALOR TOTAL</th>
                                </tr>
                            </thead>
                            <tbody id="tblmovimientos">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            `
    document.getElementById(`title`).innerHTML = title
    document.getElementById(`body`).innerHTML = body
    $.ajax({
        url: "../controller/inventarios/entradas.php",
        type: "GET",
        data : {desde : desde, hasta : hasta, bodega : bodega, refere : referencia},
        dataType: 'json',
        success:function(data){
            let tbl = '';
            let totalvalor = 0;
            let totalcant = 0;
            let total = 0;
            if(data.length != 0){
                data.forEach((item) => {
                    totalvalor += Number(item.VALOR);
                    total +=  Number(item.VALOR / item.CANTIDAD);
                    totalcant += Number(item.CANTIDAD);
                    tbl += `
                    <tr class="bg-white border-b">
                        <td style="width: 15%" class="text-center">${formatDate(item.FECHA)}</td>
                        <td style="width: 20%" class="text-center">${item.MOVIMIENTO}</td>
                        <td style="width: 10%" class="text-center">${item.PREFIJO}</td>
                        <td style="width: 15%" class="text-center">${item.DOCUMENTO}</td>
                        <td style="width: 15%" class="text-center">${item.UNDMEDIDA}</td>
                        <td style="width: 10%" class="text-center">${round(item.CANTIDAD, 2)}</td>
                        <td style="width: 10%" class="text-center">${formatterPeso.format(Math.round(item.VALOR / item.CANTIDAD))}</td>
                        <td style="width: 20%" class="text-center">${formatterPeso.format(Math.round(item.VALOR))}</td>
                    </tr>
                    `
                });
                tbl += `
                <tr class="table-secondary">
                    <th colspan="5">TOTAL</th>
                    <td class="text-center ${(totalcant < 0) ? 'text-danger':''}">${round(totalcant,2)}</td>
                    <td class="text-center ${(total < 0) ? 'text-danger':''}">${ formatterPeso.format(Math.round(total))}</td>
                    <td class="text-center ${(totalvalor < 0) ? 'text-danger':''}">${ formatterPeso.format(Math.round(totalvalor))}</td>
                </tr>
            `
            }else{
                tbl = `<tr><td colspan="7" class="text-center">NO HAY REGISTROS</td></tr>`
            }
            document.getElementById('tblmovimientos').innerHTML = tbl
        }
    });
    modal.modal('show')
}

function salidas(referencia, producto, desde, hasta, bodega){
    var title = `
        <h5 class="modal-title" role="title" id="exampleModalLabel">Movimientos Salidas de <strong>${producto} - ${referencia}</strong></h5>
    `
    var body = `
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="row student text-center" style="align-items: center">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped font-small">
                            <thead>
                                <tr>
                                    <th scope="col" >FECHA DOC</th>
                                    <th scope="col" >MOVIMIENTO</th>
                                    <th scope="col" >PREFIJO</th>
                                    <th scope="col" >DOCUMENTO</th>
                                    <th scope="col" >UND MEDIDA</th>
                                    <th scope="col" >CANTIDAD</th>
                                    <th scope="col" >VALOR UND</th>
                                    <th scope="col" >VALOR TOTAL</th>
                                </tr>
                            </thead>
                            <tbody id="tblmovimientos">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            `
    document.getElementById(`title`).innerHTML = title
    document.getElementById(`body`).innerHTML = body
    $.ajax({
        url: "../controller/inventarios/salidas.php",
        type: "GET",
        data : {desde : desde, hasta : hasta, bodega : bodega, refere : referencia},
        dataType: 'json',
        success:function(data){
            let tbl = '';
            let totalvalor = 0;
            let totalcant = 0;
            let total = 0;
            if(data.length != 0){
                data.forEach((item) => {
                    totalvalor += Number(item.VALOR);
                    total +=  Number(item.VALOR / item.CANTIDAD);
                    totalcant += Number(item.CANTIDAD);
                    tbl += `
                    <tr class="bg-white border-b">
                        <td style="width: 15%" class="text-center">${formatDate(item.FECHA)}</td>
                        <td style="width: 20%" class="text-center">${item.MOVIMIENTO}</td>
                        <td style="width: 10%" class="text-center">${item.PREFIJO}</td>
                        <td style="width: 15%" class="text-center">${item.DOCUMENTO}</td>
                        <td style="width: 15%" class="text-center">${item.UNDMEDIDA}</td>
                        <td style="width: 10%" class="text-center">${round(item.CANTIDAD, 2)}</td>
                        <td style="width: 10%" class="text-center">${formatterPeso.format(Math.round(item.VALOR / item.CANTIDAD))}</td>
                        <td style="width: 20%" class="text-center">${formatterPeso.format(Math.round(item.VALOR))}</td>
                    </tr>
                    `
                });
                tbl += `
                <tr class="table-secondary">
                    <th colspan="5">TOTAL</th>
                    <td class="text-center ${(totalcant < 0) ? 'text-danger':''}">${round(totalcant,2)}</td>
                    <td class="text-center ${(total < 0) ? 'text-danger':''}">${ formatterPeso.format(Math.round(total))}</td>
                    <td class="text-center ${(totalvalor < 0) ? 'text-danger':''}">${ formatterPeso.format(Math.round(totalvalor))}</td>
                </tr>
            `
            }else{
                tbl = `<tr><td colspan="7" class="text-center">NO HAY REGISTROS</td></tr>`
            }
            document.getElementById('tblmovimientos').innerHTML = tbl
        }
    });
    modal.modal('show')
}