@extends('layouts.panel')

@section('main')

			<div role="main" class="main">


				<section class="page-top">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<li><a href="#">Inicio</a></li>
									<li class="active">Panel de Control</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h1>TARIFARIO</h1>
							</div>

						</div>
					</div>
				</section>

					<div class="container">

						<div class="row">


						<div class="col-md-12">
							<a href="#">
								<button id="addToTable" class="btn btn-primary">AGREGAR BENEFICIO </button>
							</a>
						</div>



						<div class="col-md-12">
							<table class="table table-bordered table-striped mb-none" id="datatable-editable">
								<thead>

									<tr>
										<th>CATEGORIA</th>
										<th>ARCHIVO</th>
									</tr>
								</thead>
								<tbody>
									<tr class="gradeX">
										<td>MARROQUINERÍA</td>
										<td><button type="button" class="btn btn-primary btn-sm">VER ARCHIVO</button></td>
									</tr>
									<tr class="gradeX">
								<td>CARPINTERÍA</td>
										<td><button type="button" class="btn btn-primary btn-sm">VER ARCHIVO</button></td>
									</tr>
									<tr class="gradeX">
								<td>GAS</td>
										<td><button type="button" class="btn btn-primary btn-sm">VER ARCHIVO</button></td>
									</tr>
									<tr class="gradeX">
								<td>PLOMERÍA</td>
										<td><button type="button" class="btn btn-primary btn-sm">VER ARCHIVO</button></td>
									</tr>
									<tr class="gradeX">
								<td>ELECTRICIDAD</td>
										<td><button type="button" class="btn btn-primary btn-sm">VER ARCHIVO</button></td>
									</tr>
									<tr class="gradeX">
								<td>AIRE ACONDICIONADO</td>
										<td><button type="button" class="btn btn-primary btn-sm">VER ARCHIVO</button></td>
									</tr>
<tr class="gradeX">
								<td>REPARACIÓN DE PC</td>
										<td><button type="button" class="btn btn-primary btn-sm">VER ARCHIVO</button></td>
									</tr>

<tr class="gradeX">
								<td>PELUQUERÍA Y MANICURÍA</td>
										<td><button type="button" class="btn btn-primary btn-sm">VER ARCHIVO</button></td>
									</tr>
<tr class="gradeX">
								<td>ESTÉTICA FACIAL</td>
										<td><button type="button" class="btn btn-primary btn-sm">VER ARCHIVO</button></td>
									</tr>
<tr class="gradeX">
								<td>ESTÉTICA CORPORAL</td>
										<td><button type="button" class="btn btn-primary btn-sm">VER ARCHIVO</button></td>
									</tr>
<tr class="gradeX">
								<td>DISEÑO, COSTURA, ARREGLOS Y OTROS</td>
										<td><button type="button" class="btn btn-primary btn-sm">VER ARCHIVO</button></td>
									</tr>


								</tbody>
							</table>
						</div>








					</div>






				</div>

			</div>

@endsection
