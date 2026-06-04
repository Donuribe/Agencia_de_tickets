<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Collection;

class TicketsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    protected Collection $tickets;

    public function __construct(Collection $tickets)
    {
        $this->tickets = $tickets;
    }

    public function collection(): Collection
    {
        return $this->tickets;
    }

    public function headings(): array
    {
        return ['ID', 'Título', 'Descripción', 'Cliente', 'Usuario Asignado', 'Estado'];
    }

    public function map($ticket): array
    {
        $usuarioAsignado = $ticket->usuarioAsignado->name ?? 'Sin asignar';
        if ($ticket->usuarioAsignado?->tipoUsuario) {
            $usuarioAsignado .= ' "' . $ticket->usuarioAsignado->tipoUsuario->nombre_tipo . '"';
        }

        return [
            (int) $ticket->id,
            (string) ($ticket->titulo      ?? ''),
            (string) ($ticket->descripcion ?? ''),
            (string) ($ticket->cliente->nombre ?? 'N/A'),
            $usuarioAsignado,
            $ticket->estado ? 'Activo' : 'Inactivo',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet   = $event->sheet->getDelegate();
                $lastCol = 'F'; // 6 columnas: A–F

                $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
                    'font' => [
                        'bold'  => true,
                        'color' => ['argb' => 'FFFFFFFF'],
                        'size'  => 12,
                    ],
                    'fill' => [
                        'fillType'   => 'solid',
                        'startColor' => ['argb' => 'FF1F7A4D'],
                    ],
                    'alignment' => ['horizontal' => 'center'],
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
