<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * Class CreateUser
 */
class CreateUser extends CreateRecord
{
    /**
     * @var string
     */
    protected static string $resource = UserResource::class;
}
