@extends('layouts.app')

@section('content')

    <div class="container card mb-5">
        <div class="card-body">
        @if (array_key_exists('ConditionDescription',$data ))
            <h1>Condition: {{$data['Item']['ConditionDescription']}}</h1>
        @else
            <h1>Condition: {{$data['Item']['ConditionDisplayName']}}</h1>
        @endif
        </div>
    </div>


       <div id="description">{!! $data['Item']['Description'] !!}</div>

    <script>

    </script>
@endsection
