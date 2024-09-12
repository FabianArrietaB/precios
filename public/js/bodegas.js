$(document).ready(function(){
    getPagination('#existencias');
});

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
            getPagination('#existencias');
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
                title: 'Cargando Datos',
                showConfirmButton: false,
                timer: 8000
            });
            document.getElementById('tblexistencias').innerHTML = '';
        },
        success: function(res) {
            console.log(res);

            if (res.data.length != 0) {
                
                let tbl = '';

                res.detalle_cuenta.forEach((item, index) => {
                    tbl += `
                        <tr">
                            <th>${++index}</th>
                            <td>${item.cuenta_detalle}</td>
                            <td>${item.detalle}</td>
                            <td class="que se ruede a la derecha">${format_number(item.cantidad)}</td>
                            <td class="que se ruede a la derecha">${format_number(item.total)}</td>
                        </tr>
                    `
                });
                document.getElementById('tblexistencias').innerHTML = tbl;
            }
        }
    });
}

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