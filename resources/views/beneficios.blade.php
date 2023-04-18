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
								<h1>BENEFICIOS</h1>
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

										<th>COMERCIO</th>
										<th>BENEFICIO</th>


									</tr>
								</thead>
								<tbody>
									<tr class="gradeX">
								<td>FERRETERÍA MANOLO</td>
									<td><button type="button" class="btn btn-primary btn-sm">VER BENEFICIO</button></td>

								</tr>
								<tr class="gradeX">
								<td>CARPINTERÍA LOS HERMANOS</td>
									<td><button type="button" class="btn btn-primary btn-sm">VER BENEFICIO</button></td>
								</tr>
								<tr class="gradeX">
								<td>ELECTRO AVELLANEDA</td>
									<td><button type="button" class="btn btn-primary btn-sm">VER BENEFICIO</button></td>
								</tr>
								<tr class="gradeX">
								<td>CASA DE SANITARIOS HD</td>
									<td><button type="button" class="btn btn-primary btn-sm">VER BENEFICIO</button></td>
								</tr>

								<tr class="gradeX">
								<td>PELUQUERÍA RULO</td>
								    <td><button type="button" class="btn btn-primary btn-sm">VER BENEFICIO</button></td>
								</tr>
								<tr class="gradeX">



								</tbody>
							</table>
						</div>

				</div>
				</div>

			</div>

@endsection
