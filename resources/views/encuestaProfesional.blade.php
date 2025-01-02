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
    <?php session()->forget('message'); ?>
	@endif
	@if (Session::has('error'))
	<div class="alert alert-danger">
		<p>{{ Session::get('error') }}</p>
	</div>
	@endif
    @if(!$survey_completed)

    <form action="{{ route('saveSurveyProf', ['hash' => $hash])  }}" method="POST" class="needs-validation fs-6" novalidate>
    @csrf
    @foreach ($questions as $question)
        <div class="question" id="question-{{ $question->id }}" style="display: none;" class="mb-5">
            <label for="question-{{ $question->id }}" class="form-label fw-bold mb-2">{{ $question->question_text }}</label>

            <div class="mb-5 container">
                @switch($question->question_type)
                    @case('boolean')
                    @php
                        $options = $question->options; 
                    @endphp

                    @if($options && is_array($options))
                        @foreach($options as $option)
                            <div class="form-check">
                                <input 
                                    type="radio" 
                                    class="form-check-input" 
                                    id="{{ strtolower($option) }}-{{ $question->id }}" 
                                    name="question_{{ $question->id }}" 
                                    value="{{ $option }}">
                                <label 
                                    class="form-check-label" 
                                    for="{{ strtolower($option) }}-{{ $question->id }}">
                                    {{ $option }}
                                </label>
                            </div>
                        @endforeach
                    @endif
                        @break

                    @case('select')
                        <select 
                            class="form-select w-auto" 
                            name="question_{{ $question->id }}">
                            <option value=""></option>
                            @foreach ($question->options as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </select>
                        @break

                    @case('text')
                        <textarea 
                            name="question_{{ $question->id }}" 
                            class="form-control w-75" 
                            rows="4"></textarea>
                        @break

                    @case('multiple-choice')
                        @foreach ($question->options as $option)
                            <div class="form-check">
                                <input 
                                    type="checkbox" 
                                    class="form-check-input" 
                                    id="option-{{ $question->id }}-{{ $loop->index }}" 
                                    name="question_{{ $question->id }}[]" 
                                    value="{{ $option }}">
                                <label 
                                    class="form-check-label" 
                                    for="option-{{ $question->id }}-{{ $loop->index }}">
                                    {{ $option }}
                                </label>
                            </div>
                        @endforeach
                        @break

                    @default
                        <p class="text-danger"></p>
                @endswitch
            </div>
        </div>
    @endforeach

        <button type="submit">Enviar</button>
    </form>

@endif

</div>
</div>
    



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const questionElements = {};

        const question1Element = document.getElementById('question-1');
        question1Element.style.display = 'block';


        // Initialize questions: hide all dependent ones by default
        @foreach ($questions as $question)
            (function() {
                let questionId = @json($question->id);
                const questionElement = document.getElementById('question-' + questionId);

                questionElements[questionId] = {
                    element: questionElement,
                    condition: @json($question->condition ? json_decode($question->condition, true) : null),
                    parentId: {{ $question->parent_question_id ?? 'null' }}
                };

                // Hide dependent questions initially
                if (questionElements[questionId].condition) {
                    questionElement.style.display = 'none';
                }
            })();
        @endforeach

        // Function to reset fields inside a question element
        function resetFields(questionElement) {
            const inputs = questionElement.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                if (input.type === 'radio' || input.type === 'checkbox') {
                    input.checked = false;
                } else {
                    input.value = '';
                }
            });
        }
        
        // Function to evaluate conditions recursively
        function evaluateVisibility(questionId) {
            const question = questionElements[questionId];
            if (!question || !question.condition) return true; // No condition means always visible

            const parentId = question.parentId;
            const parentInputName = 'question_' + parentId;

            // Check if the parent is visible and condition is met
            if (parentId && !evaluateVisibility(parentId)) {
                question.element.style.display = 'none';
                resetFields(question.element); // Reset fields when hiding
                return false;
            }

            const condition = question.condition;
            const parentInputs = document.querySelectorAll(`input[name="${parentInputName}"], select[name="${parentInputName}"]`);
            let isConditionMet = false;

            parentInputs.forEach(input => {
                if ((input.type === 'radio' || input.type === 'checkbox') && input.checked && input.value === condition.response) {
                    isConditionMet = true;
                } else if (input.tagName === 'SELECT' && input.value === condition.response) {
                    isConditionMet = true;
                }
            });

            if (isConditionMet) {
                question.element.style.display = 'block';
                return true;
            } else {
                question.element.style.display = 'none';
                resetFields(question.element); // Reset fields when hiding
                return false;
            }
        }

        // Attach change listeners to all parent inputs
        @foreach ($questions as $question)
            @if ($question->condition)
                (function() {
                    const parentInputName = 'question_{{ $question->parent_question_id }}';
                    const dependentQuestionId = {{ $question->id }};
                    const parentInputs = document.querySelectorAll(`input[name="${parentInputName}"], select[name="${parentInputName}"]`);

                    parentInputs.forEach(input => {
                        input.addEventListener('change', function () {
                            Object.keys(questionElements).forEach(qId => evaluateVisibility(qId));
                        });
                    });
                })();
            @endif
        @endforeach

        // Evaluate all questions initially
        Object.keys(questionElements).forEach(qId => evaluateVisibility(qId));
    });
</script>



@endsection





