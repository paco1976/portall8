<div>
<div class=" container" style="display: flex; justify-content: space-between;">
									
                                    
                            <button onclick="showHide('surveyList')" style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
										<caption>Total encuestas</caption>
										<h2 style="margin-bottom: 0px">{{ $SurveyTotal ?? 0 }}</h2>
									</button>		
									<button onclick="showHide('profesionalMorequalified')"  style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
										<caption>Perfil con buenas calificaciones</caption>
										<h2 style="margin-bottom: 0px">{{ $profesionalMorequalified->first()->name ?? 'N/A' }} {{ $profesionalMorequalified->first()->last_name ?? '' }}</h2>
                                        
									</button>
									<button onclick="showHide('profesionalWorstqualified')"  style="border: none; background-color: #dedede; margin: 1px; padding: 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
										<caption>Perfil malas calificaciones</caption>
                                        <h2 style="margin-bottom: 0px">{{ $profesionalWorstqualified->first()->name ?? 'N/A' }} {{ $profesionalWorstqualified->first()->last_name ?? '' }}</h2>
									</button>								
								</div>
								
							</div>
                    <div class="mt-4">
						@if($allSurveys)
						<div class="col-md-10 info" id="surveyList" style="text-align:center; width:99%;  display:none;">
                            <h4>Encuestas</h4>
                            
                            <div class="survey-scroll-container" style="display: flex; overflow-x: auto; gap: 10px;">
                                @foreach ($allSurveys as $survey)
                                    <div class="col-md-5" style="min-width: 300px; margin: 10px;">
                                        <div class="card text-center">
                                            <div class="card-header" style="background-color:#1c5fa8; color:white; font-size:18px">
                                                {{ $survey->name }} {{ $survey->last_name }}
                                            </div>
                                            <div class="card-header">
                                                {{ $survey->cat }}
                                            </div>
                                            <div class="card-body">
                                            <p class="card-text">{{date('d/m/Y H:i:s',strtotime($survey->updated_at))}}</p>   
                                            <h5 class="card-title">Calificación</h5>
                                                <p class="card-text">{{ $survey->satisfaction }}</p>
                                            </div>
                                            <div class="card-footer text-muted card-title">
                                            <a href="{{ route('admin_surveys', ['survey_id' => $survey->id ]) }}" target="_blank">Ver encuesta</a>
                                            <form action="{{ route('admin_delete_survey', ['survey_id' => $survey->id]) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de que desea eliminar esta encuesta?')"><i class="fa fa-trash-o"></i></button>
                                            </form>
                    
                                            </div>
                                        </div>
                                       
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif	

						@if($profesionalMorequalified)
						<div class=" col-md-10 info" id="profesionalMorequalified" style="text-align:center; display:none;width:99%" >
							<h4>Perfiles con buenas calificaciones</h4>
							<div class="survey-scroll-container" style="display: flex; overflow-x: auto; gap: 10px;">
							@foreach ($profesionalMorequalified as $best)
                                <div class="col-md-5" style="min-width: 300px; margin: 10px;">
                                    <div class="card text-center">
                                        <div class="card-header" style="background-color:#1c5fa8; color:white; font-size:18px">
                                            {{ $best->name }} {{ $best->last_name }}
                                        </div>
                                        <div class="card-header">
                                            {{ $best->cat }}
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">Promedio</h5>
                                            <p class="card-text">{{ $best->average }}</p>
                                        </div>
                                        <div class="card-footer text-muted card-title">
                                            <a href="{{ route('admin_prof_contacts', ['publicacion_hash' => $best->hash ]) }}" target="_blank">Total encuestas calificadas: {{ $best->surveysWRating }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>								
						</div>
						@endif	
						@if($profesionalWorstqualified)	
						<div class=" col-md-10 info" id="profesionalWorstqualified" style="text-align:center; display:none;width:99%" >
							<h4>Perfiles con malas calificaciones</h4>
							<div class="survey-scroll-container" style="display: flex; overflow-x: auto; gap: 10px;">
							@foreach ($profesionalWorstqualified as $worst)
                                <div class="col-md-5" style="min-width: 300px; margin: 10px;">
                                    <div class="card text-center">
                                        <div class="card-header" style="background-color:#1c5fa8; color:white; font-size:18px">
                                            {{ $worst->name }} {{ $worst->last_name }}
                                        </div>
                                        <div class="card-header">
                                            {{ $worst->cat }}
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">Promedio</h5>
                                            <p class="card-text">{{ $worst->average }}</p>
                                        </div>
                                        <div class="card-footer text-muted card-title">
                                        <a href="{{ route('admin_prof_contacts', ['publicacion_hash' => $worst->hash ]) }}" target="_blank">Total encuestas calificadas: {{ $worst->surveysWRating }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
						</div>
						@endif
                    </div>

</div>