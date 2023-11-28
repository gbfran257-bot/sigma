$(document).ready((e) => {
    $('#breadc').html('<li><a href="index.php">HOME</a></li><li>FARMACIA</li><li class="active"><strong>PEDIDOS</strong></li><br><select style="width: 500px !important;" class="form-control" id="sucursales-pedidos"><option selected>-SELECCIONAR-</option></select><button id="generar_pedidos" class="btn btn-warning btn-sm" style="margin-left: 01rem;">Generar pedido</button>');
	$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true;
    $("#generar_pedidos").click(() => imprimirReportePedidos());

    initSelectSucursales();

    initDataTablePrincipal();
});

const initSelectSucursales = () => {
    $("#sucursales-pedidos").select2({
        ajax: {
            url: "pedidos/files-serverside/sucursales.php",
            dataType: "json",
        },
    });

    $("#sucursales-pedidos").change(() => $("#dataTablePrincipal").DataTable().ajax.reload().draw());
};

const initDataTablePrincipal = () => {
    const tamañoPagina = $('#referencia').height() - $('#navcit').height() - $('#my_footer').height() - 153 - $('#breadc').height();
    const tablaPrincipal = $("#dataTablePrincipal").DataTable({
        serverSide: true,
        "sScrollY": tamañoPagina,
        ordering: false,
        searching: true,
        scrollCollapse: false,
        "scrollX": true,
        "fnFooterCallback": (nRow, aaData, iStart, iEnd, aiDisplay) => {  },
        scroller: false,
        responsive: true,
        "aoColumns": [
            {
                "bVisible": true,
            }, {
                "bVisible": true,
            }, {
                "bVisible": true,
            }, {
                "bVisible": true,
            }, {
                "bVisible": true,
            }, {
                "bVisible": true,
            }, {
                "bVisible": true,
            },
        ],
        "sDom": '<"filtro1Principal"f>r<"data_tPrincipal"t><"infoPrincipal"S><"proc"p>', 
		deferRender: true,
        select: false,
        "processing": false,
		"sAjaxSource": "pedidos/files-serverside/datatable-serverside/pedidos.php",
        "fnServerParams": (aoData, fnCallback) => {
            const date = new Date();
            const fechaMin = $('#fechaDe').val() === undefined ? `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}` : $('#fechaDe').val();
            const fechaMax = $('#fechaA').val() === undefined ? `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}` : $('#fechaA').val();
			aoData.push({
                "name": "accesoU",
                "value": $('#acc_user').val()
            });
			aoData.push({
                "name": "min",
                "value": fechaMin  + ' 00:00:00'
            });
			aoData.push({
                "name": "max",
                "value": fechaMax + ' 23:59:59'
            });
			aoData.push({
                "name": "idU",
                "value": $('#id_user').val()
            });
            aoData.push({
                "name": "id_sucursal",
                "value": $("#sucursales-pedidos").val()
            });
		},
        "oLanguage": {
			"sLengthMenu": "MONSTRANDO _MENU_ records per page", "sZeroRecords": "SIN COINCIDENCIAS - LO SENTIMOS", 
			"sInfo": "SERVICIOS FILTRADOS: _END_",
			"sInfoEmpty": "NINGÚN SERVICIO FILTRADO.", "sInfoFiltered": " TOTAL DE PEDIDOS: _MAX_", "sSearch": "",
			"oPaginate": { "sNext": "<span class='paginacionPrincipal'>Siguiente</span>", "sPrevious": "<span class='paginacionPrincipal'>Anterior</span>&nbsp;&nbsp;&nbsp;&nbsp;" }
		},
        "iDisplayLength": 500,
        paging: true,
    });

    $('#clickme').click((e) => tablaPrincipal.draw());

    setTimeout(() => $('#clickme').click(), 500);
	
    $(".filtro1Principal").addClass("hidden");

	//para los fintros individuales por campo de texto
	tablaPrincipal.columns().every(function() {
        var that = this;
        $('input', this.footer()).on('keyup change', function() {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
    });
	//fin filtros individuales por campo de texto

	$('#top-search').keyup((e) => {
        $('#dataTablePrincipal_filter input').val($(this).val());
        $('#dataTablePrincipal_filter input').keyup();
    }).focus();
	
    $('.filtro1Principal').addClass('hidden');
};