<?php

// DataTables PHP library
include( "../../php/DataTables.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Join,
	DataTables\Editor\Validate;


/* * Example PHP implementation used for the join.html example */
Editor::inst( $db, 'medicamentos_receta', 'id_mr' )
	->field( 
		Field::inst( 'medicamentos.id_med' ),
		Field::inst( 'medicamentos.nombre_generico_med' ),
		Field::inst( 'medicamentos.descripcion_med' ),
		Field::inst( 'medicamentos.cantidad_med' ),
		Field::inst( 'medicamentos_receta.cantidad_mr' ),
		Field::inst( 'medicamentos_receta.unidad_mr' )
			->options( 'unidades', 'id_un', 'unidad_un' ),
		Field::inst( 'medicamentos_receta.periodicidad_mr' ),
		Field::inst( 'medicamentos_receta.duracion_mr' ),
		Field::inst( 'unidades.unidad_un' )
	)
	->leftJoin( 'medicamentos', 'medicamentos.id_med', '=', 'medicamentos_receta.id_med_mr' )
	->leftJoin( 'unidades',     'unidades.id_un',          '=', 'medicamentos_receta.unidad_mr' )
	->where('medicamentos_receta.no_temp_mr', $_GET['aleatorio'])
	->whereSet( true )
	->process($_POST)
	->json();
