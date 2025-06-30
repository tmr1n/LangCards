<?php

namespace App\Enums;

enum TypeShowingDeck: string
{
    case onlyPremium = 'onlyPremium';
    case onlyNotPremium = 'onlyNotPremium';
    case all = 'all';

}
