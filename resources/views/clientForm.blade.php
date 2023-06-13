<div id="surveyForm">
  <form id="clientInfoForm" action="{{ route('save_client_info') }}" method="POST" novalidate>
    @csrf
    <div class="form-group">
      <input type="hidden" value="{{ old('user_id', $user_id) }}" name="user_id">
    </div>
    <div class="form-group">
      <label for="client_name">Nombre *</label>
      <input type="text" class="form-control" name="client_name" id="name" value="{{ old('client_name') }}" required>
      <div class="invalid-feedback" id="client_name_error"></div>
    </div>

    <div class="form-group">
      <label for="client_cellphone">Celular *</label>
      <input type="text" class="form-control" name="client_cellphone" id="cellphone" value="{{ old('client_cellphone') }}" required>
      <div class="invalid-feedback" id="client_cellphone_error"></div>
    </div>

    <div class="form-group">
      <div class="form-check-container">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" name="terms" id="terms" required checked>
        </div>
        <label class="form-check-label" for="terms">Acepto los <a href="{{ url('/condiciones') }}">términos y condiciones del sitio</a>. *</label>
      </div>
      <div class="invalid-feedback" id="terms_error"></div>
    </div>

    <div class="form-group">
      <div class="form-check-container">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" name="agree" id="agree" checked>
        </div>
        <label class="form-check-label" for="agree">Acepto que el CEFEPERS almacene mis datos de contacto y acepto recibir encuestas o promociones.</label>
      </div>
    </div>

    <button type="submit" class="btn btn-primary" id="submitBtn">Enviar</button>
  </form>
</div>

<script>
  $(document).ready(function() {
    $('#clientInfoForm').submit(function(event) {
      event.preventDefault();
      let form = $(this);

      // Disable the submit button
      $('#submitBtn').attr('disabled', true);

      // Clear previous error messages
      $('.invalid-feedback').empty();
      $('.form-control').removeClass('is-invalid');

      // Perform client-side validation
      let clientName = $('#name').val().trim();
      let clientCellphone = $('#cellphone').val().trim();
      let termsChecked = $('#terms').is(':checked');

      let hasErrors = false;

      if (clientName === '') {
        $('#client_name_error').text('Por favor, completar nombre');
        $('#name').addClass('is-invalid');
        hasErrors = true;
      }

      if (clientCellphone === '') {
        $('#client_cellphone_error').text('Por favor, completar número de celular, por ejemplo: 1156677889');
        $('#cellphone').addClass('is-invalid');
        hasErrors = true;
      }

      if (!termsChecked) {
        $('#terms_error').text('Debe aceptar los términos y condiciones del sitio');
        $('#terms').addClass('is-invalid');
        hasErrors = true;
      }

      // Check if any validation errors occurred
      if (!hasErrors) {
        // Submit the form
        form[0].submit();
      } else {
        // Enable the submit button
        $('#submitBtn').attr('disabled', false);
      }
    });
  });
</script>