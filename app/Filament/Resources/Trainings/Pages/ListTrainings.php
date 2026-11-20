<?php

namespace App\Filament\Resources\Trainings\Pages;

use App\Filament\Resources\Trainings\TrainingResource;
use Filament\Resources\Pages\ListRecords;

class ListTrainings extends ListRecords
{
    protected static string $resource = TrainingResource::class;
}
