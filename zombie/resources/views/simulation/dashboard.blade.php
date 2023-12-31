<x-main-layout title="Symulacja" showSettingsButton="true">
    <div class="dashboard-container">
        <div class="left-panel-container flex-column">
            @foreach($leftPanelData as $data)
                <x-info-panel-element label="{{$data['label']}}" value="{{$data['value']}}" icon="{{$data['icon']}}"/>
            @endforeach
        </div>
        <div class="flex-column" style="align-items: stretch; gap: 16px;">
            <h3 style="text-align: center; margin-bottom: 0;">Przykładowe osoby</h3>
            <div class="dashboard-examples-container">
                <div class="flex-column gap-16">
                    <div class="dashboard-examples-titles">
                        <button onclick="changeHumans()">
                            <img src="{{asset('images/rotate-solid.svg')}}">
                        </button>
                        <div class="big-text">Ludzie:</div>
                    </div>
                    <div id='humans-container' class="dashboard-examples-each-container">
                        @foreach($randomHumans as $data)
                            <div>
                                <div>{{$data->name}}</div>
                                <div>Wiek: {{$data->age}}</div>
                                <div>Zawód: {{$data->profession}}</div>
                                <div>Ostatni posiłek: {{ $currentTurn - $data->last_eat_at }} tura temu</div>
                                <div>Stan zdrowia: {{$data->health}}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex-column gap-16">
                    <div class="dashboard-examples-titles">
                        <button onclick="changeZombies()"><img src="{{asset('images/rotate-solid.svg')}}">
                        </button>
                        <div class="big-text">Zombie:</div>
                    </div>
                    <div id='zombies-container' class="dashboard-examples-each-container">
                        @foreach($randomZombies as $data)
                            <div>
                                <div>{{$data->name}}</div>
                                <div>Wiek: {{$data->age}}</div>
                                <div>Były zawód: {{$data->profession}}</div>
                                <div>Stan zdrowia: {{$data->health}}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
            <form id="nextTurnForm" method="POST" action="{{route('turn.create')}}"
                  {{$simulationStillOngoing ? 'class=center-child' : 'class=hidden'}}
                  style="margin-bottom: 0;">
                @csrf
                <x-standard-button label="Następna tura"/>
            </form>
            <a {{$simulationStillOngoing ? 'class=hidden' : 'class=center-child'}} href="{{  asset ('/statistics')}}">
                <button>Symulacja zakończona - wyświetl statystyki</button>
            </a>
        </div>
    </div>
</x-main-layout>

<script>
    document.getElementById('nextTurnForm').addEventListener(
        "submit",
        () => loadingNow(true),
    );

    function changeHumans() {
        let parent = document.getElementById("humans-container")
        parent.innerHTML = 'Ładuję...';
        axios.get('api/human/randomList')
            .then(function (response) {
                let newData = response.data
                parent.innerHTML = '';
                newData.forEach((data) => {
                    let newDiv = document.createElement('div')
                    newDiv.innerHTML = `
                <div>${data.name}</div>
                <div>Wiek: ${data.age}</div>
                <div>Zawód: ${data.profession}</div>
                <div>Ostatni posiłek: ${data.last_eat_at} turn temu</div>
                <div>Stan zdrowia: ${data.health}</div>`
                    parent.append(newDiv)
                })
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    function changeZombies() {
        let parent = document.getElementById("zombies-container")
        parent.innerHTML = 'Ładuję...';
        axios.get('api/zombie/randomList')
            .then(function (response) {
                let newData = response.data
                parent.innerHTML = '';
                newData.forEach((data) => {
                    let newDiv = document.createElement('div')
                    newDiv.innerHTML = `
                <div>${data.name}</div>
                <div>Wiek: ${data.age}</div>
                <div>Były zawód: ${data.profession}</div>
                <div>Stan zdrowia: ${data.health}</div>`
                    parent.append(newDiv)
                })
            })
            .catch(function (error) {
                console.log(error);
            });
    }
</script>

