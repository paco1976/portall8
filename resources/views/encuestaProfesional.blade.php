@extends('layouts.home')

@section('main')
<div role="main" class="main">

	<section class="section section-concept section-no-border section-dark section-angled section-angled-reverse pt-5 m-0 overlay overlay-show overlay-op-8" style="background-image: url({{asset('img/slides/slide-bg-4.jpg')}}); background-size: cover; background-position: center; min-height: 645px;">
		<div class="section-angled-layer-bottom section-angled-layer-increase-angle bg-light" style="padding: 8rem 0;"></div>
		<div class="container pt-lg-5 mt-5">
			<div class="row pt-3 pb-lg-0 pb-xl-0">
				<div class="col-lg-6 pt-4 mb-5 mb-lg-0">
					<h1 class="font-weight-bold text-10 text-xl-12 line-height-2 mb-3">Encuesta</h1>					
					<a href="#ver" data-hash data-hash-offset="0" data-hash-offset-lg="100" class="btn btn-gradient-primary border-primary btn-effect-4 font-weight-semi-bold px-4 btn-py-2 text-3">Ver <i class="fas fa-arrow-down ms-1"></i></a>
				</div>

			</div>
		</div>
	</section>
	
	
	
<div role="main" class="main" id="ver">
	<div class="container pt-3 pb-2">
	@if (Session::has('message'))
	<div class="alert alert-success">
		<p>{{ Session::get('message') }}</p>
	</div>
	@endif
	@if (Session::has('error'))
	<div class="alert alert-danger">
		<p>{{ Session::get('error') }}</p>
	</div>
	@endif
    @if(!Session::has('message'))
    <div class="mb-5">Hola, {{ $professional_name }}. Cliente: {{ $client_name }}</div>

    <form id="surveyForm" action="{{ route('saveSurveyProf', ['hash' => $hash])  }}" method="POST" class="needs-validation fs-6" novalidate>
    @csrf
        <div class="mb-5">
        <!-- Pregunta 1 -->
                    <label class="form-label fw-bold">¿Pudiste realizar el trabajo?</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="job_done" id="job_done_true" value="1" required>
                        <label class="form-check-label" for="job_done_true">Sí</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="job_done" id="job_done_false" value="0" required>
                        <label class="form-check-label" for="job_done_false">No</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="job_done" id="job_done_resend" value="resend" required>
                        <label class="form-check-label" for="job_done_resend">Aún nos estamos poniendo de acuerdo</label>
                    </div>
                </div>

        <!-- Sí -->
                <div id="job_done_yes" style="display: none;">
                    <div class="mb-5">
                        <label class="form-label fw-bold">¿Cómo evaluás el acuerdo?</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="agreement_evaluation" id="evaluation_muy_bueno" value="Muy bueno">
                            <label class="form-check-label" for="evaluation_muy_bueno">Muy bueno</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="agreement_evaluation" id="evaluation_bueno" value="Bueno">
                            <label class="form-check-label" for="evaluation_bueno">Bueno</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="agreement_evaluation" id="evaluation_malo" value="Malo">
                            <label class="form-check-label" for="evaluation_malo">Malo</label>
                        </div>
                    </div>

                    <div class="mb-5" id="evaluation_reason_wrapper" style="display: none;">
                        <label for="evaluation_reason" class="form-label fw-bold">¿Por qué?</label>
                        <textarea class="form-control" id="evaluation_reason" name="evaluation_reason" rows="3"></textarea>
                    </div>

                    <div class="mb-5">
                        <label for="time_taken" class="form-label fw-bold">¿Te llevó el tiempo que esperabas?</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="time_evaluation" id="time_yes" value="1">
                            <label class="form-check-label" for="time_yes">Sí</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="time_evaluation" id="time_no" value="0">
                            <label class="form-check-label" for="time_no">No</label>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="pricing" class="form-label fw-bold">¿Pudiste ponerle un precio acorde al tiempo y los costos que implicó su realización?</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pricing_evaluation" id="pricing_yes" value="1">
                            <label class="form-check-label" for="pricing_yes">Sí</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="pricing_evaluation" id="pricing_no" value="0">
                            <label class="form-check-label" for="pricing_no">No</label>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="adjustments" class="form-label fw-bold">¿Qué cosas ajustarías para el próximo trabajo?</label>
                        <textarea class="form-control" id="adjustments" name="adjustments" rows="3"></textarea>
                    </div>

                    <div class="mb-5">
                        <label for="client_satisfaction" class="form-label fw-bold">¿Crees que el cliente quedó conforme?</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="client_satisfaction" id="client_satisfaction_yes" value="1">
                            <label class="form-check-label" for="client_satisfaction_yes">Sí</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="client_satisfaction" id="client_satisfaction_no" value="0">
                            <label class="form-check-label" for="client_satisfaction_no">No</label>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="client_satisfaction_comments" class="form-label fw-bold">¿Por qué?</label>
                        <textarea class="form-control" id="client_satisfaction_comments" name="client_satisfaction_comments" rows="3"></textarea>
                    </div>
                    <div class="mb-5">
                        <label for="client_interaction" class="form-label fw-bold">¿Qué te pareció el trato con el cliente?</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="client_interaction" id="client_interaction_1" value="Muy bueno">
                            <label class="form-check-label" for="client_interaction_1">Muy bueno</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="client_interaction" id="client_interaction_2" value="Bueno">
                            <label class="form-check-label" for="client_interaction_2">Bueno</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="client_interaction" id="client_interaction_3" value="Malo">
                            <label class="form-check-label" for="client_interaction_3">Malo</label>
                        </div>
                    </div>
                    <div class="mb-5" id="interaction_reason_wrapper" style="display: none;">
                            <label for="client_interaction_comments" class="form-label fw-bold">¿Por qué?</label>
                            <textarea class="form-control" id="client_interaction_comments" name="client_interaction_comments" rows="3"></textarea>
                    </div>
    
                    <div class="mb-5">
                            <label for="additional_comments" class="form-label fw-bold">Otros comentarios que quieras dejarnos</label>
                            <textarea class="form-control" id="additional_comments" name="additional_comments" rows="3"></textarea>
                    </div>
                </div>
                

        <!-- No -->
        <div id="job_done_no" style="display: none;">
                   
                    <div class="mb-5">
                        <label for="job_not_completed" class="form-label fw-bold">¿Por qué?</label><br>
                        <div class="form-check form-check">
                            <input class="form-check-input" type="radio" name="job_not_completed" id="job_not_completed_client" value="1">
                            <label class="form-check-label" for="job_not_completed_client">El cliente no respondió mis mensajes</label>
                        </div>
                        <div class="form-check form-check">
                            <input class="form-check-input" type="radio" name="job_not_completed" id="job_not_completed_prof" value="2">
                            <label class="form-check-label" for="job_not_completed_prof">Dejé de responder los mensajes</label>
                        </div>
                        <div class="form-check form-check">
                            <input class="form-check-input" type="radio" name="job_not_completed" id="job_not_completed_disagreement" value="3">
                            <label class="form-check-label" for="job_not_completed_disagreement">No pudimos ponernos de acuerdo</label>
                        </div>
                    </div>

                    <div class="mb-5" id="disagreement_reason" style="display: none;">
                        <label for="disagreement_option_id" class="form-label fw-bold">¿En qué?</label><br>
                        <div class="form-check form-check">
                            <input class="form-check-input" type="checkbox" name="disagreement_option_id" id="disagreement_comments_1" value="1">
                            <label class="form-check-label" for="job_not_completed_1">En el día de visita</label>
                        </div>

                        <div class="form-check form-check">
                            <input class="form-check-input" type="checkbox" name="disagreement_option_id" id="disagreement_comments_2" value="2">
                            <label class="form-check-label" for="job_not_completed_2">Me resultó muy lejos</label>
                        </div>

                        <div class="form-check form-check">
                            <input class="form-check-input" type="checkbox" name="disagreement_option_id" id="disagreement_comments_3" value="2">
                            <label class="form-check-label" for="job_not_completed_3">En el presupuesto</label>
                        </div>

                        <div class="form-check form-check">
                            <input class="form-check-input" type="checkbox" name="disagreement_option_id" id="disagreement_comments_4" value="3">
                            <label class="form-check-label" for="job_not_completed_4">No sé hacer el tipo  de trabajo que me solicitaron</label>
                        </div>

                        <div class="form-check form-check">
                            <input class="form-check-input" type="checkbox" name="disagreement_option_id" id="disagreement_comments_5" value="4">
                            <label class="form-check-label" for="job_not_completed_5">No tengo las herramientas para hacer el tipo de trabajo que me solicitaron</label>
                        </div>

                        <div class="form-check form-check">
                            <input class="form-check-input" type="checkbox" name="disagreement_option_id" id="disagreement_comments_5" value="5">
                            <label class="form-check-label" for="job_not_completed_5">No tengo tiempo para realizar ese trabajo</label>
                        </div>

                        <div class="form-check form-check">
                            <label for="disagreement_comments" class="form-label">Otra razón que quieras comentarnos…</label>
                            <textarea class="form-control" id="disagreement_comments" name="disagreement_comments" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="mb-5">
                            <label for="additional_comments" class="form-label fw-bold">Otros comentarios que quieras dejarnos</label>
                            <textarea class="form-control" id="additional_comments" name="additional_comments" rows="3"></textarea>
                    </div>

                   
        </div>

        <!-- Todavía no -->
        <div id="job_done_not_yet" style="display: none;">
        Te enviaremos un recordatorio dentro de una semana.
        </div>

        <button type="submit" class="btn btn-primary mt-5">Enviar</button>
        
        </div>
    </form>
	@endif
