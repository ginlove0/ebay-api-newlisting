@extends('layouts.app')

@section('content')

{{--    sound --}}
<audio id="myAudio">
    <source src="{{ asset('audio/button-37.mp3') }}" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>



    <script src="https://js.pusher.com/4.4/pusher.min.js"></script>

<div class="container text-center">
<input type="text" id="myInput" onkeyup="searchName()" class="form-control" placeholder="Search for names..">
</div>

    <div class="container">
        <div id="content">
            @if(!empty($data))
                @foreach($data as $item)
                <div class="card m-4 item">
                    <div class="card-body d-flex">

                        <div class="mr-3">
                        <img style="height: 105px; width: 140px;" src="{{$item->picture}}">
                        </div>
                        <div>
                        <p class="title" >{{$item->title}}</p>
                        @if ($item->from_site == 'EBAY-AU')
                           <h3>AU ${{$item->price}}</h3>
                            @else
                            <h3>${{$item->price}}</h3>
                        @endif

                        <p class="grey-word">shipping: ${{$item->shipping_cost}}</p>
                        <h4>{{$item->item_condition}}</h4>
                            <p>{{$item->from_site}}</p>
                        </div>
                        <div class="ml-auto d-flex flex-column">
                            <a target="_blank" href="https://www.ebay.com.au/itm/{{$item->id}}" class="float-right btn btn-info text-white">Show on eBay</a>
                            <a href="/{{$item->id}}" class="float-right btn btn-info text-white mt-2">Show Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
             @endif
        </div>
    </div>



    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: 'ap4',
            forceTLS: true
        });

        async function playSound()
        {
            let sound = document.getElementById('myAudio');
            await sound.play();
            if (sound !== undefined) {
                sound.then(() => {
                    sound.play();

                }).catch(error => {
                    // Autoplay was prevented.
                    // Show a "Play" button so that user can start playback.
                });
            }
        }

        var channel = pusher.subscribe('my-channel');
        channel.bind('App\\Events\\MessagePushed', function(data) {
           let getData = data.data;
           let content = document.getElementById('content');
            console.log(data);
            playSound();
           // getData.data.forEach((item) => {


               content.innerHTML =
                   `
                 <div class="card m-4 item">
                    <div class="card-body d-flex">
                      <div class="mr-3">
                        <img style="height: 105px; width: 140px;" src="${getData.picture}">
                      </div>
<div>
                        <p class="title" >${getData.title}</p>
                       ${getData.from_site == 'EBAY-AU' ? `<h3>AU $${getData.price}</h3>` : `<h3>$${getData.price}</h3>`}
                       <p>shipping: $${getData.shipping_cost}</p>
                        <h4>${getData.item_condition}</h4>
                        <p>${getData.from_site}</p>
                          <p class="text-success">New</p>

</div>
                    </div>
                </div>
                 `
               + content.innerHTML;
        });
    </script>

    <script>

        function searchName()
        {
            var input, filter, ul, li, a, i, txtValue, titleValue;
            input = document.getElementById('myInput');
            filter = input.value.toUpperCase();

            ul = document.getElementById("content");
            li = ul.getElementsByClassName("item");

            // Loop through all list items, and hide those who don't match the search query
            for (i = 0; i < li.length; i++) {
                titleValue = li[i].getElementsByClassName("title")[0];
                txtValue = titleValue.textContent || titleValue.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }
    </script>

    <script src="{{ asset('js/showDetails.js') }}"></script>
@endsection
