<x-main-layout title="Symulacja zakończona" showSettingsButton="true">
    <h2> Symulacja trwała następującą ilość tur: {{$turns}}</h2>
    <h2>Powód zakończenia symulacji: {{$reasonForEnding}}</h2>
    <h3>Statystyki:</h3>
    <div class="flex-column gap-16">
        <div>Pozostali ludzie: {{$humanNumber}}</div>
        <div>Zabici ludzie: {{$deadHumans}}</div>
        <div>Ludzie przemienieni w zombie: {{$turnedHumans}}</div>
        <div>Pozostałe zombie: {{$zombieNumber}}</div>
        <div>Zabite zombie: {{$deadZombies}}</div>
        <div>Wszystkie ugryzienia: {{$allBites}}</div>
        <div>Pozostałe obrażenia: {{$allInjuries}}</div>
    </div>
</x-main-layout>
