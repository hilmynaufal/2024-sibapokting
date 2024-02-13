<?php

namespace App\Livewire\Main\Layanan\Bphtb\Form;
use App\Models\Bphtb\ObjekPajak as Model;
use App\Models\Bphtb\Persyaratan;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Storage;


class PersyaratanVerifikasi extends Component
{
    public $listPersyaratanVerifikasi;
    public $listPersyaratanValidasi;
    public $model;
    public $file_dokumen;
    public $id_bphtb;
    
    // Field Upload
    public $akta_apabila_sudah_diaktakan_sertifikat_warkah_girik_letter_c;
    public $akta_jual_beli_apabila_sudah_diaktakan;
    public $akta_peralihan_apabila_sudah_diaktakan;
    public $aktaakta_apabila_sudah_di_aktakan;
    public $bukti_kepemilikan_sertifikat_warkah;
    public $bukti_kepemilikan_shm_shgb_warkah_dll;
    public $bukti_lainnya;
    public $bukti_pendukung;
    public $bukti_pendukung_lainnya;
    public $buktibukti_lainnya;
    public $buktibukti_lainnya_yang_dapat_dijadikan_dasar_perhitungan_bphtb;
    public $buktibukti_lainnya_yang_dapat_dijadikan_perhitungan_bphtb;
    public $buktibukti_lainnyascan_tanda_pembayaran_bphtb_slip_setoran_bank_screenshot_mbanking_dll;
    public $kartu_keluarga;
    public $kartu_keluarga_penerima_hak_tukar__pemberi_hak_tukar;
    public $ktp;
    public $ktp_penerima_hadiahpemberi_hadiah;
    public $ktp_penerima_hak_tukar__pemberi_hak_tukar;
    public $ktp_penerima_hibahpemberi_hibah;
    public $scan_akta_kelahiran_apabila_penerima_hibah_belum_mempunyai_ktp;
    public $scan_akta_peralihan;
    public $scan_akta_tukar__menukar;
    public $scan_bukti_kepemilikan_sertifikat;
    public $scan_bukti_kepemilikan_shm_shgb_warkah_dll;
    public $scan_bukti_kepemilikan_sk_bpn;
    public $scan_bukti_pemenang_lelang;
    public $scan_bukti_pendukung_lainnya;
    public $scan_bukti_transaksibukti_transaksi_pendukung_lainnya;
    public $scan_cover_note_ppatppats;
    public $scan_foto_lokasi__denah_lokasi;
    public $scan_kartu_keluarga;
    public $scan_kartu_keluarga_penerima_hak;
    public $scan_keterangan_akhli_waris;
    public $scan_kk;
    public $scan_kk_pelepas_hak;
    public $scan_ktp;
    public $scan_ktp__kk_pembeli;
    public $scan_ktp__kk_pemberi_hibah;
    public $scan_ktp__kk_penjual;
    public $scan_ktp_dan_kk_penerima_hibah;
    public $scan_ktp_pelepas_hak;
    public $scan_ktp_penerima_hak;
    public $scan_ktp_seluruh_penerima_hak_warispewaris;
    public $scan_putusan_hakim;
    public $scan_risalah_lelang;
    public $scan_riwayat_tanah;
    public $scan_seluruh_kartu_keluarga_ahli_waris_yang_masih_berlaku;
    public $scan_sertifikat;
    public $scan_sk_bpn;
    public $scan_sppt_pbb_tahun_terahkir;
    public $scan_sppt_pbb_tahun_terakhir;
    public $scan_surat_keterangan__ptsl_dari_desanotaris;
    public $scan_surat_keterangan_ahli_waris;
    public $scan_surat_keterangan_ptsl;
    public $scan_surat_kuasa;
    public $scan_surat_kuasa__apabila_dikuasakan;
    public $scan_surat_kuasa_apabila_dikuasakan;
    public $scan_surat_pernyataan_aphb_bermaterai;
    public $scan_surat_pernyataan_hibah;
    public $scan_surat_pernyataan_jual_beli;
    public $scan_surat_pernyataan_objek;
    public $scan_surat_pernyataan_objek_lelang;
    public $scan_tanda_pembayaran_bphtb_slip_setoran_bank_screenshot_mbanking_dll;
    public $sppt_pbb_tahun_terakhir;
    public $surat_keterangan_ptsl_dari_desa;
    public $surat_keterangan_ptsl_dari_desanotaris;
    public $surat_keterangan_sktm_dtks_pkh_bpnt;
    public $surat_kuasa;
    public $surat_kuasa_apabila_dikuasakan;
    public $surat_pernyataan_objek;
    public $surat_pernyataan_pelepasan_hak;
    public $surat_putusan_hakim;
    public $tanda_pembayaran_bphtb_slip_setoran_bank_screenshot_mbanking_dll;
    
    use WithFileUploads;
    
    public function render()
    {
        return view('livewire.main.layanan.bphtb.form.persyaratan-verifikasi');
    }
    
    public function mount($id)
    {
        $bphtb = Crypt::decrypt($id);
        $this->model = Model::where('id_bphtb',$bphtb)->first();
        $model = Model::where('id_bphtb',$bphtb)->first();
        $this->id_bphtb = $model->id_bphtb;
        $this->listPersyaratanVerifikasi = Persyaratan::where('jenis_transaksi_id', $model->jenis_transaksi_id)
        ->where('jenis_persyaratan', 1)
        // ->orderBy('id','ASC')
        ->get();
        
        $this->listPersyaratanValidasi = Persyaratan::where('jenis_transaksi_id', $model->jenis_transaksi_id)
        ->where('jenis_persyaratan', 3)
        // ->orderBy('id','ASC')
        ->get();
    }
    
    public function updated($property, $value)
    {
        $bphtb = Model::where('id_bphtb', $this->id_bphtb)->first();
        if (!empty($property)) {
            if ($property === $property) {
                $this->validate([$property => 'file|mimes:pdf,jpg,jpeg,png,docx,doc,xls,xlsx|max:10000']);
                $tgl_masuk = Carbon::parse($bphtb->created_at);
                $year = $tgl_masuk->year;
                $month = $tgl_masuk->month;
                $day = $tgl_masuk->day;
                $folderPath = "uploads/layanan/bphtb/{$year}/{$month}/{$day}/{$bphtb->id_bphtb}";
                if (!file_exists(Storage::disk('public')->path($folderPath))) {
                    Storage::disk('public')->makeDirectory($folderPath, 0755, true);
                }
                $lampiran = Persyaratan::where('id_bphtb', $bphtb->id_bphtb)->where('nama_field', $property)->first();
                $uploadedFile = $value;
                $fileName = $uploadedFile->getClientOriginalName(); // Mengambil nama asli file yang diunggah
                $fileExtension = $uploadedFile->getClientOriginalExtension(); // Mengambil ekstensi file yang diunggah
                $newFileName = time() . '_' . $bphtb->id_bphtb . '_' . str_replace(' ','_',strtolower($property).'.'.$fileExtension); // Menyusun nama baru file
                $lampiran->file_dokumen = $value->storeAs($folderPath, $newFileName, 'public'); // Menyimpan file dengan nama baru
                $lampiran->update();
                $lampiran->file_dokumen = NULL;
            }
        }
    }
    
    
}

