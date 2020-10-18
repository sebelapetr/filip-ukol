<?php
/**
 * Created by PhpStorm.
 * User: Petr Šebela
 * Date: 24. 9. 2020
 * Time: 20:36
 */

declare(strict_types=1);

namespace App\Model;

use Nextras\Orm\Collection\ICollection;
use Nextras\Orm\Repository\Repository;

class VehiclesRepository extends Repository
{

    public static function getEntityClassNames(): array
    {
        return [Vehicle::class];
    }

    public function findActive(array $args = []): ICollection
    {
        return $this->findBy(['deleted' => false] + $args);
    }
}