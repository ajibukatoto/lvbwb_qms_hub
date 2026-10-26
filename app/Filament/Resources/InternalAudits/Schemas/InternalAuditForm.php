<?php

namespace App\Filament\Resources\InternalAudits\Schemas;

use Filament\Schemas\Schema;

class InternalAuditForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }
}
