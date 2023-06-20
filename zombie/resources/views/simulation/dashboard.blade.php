<x-main-layout title="Dashboard">
    <form method="POST" action="{{route('turn.create')}}">
        @csrf
        <x-standard-button label="Następna tura"/>
    </form>
</x-main-layout>

