<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head id="Head1">
    <title>	My Calendar </title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link href="css/dailog.css" rel="stylesheet" type="text/css" />
    <link href="css/calendar.css" rel="stylesheet" type="text/css" /> 
    <link href="css/dp.css" rel="stylesheet" type="text/css" />   
    <link href="css/alert.css" rel="stylesheet" type="text/css" /> 
    <link href="css/main.css" rel="stylesheet" type="text/css" /> 
    

    <script src="src/jquery.js" type="text/javascript"></script>
    
    <script src="src/Plugins/Common.js" type="text/javascript"></script>    
    <script src="src/Plugins/datepicker_lang_US.js" type="text/javascript"></script>     
    <script src="src/Plugins/jquery.datepicker.js" type="text/javascript"></script>

    <script src="src/Plugins/jquery.alert.js" type="text/javascript"></script>    
    <script src="src/Plugins/jquery.ifrmdailog.js" defer="defer" type="text/javascript"></script>
    <script src="src/Plugins/wdCalendar_lang_US.js" type="text/javascript"></script>    
    <script src="src/Plugins/jquery.calendar.js" type="text/javascript"></script>   
    
    <script type="text/javascript">
        $(document).ready(function() {
			   
           var view="week";          
           
            var DATA_FEED_URL = "php/datafeed.php";
			
			//Mi codigo
			$("#personalA").load('genera/personalC.php', function( response, status, xhr ){ if ( status == "success" ) { } });
			$("#aparatosA").load('genera/aparatoC.php', function( response, status, xhr ){ if ( status == "success" ) { } });
			$('#paraA').change(function(e) {
                if($(this).val()==6){$('#dPersonalA').show();$('#dAparatoA').hide();}
				else if($(this).val()==1){$('#dAparatoA').show();$('#dPersonalA').hide();}
				else{$('#dAparatoA').hide();$('#dPersonalA').hide();}
				
				var op = {
					view: view, theme:3, showday: new Date(), EditCmdhandler:Edit, DeleteCmdhandler:Delete,
					ViewCmdhandler:View, onWeekOrMonthToDay:wtd,
					onBeforeRequestData: cal_beforerequest, onAfterRequestData: cal_afterrequest, onRequestDataError: cal_onerror, 
					autoload:true,
					url: DATA_FEED_URL + "?method=list",  
					quickAddUrl: DATA_FEED_URL + "?method=add", 
					quickUpdateUrl: DATA_FEED_URL + "?method=update",
					quickDeleteUrl: DATA_FEED_URL + "?method=remove",
					extParam: [{name:"paraA1", value:$('#paraA').val()}, {name:"personaA1", value:$('#personalA').val()}, {name:"aparatoA1", value:$('#aparatosA').val()}]
				};
				
				var $dv = $("#calhead");
				var _MH = document.documentElement.clientHeight;
				var dvH = $dv.height() + 2;
				op.height = _MH - dvH;
				op.eventItems =[];
	
				var p = $("#gridcontainer").bcalendar(op).BcalGetOp();
				if (p && p.datestrshow) {
					$("#txtdatetimeshow").text(p.datestrshow);
				}
				$("#caltoolbar").noSelect();
			
				$('#miActualiza').click();
            });
			$("#personalA").change(function(e) {
				$("#aparatosA").val('');
				var op = {
					view: view, theme:3, showday: new Date(), EditCmdhandler:Edit, DeleteCmdhandler:Delete,
					ViewCmdhandler:View, onWeekOrMonthToDay:wtd,
					onBeforeRequestData: cal_beforerequest, onAfterRequestData: cal_afterrequest, onRequestDataError: cal_onerror, 
					autoload:true,
					url: DATA_FEED_URL + "?method=list",  
					quickAddUrl: DATA_FEED_URL + "?method=add", 
					quickUpdateUrl: DATA_FEED_URL + "?method=update",
					quickDeleteUrl: DATA_FEED_URL + "?method=remove",
					extParam: [{name:"paraA1", value:$('#paraA').val()}, {name:"personaA1", value:$('#personalA').val()}, {name:"aparatoA1", value:$('#aparatosA').val()}]
				};
				
				var $dv = $("#calhead");
				var _MH = document.documentElement.clientHeight;
				var dvH = $dv.height() + 2;
				op.height = _MH - dvH;
				op.eventItems =[];
	
				var p = $("#gridcontainer").bcalendar(op).BcalGetOp();
				if (p && p.datestrshow) {
					$("#txtdatetimeshow").text(p.datestrshow);
				}
				$("#caltoolbar").noSelect();
                $('#miActualiza').click();
            });
			$("#aparatosA").change(function(e) {
				$("#personalA").val('');
				var op = {
					view: view, theme:3, showday: new Date(), EditCmdhandler:Edit, DeleteCmdhandler:Delete,
					ViewCmdhandler:View, onWeekOrMonthToDay:wtd,
					onBeforeRequestData: cal_beforerequest, onAfterRequestData: cal_afterrequest, onRequestDataError: cal_onerror, 
					autoload:true,
					url: DATA_FEED_URL + "?method=list",  
					quickAddUrl: DATA_FEED_URL + "?method=add", 
					quickUpdateUrl: DATA_FEED_URL + "?method=update",
					quickDeleteUrl: DATA_FEED_URL + "?method=remove",
					extParam: [{name:"paraA1", value:$('#paraA').val()}, {name:"personaA1", value:$('#personalA').val()}, {name:"aparatoA1", value:$('#aparatosA').val()}]
				};
				
				var $dv = $("#calhead");
				var _MH = document.documentElement.clientHeight;
				var dvH = $dv.height() + 2;
				op.height = _MH - dvH;
				op.eventItems =[];
	
				var p = $("#gridcontainer").bcalendar(op).BcalGetOp();
				if (p && p.datestrshow) {
					$("#txtdatetimeshow").text(p.datestrshow);
				}
				$("#caltoolbar").noSelect();
                $('#miActualiza').click();
            });
			//Fin mi codigo
			
            var op = {
                view: view, theme:3, showday: new Date(), EditCmdhandler:Edit, DeleteCmdhandler:Delete,
                ViewCmdhandler:View, onWeekOrMonthToDay:wtd,
                onBeforeRequestData: cal_beforerequest, onAfterRequestData: cal_afterrequest, onRequestDataError: cal_onerror, 
                autoload:true,
                url: DATA_FEED_URL + "?method=list",  
                quickAddUrl: DATA_FEED_URL + "?method=add", 
                quickUpdateUrl: DATA_FEED_URL + "?method=update",
                quickDeleteUrl: DATA_FEED_URL + "?method=remove",
				extParam: [{name:"paraA1", value:$('#paraA').val()}, {name:"personaA1", value:$('#personalA').val()}, {name:"aparatoA1", value:$('#aparatosA').val()}]
            };
			
            var $dv = $("#calhead");
            var _MH = document.documentElement.clientHeight;
            var dvH = $dv.height() + 2;
            op.height = _MH - dvH;
            op.eventItems =[];

            var p = $("#gridcontainer").bcalendar(op).BcalGetOp();
            if (p && p.datestrshow) {
                $("#txtdatetimeshow").text(p.datestrshow);
            }
            $("#caltoolbar").noSelect();
            
            $("#hdtxtshow").datepicker({ picker: "#txtdatetimeshow", showtarget: $("#txtdatetimeshow"),
            onReturn:function(r){                          
                            var p = $("#gridcontainer").gotoDate(r).BcalGetOp();
                            if (p && p.datestrshow) {
                                $("#txtdatetimeshow").text(p.datestrshow);
                            }
                     } 
            });
            function cal_beforerequest(type)
            {	
                var t="Cargando datos...";
                switch(type)
                {
                    case 1:
                        t="Cargando datos...";
                        break;
                    case 2:                      
                    case 3:  
                    case 4:    
                        t="The request is being processed ...";                                   
                        break;
                }
                $("#errorpannel").hide();
                $("#loadingpannel").html(t).show();    
            }
            function cal_afterrequest(type)
            {
                switch(type)
                {
                    case 1:
                        $("#loadingpannel").hide();
                        break;
                    case 2:
                    case 3:
                    case 4:
                        $("#loadingpannel").html("Success!");
                        window.setTimeout(function(){ $("#loadingpannel").hide();},2000);
                    break;
                }              
               
            }
            function cal_onerror(type,data)
            {
                $("#errorpannel").show();
            }
            function Edit(data)
            {
               var eurl="edit.php?id={0}&start={2}&end={3}&isallday={4}&title={1}";   
                if(data)
                {
                    var url = StrFormat(eurl,data);
                    OpenModelWindow(url,{ width: 600, height: 400, caption:"Administrar la Agenda",onclose:function(){
                       $("#gridcontainer").reload();
                    }});
                }
            }    
            function View(data)
            {
                var str = "";
                $.each(data, function(i, item){
                    str += "[" + i + "]: " + item + "\n";
                });
                alert(str);               
            }    
            function Delete(data,callback)
            {           
                
                $.alerts.okButton="Ok";  
                $.alerts.cancelButton="Cancel";  
                hiConfirm("Are You Sure to Delete this Event", 'Confirm',function(r){ r && callback(0);});           
            }
            function wtd(p)
            {
               if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $("#showdaybtn").addClass("fcurrent");
            }
            //to show day view
            $("#showdaybtn").click(function(e) {
                //document.location.href="#day";
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $(this).addClass("fcurrent");
                var p = $("#gridcontainer").swtichView("day").BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
            });
            //to show week view
            $("#showweekbtn").click(function(e) {
                //document.location.href="#week";
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $(this).addClass("fcurrent");
                var p = $("#gridcontainer").swtichView("week").BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }

            });
            //to show month view
            $("#showmonthbtn").click(function(e) {
                //document.location.href="#month";
                $("#caltoolbar div.fcurrent").each(function() {
                    $(this).removeClass("fcurrent");
                })
                $(this).addClass("fcurrent");
                var p = $("#gridcontainer").swtichView("month").BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
            });
            
            $("#showreflashbtn").click(function(e){
                $("#gridcontainer").reload();
            });
            
            //Add a new event
            $("#faddbtn").click(function(e) {
                var url ="edit.php";
                OpenModelWindow(url,{ width: 500, height: 400, caption: "Crear una Nueva Cita"});
            });
            //go to today
            $("#showtodaybtn").click(function(e) {
                var p = $("#gridcontainer").gotoDate().BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }

            });
            //previous date range
            $("#sfprevbtn").click(function(e) {
                var p = $("#gridcontainer").previousRange().BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }

            });
            //next date range
            $("#sfnextbtn").click(function(e) {
                var p = $("#gridcontainer").nextRange().BcalGetOp();
                if (p && p.datestrshow) {
                    $("#txtdatetimeshow").text(p.datestrshow);
                }
            });
            
        });
    </script>    
