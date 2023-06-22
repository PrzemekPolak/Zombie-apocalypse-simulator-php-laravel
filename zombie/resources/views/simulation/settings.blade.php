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
            <button class="settings-form-button">Potwierdź ustawienia i przejdź do symulacji</button>
        </form>
        <form method="POST"
              action="{{route('simulation.delete')}}" {{$simulationOngoing ? 'class=center-child' : 'class=hidden'}}>
            <button>Resetuj symulacje</button>
        </form>
    </div>
</x-main-layout>
