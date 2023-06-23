<x-main-layout title="Symulacja zakończona" showSettingsButton="true">
    <h2> Symulacja trwała następującą ilość tur: {{$turns}}</h2>
    <h2>Powód zakończenia symulacji: {{$reasonForEnding}}</h2>
    <h3>Statystyki:</h3>
    <div>Pozostali ludzie: {{$humanNumber}}</div>
    <div>Pozostałe zombie: {{$zombieNumber}}</div>
    <div>Wszystkie ugryzienia: {{$allBites}}</div>
    <div>Pozostałe obrażenia: {{$allInjuries}}</div>
</x-main-layout>
