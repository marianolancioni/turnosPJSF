<?php

namespace App\DataTables;

use App\Entity\Organismo;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\BoolColumn;
use Omines\DataTablesBundle\Column\NumberColumn;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTable;
use Omines\DataTablesBundle\DataTableTypeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * TableType para datatables de grilla de Organismos
 */
class OrganismoTableType extends AbstractController implements DataTableTypeInterface
{

    /**
     * Configuro las columnas y sus funcionamiento de la grilla de localidades
     *
     * @param DataTable $dataTable
     * @param array $options
     * @return void
     */
    public function configure(DataTable $dataTable, array $options)
    {
        $dataTable->add('id', TextColumn::class, ['label' => '#', 'searchable' => false]);
        $dataTable->add('codigo', NumberColumn::class, ['label' => 'Código', 'searchable' => true]);
        $dataTable->add('organismo', TextColumn::class, ['label' => 'Organismo', 'searchable' => true, 'leftExpr' => "toUpper(o.organismo)", 'rightExpr' => function ($value) {
            return '%' . strtoupper($value) . '%';
        }]);
        $dataTable->add('telefono', TextColumn::class, ['label' => 'Teléfono', 'searchable' => false]);
        $dataTable->add('habilitado', BoolColumn::class, ['label' => 'Habilitado', 'searchable' => false, 'className' => 'text-center', 'trueValue' => '<i class="fas fa-check"></i>', 'falseValue' => '<i class="fa fa-times"></i>', 'nullValue' => 'unknown']);
        if ($this->isGranted(('ROLE_EDITOR'))) {
            $dataTable->add('acciones', TextColumn::class, ['label' => 'Acciones', 'className' => 'text-center', 'render' => function ($value, $context) {
                return '&nbsp;&nbsp;<a href="' . $this->generateUrl('organismo_show', ['id' => $context->getId()]) . '" title="Ver"><i class="fas fa-eye"></i></a>' .
                    '&nbsp;&nbsp;<a href="' . $this->generateUrl('organismo_edit', ['id' => $context->getId()]) . '" title="Editar"><i class="fas fa-pen"></i></a>';
            }]);
        }

        $dataTable->addOrderBy('codigo', DataTable::SORT_ASCENDING);
        $dataTable->createAdapter(ORMAdapter::class, [
            'entity' => Organismo::class,
            'query' => function (QueryBuilder $builder) {
                $builder
                    ->select('o')
                    ->from(Organismo::class, 'o');
            }
        ]);
    }
}
