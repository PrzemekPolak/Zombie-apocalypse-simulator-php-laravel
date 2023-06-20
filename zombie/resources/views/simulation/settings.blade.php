<x-main-layout title="Ustawienia">
    <div clsass="container">
        <form method="POST" action="{{route('settings.update')}}">
            @csrf
            @foreach($settings as $data)
                <x-slider-input name="{{$data->event}}" label="{{$data->description}}"
                                initialValue="{{$data->chance}}"/>
            @endforeach
            <x-standard-button label="Przejdź do symulacji"/>
        </form>
    </div>
</x-main-layout>

<style>
    .container {
        max-width: 800px;
    }
</style>