</div>

</div>
    
    
<script>
    // handle showing/hiding sections based on user responses
    document.querySelectorAll('input[name="job_done"]').forEach((input) => {
        input.addEventListener('change', () => {
            const jobDone = input.value;
            const jobYes = document.getElementById('job_done_yes')
            const jobNo = document.getElementById('job_done_no')
            const jobNotYet = document.getElementById('job_done_not_yet')                      
            
            jobYes.style.display = (jobDone === '1') ? 'block' : 'none';
            jobNo.style.display = (jobDone === '0') ? 'block' : 'none';
            jobNotYet.style.display = (jobDone === 'resend') ? 'block' : 'none';
            
            if(jobDone === '0' || jobDone === 'resend'){
                const inputsInJobYes = jobYes.querySelectorAll('input, textarea');
                inputsInJobYes.forEach(input => {
                    if (input.type === 'radio' || input.type === 'checkbox') {
                        input.checked = false;
                    } else {
                        input.value = '';
                    }
                });
            }
            if(jobDone === '1' || jobDone === 'resend'){
                const inputsInJobNo = jobNo.querySelectorAll('input, textarea');
                inputsInJobNo.forEach(input => {
                    if (input.type === 'radio' || input.type === 'checkbox') {
                        input.checked = false;
                    } else {
                        input.value = '';
                    }
                });
            }
        });
    });

    document.querySelectorAll('input[name="job_not_completed"]').forEach((input) => {
        input.addEventListener('change', () => {
            const reason = input.value;
            document.getElementById('disagreement_reason').style.display = (reason === 'Disagreement') ? 'block' : 'none';
        

        });
    });

    document.querySelectorAll('input[name="agreement_evaluation"]').forEach((input) => {
        input.addEventListener('change', () => {
            const evaluation = input.value;
            document.getElementById('evaluation_reason_wrapper').style.display = (evaluation === 'Malo') ? 'block' : 'none';
        

        });
    });

    document.querySelectorAll('input[name="client_interaction"]').forEach((input) => {
        input.addEventListener('change', () => {
            const interaction = input.value;
            document.getElementById('interaction_reason_wrapper').style.display = (interaction === 'Malo') ? 'block' : 'none';
        

        });
    });
    
</script>
@endsection





