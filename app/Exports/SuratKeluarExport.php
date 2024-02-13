<?php

namespace App\Exports;

use App\Models\SuratKeluar;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

// Format
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class SuratKeluarExport extends DefaultValueBinder implements FromQuery, WithHeadings, ShouldAutoSize, WithStyles, WithMapping, WithCustomValueBinder, WithTitle, WithEvents
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public $tgl_awal, $tgl_akhir, $no_surat, $tujuan, $status, $search;
    public $sortColoumName = "created_at";
    public $sortDirection = "desc";
    public $perpage = 100;
    
    public function __construct($cari_tgl_awal, $cari_tgl_akhir, $cari_no_surat, $cari_tujuan, $cari_status, $cari_search)
    {
        $this->tgl_awal = $cari_tgl_awal;
        $this->tgl_akhir = $cari_tgl_akhir;
        $this->no_surat = $cari_no_surat;
        $this->tujuan = $cari_tujuan;
        $this->status = $cari_status;
        $this->search = $cari_search;
    }
    
    public function query()
    {
        $query = SuratKeluar::query();
        
        $query->when($this->tgl_awal, function ($query) {
            return $query->whereDate('tgl_surat', '>=', $this->tgl_awal);
        })
        ->when($this->tgl_akhir, function ($query) {
            return $query->whereDate('tgl_surat', '<=', $this->tgl_akhir);
        })
        ->when($this->no_surat, function ($query) {
            return $query->where('no_surat', 'like', '%' . $this->no_surat . '%');
        })
        ->when($this->tujuan, function ($query) {
            return $query->where('tujuan_surat_id', 'like', '%' . $this->tujuan . '%');
        })
        ->when($this->status, function ($query) {
            return $query->where('is_complete', $this->status);
        })
        ->whereRaw('LOWER(perihal_surat) like ?', ['%' . strtolower($this->search) . '%'])
        ->orderBy($this->sortColoumName, $this->sortDirection)
        ->get();
        // ->paginate($this->perpage);
        
        return $query->latest();
        
    }
    
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->getFont()->setBold(true);
    }
    public function headings(): array
    {
        return [
            'No Surat',
            'No Arsip',
            'Tanggal Surat',
            'Tanggal Diterima',
            'Pengirim',
            'Alamat Pengirim',
            'Perihal Surat',
            'Tujuan',
            'Status',
        ];
    }
    
    public function map($model): array
    {
        return [
            $model->no_surat,
            $model->no_arsip,
            $model->tgl_surat,
            $model->tgl_terima,
            $model->pengirim_surat,
            $model->alamat,
            $model->perihal_surat,
            $model->tujuan->jabatan,
            $model->is_complete
        ];
    }
    
    public function title(): string
    {
        return 'Data Pegawai';
    }
    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:P1')
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('CCCCCC');
            },
        ];
    }
    
    
}
