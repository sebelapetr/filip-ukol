<?php
declare(strict_types=1);

namespace App\Components\Datagrids;


use App\Model\Orm;
use App\Model\Vehicle;
use Nette;
use Nette\ComponentModel\IContainer;
use Nette\Utils\Html;
use Ublaboo\DataGrid\DataGrid;

class VehiclesDatagrid extends DataGrid
{
    protected Orm $orm;

    public function __construct(Orm $orm,?IContainer $parent = null, ?string $name = null)
    {
        parent::__construct($parent, $name);
        $this->orm = $orm;
    }

    public function setup()
    {
        $domain = "entity.vehicle";

        $this->setDataSource($this->orm->vehicles->findActive());

        $this->addColumnText('id','ID')
            ->setSortable();

        $this->addColumnText("spz", 'SPZ')
            ->setRenderer(function (Vehicle $item) {
                return substr_replace($item->spz," ", 3, -strlen($item->spz));
            })
            ->setSortable()
            ->setFilterText();

        $this->addColumnText("type", 'TYP')
            ->setRenderer(function (Vehicle $item) {
                return $this->translator->translate("entity.vehicle.vehicleType.".$item->type);
            })
            ->setSortable()
            ->setFilterText();

        $this->addColumnText("vehicleBrand", 'ZNAČKA')
            ->setSortable()
            ->setFilterMultiSelect([]);

        $this->addColumnText("vehicleModel", 'MODEL')
            ->setSortable()
            ->setFilterMultiSelect([]);

        $this->addColumnText("vehicleColor", 'BARVA')
            ->setRenderer(function (Vehicle $item) {
                return $this->translator->translate('colors.'.$item->vehicleColor);
            })
            ->setSortable()
            ->setFilterMultiSelect([]);

        $this->addColumnText("startKm", 'KM na startu')
            ->setRenderer(function (Vehicle $item) {
                return number_format($item->startKm, 0,'.',' ') . ' km';
            })
            ->setSortable()
            ->setFilterRange();

        $this->addColumnText("endKm", 'Aktuální KM')
            ->setRenderer(function (Vehicle $item) {
                return number_format($item->endKm, 0,'.',' ') . ' km';
            })
            ->setSortable()
            ->setFilterRange();

        $this->addColumnText("createdAt", 'Vytvořeno')
            ->setRenderer(function (Vehicle $item) {
                return $item->createdAt->format('d.m.Y');
            })
            ->setSortable()
            ->setFilterDate();

        $this->addAction('edit', 'Upravit');

    }
}