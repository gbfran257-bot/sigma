function verOV_p(idP,fechaMin,fechaMax,concepto){
    $("#myModal").load('servicios/htmls/vinculacionOV.php', function( response, status, xhr ){ if(status=="success"){
        var dato_p = {idP:idP, fechaMin:fechaMin, fechaMax:fechaMax}
        $.post('servicios/files-serverside/prodServicios.php',dato_p).done(function(data){ 
            $('#bodyT').html(data);
            $('#titulo_modal').html('ORDENES DE VENTA DONDE SE VENDIO '+ concepto);
        });
        
        $('#myModal').modal('show');
        $('#myModal').on('shown.bs.modal', function (e) { });
        $('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });
    }});  
}

function verOV_f(idP,fechaMin,fechaMax,concepto,sucursal){
    $("#myModal").load('servicios/htmls/vinculacionOV.php', function( response, status, xhr ){ if(status=="success"){
        var dato_p = {idP:idP, fechaMin:fechaMin, fechaMax:fechaMax, sucursal: sucursal}
        $.post('farmacia/files-serverside/prodFarmacia.php',dato_p).done(function(data){ 
            $('#bodyT').html(data);
            $('#titulo_modal').html('ORDENES DE VENTA DONDE SE VENDIO '+ concepto);
        });
        
        $('#myModal').modal('show');
        $('#myModal').on('shown.bs.modal', function (e) { });
        $('#myModal').on('hidden.bs.modal', function (e) { $(".modal-content").remove(); $("#myModal").empty(); });
    }});  
}