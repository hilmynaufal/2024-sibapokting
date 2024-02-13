<?php

namespace App\Livewire\Main\Layanan\Bphtb\Detail;
use App\Models\Bphtb\PembayaranPajak as Model;
use App\Models\Bphtb\ObjekPajak;
use App\Models\Bphtb\PenerimaHak;
use App\Models\Bphtb\PelepasHak;
use App\Models\Bphtb\ObjekPajakVerifikasi;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Pembayaran extends Component
{
    public $pembayaran_pajak;
    public $objek_pajak;
    public $objek_pajak_verifikasi;
    public $selisih_pembayaran;
    public $id_bphtb;
    
    public function render()
    {
        return view('livewire.main.layanan.bphtb.detail.pembayaran');
    }
    
    public function mount($id)
    {
        $bphtb = Crypt::decrypt($id);
        $this->pembayaran_pajak = Model::where('id_bphtb',$bphtb)->first();
        $this->objek_pajak = ObjekPajak::where('id_bphtb',$bphtb)->first();
        $this->objek_pajak_verifikasi = ObjekPajakVerifikasi::where('id_bphtb',$bphtb)->first();
        $this->id_bphtb = $bphtb;
        if(!empty($this->objek_pajak_verifikasi)){
            $this->selisih_pembayaran =  $this->objek_pajak_verifikasi->nilai_bayar_bphtb - $this->objek_pajak->nilai_bayar_bphtb ;
        }
    }

    public function create()
    {
        $objek_pajak = ObjekPajak::where('id_bphtb',$this->id_bphtb)->first();
        $penerima_hak = PenerimaHak::where('id_bphtb',$this->id_bphtb)->first();
        $pelepas_hak = PelepasHak::where('id_bphtb',$this->id_bphtb)->first();
        
        $pembayaran = Model::updateOrCreate([
            'id_bphtb' => $this->id_bphtb,
        ], [
            'kode_bayar' => generateKodePembayaran(),
            'total_tagihan' => $objek_pajak->nilai_bayar_bphtb,
            ])->update([
                'created_id' => Auth::user()->id,
                'created_at' => now(),
                'updated_id' => Auth::user()->id,
                'updated_at' => now(),
                'id_bphtb' => $this->id_bphtb,
                'kode_bayar' => generateKodePembayaran(),
                'tanggal_tagihan' => now(),
                'status_tagihan' => 'Aktif',
                'batas_waktu_tagihan' => now()->addDays(7),
                'total_tagihan' => $objek_pajak->nilai_bayar_bphtb,
                'penerima_hak_id' => $penerima_hak->id,
                'pelepas_hak_id' => $pelepas_hak->id,
                'objek_pajak_id' => $objek_pajak->id,
                'no_registrasi' => generateKodeRegistrasi(),
                'tanggal_pendaftaran' => now(),
            ]);
            return redirect()->route('main.layanan.bphtb.detail',[Crypt::encrypt($this->id_bphtb)]);
        }

    
    public function recommendationForm()
    {
        $objek_pajak = ObjekPajak::where('id_bphtb', $this->id_bphtb)->first();
        
        if (!$objek_pajak) {
            // Handle jika objek pajak tidak ditemukan
            return redirect()->back()->with('error', 'Objek pajak tidak ditemukan.');
        }
        
        $verifikasi = ObjekPajakVerifikasi::firstOrNew(['id_bphtb' => $this->id_bphtb]);
        
        // Mengganti data verifikasi dengan data dari objek pajak
        $verifikasi->fill($objek_pajak->toArray());
        
        // Mengatur nilai created_id dan created_at
        $verifikasi->created_id = Auth::user()->id;
        $verifikasi->created_at = now();
        
        // Simpan data verifikasi
        $verifikasi->save();
        
        // Redirect ke halaman verifikasi objek pajak
        return redirect()->route('bphtb.verifikasi.objek.pajak', [Crypt::encrypt($this->id_bphtb)]);
    }
    
    
}

