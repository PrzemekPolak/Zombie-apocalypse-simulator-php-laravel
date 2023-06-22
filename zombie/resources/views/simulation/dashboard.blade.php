<x-main-layout title="Symulacja" showSettingsButton="true">
    <div class="dashboard-container">
        <div class="left-panel-container flex-column">
            @foreach($leftPanelData as $data)
                <x-info-panel-element label="{{$data['label']}}" value="{{$data['value']}}" icon="{{$data['icon']}}"/>
            @endforeach
        </div>
        <div class="flex-column" style="align-items: stretch; gap: 16px;">
            <h3 style="text-align: center; margin-bottom: 0;">Przykładowe osoby</h3>
            <div style="display: flex; justify-content: space-evenly; flex: 1;">
                <div class="flex-column" style="gap: 16px; justify-content: space-between;">
                    <div style="text-align: center" class="big-text">Ludzie:</div>
                    @foreach($randomHumans as $data)
                        <div>
                            <div>{{$data->name}}</div>
                            <div>Wiek: {{$data->age}}</div>
                            <div>Zawód: {{$data->profession}}</div>
                            <div>Ostatni posiłek: {{$data->last_eat_at}} turn temu</div>
                            <div>Stan zdrowia: {{$data->health}}</div>
                        </div>
                    @endforeach
                </div>
                <div class="flex-column" style="gap: 16px; justify-content: space-between;">
                    <div style="text-align: center" class="big-text">Zombie:</div>
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
            <form method="POST" action="{{route('turn.create')}}" class="center-child" style="margin-bottom: 0;">
                @csrf
                <x-standard-button label="Następna tura"/>
            </form>
        </div>
    </div>
</x-main-layout>

