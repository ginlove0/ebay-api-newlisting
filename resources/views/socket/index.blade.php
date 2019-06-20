@extends('layouts.app')

@section('content')
    <script src="https://js.pusher.com/4.4/pusher.min.js"></script>



   <div class="container">
        <div>
            <h1>ss</h1>
        </div>
   </div>



    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('b81b4e05760789c1850f', {
            cluster: 'ap4',
            forceTLS: true
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('App\\Events\\MessagePushed', function(data) {
            alert(JSON.stringify(data));
        });
    </script>
@endsection
