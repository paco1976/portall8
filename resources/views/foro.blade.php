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
								<h1>Foros Generales</h1>
							</div>
						</div>
					</div>
				</section>


				<div class="container">

					<div class="row">
						<div class="col-md-12">
							<a href="#">
								<button id="addToTable" class="btn btn-primary">AGREGAR FORO A UNA CATEGORÍA </button>
							</a>
						</div>
						<div class="col-md-12">
							<table class="table table-bordered table-striped mb-none" id="datatable-editable">
								<thead>

									<tr>

										<th>Fecha ultima actualizacion</th>
										<th>Categoria</th>
										<th>Mensaje</th>
									</tr>
								</thead>
								<tbody>
									<tr class="gradeX">

										<td>15/06/2019</td>
										<td>Refrigeración</td>


										<td class="actions">

											<a href="foro_electricidad.html" class="on-default edit-row">Ver Foro</i></a>

										</td>
									</tr>
									<tr class="gradeX">

										<td>15/06/2019</td>
										<td>Electricidad</td>


										<td class="actions">

											<a href="foro_electricidad.html" class="on-default edit-row">Ver Foro</i></a>

										</td>
									</tr>
									<tr class="gradeX">

										<td>15/06/2019</td>
										<td>Peluquería</td>


										<td class="actions">

											<a href="foro_electricidad.html" class="on-default edit-row">Ver Foro</i></a>

										</td>
									</tr>
									<tr class="gradeX">

										<td>15/06/2019</td>
										<td>Carpintería</td>


										<td class="actions">

											<a href="foro_electricidad.html" class="on-default edit-row">Ver Foro</i></a>

										</td>
									</tr>
									<tr class="gradeX">

										<td>15/06/2019</td>
										<td>Gasista</td>


										<td class="actions">

											<a href="foro_electricidad.html" class="on-default edit-row">Ver Foro</i></a>

										</td>
									</tr>
									<tr class="gradeX">

										<td>15/06/2019</td>
										<td>Herrerría</td>


										<td class="actions">

											<a href="foro_electricidad.html" class="on-default edit-row">Ver Foro</i></a>

										</td>
									</tr>
									<tr class="gradeX">

										<td>15/06/2019</td>
										<td>Maquillador/a</td>


										<td class="actions">

											<a href="foro_electricidad.html" class="on-default edit-row">Ver Foro</i></a>

										</td>
									</tr>
									<tr class="gradeX">

										<td>15/06/2019</td>
										<td>Estilista Corporal</td>


										<td class="actions">

											<a href="foro_electricidad.html" class="on-default edit-row">Ver Foro</i></a>

										</td>
									</tr>
								</tbody>
							</table>
						</div>








					</div>






				</div>

			</div>

@endsection
