<x-main-layout title="Dashboard">
    <div>
        <div>Obecna tura: {{$currentTurn}}</div>
        <div>Liczba ludzi: {{$humansNumber}}</div>
        <div>Liczba zombie: {{$zombieNumber}}</div>
        @foreach($resources as $data)
            <div>
                <div>{{$data->type}}</div>
                <div>{{$data->quantity}}</div>
            </div>
        @endforeach
    </div>
    <form method="POST" action="{{route('turn.create')}}">
        @csrf
        <x-standard-button label="Następna tura"/>
    </form>
    <a href="{{  asset ('/settings')}}">
        <button>Ustawienia</button>
    </a>
</x-main-layout>

