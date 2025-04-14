<?php

namespace App\Enum;

enum Status: string
{
    case EN_COUR = 'en cour';
    case EN_ATTENTE = 'en attente';
    case VALIDER = 'valider';
    case EN_RETARD = 'en retard';
    case REFUSER = 'refuser';
    case RETOURNER = 'retourner';
}
