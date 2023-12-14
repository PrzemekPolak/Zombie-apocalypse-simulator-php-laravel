<?php

namespace App\Domain;

use App\Domain\Enum\ProfessionType;

class Profession
{
    private function __construct(
        public readonly string         $name,
        public readonly ProfessionType $type,
    )
    {
    }

    public static function create(
        string $name,
    ): self
    {
        $type = ProfessionType::None;

        if (in_array($name, ['doctor', 'nurse'])) {
            $type = ProfessionType::Health;
        }
        if (in_array($name, ['farmer', 'hunter'])) {
            $type = ProfessionType::Food;
        }
        if (in_array($name, ['engineer', 'mechanic'])) {
            $type = ProfessionType::Weapon;
        }
        if (in_array($name, ['soldier', 'police'])) {
            $type = ProfessionType::Fighting;
        }

        return new self(
            $name,
            $type,
        );
    }

    public function translatedName(): string
    {
        return $this->professionNamesTranslations()[$this->name];
    }

    private function professionNamesTranslations(): array
    {
        return [
            'doctor' => 'lekarz',
            'nurse' => 'pielęgniarka',
            'farmer' => 'rolnik',
            'hunter' => 'łowca',
            'engineer' => 'inżynier',
            'mechanic' => 'mechanik',
            'student' => 'student',
            'programmer' => 'programista',
            'teacher' => 'nauczyciel',
            'lawyer' => 'prawnik',
            'accountant' => 'księgowy',
            'architect' => 'architekt',
            'chef' => 'szef kuchni',
            'writer' => 'pisarz',
            'artist' => 'artysta',
            'musician' => 'muzyk',
            'photographer' => 'fotograf',
            'dentist' => 'dentysta',
            'pilot' => 'pilot',
            'scientist' => 'naukowiec',
            'firefighter' => 'strażak',
            'marketing manager' => 'kierownik marketingu',
            'graphic designer' => 'grafik',
            'athlete' => 'sportowiec',
            'veterinarian' => 'weterynarz',
            'journalist' => 'dziennikarz',
            'electrician' => 'elektryk',
            'psychologist' => 'psycholog'
        ];
    }
}
