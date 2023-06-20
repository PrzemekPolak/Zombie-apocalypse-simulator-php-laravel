<x-main-layout title="Ustawienia">
    <div clsass="container">
        <form method="POST" action="{{route('settings.update')}}">
            @csrf
            <x-slider-input name="injuryChance" label="Szansa na przypadkowe zranienie się przez człowieka"/>
            <x-standard-button label="Przejdź do symulacji"/>
        </form>
    </div>
</x-main-layout>

<style>
    .container {
        min-width: 600px;
    }
</style>
