<?php
declare(strict_types=1);

namespace App\Forms;

use App\Model\Orm;
use App\Model\Vehicle;
use Nette;
use Tracy\Debugger;

class VehicleForm extends Nette\Application\UI\Control
{
    private Orm $orm;
    public ?Vehicle $vehicle;

    public function __construct(Orm $orm, ?Vehicle $vehicle)
    {
        $this->orm = $orm;
        $this->vehicle = $vehicle;
    }

    public function render()
    {
        $this->template->setFile(__DIR__ . '/VehicleForm.latte');
        $this->template->vehicle = $this->vehicle;
        $this->template->render();
    }

    protected function createComponentForm()
    {
        $form = new Nette\Application\UI\Form();

        $form->addText('spz', 'SPZ')
            ->setRequired();

        $form->addText('vehicleBrand', 'Značka')
            ->setRequired();

        $form->addText('vehicleModel', 'Model')
            ->setRequired();

        $form->addText('vehicleColor', 'Barva')
            ->setRequired();

        $form->addText('startKm', 'Km na začátku')
            ->setRequired();

        $form->addText('endKm', 'Km na konci')
            ->setRequired();

        $form->addSelect('type', 'Typ', [Vehicle::TYPE_CAR => 'Auto', Vehicle::TYPE_SCOOTER => 'Skůtr'])
            ->setRequired();

        $form->addSubmit('send', 'Odeslat');

        $form->onSuccess[] = [$this, 'onSuccess'];

        if ($this->vehicle)
        {
            $form->setDefaults($this->vehicle->toArray());
        }

        return $form;
    }

    public function onSuccess(Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();

        if (!$this->vehicle)
        {
            $vehicle = new Vehicle();
        } else {
            $vehicle = $this->vehicle;
        }

        $vehicle->spz = $values->spz;
        $vehicle->vehicleBrand = $values->vehicleBrand;
        $vehicle->vehicleModel = $values->vehicleModel;
        $vehicle->vehicleColor = $values->vehicleColor;
        $vehicle->startKm = $values->startKm;
        $vehicle->endKm = $values->endKm;
        $vehicle->type = $values->type;
        $vehicle->createdAt = new \DateTimeImmutable();

        $this->orm->persistAndFlush($vehicle);

        if ($this->vehicle) {
            $this->getPresenter()->flashMessage('Vozidlo bylo upraveno');
        } else {
            $this->getPresenter()->flashMessage('Vozidlo bylo přidáno');
        }
    }
}