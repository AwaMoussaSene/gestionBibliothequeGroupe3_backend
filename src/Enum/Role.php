<?php

namespace App\Enum;

enum Role: string
{
    case RP = 'RP';
    case RB = 'RB';
    case Adherent = 'Adherent';
    case Visiteur = 'Visiteur';
}
