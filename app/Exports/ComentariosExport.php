<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Collection;

class ComentariosExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    protected Collection $comentarios;

    public function __construct(Collection $comentarios)
    {
        $this->comentarios = $comentarios;
    }

    public function collection(): Collection
    {
        return $this->comentarios;
    }

    public function headings(): array
    {
        return ['ID', 'Mensaje', 'Ticket', 'Usuario', 'Fecha', 'Estado'];
    }

    public function map($comentario): array
    {
        $usuario = $comentario->usuario->name ?? 'N/A';
        if ($comentario->usuario?->tipoUsuario) {
            $usuario .= ' "' . $comentario->usuario->tipoUsuario->nombre_tipo . '"';
        }

        return [
            (int) $comentario->id,
            (string) ($comentario->mensaje ?? ''),
            (string) ($comentario->ticket->titulo ?? 'N/A'),
            $usuario,
            $comentario->fecha ?? '',
            $comentario->estado ? 'Activo' : 'Inactivo',
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
                        'startColor' => ['argb' => 'FF5B2D8E'],
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
