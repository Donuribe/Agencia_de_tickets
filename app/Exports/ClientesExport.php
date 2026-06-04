<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Collection;

/**
 * ClientesExport
 *
 * CORRECCIÓN: Se eliminó WithStyles (depende de ext-gd en runtime) y se
 * reemplazó por WithEvents + AfterSheet para aplicar estilos de forma segura
 * sin requerir la extensión GD de PHP.
 */
class ClientesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    protected Collection $clientes;

    public function __construct(Collection $clientes)
    {
        $this->clientes = $clientes;
    }

    public function collection(): Collection
    {
        return $this->clientes;
    }

    public function headings(): array
    {
        return ['ID', 'Nombre', 'Dirección', 'Teléfono', 'Estado'];
    }

    public function map($cliente): array
    {
        return [
            (int) $cliente->id,
            (string) ($cliente->nombre    ?? ''),
            (string) ($cliente->direccion ?? ''),
            (string) ($cliente->telefono  ?? ''),
            $cliente->estado ? 'Activo' : 'Inactivo',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastCol = 'E'; // 5 columnas: A–E

                // Estilo de encabezado: fondo azul, texto blanco, negrita
                $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
                    'font' => [
                        'bold'  => true,
                        'color' => ['argb' => 'FFFFFFFF'],
                        'size'  => 12,
                    ],
                    'fill' => [
                        'fillType'   => 'solid',
                        'startColor' => ['argb' => 'FF4472C4'],
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                    ],
                ]);

                $lastRow = $sheet->getHighestRow();
                if ($lastRow > 1) {
                    $sheet->getStyle("A1:{$lastCol}{$lastRow}")->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => 'thin',
                                'color'       => ['argb' => 'FFB0B0B0'],
                            ],
                        ],
                    ]);

                    for ($row = 2; $row <= $lastRow; $row++) {
                        if ($row % 2 === 0) {
                            $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
                                'fill' => [
                                    'fillType'   => 'solid',
                                    'startColor' => ['argb' => 'FFF2F2F2'],
                                ],
                            ]);
                        }
                    }
                }
            },
        ];
    }
}
