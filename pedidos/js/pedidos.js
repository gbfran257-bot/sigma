$(document).ready((e) => {
    $('#breadc').html('<li><a href="index.php">HOME</a></li><li>FARMACIA</li><li class="active"><strong>PEDIDOS</strong></li><br><select class="form-control" id="sucursales-pedidos"></select>');
	$('#my_search').removeClass('hidden'); $.fn.datepicker.defaults.autoclose = true;

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
	
	//para los fintros individuales por campo de texto
	/* tablaPrincipal.columns().every(() => {
		var that = this;
		$('input', this.footer()).on('keyup change', () => {
			if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
		});
	}); */
	//fin filtros individuales por campo de texto

	$('#top-search').keyup((e) => {
        $('#dataTablePrincipal_filter input').val($(this).val());
        $('#dataTablePrincipal_filter input').keyup();
    }).focus();
	
    $('.filtro1Principal').addClass('hidden');

	$('.infoPrincipal').append('<div id="divRangoFechas" style="text-align:left;"> <table width="100%" border="0" cellpadding="4" cellspacing="2" style="color:black; float:left;"> <tr> <td width="10px">De &nbsp;</td> <td width="1%"> <input name="fechaDe" class="fechas form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" style="width:100px;" type="text" id="fechaDe" value="" readonly > </td> <td width="10px">&nbsp; A &nbsp;</td> <td width="1%"> <input style="width:100px;" name="fechaA" type="text" class="fechas form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" id="fechaA" value="" readonly> </td> <td id="rangosFechas">&nbsp; <input type="radio" class="rad" id="radio1" name="radio" /><label for="radio1">&nbsp; Hoy &nbsp;</label> <input type="radio" class="rad" id="radio2" name="radio" /><label for="radio2">&nbsp; Todos &nbsp;</label> </td> </tr> </table> </div>');
    
    const date = new Date();
    $('#fechaDe').val(`${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`);
    $('#fechaA').val(`${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`);

	$('#radio1').click((e) =>{
		$('#fechaDe').val(`${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`);
        $('#fechaA').val(`${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`);
        tablaPrincipal.draw();
	});
	
	$('#radio2').click((e) =>{
		$('#fechaDe').val('2000-01-01');
        $('#fechaA').val(`${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`);
        tablaPrincipal.draw();
	});
	
	$('#fechaDe').on('changeDate', (e) => tablaPrincipal.draw());
	$("#fechaA").on('changeDate', (e) => tablaPrincipal.draw());
};