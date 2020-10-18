<?php
declare(strict_types=1);

namespace App\Forms;

use App\Model\Vehicle;

interface IVehicleFormFactory
{
    /** @return VehicleForm */
    function create(?Vehicle $vehicle);
}