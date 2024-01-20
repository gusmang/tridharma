<?php

namespace App\Exports;

use App\Models\Acara;
use App\Models\Peserta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Events\AfterSheet;

class ReportPesertaAcara implements FromView, ShouldAutoSize, WithEvents, WithTitle
{

    public $acara;
    public $tanggal_mulai;
    public $tanggal_selesai;
    public $peserta = [];

    public function __construct(Acara $acara, $tanggal_mulai, $tanggal_selesai)
    {
        $this->acara = $acara;
        $this->tanggal_mulai = $tanggal_mulai;
        $this->tanggal_selesai = $tanggal_selesai;
    }

    public function view(): View
    {
        $acara           = $this->acara;
        $tanggal_mulai   = $this->tanggal_mulai;
        $tanggal_selesai = $this->tanggal_selesai;

        $peserta = Peserta::where([
            'acara_id' => $acara->id,
            'sudah_bayar' => 1
        ]);

        if($tanggal_mulai != null) {
            $peserta->where('tanggal', '>=', $tanggal_mulai);
        }
        if($tanggal_selesai != null) {
            $peserta->where('tanggal', '<=', $tanggal_selesai);
        }

        $peserta = $peserta->orderBy('nomor_urut')->get();

        $this->peserta = $peserta;

        return view('excel.report_acara_peserta', compact('acara', 'tanggal_mulai', 'tanggal_selesai', 'peserta'));

    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {


                $event->sheet->getDelegate()
                                ->getStyle('A1:C3')->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

                $index = 5 + count($this->peserta);
                $event->sheet->getDelegate()->getStyle("A5:I$index")->applyFromArray(
                    array(
                        'borders' => array(
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => '000000']
                            ],
                        )
                    )
                );


            },
        ];
    }

    public function title(): string
    {
        $name = "Report Peserta {$this->acara->name}";

        return substr($name, 0, 31);
    }

}
