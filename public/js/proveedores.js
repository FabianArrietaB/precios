$(document).ready(function(){
    $('#tblproveedores').load('precios/tblproveedores.php');
});

$(document).ready(function () {
    (function($) {
        $('#filtro').keyup(function () {
            var ValorBusqueda = new RegExp($(this).val(), 'i');
            $('#tblproveedore tr').hide();
            $('#tblproveedore tr').filter(function () {
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