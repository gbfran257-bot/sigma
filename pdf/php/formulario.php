<!DOCTYPE html>
<html>
	<head>
        <title>PDF en PHP</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="../css/estilos.css">
	</head>
 
    <body>
        <div class="wrap">
            <header id="header_main">
                <div style="margin:0 auto; width:200px"><img src="../images/logoSS.png"/></div>
                <h2>Formulario para generar PDF</h2>
            </header>
 
            <section id="formulario">
                <form  method="post" action="pdf/pdf_blanco.php" target="_blank">
                        <div id="generar">
                            <p>Generar formato a matricula</p>
                            <input type="text" name="matricula">
                        </div>
                        <div id="fecha">
                        <p>México D.F. a</p>
 
                          <select name="dia" id="dia">
                            <option selected>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                            <option>9</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                            <option>24</option>
                            <option>25</option>
                            <option>26</option>
                            <option>27</option>
                            <option>28</option>
                            <option>29</option>
                            <option>30</option>
                            <option>31</option>
                          </select>
 
                          <p class="de">de</p> 
 
                          <select name="mes" id="mes">
                            <option>Enero</option>
                            <option>Febrero</option>
                            <option>Marzo</option>
                            <option>Abril</option>
                            <option>Mayo</option>
                            <option>Junio</option>
                            <option>Julio</option>
                            <option>Agosto</option>
                            <option>Septiembre</option>
                            <option>Octubre</option>
                            <option>Noviembre</option>
                            <option>Diciembre</option>
                          </select>
 
                          <p class="de">de</p> 
 
                          <select name="anio" id="anio">
                            <option>2013</option>
                            <option>2014</option>
                            <option>2015</option>
                            <option>2016</option>
                            <option>2017</option>
                          </select>
                    </div>
 
                        <input name="buscar" type="submit" class="generarBorrar" value="Generar PDF" >
                        <input type="reset" value="Borrar" class="generarBorrar">
 
                </form>
            </section>
        </div>
    </body>
</html>
