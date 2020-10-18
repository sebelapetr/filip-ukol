<?php
declare(strict_types=1);

namespace App\Components;

use App\Components\Datagrids\VehiclesDatagrid;
use App\Model\Orm;
use Nette\SmartObject;

class VehiclesDatagridFactory
{
    use SmartObject;

    /** @var Orm */
    private $orm;

    public function __construct(Orm $orm)
    {
        $this->orm = $orm;
    }

    public function create(): VehiclesDatagrid
    {
        $datagrid = new VehiclesDatagrid($this->orm);
        $datagrid->setup();

        return $datagrid;
    }
}