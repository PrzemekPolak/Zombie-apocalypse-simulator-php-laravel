<x-main-layout title="Ustawienia">
    <div>
        <form method="POST" action="{{route('settings.update')}}" class="flex-column gap-16">
            @csrf
            @foreach($settings as $data)
                <x-slider-input name="{{$data->event}}" label="{{$data->description}}"
                                initialValue="{{$data->chance}}"/>
            @endforeach
            <x-number-input name="humanNumber" label="Ilość ludzi na początku symulacji" initialValue="100"
                            maxValue="10000"/>
            <x-number-input name="zombieNumber" label="Ilość zombie na początku symulacji" initialValue="10"
                            maxValue="1000"/>
            <div>
                <input type="checkbox" name="shouldLoop"/><label for="shouldLoop"> Czy powinno przeprowadzić całą
                    symulację w tle</label>
            </div>
            <button class="settings-form-button" onclick="loadingNow()">Potwierdź ustawienia i przejdź do symulacji
            </button>
        </form>
        <form method="POST"
              action="{{route('simulation.delete')}}" {{$simulationOngoing ? 'class=center-child' : 'class=hidden'}}>
            @csrf
            <button onclick="loadingNow(true)">Resetuj symulacje</button>
        </form>

        {{--        <button onclick="startSimulationLoop()">Przeprowadź całą symulację w tle</button>--}}
    </div>
</x-main-layout>

<script>
    function loadingNow(state) {
        if (state) {
            // document.querySelectorAll('button').forEach((el) => el.disabled = true)
        }
    }

    {{--function startSimulationLoop() {--}}
    {{--    loadingNow(true)--}}
    {{--    let humanNumber = parseInt(document.getElementById("humanNumber-input").value)--}}
    {{--    let zombieNumber = parseInt(document.getElementById("zombieNumber-input").value)--}}
    {{--    axios.post('{{route('simulation.loop')}}', {humanNumber: humanNumber, zombieNumber: zombieNumber})--}}
    {{--        .then(function (response) {--}}
    {{--            console.log(response)--}}
    {{--            if (response.status === 200) {--}}
    {{--                window.location.href = response.data--}}
    {{--            }--}}
    {{--        })--}}
    {{--        .catch(function (error) {--}}
    {{--            console.log(error);--}}
    {{--        });--}}
    {{--}--}}
</script>
