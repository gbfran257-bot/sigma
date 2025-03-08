$(document).ready((e) => {
    $('#breadc').html('<li><a href="index.php">HOME</a></li><li>FARMACIA</li><li class="active"><strong>PEDIDOS</strong></li><br><select style="width: 500px !important;" class="form-control" id="sucursales-pedidos"><option selected>-SELECCIONAR-</option></select><button id="generar_pedidos" class="btn btn-warning btn-sm" style="margin-left: 01rem;">Generar pedido</button>');
	$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true;
   
   $('#generar_pedidos').click(function(e) { 
    var sucursaltexto = $("#sucursales-pedidos option:selected").text();
        window.open("pedidos/html/reporte_stock.php?sucursal="+$("#sucursales-pedidos").val()+"&nombre="+sucursaltexto+"&id_usuario="+$('#id_user').val(), "_blank");
    });

    initSelectSucursales();

    initDataTablePrincipal();
});

const initSelectSucursales = () => {
    $("#sucursales-pedidos").select2({
        ajax: {
            url: "pedidos/files-serverside/sucursales2.php",
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
        "fnFooterCallback": (nRow, aaData, iStart, iEnd, aiDisplay) => { 
            var existencias = 0, maximos = 0, minimos = 0, surtir = 0;
            for(var i=iStart ; i<iEnd ; i++){ 
                if (aaData[aiDisplay[i]] && aaData[aiDisplay[i]].length > 4) {
                   existencias += aaData[ aiDisplay[i] ][3]*1;
                   maximos += aaData[ aiDisplay[i] ][4]*1;
                   minimos += aaData[ aiDisplay[i] ][5]*1;
                   surtir += aaData[ aiDisplay[i] ][6]*1;
                }
                var nCells = nRow.getElementsByTagName('th');
                nCells[3].innerHTML = redondear(parseFloat(existencias * 100)/100,2);
                nCells[4].innerHTML = redondear(parseFloat(maximos * 100)/100,2);
                nCells[5].innerHTML = redondear(parseFloat(minimos * 100)/100,2);
                nCells[6].innerHTML = redondear(parseFloat(surtir * 100)/100,2);
         }
        },
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