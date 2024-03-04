<?php
namespace App\Livewire\Main;
use Livewire\Component;
use App\Models\RefSilinda as Model;
use App\Models\Transaksi\Komoditas;
use App\Models\Referensi\RefPasar;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

class IntegrasiProses extends Component
{
    use WithPagination,WithoutUrlPagination;
    use LivewireAlert;
    // TOKEN ACCESS API
    private $credentialId;
    private $credentialKey;
    private $urlTokenSPLP;
    private $baseURL;
    private $pathResource;
    private $pathResourceSend;
    private $allToken ;
    // END ACCESS API

    #[Layout('components.layouts.keenthemes.page')]
    public function mount()
    {
        $model = Model::where('is_active','=',1)->first();
        $this->credentialId = $model->credentialId;
        $this->credentialKey = $model->credentialKey;
        $this->urlTokenSPLP = $model->urlTokenSPLP;
        $this->baseURL = $model->baseURL;
        $this->pathResource = $model->pathResource;
        $this->pathResourceSend = $model->pathResourceSend;
    }
    
    public function render()
    {
        $pasarInt           = RefPasar::where('status_integrasi',1)->get();
        return view('livewire.main.integrasi.view',[
            'pasar' => $pasarInt,
        ]);
    }

    public function singkronisasi($id){
        $pasarInt   = RefPasar::where('id',$id)->first();
        $komoditas   = Komoditas::where('pasar_id',$id)->where('detail_tgl',date("Y-m-d"))->get();
       dd($komoditas);
    }
    
    // mendapatkan token SPLP
    // private function token_splp($credentialId, $credentialKey, $urlTokenSPLP)
    // {
    //     $ch = curl_init();

    //     curl_setopt($ch, CURLOPT_URL, $urlTokenSPLP);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //     curl_setopt($ch, CURLOPT_POST, 1);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials&scope=silinda_creator");

    //     $headers = array();
    //     $headers[] = 'Authorization: Basic NWEzSzNvTmZGcHdZal9VT0RRR091OFNZZFU0YTpyempwNWpBUGhXSEpOY2JkZkVDSFlZWUg1T1lh';
    //     $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     //ignore SSL
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //     curl_setopt($ch, CURLINFO_HEADER_OUT, 1);

    //     $result = curl_exec($ch);
    //     $result1 = json_decode($result);
    //     if (curl_errno($ch)) {
    //         echo 'Error:' . curl_error($ch);
    //     }
    //     curl_close($ch);
    //     // dd($result);

    //     $tokenResponse = $result1->access_token;
    //     return $tokenResponse;
    // }

    // function httpHeader($token)
    // {
    //     $headers = array(
    //         'Content-Type: application/json',
    //         'Authorization:'.$token,
    //         'Cookie: priangan_ses=a%3A5%3A%7Bs%3A10%3A%22session_id%22%3Bs%3A32%3A%223c42b07daa419f31433e7a39fa7b8be0%22%3Bs%3A10%3A%22ip_address%22%3Bs%3A14%3A%22103.170.104.48%22%3Bs%3A10%3A%22user_agent%22%3Bs%3A29%3A%22Synapse-PT-HttpComponents-NIO%22%3Bs%3A13%3A%22last_activity%22%3Bi%3A1697775983%3Bs%3A9%3A%22user_data%22%3Bs%3A0%3A%22%22%3B%7D78ddfc0eb4cb1af12e3b8894b97d13e0'
    //     );
    //     return $headers;
    // }

    // function httpHeaderSend($token)
    // {
    //     $headers = [
    //         'Authorization : ' . $token,
    //         'Content-Type:application/json',
    //         'Cookie: priangan_ses=a%3A5%3A%7Bs%3A10%3A%22session_id%22%3Bs%3A32%3A%225621aa3e66cf4220e54cda6d6bb24a69%22%3Bs%3A10%3A%22ip_address%22%3Bs%3A15%3A%22172.10.10.67%22%3Bs%3A10%3A%22user_agent%22%3Bs%3A29%3A%22Synapse-PT-HttpComponents-NIO%22%3Bs%3A13%3A%22last_activity%22%3Bi%3A1697095087%3Bs%3A9%3A%22user_data%22%3Bs%3A0%3A%22%22%3B%7D2696be34422c57f3fb81adcd0d980164'
    //     ];
    //     return $headers;
    // }

    // public function token_get(){
    //     $Token1                     = "Bearer " . $this->token_splp($this->credentialId,$this->credentialKey, $this->urlTokenSPLP);
    //     $data                       = Model::where('is_active','=',1)->first();
    //     $model                      = Model::firstOrNew(['id' =>  $data->id]);
    //     $model->token               = $Token1;
    //     $model->save();
    // }

}