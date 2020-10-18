<?php
/**
 * Created by PhpStorm.
 * User: Petr Šebela
 * Date: 24. 9. 2020
 * Time: 20:35
 */

declare(strict_types=1);

namespace App\Model;

use Nextras\Orm\Entity\Entity;

/**
 * Class Vehicle
 * @package App\Model
 * @property int $id {primary}
 * @property string $spz
 * @property string $vehicleBrand
 * @property string $vehicleModel
 * @property string $vehicleColor
 * @property int $startKm
 * @property int $endKm
 * @property \DateTimeImmutable $createdAt {default now}
 * @property boolean $deleted {default false}
 * @property string $type {enum self::TYPE_*}
 */
class Vehicle extends Entity
{

    public const TYPE_CAR = "CAR";
    public const TYPE_SCOOTER = "SCOOTER";

}