</head>
<body>
    <div>

      <div id="calhead" style="padding-left:1px;padding-right:1px;">          
            <div class="cHead"><div class="ftitle">AGENDA</div>
            <div id="loadingpannel" class="ptogtitle loadicon" style="display: none;">Cargando datos...</div>
             <div id="errorpannel" class="ptogtitle loaderror" style="display: none;">Sorry, could not load your data, please try again later</div>
            </div>          
            
            <div id="caltoolbar" class="ctoolbar">
              <div id="faddbtn" class="fbutton">
                <div><span title='Click para Crear un Nuevo Evento' class="addcal">
                Nuevo Evento                
                </span></div>
            </div>
            <div class="btnseparator"></div>
             <div id="showtodaybtn" class="fbutton">
                <div><span title='Click para regresar a hoy' class="showtoday">
                Hoy</span></div>
            </div>
              <div class="btnseparator"></div>

            <div id="showdaybtn" class="fbutton">
                <div><span title='Vista Por Día' class="showdayview">Vista Por Día</span></div>
            </div>
              <div  id="showweekbtn" class="fbutton fcurrent">
                <div><span title='Vista Por Semana' class="showweekview">Vista Por Semana</span></div>
            </div>
              <div  id="showmonthbtn" class="fbutton">
                <div><span title='Vista Por Mes' class="showmonthview">Vista Por Mes</span></div>

            </div>
            <div class="btnseparator"></div>
              <div  id="showreflashbtn" class="fbutton">
                <div><span title='Actualizar' id="miActualiza" class="showdayflash">Actualizar</span></div>
                </div>
             <div class="btnseparator"></div>
            <div id="sfprevbtn" title="Anterior"  class="fbutton">
              <span class="fprev"></span>

            </div>
            <div id="sfnextbtn" title="Siguiente" class="fbutton">
                <span class="fnext"></span>
            </div>
            <div class="fshowdatep fbutton">
                    <div>
                        <input type="hidden" name="txtshow" id="hdtxtshow" />
                        <span id="txtdatetimeshow">Cargar Fecha</span>
                    </div>
            </div>
            
            <div class="fshowdatep fbutton">
            	<div>
            		<select name="paraA" id="paraA" class="">
                      <option value="x">-AGENDAS-</option>
                      <option value="6">PERSONAL</option>
                      <option value="1">APARATO</option>
                      <option value="0">OTRO</option>
                    </select>
            	</div>
            </div>
            <div id="dPersonalA" class="fshowdatep fbutton" style="display:none;">
            	<div>
            		<select name="personalA" id="personalA" class=""> </select>
            	</div>
            </div>
            <div id="dAparatoA" class="fshowdatep fbutton" style="display:none;">
            	<div>
            		<select name="aparatosA" id="aparatosA" class=""> </select>
            	</div>
            </div>
            
            <div class="clear"></div>
            
            </div>
      </div>
      <div style="padding:1px;">

        <div class="t1 chromeColor">
            &nbsp;</div>
        <div class="t2 chromeColor">
            &nbsp;</div>
        <div id="dvCalMain" class="calmain printborder">
            <div id="gridcontainer" style="overflow-y: visible;">
            </div>
        </div>
        <div class="t2 chromeColor">

            &nbsp;</div>
        <div class="t1 chromeColor">
            &nbsp;
        </div>   
        </div>
     
  </div>
</body>
</html>
