@extends('layouts.home')

@section('main')

<div role="main" class="main">
<div class="container" style="margin-bottom: 10px">
<body>
    <h1>Últimos clientes registrados</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
            </tr>
        </thead>
        <tbody>
    @foreach($surveys as $survey)
        <tr>
            <td>{{ $survey->id }}</td>
            <td>{{ $survey->client_name }}</td>
            <td>{{ $survey->client_cellphone }}</td>
            <td>
                <form action="{{ route('survey.init') }}" method="post">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $survey->user_id }}">
                    <input type="hidden" name="survey_id" value="{{ $survey->id }}">
                    <button type="submit">Enviar encuesta</button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>
    </table>

</div>
</div>
@endsection