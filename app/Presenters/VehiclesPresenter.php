<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Components\Datagrids\VehiclesDatagrid;
use App\Components\VehiclesDatagridFactory;
use App\Forms\IVehicleFormFactory;
use App\Model\Orm;
use App\Model\Vehicle;
use Nette;
use Tracy\Debugger;


final class VehiclesPresenter extends Nette\Application\UI\Presenter
{

    /** @inject */
    public Orm $orm;

    /** @inject */
    public VehiclesDatagridFactory $vehiclesDatagridFactory;

    /** @var IVehicleFormFactory @inject */
    public $vehicleFormFactory;

    public ?Vehicle $vehicle;

    public function createComponentVehiclesDatagrid(string $name): VehiclesDatagrid
    {
        return $this->vehiclesDatagridFactory->create();
    }

    public function actionEdit(int $id = null): void
    {
        if ($id) {
            try {
                $this->vehicle = $this->orm->vehicles->getById($id);
            } catch (\Exception $exception) {
                Debugger::log($exception);
            }
        } else {
            $this->vehicle = null;
        }
    }

    protected function createComponentVehicleForm()
    {
        $control = $this->vehicleFormFactory->create($this->vehicle);

        return $control;
    }
}

