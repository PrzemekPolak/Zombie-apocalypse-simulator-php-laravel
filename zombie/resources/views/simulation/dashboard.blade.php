<x-main-layout title="Dashboard">
    <div>
        <div>Obecna tura: {{$currentTurn}}</div>
        <div>Liczba ludzi: {{$humansNumber}}</div>
        <div>Liczba zombie: {{$zombieNumber}}</div>
    </div>
    <form method="POST" action="{{route('turn.create')}}">
        @csrf
        <x-standard-button label="Następna tura"/>
    </form>
</x-main-layout>

