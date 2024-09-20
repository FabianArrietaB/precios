$(document).ready(function(){
    getPagination('#productos');
});

let modal = $('#modalorden');

document.addEventListener('DOMContentLoaded', () => {
    const dateInput = document.getElementById('hasta')
    // formato ISO yyyy-mm-ddThh:mm:ss.ffffff
    dateInput.value = new Date().toISOString() // fecha actual en formato iso
    // seleccionamos lo que esta a la izquierda de la T, que es la parte de la fecha
    .split('T')[0]
})

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

function existencias(){
    desde = $("#desde").val();
    hasta = $("#hasta").val();
    bodega = $("#sede").val();
    console.log(desde, hasta, bodega)
    $.ajax({
        url : "../controller/inventarios/stock.php",
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
            document.getElementById('tblstock').innerHTML = '';
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
                    if(item.STOCK <= 5 && item.STOCK >= 1){
                        estado = 'QUEDAN MENOS DE 5 UND'
                        clasestock = 'text-warning'
                    }else if(item.STOCK >= 6 && item.STOCK <=10){
                        estado = 'QUEDAN MENOS DE 10 UND'
                        clasestock = 'text-info'
                    }else if(item.STOCK >= 11){
                        estado = 'CON EXISTENCIAS'
                        clasestock = 'text-success'
                    }else{
                        estado = 'SIN STOCK'
                        clasestock = 'text-danger'
                    }
                    if(item.PREFIJO == null && item.NUMERO == null){
                        orden = 'SIN ORDEN'
                        clase = 'text-danger'
                        fechaord = 'SIN ORDEN'
                    }else{
                        orden =  item.PREFIJO + ' ' + item.NUMERO
                        clase = 'text-primary'
                        fechaord = formatDate(item.FECHAORD)
                    }
                    tbl += `
                        <tr">
                            <td style="width: 2%" class="text-center">${++index}</td>
                            <td style="width: 10%" class="text-center">${item.REFERENCIA}</td>
                            <td style="width: 25%" class="text-center">${item.NOMBRE}</td>
                            <td style="width: 15%" class="text-center">${item.BODEGA} / ${round(item.STOCK, 2)}</td>
                            <td class="text-center" style="width: 15%" >${formatDate(item.FECCOMPRA)}</td>
                            <td class="text-center ${clasestock} " style="width: 15%" >${estado}</td>
                            <td ondblclick="detalleorden('${item.PREFIJO}', '${item.NUMERO}', '${item.FECHAORD}')" class="text-center ${clase} " style="width: 15%" >${orden}</td>
                            <td class="text-center ${clase}" style="width: 15%" >${fechaord}</td>
                        </tr>
                    `
                });
                Swal.fire({
                    icon: 'success',
                    title: 'Informacion Cargada',
                    showConfirmButton: false,
                    timer: 2000
                });
                document.getElementById('tblstock').innerHTML = tbl;
            }
        }
    });
}

function detalleorden(prefijo, numero, fecha){
    console.log(prefijo, numero)
    $.ajax({
        url : "../controller/inventarios/orden.php",
        type : 'GET',
        data : { prefijo : prefijo, numero : numero },
        dataType: 'json',
        success: function (data) {
            //console.log(data);
            let tbl = '';
            let totalund = 0;
            let totalcant = 0;
            let total = 0;
            data.forEach((item, index) => {
                if(item === ""){
                    tbl += '<tr><td colspan="7">No hay datos</td></tr>';
                }else{
                    totalund += Number(item.VALOR);
                    totalcant += Number(item.CANTIDAD);
                    total +=  Number(item.TOTAL);
                    tbl += `
                    <tr>
                        <td style="width: 5%" class="text-center">${++index}</td>
                        <td style="width: 15%" class="text-center">${item.REFERENCIA}</td>
                        <td style="width: 40%" class="text-center">${item.PRODUCTO}</td>
                        <td style="width: 10%" class="text-center">${item.UNDMED}</td>
                        <td style="width: 10%" class="text-center text-info">${round(item.CANTIDAD, 2)}</td>
                        <td style="width: 10%" class="text-center">${formatterPeso.format(Number(item.VALOR))}</td>
                        <td style="width: 10%" class="text-center">${formatterPeso.format(Number(item.TOTAL))}</td>
                    </tr>
                `
                }
            });
            var title = `
            <h5 class="modal-title" role="title" id="exampleModalLabel">Detalle Orden de Compra <strong>${prefijo} - ${numero}</strong></h5>
            `
            var bodi = `
                <div class="row item-center">
                    <div class="col-md-3">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Fecha</span>
                            </div>
                            <input disable type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="${formatDate(fecha)}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Items</span>
                            </div>
                            <input disable type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="${round(totalcant,2)}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Total</span>
                            </div>
                            <input disable type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="${formatterPeso.format(Math.round(totalund))}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Total Orden</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="${formatterPeso.format(Math.round(total))}">
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="row student text-center" style="align-items: center">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped font-small">
                                <thead>
                                    <tr>
                                        <th scope="col" >#</th>
                                        <th scope="col" >REFERENCIA</th>
                                        <th scope="col" >NOMBRE</th>
                                        <th scope="col" >UNDMED</th>
                                        <th scope="col" >CANTIDAD</th>
                                        <th scope="col" >PRECIO</th>
                                        <th scope="col" >TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody id="tblitems">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                `
        document.getElementById('title').innerHTML = title
        document.getElementById('body').innerHTML = bodi    
        document.getElementById('tblitems').innerHTML = tbl
        }
    });
    modal.modal('show')
}