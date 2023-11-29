<x-main-layout title="Ustawienia">
    <div>
        <form id="settingsForm" class="flex-column gap-16">
            @csrf
            @foreach($settings as $data)
                <x-slider-input
                    minValue='{{$rules[$data->event][0]}}'
                    maxValue='{{$rules[$data->event][1]}}'
                    name="{{$data->event}}"
                    label="{{$data->description}}"
                    initialValue="{{$data->chance}}">
                </x-slider-input>
            @endforeach
            <x-number-input name="humanNumber" label="Ilość ludzi na początku symulacji" initialValue="200"
                            maxValue="500"/>
            <x-number-input name="zombieNumber" label="Ilość zombie na początku symulacji" initialValue="50"
                            maxValue="500"/>
            <div>
                <input type="checkbox" id="shouldLoop" name="shouldLoop"/>
                <label for="shouldLoop"> Czy powinno przeprowadzić całą symulację w pętli na serwerze i przekierować do
                    statystyk po jej zakończeniu (przy dużych ilościach osób zajmie dużo czasu)</label>
            </div>
            <button class="settings-form-button" onclick="send()">Potwierdź ustawienia i przejdź do symulacji</button>
        </form>
        <div {{$simulationOngoing ? 'class=center-child' : 'class=hidden'}}>
            <button onclick="resetSettings()">Resetuj symulacje</button>
        </div>
    </div>
</x-main-layout>

<script>
    function resetSettings() {
        loadingNow(true)
        axios.post('{{route('simulation.delete')}}', {})
            .then(function (response) {
                if (response.status === 200) {
                    window.location.href = '/settings'
                }
            })
            .catch(function (error) {
                console.log(error);
            })
    }

    function send() {
        loadingNow(true)

        axios.post('{{route('settings.update')}}', new FormData(document.getElementById('settingsForm')))
            .then(
                () => {
                    if (document.getElementById('shouldLoop').checked) {
                        axios.post('api/whole_simulation')
                            .then(
                                () => window.location = "{{ url('/statistics') }}"
                            )
                    } else window.location = "{{ url('/dashboard') }}"
                }
            )
    }
</script>
