<?php
use App\Models\RefMenu;
use App\Models\Role;
use App\Models\User;
use App\Models\MRole;
use App\Models\Status;
use App\Models\RefSetting;
use App\Models\Referensi\RefPasar;
use App\Models\Referensi\RefKomoditas;
use App\Models\Referensi\RefBarang;
use App\Models\Activity;
use App\Models\Transaksi\Komoditas;
use App\Models\Transaksi\Barang;
use App\Models\Bphtb\PembayaranPajak;
use App\Models\Bphtb\PembayaranPajakKurang;
use App\Models\Disposisi;
use App\Models\DisposisiMasuk;
use App\Models\Verifikasi;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\RefJabatan;
use App\Models\RefAksesMenu;
use App\Models\RefJenisSurat;
use App\Models\RefSifatSurat;
use Jenssegers\Agent\Agent;
use Ladumor\OneSignal\OneSignal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Auth;

function getAppName()
{
    $setting = RefSetting::where('is_active', '=', 1)->first();
    return $setting->name;
}

function getDescriptionName()
{
    $setting = RefSetting::where('is_active', '=', 1)->first();
    return $setting->description;
}

function getAppLogo()
{
    $setting = RefSetting::where('is_active', '=', 1)->first();
    return Storage::disk('public_local')->url($setting->logo_url);
}

function getAppFavicon()
{
    $setting = RefSetting::where('is_active', '=', 1)->first();
    return Storage::disk('public_local')->url($setting->favicon_url);
}

function getApp()
{
    $setting = RefSetting::where('is_active', '=', 1)->first();
    return $setting;
}
function statusActive($url,$uri){
    return $uri;
}
function menu($role)
{
    $menu = RefAksesMenu::with('menu')
    ->whereHas('menu', function ($query) {
        return $query->where([['parent_id', '=', 0], ['is_active', '=', 1], ['is_delete', '=', 0]]);
    })
    ->where('role_id', '=', $role)
    ->get()
    ->sortBy(function ($query) {
        return $query->menu->posisi;
    })
    ->all();
    
    return $menu;
}

function menuUtama()
{
    $menu = RefMenu::where([['parent_id', '=', 0], ['is_active', '=', 1], ['is_delete', '=', 0]])
    ->where('jenis_menu', 'Front')
    ->orderBy('posisi','asc')
    ->get();
    
    return $menu;
}


function menuChildUtama($parent)
{
    $child = RefMenu::where([['parent_id', '=', $parent], ['is_active', '=', 1], ['is_delete', '=', 0]])
    ->where('jenis_menu', 'Front')
    ->get();
    return $child;
}

function cekMenuChild($parent, $role)
{
    $cekchild = RefAksesMenu::whereHas('menu', function ($query) use ($parent) {
        return $query->where([['parent_id', '=', $parent], ['is_active', '=', 1], ['is_delete', '=', 0]]);
    })
    ->where('role_id', '=', $role)
    ->first();
    return $cekchild;
}

function cekChild($parent)
{
    $cekchild = RefMenu::where('parent_id', $parent)->first();
    return $cekchild;
}

function menuChild($parent, $role)
{
    $child = RefAksesMenu::whereHas('menu', function ($query) use ($parent) {
        return $query->where([['parent_id', '=', $parent], ['is_active', '=', 1], ['is_delete', '=', 0]]);
    })
    ->where('role_id', '=', $role)
    ->get()
    ->sortBy(function ($query) {
        return $query->menu->posisi;
    })
    ->all();
    return $child;
}

function MenuChildern($id)
{
    $model = RefMenu::select('id', 'menu', 'url', 'posisi', 'parent_id')
    ->where([['is_active', '=', 1], ['parent_id', '=', $id]]);
    if ($model->get()) {
        return $model;
    } else {
        return "";
    }
    // return $model;
}

function MenuChildernList($id)
{
    $model = RefMenu::select('id', 'menu', 'url', 'posisi', 'parent_id')
    ->where([['is_active', '=', 1], ['parent_id', '=', $id]])->get();
    return $model;
}

function setIconMenu($id){
    $menu = RefMenu::where('id', $id)->first();
    $class = 'ki-outline ';
    switch ($menu->type) {
        case 'module':
            $class .= 'ki-folder ';
            break;
            case 'controller':
                $class .= 'ki-tablet-text-down';
                break;
                case 'action':
                    $class .= 'ki-gear';
                    break;
                    default:
                    $class .= 'ki-abstract-30';
                    break;
                }
                return $class;
            }
            
            
            function getStatus($status)
            {
                if ($status == 1) {
                    $hasil = "Enable";
                } elseif ($status == 0) {
                    $hasil = "Disable";
                }
                return $hasil;
            }
            
            function getGender($status)
            {
                if ($status == 1) {
                    $hasil = "L";
                } elseif ($status == 0) {
                    $hasil = "P";
                }
                return $hasil;
            }
            
            function TglIndo($tgl)
            {
                $dt = new  \Carbon\Carbon($tgl);
                setlocale(LC_TIME, 'IND');
                $bulan = Bulan($tgl);
                $tgl = $dt->formatLocalized('%e');
                $tahun = $dt->formatLocalized('%Y');
                return $tgl . ' ' . $bulan . ' ' . $tahun;
            }

            function TglIndoBulan($tgl)
            {
                $dt = new  \Carbon\Carbon($tgl);
                setlocale(LC_TIME, 'IND');
                $bulan = BulanSingkat($tgl);
                $tgl = $dt->formatLocalized('%e');
                return $tgl . ' ' . $bulan;
            }
            
            function TglIndoHari($tgl)
            {
                setlocale(LC_TIME, 'IND');
                $dts = Carbon::parse($tgl)->locale('id'); // Mengatur format bahasa ke bahasa Indonesia
                $dt = new  \Carbon\Carbon($tgl);
                $hari = Hari($tgl);
                $bulan = Bulan($tgl);
                $tgl = $dt->formatLocalized('%e');
                $tahun = $dt->formatLocalized('%Y');
                return $hari . ', ' . $tgl . ' ' . $bulan . ' ' . $tahun;
            }
            function TglIndoTahun($tgl)
            {
                $dt = new  \Carbon\Carbon($tgl);
                setlocale(LC_TIME, 'IND');
                $bulan = Bulan($tgl);
                $tgl = $dt->formatLocalized('%e');
                $tahun = $dt->formatLocalized('%Y');
                return $tahun;
            }
            function TglTimeIndo($tgl)
            {
                setlocale(LC_TIME, 'IND');
                $dts = Carbon::parse($tgl)->locale('id'); // Mengatur format bahasa ke bahasa Indonesia
                $dt = new  \Carbon\Carbon($tgl);
                $hari = Hari($tgl);
                $bulan = Bulan($tgl);
                $tgl = $dt->formatLocalized('%e');
                $tahun = $dt->formatLocalized('%Y');
                return $hari . ', ' . $tgl . ' ' . $bulan . ' ' . $tahun .  ' - ' . $dt->format('H:i');;
            }
            
            
            function rupiah($angka, $koma)
            {
                $hasil_rupiah = "Rp " . number_format($angka, $koma, ',', '.');
                return $hasil_rupiah;
            }
            
            function nilai($angka, $koma)
            {
                $hasil_rupiah = number_format($angka, $koma, ',', '.');
                return $hasil_rupiah;
            }
            
            function Hari($tgl)
            {
                $dt = new \Carbon\Carbon($tgl);
                // setlocale(LC_TIME, 'IND');
                $hariInggris = $dt->format('l');
                
                $hariIndonesia = [
                    'Monday' => "Senin",
                    'Tuesday' => "Selasa",
                    'Wednesday' => "Rabu",
                    'Thursday' => "Kamis",
                    'Friday' => "Jum'at",
                    'Saturday' => "Sabtu",
                    'Sunday' => "Minggu"
                ];
                
                // Cek apakah hari dalam bahasa Inggris ada dalam array, jika tidak, kembalikan "Senin" sebagai nilai default
                return isset($hariIndonesia[$hariInggris]) ? $hariIndonesia[$hariInggris] : "Senin";
            }
            
            
            function StatusSurat($id)
            {
                $statusSurat = [
                    0 => "Draft",
                    1 => "Proses TTE",
                    2 => "Terkirim/Selesai",
                    3 => "Perbaikan",
                    4 => "di Tolak",
                    5 => "di Hapus",
                    6 => "di Baca"
                ];
                
                // Cek apakah $id terdapat dalam array, jika tidak, kembalikan "Draft" sebagai nilai default
                return isset($statusSurat[$id]) ? $statusSurat[$id] : "Draft";
            }
            
            function TglStandar($tgl)
            {
                $dt = new  \Carbon\Carbon($tgl);
                // setlocale(LC_TIME, 'IND');
                return $dt->format('Y-m-d');
            }
            
            function Bulan($tgl)
            {
                $dt = new \Carbon\Carbon($tgl);
                setlocale(LC_TIME, 'IND');
                
                // Ambil bulan dalam bentuk angka
                $bulan = $dt->formatLocalized('%m');
                
                // Array untuk menyimpan nama bulan
                $bulanNames = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];
                
                // Ambil nama bulan dari array
                $bulan = isset($bulanNames[$bulan - 1]) ? $bulanNames[$bulan - 1] : 'Januari';
                
                return $bulan;
            }

            function BulanSingkat($tgl)
            {
                $dt = new \Carbon\Carbon($tgl);
                setlocale(LC_TIME, 'IND');
                
                // Ambil bulan dalam bentuk angka
                $bulan = $dt->formatLocalized('%m');
                
                // Array untuk menyimpan nama bulan
                $bulanNames = [
                    'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                    'Jul', 'Agus', 'Sept', 'Okt', 'Nov', 'Des'
                ];
                
                // Ambil nama bulan dari array
                $bulan = isset($bulanNames[$bulan - 1]) ? $bulanNames[$bulan - 1] : 'Januari';
                
                return $bulan;
            }
            
            
            function BulanAngka($tgl)
            {
                $dt = new  \Carbon\Carbon($tgl);
                setlocale(LC_TIME, 'IND');
                
                $bulan = $dt->formatLocalized('%m');
                return $bulan;
            }
            
            
            function Tanggal($tgl = null)
            {
                // Pastikan $tgl tidak null dan valid
                if ($tgl === null) {
                    return "";
                }
                
                // Array untuk menyimpan nama tanggal
                $tanggalNames = [
                    'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh',
                    'Sebelas', 'Dua Belas', 'Tiga Belas', 'Empat Belas', 'Lima Belas', 'Enam Belas', 'Tujuh Belas',
                    'Delapan Belas', 'Sembilan Belas', 'Dua Puluh', 'Dua Puluh Satu', 'Dua Puluh Dua', 'Dua Puluh Tiga',
                    'Dua Puluh Empat', 'Dua Puluh Lima', 'Dua Puluh Enam', 'Dua Puluh Tujuh', 'Dua Puluh Delapan',
                    'Dua Puluh Sembilan', 'Tiga Puluh', 'Tiga Puluh Satu'
                ];
                
                $dt = new \Carbon\Carbon($tgl);
                setlocale(LC_TIME, 'IND');
                
                // Ambil tanggal dalam bentuk angka
                $day = $dt->formatLocalized('%e');
                
                // Ambil nama tanggal dari array
                $tanggal = isset($tanggalNames[$day - 1]) ? $tanggalNames[$day - 1] : "Satu";
                
                return $tanggal;
            }
            
            
            function Penyebut($nilai)
            {
                if(!empty($nilai) || intval($nilai)){
                    $nilai = abs($nilai);
                    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
                    $temp = "";
                    if ($nilai < 12) {
                        $temp = " " . $huruf[$nilai];
                    } elseif ($nilai < 20) {
                        $temp = Penyebut($nilai - 10) . " belas";
                    } elseif ($nilai < 100) {
                        $temp = Penyebut($nilai / 10) . " puluh" . Penyebut($nilai % 10);
                    } elseif ($nilai < 200) {
                        $temp = " seratus" . Penyebut($nilai - 100);
                    } elseif ($nilai < 1000) {
                        $temp = Penyebut($nilai / 100) . " ratus" . Penyebut($nilai % 100);
                    } elseif ($nilai < 2000) {
                        $temp = " seribu" . Penyebut($nilai - 1000);
                    } elseif ($nilai < 1000000) {
                        $temp = Penyebut($nilai / 1000) . " ribu" . Penyebut($nilai % 1000);
                    } elseif ($nilai < 1000000000) {
                        $temp = Penyebut($nilai / 1000000) . " juta" . Penyebut($nilai % 1000000);
                    } elseif ($nilai < 1000000000000) {
                        $temp = Penyebut($nilai / 1000000000) . " milyar" . Penyebut(fmod($nilai, 1000000000));
                    } elseif ($nilai < 1000000000000000) {
                        $temp = Penyebut($nilai / 1000000000000) . " trilyun" . Penyebut(fmod($nilai, 1000000000000));
                    }
                    return $temp;
                }else{
                    return "";
                }
            }
            
            function Terbilang($nilai)
            {
                if ($nilai < 0) {
                    $hasil = "minus " . trim(Penyebut($nilai));
                } else {
                    $hasil = trim(Penyebut($nilai));
                }
                return $hasil . " Rupiah";
            }
            
            function TerbilangTahun($date)
            {
                $dt = new  \Carbon\Carbon($tgl);
                setlocale(LC_TIME, 'IND');
                
                $tahun =  $dt->formatLocalized('%Y');
                if ($tahun < 0) {
                    $hasil = "minus " . trim(Penyebut($tahun));
                } else {
                    $hasil = trim(Penyebut($tahun));
                }
                return $hasil;
            }
            
            function convertdate()
            {
                date_default_timezone_set('Asia/Jakarta');
                $date = date('dmy');
                return $date;
            }
            
            function getAkses($role)
            {
                $model = MRole::where('id', '=', $role)->first();
                
                if ($model->akses_all == 1) {
                    $hasil = "enable";
                } else {
                    $hasil = 'disable';
                }
                
                return $hasil;
            }
            
            function get_ip()
            {
                $keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
                
                foreach ($keys as $key) {
                    if (array_key_exists($key, $_SERVER) === true) {
                        foreach (explode(',', $_SERVER[$key]) as $ip) {
                            if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                                return $ip;
                            }
                        }
                    }
                }
            }
            
            function setTahun()
            {
                return session('database');
            }
            
            function setEnv($key, $value)
            {
                file_put_contents(base_path() . '/.env', str_replace(
                    $key . '=' . env($value),
                    $key . '=' . $value,
                    file_get_contents(base_path() . '/.env')
                ));
            }
            
            function changeEnv($data = array())
            {
                if (count($data) > 0) {
                    
                    // Read .env-file
                    $env = file_get_contents(base_path() . '/.env');
                    
                    // Split string on every " " and write into array
                    $env = preg_split('/\s+/', $env);;
                    
                    // Loop through given data
                    foreach ((array)$data as $key => $value) {
                        
                        // Loop through .env-data
                        foreach ($env as $env_key => $env_value) {
                            
                            // Turn the value into an array and stop after the first split
                            // So it's not possible to split e.g. the App-Key by accident
                            $entry = explode("=", $env_value, 2);
                            
                            // Check, if new key fits the actual .env-key
                            if ($entry[0] == $key) {
                                // If yes, overwrite it with the new one
                                $env[$env_key] = $key . "=" . $value;
                            } else {
                                // If not, keep the old one
                                $env[$env_key] = $env_value;
                            }
                        }
                    }
                    
                    // Turn the array back to an String
                    $env = implode("\n", $env);
                    
                    // And overwrite the .env with the new data
                    file_put_contents(base_path() . '/.env', $env);
                    
                    return true;
                } else {
                    return false;
                }
            }
            
            function findRole($id)
            {
                $data = Role::where('id', $id)->first();
                return $data == null ? "-" : $data->nm_role;
            }
            
            function cleanUpOldUploads()
            {
                $storage = Storage::disk('local');
                foreach ($storage->allFiles('livewire-tmp') as $filePathname) {
                    $yesterdaysStamp = now()->subSeconds(4)->timestamp;
                    if ($yesterdaysStamp > $storage->lastModified($filePathname)) {
                        $storage->delete($filePathname);
                    }
                }
            }
            
            function countUsia($tanggal)
            {
                $dateOfBirth = $tanggal;
                $today = date("Y-m-d");
                $diff = date_diff(date_create($dateOfBirth), date_create($today));
                return $diff->format('%y tahun %m bulan %d hari');
            }
            
            function generateKode($length = 20)
            {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomString;
            }
            
            function countJarak($lat1, $lon1, $lat2, $lon2, $type)
            {
                $theta = $lon1 - $lon2;
                $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
                $miles = acos($miles);
                $miles = rad2deg($miles);
                $miles = $miles * 60 * 1.1515;
                $feet = $miles * 5280;
                $yards = $feet / 3;
                $kilometers = $miles * 1.609344;
                $meters = $kilometers * 1000;
                if ($type == 1) {
                    return number_format(round($meters)) . " meter. / " . round($kilometers, 2) . " km.";
                } elseif ($type == 2) {
                    return number_format(round($meters));
                } elseif ($type == 3) {
                    return round($meters);
                }
            }
            
            
            function getReferensi($id)
            {
                $menu = Status::where('type', $id)->orderBy('code', 'asc')->get();
                return $menu;
            }
            
            function findReferensi($type, $status)
            {
                if ($status == 6) {
                    if ($type == 1) {
                        return "Sudah di Verifikasi";
                    } elseif ($type == 2) {
                        return "Data Tidak Sesuai";
                    } else {
                        return "Dalam Proses";
                    }
                } elseif ($status == 7) {
                    if ($type == 1) {
                        return "Berkas Lengkap & Valid";
                    } elseif ($type == 2) {
                        return "Berkas Tidak Lengkap";
                    } else {
                        return "Dalam Proses";
                    }
                } elseif ($status == 8) {
                    if ($type == 1) {
                        return "Diterima";
                    } elseif ($type == 2) {
                        return "Disalurkan";
                    } else {
                        return "Dalam Proses";
                    }
                }
            }
            
            function countProgressRegistrasi($status)
            {
                if ($status == 0) {
                    return "25";
                } elseif ($status == 1) {
                    return "50";
                } elseif ($status == 2) {
                    return "75";
                } elseif ($status == 3) {
                    return "100";
                }
            }
            
            function setColor($status)
            {
                if ($status == 0) {
                    return "success";
                } elseif ($status == 1) {
                    return "primary";
                } elseif ($status == 2) {
                    return "danger";
                } elseif ($status == 3) {
                    return "info";
                }
            }
            
            function setIcon($status, $type)
            {
                if ($type == 1) {
                    if ($status == 0) {
                        return "la-clock";
                    } elseif ($status == 1) {
                        return "la-check-circle";
                    } elseif ($status == 2) {
                        return "la-times-circle";
                    }
                } elseif ($type == 2) {
                    if ($status == 0) {
                        return "la-clock";
                    } elseif ($status == 1) {
                        return "la-user-check";
                    } elseif ($status == 2) {
                        return "la-user-times";
                    }
                } elseif ($type == 3) {
                    if ($status == 0) {
                        return "las la-clock";
                    } elseif ($status == 1) {
                        return "las la-clipboard-check";
                    } elseif ($status == 2) {
                        return "las la-file-excel";
                    }
                }
            }
            
            function registerDevice()
            {
                $agent = new Agent();
                $device = $agent->device();
                $platform = $agent->platform();
                $browser = $agent->browser();
                $platform_version = $agent->version($platform);
                $browser_version = $agent->version($browser);
                
                // 0 = iOS
                // 1 = Android
                // 2 = Amazon
                // 3 = WindowsPhone (MPNS)
                // 4 = Chrome Apps / Extensions
                // 5 = Chrome Web Push
                // 6 = Windows (WNS)
                // 7 = Safari
                // 8 = Firefox
                // 9 = MacOS
                // 10 = Alexa
                // 11 = Email
                // 13 = Huawei App Gallery Builds. Not for Huawei Devices using FCM
                // 14 = SMS
                
                $fields = [
                    'device_type'  => 5,
                    'identifier'   => Auth::user()->name,
                    'timezone'     => '-28800',
                    'game_version' => '1.1',
                    'device_os'    => $platform_version,
                    'test_type'    => 1,
                    'device_model' => $platform,
                    'tags'         => array("level" => Auth::user()->role_id)
                ];
                
                $device = OneSignal::addDevice($fields);
                
                $data = User::where('status', 1)->where('username', Auth::user()->username)->first();
                //$data->device_id = $device['id'];
                $data->update();
                
                OneSignal::updateDevice($fields, $data->device_id);
                return false;
            }
            
            function notificationPage($text)
            {
                return '
                <div class="col-md-12 pb-5">
                <div class="d-flex flex-stack item-border-hover mb-3 alert alert-danger">
                <div class="d-flex align-items-center">
                <div class="symbol symbol-40px symbol-circle me-4">
                <span class="symbol-label bg-light-danger">
                <span class="svg-icon svg-icon-1 svg-icon-danger">
                <i class="las la-info fs-2x text-dark"></i>
                </span>
                </span>
                </div>
                <div class="ps-1 mb-1">
                <span class="fs-5 text-gray-800 text-hover-danger fw-boldest">' . $text . '</span>
                </div>
                </div>
                </div>
                </div>
                ';
            }
            
            function setActivity($description)
            {
                $model = new Activity([
                    'subject_id' => Auth::user()->id,
                    'causer_id' => Auth::user()->id,
                    'username' => Auth::user()->username,
                    'fullname' => Auth::user()->nama,
                    'description' => $description,
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'device' => request()->userAgent(),
                    'url' => Request::url(),
                ]);
                $model->save();
            }
            
            
            function getLink($url)
            {
                $context = stream_context_create(array(
                    "http" => array(
                        "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
                        )
                    ));
                    
                    try {
                        $html = file_get_contents($url, false, $context);
                        
                        if ($html === false) {
                            throw new Exception('Failed to retrieve the content from the URL.');
                        }
                        
                        $pattern = '/<a href="(.*?)"/';
                        if (preg_match($pattern, $html, $matches)) {
                            $url_original = $matches[1];
                            return $url_original;
                        } else {
                            throw new Exception('Pattern match failed.');
                        }
                    } catch (Exception $e) {
                        // Tangani error exception
                        // echo 'Error: ' . $e->getMessage();
                        return NULL;
                    }
                }
                
                
                function getImage($url)
                {
                    $context = stream_context_create(array(
                        "http" => array(
                            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
                            )
                        ));
                        try {
                            $html = file_get_contents($url, false, $context);
                            if ($html === false) {
                                throw new Exception('Failed to retrieve the content from the URL.');
                            }
                            $pattern = '/<meta property="og:image" content="(.*?)"/';
                            if (preg_match($pattern, $html, $matches)) {
                                $image_original = isset($matches[1]) ? $matches[1] : null;
                                return $image_original;
                            } else {
                                throw new Exception('Pattern match failed.');
                            }
                        } catch (Exception $e) {
                            // echo 'Error: ' . $e->getMessage();
                            return NULL;
                        }
                    }
                    
                    function getTitle($url)
                    {
                        $context = stream_context_create(array(
                            "http" => array(
                                "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
                                )
                            ));
                            try {
                                $html = file_get_contents($url, false, $context);
                                if ($html === false) {
                                    throw new Exception('Failed to retrieve the content from the URL.');
                                }
                                $pattern = '/<meta property="og:title" content="(.*?)"/';
                                if (preg_match($pattern, $html, $matches)) {
                                    $image_original = isset($matches[1]) ? $matches[1] : null;
                                    return $image_original;
                                } else {
                                    throw new Exception('Pattern match failed.');
                                }
                            } catch (Exception $e) {
                                // echo 'Error: ' . $e->getMessage();
                                return NULL;
                            }
                        }
                        
                        
                        function removeKeywords($title)
                        {
                            $pattern = '/\s[-…]+.*/u';
                            $filteredTitle = preg_replace($pattern, '', $title);
                            return $filteredTitle;
                        }
                        
                        function filterBerita($judulBerita, $keyword_filter)
                        {
                            $kataKunci = explode(",", $keyword_filter);
                            // $kataKunci = array("purwakarta", "aldi taher", "sandiaga","hengky");
                            foreach ($kataKunci as $kata) {
                                if (stripos(strtolower($judulBerita), strtolower($kata)) !== false) {
                                    return true;
                                }
                            }
                            
                            return false;
                        }
                        
                        function hapusKataKanan($teks)
                        {
                            $posisiSimbol = strpos($teks, "-");
                            
                            if ($posisiSimbol !== false) {
                                $teksBaru = substr($teks, 0, $posisiSimbol);
                                $teksBaru = rtrim($teksBaru);
                                return $teksBaru;
                            }
                            
                            return $teks;
                        }
                        
                        function humanFileSize($size)
                        {
                            if ($size >= 1073741824) {
                                $fileSize = round($size / 1024 / 1024 / 1024, 1) . 'GB';
                            } elseif ($size >= 1048576) {
                                $fileSize = round($size / 1024 / 1024, 1) . 'MB';
                            } elseif ($size >= 1024) {
                                $fileSize = round($size / 1024, 1) . 'KB';
                            } else {
                                $fileSize = $size . ' bytes';
                            }
                            return $fileSize;
                        }
                        
                        function StatusResponse($id)
                        {
                            
                            switch ($id) {
                                case 0:
                                    $id = "Belum di Response";
                                    break;
                                    case 1:
                                        $id = "Sudah di Baca";
                                        break;
                                        case 2:
                                            $id = "Sudah di Response";
                                            break;
                                            default:
                                            $id = "Draft";
                                            break;
                                        }
                                        return  $id;
                                    }
                                    
                                    function getPegawai($id)
                                    {
                                        $data = User::where('id', $id)->first();
                                        return $data;
                                    }
                                    
                                    function KirimPesan($no_tlp, $pesan)
                                    {
                                        $token = 'm7RXOHo7gpMBGijTW2HIxhRBc6be9PwxjCB6szmgFkGcFAN5O2WDdXErx5cN2hlz';
                                        return Curl::to('https://jogja.wablas.com/api/send-message')
                                        ->withHeader('Authorization: ' . $token . '')
                                        ->withData(array('phone' => $no_tlp, 'message' => $pesan))
                                        ->asJson()
                                        ->post();
                                    }
                                    
                                    function getDemo()
                                    {
                                        $setting = RefSetting::first();
                                        return $setting;
                                    }
                                    
                                    function validateDate($date, $format = 'Y-m-d')
                                    {
                                        $d = \DateTime::createFromFormat($format, $date);
                                        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
                                        ($d && $d->format($format) === $date) ? $date : NULL;
                                    }
                                    
                                    function getSetting()
                                    {
                                        
                                        $setting = DB::table('ref_setting')
                                        ->select('ref_setting.*')
                                        ->first();
                                        return $setting;
                                    }
                                    
                                    function getAvatar()
                                    {
                                        $setting = User::where('id', '=', Auth::user()->id)->first();
                                        return Storage::disk('public_local')->url($setting->avatar_url);
                                    }
                                    
                                    function getLampiran($id)
                                    {   
                                        $data = DB::table('t_lampiran')
                                        ->where('surat_id_token', '=', $id)
                                        ->select('*')
                                        ->get();
                                        return $data;
                                    }   
                                    
                                    function getLampiranLaporanDisposisi($id)
                                    {   
                                        $data = DB::table('t_lampiran_detail_laporan')
                                        ->where('disposisi_detail_laporan_id', '=', $id)
                                        ->select('*')
                                        ->get();
                                        return $data;
                                    }                           
                                    
                                    function getTotalStatistik($type,$label,$status,$id)
                                    {   
                                        $user = User::where('id',$id)->first();
                                        if($user->role_id==7){
                                            $jabatan = $user->id;
                                            $cari_jabatan = 'jabatan_penerima_id';
                                        }else{
                                            if($user->status_login==1){
                                                $jabatan = $user->jabatan_id;
                                            }else{
                                                $jabatan = $user->jabatan_pembantu_id;
                                            }
                                            $cari_jabatan = 'jabatan_penerima_token';
                                        }
                                        
                                        // dd($jabatan);
                                        if($type == "Surat Masuk") {
                                            $data = DB::table('t_verifikasi')
                                            ->where($cari_jabatan, '=', $jabatan)
                                            ->where('tipe', 1)
                                            ->where($label, '=', $status)
                                            ->count();
                                        }elseif($type=="Surat Keluar"){
                                            $data = DB::table('t_verifikasi')
                                            ->where('tipe', 2)
                                            ->where($cari_jabatan, '=', $jabatan)
                                            ->where($label, '=', $status)
                                            ->count();
                                        }elseif($type=="Disposisi Masuk"){
                                            $data = DB::table('t_disposisi_detail')
                                            // ->where('tipe', 1)
                                            ->where($cari_jabatan, '=', $jabatan)
                                            ->where($label, '=', $status)
                                            ->count();
                                        }elseif($type=="Disposisi Keluar"){
                                            // $data = DB::table('t_disposisi_detail')
                                            // // ->where('tipe', 2)
                                            // ->where('jabatan_pengirim_token', '=', $jabatan)
                                            // ->where($label, '=', $status)
                                            // ->count();
                                            $data = DB::table('t_disposisi')
                                            ->where('is_view', 0)
                                            ->where('jabatan_id_token', '=', $jabatan)
                                            ->count();
                                        }else{
                                            $data = 0;
                                        }
                                        return number_format($data);
                                    }             
                                    
                                    
                                    function setVerifikasiSurat($pengirim_user_id,$surat_id_token,$pegawai_id,$deskripsi,$disposisi_id_token,$status,$tipe,$jabatan_id)
                                    {
                                        // dd($jabatan_id);
                                        $surat = SuratKeluar::where('token', '=', $surat_id_token)->first();
                                        $disposisi = Disposisi::where('token', '=', $disposisi_id_token)->where('tipe',$tipe)->first();
                                        $pengirim = User::where('id', '=', $pengirim_user_id)->first();
                                        $penerima_tujuan = User::where('id', '=', $pegawai_id)->first();
                                        $jabatan_tujuan = RefJabatan::where('token', '=', $jabatan_id)->first();
                                        // $urutan = DisposisiMasuk::where('surat_id', '=', $surat->id)->where('tipe',$tipe)->count() + 1;
                                        $urutan = DisposisiMasuk::where('surat_id', '=', $surat->id)->count() + 1;
                                        
                                        $attributes = [
                                            'surat_id' => $surat->id,
                                            'surat_id_token' => $surat_id_token,
                                            'jabatan_penerima_token' => $jabatan_tujuan->token,
                                        ];
                                        
                                        $values = [
                                            // 'disposisi_id' => $disposisi->id,
                                            'deskripsi' => $deskripsi,
                                            'create_id' => $pengirim->id,
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'is_direct' => $status,
                                            'is_active' => 1,
                                            'is_status' => 0,
                                            'is_view' => 0,
                                            'is_read' => 0,
                                            'is_response' => 0,
                                            'is_disposisi' => 0,
                                            'tipe' => $tipe,
                                            'urutan' => $urutan,
                                            'jabatan_penerima_id' => $penerima_tujuan->id,
                                            'jabatan_penerima_token' => $jabatan_tujuan->token,
                                            'jabatan_penerima_nama' => $penerima_tujuan->nama,
                                            'jabatan_penerima_posisi' => $jabatan_tujuan->jabatan,
                                            // 'jabatan_pengirim_id' => $pengirim->id,
                                            // 'jabatan_pengirim_token' => getJabatanCheck($pengirim->id,"ID"),
                                            // 'jabatan_pengirim_nama' => $pengirim->nama,
                                            // 'jabatan_pengirim_posisi' => getJabatanCheck($pengirim->id,"POSISI"),
                                            'jabatan_level' => $jabatan_tujuan->level_jabatan,
                                            'jabatan_penerima_atasan_id' => $jabatan_tujuan->atasan_id,
                                        ];
                                        
                                        $cek = Verifikasi::firstOrCreate($attributes, $values);
                                        // dd($cek);
                                    }                         
                                    
                                    
                                    function setVerifikasi($pengirim_user_id,$surat_id_token,$penerima_tujuan_id,$penerima_jabatan_id,$deskripsi,$status,$tipe)
                                    {
                                        // dd($pengirim_user_id,$surat_id_token,$penerima_tujuan_id,$penerima_jabatan_id,$deskripsi,$status,$tipe);
                                        
                                        $pengirim = User::where('id', '=', $pengirim_user_id)->first();
                                        $penerima_tujuan = User::where('id', '=', $penerima_tujuan_id)->first();
                                        $jabatan = RefJabatan::where('token', '=', $penerima_jabatan_id)->first();
                                        
                                        // dd($penerima_tujuan);
                                        
                                        if($tipe==1){
                                            $surat = SuratMasuk::where('token', '=', $surat_id_token)->first();
                                            $attributes = [
                                                'surat_id' => $surat->id,
                                                'surat_id_token' => $surat_id_token,
                                                'jabatan_id_token' => $penerima_tujuan->token,
                                            ];
                                        }else{
                                            $surat = SuratKeluar::where('token', '=', $surat_id_token)->first();
                                            $attributes = [
                                                'surat_id' => $surat->id,
                                                'surat_id_token' => $surat_id_token,
                                                'jabatan_penerima_token' => $jabatan->token,
                                            ];
                                        }
                                        
                                        $values = [
                                            'deskripsi' => $deskripsi,
                                            'create_id' => $pengirim->id,
                                            'created_at' => date('Y-m-d H:i:s'),
                                            'tipe' => $tipe,
                                            'is_direct' => $status,
                                            'is_approve' => 0,
                                            'is_status' => 0,
                                            'is_view' => 0,
                                            'is_read' => 0,
                                            'is_response' => 0,
                                            'is_active' => 1,
                                            'jabatan_penerima_id' => $penerima_tujuan->id,
                                            'jabatan_penerima_token' => $jabatan->token,
                                            'jabatan_penerima_nama' => $penerima_tujuan->nama,
                                            'jabatan_penerima_posisi' => $jabatan->jabatan,
                                            // 'jabatan_pengirim_id' => $pengirim->id,
                                            // 'jabatan_pengirim_token' => $pengirim->jabatan_id,
                                            // 'jabatan_pengirim_nama' => $pengirim->nama,
                                            // 'jabatan_pengirim_posisi' => $pengirim->jabatan,
                                        ];
                                        $data = Verifikasi::updateOrInsert($attributes, $values);
                                        // $data = Verifikasi::firstOrCreate($attributes, $values);
                                        // dd($data);
                                    }     
                                    
                                    
                                    function setVerifikasiLog($suratid,$jabatanid,$deskripsi)
                                    {
                                        $model = new Activity([
                                            'log_name' => "Surat Masuk",
                                            'subject_type' => $jabatanid,
                                            'subject_id' => $suratid,
                                            'causer_id' => Auth::user()->id,
                                            'username' => Auth::user()->username,
                                            'fullname' => Auth::user()->nama,
                                            'description' => $deskripsi,
                                            'ip_address' => $_SERVER['REMOTE_ADDR'],
                                            'device' => request()->userAgent(),
                                            'url' => Request::url(),
                                        ]);
                                        $model->save();
                                    }
                                    
                                    function getVerifikasi($id,$type,$jenis)
                                    {   
                                        // dd($id);
                                        if($type==1){
                                            $data = DB::table('t_verifikasi')
                                            ->where('surat_id_token', '=', $id)
                                            ->where('tipe', $jenis)
                                            ->select('*')
                                            ->orderBy('id','ASC')
                                            ->get();
                                            
                                        }elseif($type==2){
                                            $data = DB::table('t_disposisi_detail')
                                            ->select('*')
                                            ->where('surat_id_token', '=', $id)
                                            ->where('tipe', $jenis)
                                            ->orderBy('urutan','ASC')
                                            ->get();
                                        }elseif($type==3){
                                            $data = DB::table('t_disposisi_detail')
                                            ->select('*')
                                            ->where('surat_id_token', '=', $id)
                                            // ->where('tipe', $jenis)
                                            ->orderBy('urutan','ASC')
                                            ->get();
                                        }elseif($type==4){
                                            $data = DB::table('t_verifikasi')
                                            ->select('*')
                                            ->where('surat_id_token', '=', $id)
                                            // ->where('tipe', $jenis)
                                            ->orderBy('id','ASC')
                                            ->get();
                                        }elseif($type==5){
                                            $datas = DB::table('t_disposisi_detail')
                                            ->select(DB::raw('MIN(jabatan_penerima_atasan_id) as parent_id'))
                                            ->where('surat_id_token', '=', $id)
                                            ->get();
                                            $data = $datas[0]->parent_id;
                                            
                                        }
                                        return $data;
                                    }
                                    
                                    function getLaporanDisposisi($id,$type)
                                    {   
                                        $data = DB::table('t_disposisi_detail_laporan')
                                        ->where('surat_id', '=', $id)
                                        ->select('*')
                                        ->orderBy('id','ASC')
                                        ->get();
                                        return $data;
                                    }
                                    
                                    function setDisposisi($pengirim_user_id,$surat_id_token,$pegawai_id,$deskripsi,$disposisi_id_token,$status,$tipe,$jabatan_id)
                                    {
                                        // dd($jabatan_id);
                                        $surat = SuratMasuk::where('token', '=', $surat_id_token)->first();
                                        $disposisi = Disposisi::where('token', '=', $disposisi_id_token)->where('tipe',$tipe)->first();
                                        $pengirim = User::where('id', '=', $pengirim_user_id)->first();
                                        $penerima_tujuan = User::where('id', '=', $pegawai_id)->first();
                                        // $jabatan_tujuan = RefJabatan::where('token', '=', $penerima_tujuan->jabatan_id)->first();
                                        $jabatan_tujuan = RefJabatan::where('token', '=', $jabatan_id)->first();
                                        // if($jabatan_tujuan->jabatan=="Sekretaris Perusahaan"){
                                            //     dd($jabatan_tujuan);
                                            // }
                                            // if($jabatan_tujuan->id=="15"){
                                                //     dd($jabatan_tujuan);
                                                // }
                                                // $urutan = DisposisiMasuk::where('surat_id', '=', $surat->id)->where('tipe',$tipe)->count() + 1;
                                                $urutan = DisposisiMasuk::where('surat_id', '=', $surat->id)->count() + 1;
                                                
                                                $attributes = [
                                                    'surat_id' => $surat->id,
                                                    'surat_id_token' => $surat_id_token,
                                                    'jabatan_penerima_token' => $jabatan_tujuan->token,
                                                ];
                                                
                                                $values = [
                                                    'disposisi_id' => $disposisi->id,
                                                    'deskripsi' => $deskripsi,
                                                    'create_id' => $pengirim->id,
                                                    'created_at' => date('Y-m-d H:i:s'),
                                                    'is_direct' => $status,
                                                    'is_active' => 1,
                                                    'is_status' => 0,
                                                    'is_view' => 0,
                                                    'is_read' => 0,
                                                    'is_response' => 0,
                                                    'is_disposisi' => 0,
                                                    'tipe' => $tipe,
                                                    'urutan' => $urutan,
                                                    'jabatan_penerima_id' => $penerima_tujuan->id,
                                                    'jabatan_penerima_token' => $jabatan_tujuan->token,
                                                    'jabatan_penerima_nama' => $penerima_tujuan->nama,
                                                    'jabatan_penerima_posisi' => $jabatan_tujuan->jabatan,
                                                    'jabatan_pengirim_id' => $pengirim->id,
                                                    'jabatan_pengirim_token' => getJabatanCheck($pengirim->id,"ID"),
                                                    'jabatan_pengirim_nama' => $pengirim->nama,
                                                    'jabatan_pengirim_posisi' => getJabatanCheck($pengirim->id,"POSISI"),
                                                    'jabatan_level' => $jabatan_tujuan->level_jabatan,
                                                    'jabatan_penerima_jabatan_id' => $jabatan_tujuan->id,
                                                    'jabatan_penerima_atasan_id' => $jabatan_tujuan->atasan_id,
                                                    'jabatan_penerima_atasan_id_token' => $jabatan_tujuan->atasan_id_token,
                                                ];
                                                
                                                DisposisiMasuk::firstOrCreate($attributes, $values);
                                            }   
                                            
                                            function generateDisposisiNumber()
                                            {
                                                $month = now()->format('M');
                                                $monthMappings = [
                                                    'JAN' => 'JAN',
                                                    'FEB' => 'FEB',
                                                    'MAR' => 'MAR',
                                                    'APR' => 'APR',
                                                    'MAY' => 'MEI',
                                                    'JUN' => 'JUN',
                                                    'JUL' => 'JUL',
                                                    'AUG' => 'AGTS',
                                                    'SEP' => 'SEP',
                                                    'OCT' => 'OKT',
                                                    'NOV' => 'NOP',
                                                    'DEC' => 'DES'
                                                ];
                                                
                                                $month = $monthMappings[$month] ?? $month; // Gun
                                                $year = now()->format('Y');
                                                
                                                $latestDisposisi = DB::table('t_disposisi')
                                                ->whereYear('created_at', $year)
                                                // ->latest('id')
                                                ->count();
                                                
                                                $sequenceNumber = $latestDisposisi ? ($latestDisposisi + 1) : 1;
                                                
                                                return strtoupper("{$sequenceNumber}/DISP/{$month}/{$year}");
                                            }
                                            
                                            function generateArsipMasukNumber($id)
                                            {
                                                $reset = false;
                                                $month = now()->format('M');
                                                $monthMappings = [
                                                    'Jan' => 'JAN',
                                                    'Feb' => 'FEB',
                                                    'Mar' => 'MAR',
                                                    'Apr' => 'APR',
                                                    'May' => 'MEI',
                                                    'Jun' => 'JUN',
                                                    'Jul' => 'JUL',
                                                    'Aug' => 'AGTS',
                                                    'Sep' => 'SEP',
                                                    'Oct' => 'OKT',
                                                    'Nov' => 'NOP',
                                                    'Dec' => 'DES'
                                                ];
                                                
                                                $month = $monthMappings[$month] ?? $month; // Gun
                                                $year = now()->format('Y');
                                                
                                                $year = strval($year); // Ubah tahun ke dalam format string
                                                $currentYear = date('Y');
                                                
                                                if ($reset || $year != $currentYear) {
                                                    // Reset nomor urut jika tahun berubah atau jika diinginkan
                                                    $sequenceNumber = 1;
                                                } else {
                                                    // Ambil nomor urut terakhir dari database atau penyimpanan lain
                                                    $latestNumber = DB::table('t_surat_masuk')
                                                    ->whereYear('created_at', $year)
                                                    ->where('tujuan_surat_id',$id)
                                                    ->count();
                                                    $sequenceNumber = $latestNumber + 1;
                                                }
                                                
                                                // Format nomor urut menjadi 3 digit dengan angka 0 di depan
                                                $formattedSequence = str_pad($sequenceNumber, 3, '0', STR_PAD_LEFT);
                                                
                                                // Ambil prefix dari data jabatan
                                                $pegawai = User::where('id', $id)->first();  
                                                // dd($pegawai);
                                                $jabatan = RefJabatan::where('token', $pegawai->jabatan_id)->first();  
                                                $prefix = $jabatan ? $jabatan->prefix : 'DEFAULT'; // Ganti 'DEFAULT' dengan nilai default jika data jabatan tidak ditemukan
                                                
                                                // Simpan nomor urut terakhir ke database atau penyimpanan lain (jika perlu)
                                                // misalnya: Config::set('latest_number', $sequenceNumber);
                                                
                                                // Return nomor urut dalam format yang diinginkan
                                                return "{$formattedSequence}/SM/{$jabatan->kode}/{$month}/{$year}";
                                            }
                                            
                                            function generateArsipKeluarNumber($id)
                                            {
                                                if($id==NULL){
                                                    return "";
                                                }else{
                                                    $reset = false;
                                                    $month = now()->format('M');
                                                    $monthMappings = [
                                                        'Jan' => 'JAN',
                                                        'Feb' => 'FEB',
                                                        'Mar' => 'MAR',
                                                        'Apr' => 'APR',
                                                        'May' => 'MEI',
                                                        'Jun' => 'JUN',
                                                        'Jul' => 'JUL',
                                                        'Aug' => 'AGTS',
                                                        'Sep' => 'SEP',
                                                        'Oct' => 'OKT',
                                                        'Nov' => 'NOP',
                                                        'Dec' => 'DES'
                                                    ];
                                                    $month = $monthMappings[$month] ?? $month; // Gun
                                                    $year = now()->format('Y');
                                                    $year = strval($year); // Ubah tahun ke dalam format string
                                                    $currentYear = date('Y');
                                                    
                                                    // dd($id);
                                                    list($userID, $jabatanID) = explode(":", $id);
                                                    
                                                    if ($reset || $year != $currentYear) {
                                                        // Reset nomor urut jika tahun berubah atau jika diinginkan
                                                        $sequenceNumber = 1;
                                                    } else {
                                                        // Ambil nomor urut terakhir dari database atau penyimpanan lain
                                                        $latestNumber = DB::table('t_surat_keluar')
                                                        ->whereYear('created_at', $year)
                                                        ->where('unit_kerja_id',$userID)
                                                        ->count();
                                                        $sequenceNumber = $latestNumber + 1;
                                                    }
                                                    
                                                    // Format nomor urut menjadi 3 digit dengan angka 0 di depan
                                                    $formattedSequence = str_pad($sequenceNumber, 3, '0', STR_PAD_LEFT);
                                                    // Ambil prefix dari data jabatan
                                                    $pegawai = User::where('id', $userID)->first();  
                                                    // dd($pegawai);
                                                    $jabatan = RefJabatan::where('token', $pegawai->jabatan_id)->first();  
                                                    $prefix = $jabatan ? $jabatan->prefix : 'DEFAULT'; // Ganti 'DEFAULT' dengan nilai default jika data jabatan tidak ditemukan
                                                    // Simpan nomor urut terakhir ke database atau penyimpanan lain (jika perlu)
                                                    // misalnya: Config::set('latest_number', $sequenceNumber);
                                                    // Return nomor urut dalam format yang diinginkan
                                                    return "{$formattedSequence}/SK/{$jabatan->kode}/{$month}/{$year}";
                                                }
                                            }
                                            
                                            function getNotifikasiTerbaru($type)
                                            {   
                                                if($type==1){
                                                    
                                                    $model = DB::table('t_surat_masuk')
                                                    ->select('t_surat_masuk.*', 't_verifikasi.jabatan_penerima_token', 't_verifikasi.id as verifikasi_id','t_verifikasi.is_read as verifikasi_is_read','t_verifikasi.is_status as verifikasi_is_status','t_verifikasi.read_at as verifikasi_read_at','t_verifikasi.view_at as verifikasi_view_at')
                                                    ->leftJoin('t_verifikasi', 't_surat_masuk.id', '=', 't_verifikasi.surat_id')
                                                    ->where('t_verifikasi.jabatan_penerima_token', getJabatan())
                                                    ->where('t_surat_masuk.satuan_kerja_token', Auth::user()->satuan_kerja_id)
                                                    ->where('t_verifikasi.is_read', 0)
                                                    ->orderBy('t_verifikasi.created_at', 'DESC')
                                                    ->paginate(5);
                                                    
                                                }else{
                                                    
                                                    if(Auth::user()->level==7){
                                                        $model = DB::table('t_surat_masuk')
                                                        ->select('t_surat_masuk.*', 't_disposisi_detail.jabatan_penerima_token', 't_disposisi_detail.id as disposisi_id','t_disposisi_detail.is_read as disposisi_is_read','t_disposisi_detail.jabatan_pengirim_nama','t_disposisi_detail.is_status','t_disposisi_detail.view_at','t_disposisi_detail.read_at')
                                                        ->leftJoin('t_disposisi_detail', 't_surat_masuk.id', '=', 't_disposisi_detail.surat_id')
                                                        ->where('t_disposisi_detail.jabatan_penerima_id', Auth::user()->id)
                                                        ->where('t_surat_masuk.satuan_kerja_token', Auth::user()->satuan_kerja_id)
                                                        ->where('t_disposisi_detail.is_read', 0)
                                                        ->orderBy('t_disposisi_detail.created_at', 'DESC')
                                                        ->paginate(5);
                                                    }else{
                                                        $model = DB::table('t_surat_masuk')
                                                        ->select('t_surat_masuk.*', 't_disposisi_detail.jabatan_penerima_token', 't_disposisi_detail.id as disposisi_id','t_disposisi_detail.is_read as disposisi_is_read','t_disposisi_detail.jabatan_pengirim_nama','t_disposisi_detail.is_status','t_disposisi_detail.view_at','t_disposisi_detail.read_at')
                                                        ->leftJoin('t_disposisi_detail', 't_surat_masuk.id', '=', 't_disposisi_detail.surat_id')
                                                        ->where('t_disposisi_detail.jabatan_penerima_token', getJabatan())
                                                        ->where('t_surat_masuk.satuan_kerja_token', Auth::user()->satuan_kerja_id)
                                                        ->where('t_disposisi_detail.is_read', 0)
                                                        ->orderBy('t_disposisi_detail.created_at', 'DESC')
                                                        ->paginate(5);
                                                    }
                                                    
                                                }
                                                return $model;
                                            }
                                            
                                            function getRoleAkses($id)
                                            {   
                                                $data = DB::table('ref_users')
                                                ->where('id',$id)
                                                ->select('*')
                                                ->get();
                                                
                                                return $data;
                                            }
                                            
                                            
                                            function getRoleAksesLogin()
                                            {                               
                                                $data = User::where('id',Auth::user()->id)->count();
                                                if($data>0){
                                                    $user = User::where('id',Auth::user()->id)->first();
                                                    $autoStatusJabatan = $user->status_login == 1 ? 2 : 1;
                                                    $autoJabatanNama = $user->status_login == 1 ? $user->jabatan_pembantu : $user->jabatan;
                                                    return "<a href='". route('dashboard.auto.login', [$autoStatusJabatan, Crypt::encryptString($user->id)]) ."' class='dropdown-item'><i class='ti-lock'></i> Login as ".$autoJabatanNama."</a>";
                                                }
                                            }
                                            
                                            
                                            function getJabatan()
                                            {
                                                $user = User::where('id',Auth::user()->id)->first();
                                                if($user->status_login == 1) {
                                                    $jabatan = $user->jabatan_id;
                                                } else {
                                                    $jabatan = $user->jabatan_pembantu_id;
                                                }
                                                return $jabatan;
                                            }
                                            
                                            function getJabatanLevel()
                                            {
                                                $user = User::where('id',Auth::user()->id)->first();
                                                if($user->status_login == 1) {
                                                    $jabatan = $user->jabatan_id;
                                                } else {
                                                    $jabatan = $user->jabatan_pembantu_id;
                                                }
                                                $jabatan_level = Refjabatan::where('token',$jabatan)->first();
                                                return $jabatan_level->level_jabatan;
                                            }
                                            
                                            
                                            function getJabatanNama()
                                            {
                                                $user = User::where('id',Auth::user()->id)->first();
                                                if($user->status_login == 1) {
                                                    $jabatan = $user->jabatan;
                                                } else {
                                                    $jabatan = $user->jabatan_pembantu;
                                                }
                                                return $jabatan;
                                            }
                                            
                                            function getJabatanCheck($id, $type)
                                            {
                                                $user = User::where('id', $id)->first();
                                                // dd($user);
                                                $jabatan = ($user->status_login == 1) ? ($type == "ID" ? $user->jabatan_id : $user->jabatan)
                                                : ($type == "ID" ? $user->jabatan_pembantu_id : $user->jabatan_pembantu);
                                                
                                                // dd($jabatan);
                                                return $jabatan;
                                            }
                                            
                                            
                                            function getJabatanRole()
                                            {
                                                $user = User::where('id',Auth::user()->id)->first();
                                                if($user->status_login == 1) {
                                                    $jabatan = $user->role_id;
                                                } else {
                                                    $jabatan = $user->role_id_pembantu;
                                                }
                                                return $jabatan;
                                            }
                                            
                                            function getAtasanByJabatan($type,$jabatanID){
                                                $jabatan = RefJabatan::where(['token' =>  $jabatanID])->first();
                                                // dd($jabatanID);
                                                $user = User::where(['jabatan_id' => $jabatan->token])->first();
                                                if($user == null) {
                                                    $user = User::where(['jabatan_pembantu_id' => $jabatan->token])->first();
                                                }
                                                if($type==1){
                                                    return $user;
                                                }else{
                                                    return $jabatan;
                                                }
                                            }
                                            
                                            function getInisial($string) {
                                                // Memecah string menjadi array kata
                                                $kata = explode(" ", $string);
                                                
                                                // Inisialisasi variabel untuk inisial
                                                $inisial = '';
                                                
                                                // Loop melalui setiap kata
                                                foreach ($kata as $k) {
                                                    // Mengambil karakter pertama dari setiap kata
                                                    $inisial .= $k[0];
                                                }
                                                
                                                // Mengembalikan inisial dalam huruf besar
                                                return strtoupper($inisial);
                                            }
                                            
                                            function limitasiKarakter($teks, $panjang_maksimal = 100) {
                                                if (strlen($teks) <= $panjang_maksimal) {
                                                    return $teks; // Kembalikan teks asli jika panjangnya sudah kurang dari atau sama dengan panjang maksimal
                                                } else {
                                                    // Potong teks dan tambahkan "..." (titik-titik) sebagai penanda bahwa teks telah dipotong
                                                    return substr($teks, 0, $panjang_maksimal - 3) ;
                                                }
                                            }
                                            
                                            function getSifatSurat($id)
                                            {
                                                $data = RefSifatSurat::where('id',$id)->first();
                                                return $data;
                                            }
                                            
                                            function getJenisSurat($id)
                                            {
                                                $data = RefJenisSurat::where('id',$id)->first();
                                                return $data;
                                            }
                                            
                                            function getNamaLengkap($id)
                                            {
                                                $data = User::where('id',$id)->first();
                                                return $data->nama;
                                            }
                                            
                                            function getCloneSurat($id){
                                                $surat_keluar = SuratKeluar::where('token',$id)->first();    
                                                $surat_masuk = SuratMasuk::firstOrCreate(['no_surat' =>  $surat_keluar->no_surat]);
                                                $surat_masuk->id = SuratKeluar::max('id') + 1;  
                                                $surat_masuk->tgl_terima = date('Y-m-d');
                                                $surat_masuk->tgl_surat = $surat_keluar->tgl_surat;
                                                $surat_masuk->no_surat = $surat_keluar->no_surat;
                                                if($surat_keluar->is_type==1){
                                                    $surat_masuk->alamat = getApp()->address;
                                                }else{
                                                    $surat_masuk->alamat = $surat_keluar->alamat;
                                                }
                                                
                                                $surat_masuk->perihal_surat = $surat_keluar->perihal_surat;
                                                $surat_masuk->no_arsip = $surat_keluar->no_arsip;
                                                $surat_masuk->isi_surat = $surat_keluar->keterangan_surat;
                                                $surat_masuk->keterangan_surat = $surat_keluar->keterangan_surat;
                                                $surat_masuk->created_at = $surat_keluar->created_at;
                                                $surat_masuk->updated_at = $surat_keluar->updated_at;
                                                $surat_masuk->deleted_at = $surat_keluar->deleted_at;
                                                $surat_masuk->create_id = $surat_keluar->create_id;
                                                $surat_masuk->update_id = $surat_keluar->update_id;
                                                $surat_masuk->delete_id = $surat_keluar->delete_id;
                                                $surat_masuk->token = $surat_keluar->token;
                                                $surat_masuk->is_active = 1;
                                                $surat_masuk->is_delete = 0;
                                                $surat_masuk->is_read = 0;
                                                $surat_masuk->is_view = 0;
                                                $surat_masuk->file_lampiran = $surat_keluar->file_lampiran;
                                                $surat_masuk->file_lampiran_url = $surat_keluar->file_lampiran_url;
                                                $surat_masuk->file_lampiran_size = $surat_keluar->file_lampiran_size;
                                                $surat_masuk->pembuat_surat_id = Auth::user()->id;
                                                $surat_masuk->pembuat_surat_token = Auth::user()->jabatan_id;
                                                $surat_masuk->sekretaris_surat_id = $surat_keluar->penandatangan_surat_satu_id;
                                                $surat_masuk->sekretaris_surat_token = $surat_keluar->penandatangan_surat_satu_token;
                                                $surat_masuk->tujuan_surat_id = $surat_keluar->tujuan_surat_id;
                                                $surat_masuk->tujuan_surat_token = $surat_keluar->tujuan_surat_token;
                                                $surat_masuk->satuan_kerja_id = $surat_keluar->satuan_kerja_id;
                                                $surat_masuk->satuan_kerja_token = $surat_keluar->satuan_kerja_token;
                                                $jabatan = RefJabatan::where('token',$surat_keluar->penandatangan_surat_satu_token)->first();
                                                $user = User::where('id',$surat_keluar->penandatangan_surat_satu_id)->first();
                                                $surat_masuk->pengirim_surat = $user->nama . " - " . $jabatan->jabatan;
                                                $surat_masuk->save();     
                                                setVerifikasi($surat_masuk->create_id,$surat_masuk->token,$surat_masuk->tujuan_surat_id,$surat_masuk->tujuan_surat_token,"Surat Keluar Terkirim & Sudah di Tanda Tangan Oleh ".Auth::user()->jabatan,1,1);
                                                $surat_keluar->is_approve=1;
                                                $surat_keluar->is_send=1;
                                                $surat_keluar->update();
                                            }
                                            
                                            function bulanKeRomawi($bulan) {
                                                $romawi = [
                                                    1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
                                                    7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
                                                ];
                                                
                                                return $romawi[$bulan];
                                            }
                                            
                                            function generateNomorSurat($tgl_surat, $jenis_surat, $sifat_surat, $unit_kerja, $id) {
                                                if($tgl_surat!=NULL){
                                                    // dd($tgl_surat);
                                                    // Ubah format tanggal
                                                    $tanggal_array = explode('-', $tgl_surat);
                                                    // dd($tanggal_array);
                                                    $bulan_romawi = bulanKeRomawi((int)$tanggal_array[1]);                        
                                                    // Ambil dua digit terakhir tahun
                                                    $tahun = substr($tanggal_array[0], 0);
                                                }else{
                                                    $bulan_romawi = "";
                                                    $tahun = "";
                                                }
                                                
                                                // Reset nomor urut pada awal tahun
                                                $current_year = date('Y');
                                                $reset_counter = ($tahun != $current_year);
                                                
                                                // Jumlah surat berdasarkan sifat surat
                                                if($id!=NULL){
                                                    $data = SuratKeluar::where('sifat_surat_id',$id)->count() + 1;
                                                }else{
                                                    $data = "";
                                                }
                                                
                                                static $counter = [
                                                    'SR' => 0,
                                                    'T' => 0,
                                                    'R' => 0,
                                                    'S' => 0,
                                                    'B' => 0
                                                ];
                                                
                                                // Reset nomor urut jika awal tahun atau sifat surat berbeda
                                                if ($reset_counter || !isset($counter[$sifat_surat])) {
                                                    $counter[$sifat_surat] = 1;
                                                } else {
                                                    // Increment nomor urut jika tidak direset
                                                    $counter[$sifat_surat]++;
                                                }
                                                
                                                // Generate nomor surat
                                                // $no_surat = "ST-" . sprintf("%04d", $counter[$sifat_surat]) . "/$unit_kerja/$jenis_surat/$sifat_surat/$bulan_romawi/$tahun";
                                                $no_surat = "ST-" . sprintf("%04d", $data) . "/$unit_kerja/$jenis_surat/$sifat_surat/$bulan_romawi/$tahun";
                                                
                                                return $no_surat;
                                            }
                                            
                                            function convertStringToArray($inputString) {
                                                $segments = explode(',', $inputString);
                                                
                                                // Menghapus spasi di setiap segment
                                                $segments = array_map('trim', $segments);
                                                
                                                // Mengubah setiap segment menjadi format yang diinginkan
                                                $formattedArray = array_map(function($segment) {
                                                    return "'$segment'";
                                                }, $segments);
                                                
                                                // Menggabungkan elemen array menjadi string
                                                $resultString = '[' . implode(',', $formattedArray) . ']';
                                                
                                                // Menampilkan hasil
                                                return $resultString;
                                            }
                                            
                                            function getStatusLabel($is_status, $view_at, $read_at) {
                                                $status = match($is_status) {
                                                    0 => ['class' => 'label-warning', 'text' => 'Belum Lihat', 'time' => TglTimeIndo($view_at)],
                                                    1 => ['class' => 'label-info', 'text' => 'Sudah Dilihat', 'time' => TglTimeIndo($view_at)],
                                                    2 => ['class' => 'label-success', 'text' => 'Sudah Dibaca', 'time' => TglTimeIndo($read_at)],
                                                    default => null,
                                                };
                                                
                                                if ($status) {
                                                    return '<div class="label float-end ' . $status['class'] . '" data-bs-toggle="tooltip" title="' . $status['time'] . '">' . $status['text'] . '</div>';
                                                }
                                                
                                                return '';
                                            }
                                            
                                            function getResponseDisposisiLabel($is_response, $is_disposisi) {
                                                $html = '';
                                                if ($is_response == 1) {
                                                    $html .= '<div class="label label-inverse float-end">Laporan</div>';
                                                }
                                                if ($is_disposisi == 1) {
                                                    $html .= '<div class="label label-danger float-end">Disposisi</div>';
                                                }
                                                return $html;
                                            }
                                            
                                            function buatTreeView($parent_id, $data, $parentID)
                                            {
                                                $html = '<ul'; // Tidak menambahkan langsung kelas di sini
                                                if ($parent_id == $parentID) {
                                                    $html .= ' class="wtree"'; // Menambahkan kelas "wtree" hanya pada elemen ul pertama
                                                }
                                                $html .= '>';
                                                
                                                foreach ($data as $item) {
                                                    if ($item->jabatan_penerima_atasan_id == $parent_id) {
                                                        $html .= '<li title="'.$item->deskripsi.'">';
                                                        $html .= '<span>';
                                                        $html .= $item->is_direct == 0 ? "<div class='label label-info'>CC</div>" : "<div class='label label-primary'>Direct</div>";
                                                        $html .= ' <b>'. strtoupper($item->jabatan_penerima_posisi) . '</b> - ' . $item->jabatan_penerima_nama;
                                                        $html .= getStatusLabel($item->is_status, $item->view_at, $item->read_at);
                                                        $html .= '<br>';
                                                        // $html .= '<small class="text-sm">'.$item->deskripsi.'</small>';
                                                        // $html .= '<br>';
                                                        $html .= '<small class="text-sm">'.TglTimeIndo($item->created_at).' - '.\Carbon\Carbon::parse($item->created_at)->diffForHumans().'</small>';
                                                        $html .= getResponseDisposisiLabel($item->is_response,$item->is_disposisi);
                                                        $html .= '</span>';
                                                        $html .= buatTreeView($item->jabatan_penerima_jabatan_id, $data, $parentID);
                                                        $html .= '</span>';
                                                    }
                                                }
                                                $html .= '</ul>';
                                                return $html;
                                            }
                                            
                                            function generateKodePembayaran() {
                                                $tahun = date('Y');
                                                $bulan = date('m');
                                                $tanggal = date('d');
                                                
                                                // Ambil kode_urut dari database atau sesuai kebutuhan
                                                $kode_urut = PembayaranPajak::count()+1; // Misalnya, fungsi untuk mendapatkan kode_urut dari database
                                                
                                                // Format kode pembayaran
                                                $kode_pembayaran = $tahun . $bulan . $tanggal . str_pad($kode_urut, 4, '0', STR_PAD_LEFT);
                                                
                                                return $kode_pembayaran;
                                            }

                                            function generateKodeRegistrasi() {
                                                $tahun = date('Y');
                                                
                                                // Ambil kode_urut dari database atau sesuai kebutuhan
                                                $kode_urut = PembayaranPajak::count()+1; // Misalnya, fungsi untuk mendapatkan kode_urut dari database
                                                
                                                // Format kode pembayaran
                                                $kode_pembayaran = $tahun . str_pad($kode_urut, 5, '0', STR_PAD_LEFT);
                                                
                                                return $kode_pembayaran;
                                            }


                                            function tglPendaftaran($bphtb){
                                                $pembayaran = PembayaranPajak::where('id_bphtb', '=', $bphtb)->first();
                                                if(empty($pembayaran->tanggal_pendaftaran)){
                                                    return 'Tanggal Pendaftaran belum dibuat';
                                                }else{
                                                    return tglIndo($pembayaran->tanggal_pendaftaran);
                                                }
                                            }

                                            function statusValidasi($bphtb){
                                                $html = '';
                                                $pembayaran = PembayaranPajak::where('id_bphtb', '=', $bphtb)->first();
                                                if(empty($pembayaran->status_validasi)){
                                                        $html .= '<span class="badge badge-light-danger">Dalam Proses</span>';
                                                }else{
                                                    if ($pembayaran->status_validasi==0){
                                                        $html .= '<span class="badge badge-light-danger">Dalam Proses</span>';
                                                    }elseif ($pembayaran->status_validasi==1){
                                                        $html .= '<span class="badge badge-light-success">Sudah Divalidasi - Lunas</span>';
                                                    }elseif ($pembayaran->status_validasi==2){
                                                        $html .= '<span class="badge badge-light-primary">Sudah Divalidasi - Kurang Bayar</span>';
                                                    }
                                                }

                                                return $html;
                                            }


                                            function statusBerkas($bphtb){
                                                $html = '';
                                                $pembayaran = PembayaranPajak::where('id_bphtb', '=', $bphtb)->first();
                                                    if ($pembayaran->status_validasi==0){
                                                        $html .= '<span class="badge badge-light-danger">Berkas proses verifikasi</span>';
                                                    }elseif ($pembayaran->status_validasi==1){
                                                        $html .= '<span class="badge badge-light-success">Berkas menunggu Penetapan</span>';
                                                    }elseif ($pembayaran->status_validasi==2){
                                                        $html .= '<span class="badge badge-light-primary">Berkas dikembalikan oleh PPTK - Kurang Bayar</span>';
                                                    }else{
                                                        $html .= '<span class="badge badge-light-danger">Berkas di PPTK/NOTARIS</span>';
                                                    }

                                                return $html;
                                            }

                                            
                                            function statusValidasiKb($bphtb){
                                                $html = '';
                                                $pembayaran = PembayaranPajakKurang::where('id_bphtb', '=', $bphtb)->first();
                                                if(empty($pembayaran->status_validasi)){
                                                        $html .= '<span class="badge badge-light-danger">Dalam Proses</span>';
                                                }else{
                                                    if ($pembayaran->status_validasi==0){
                                                        $html .= '<span class="badge badge-light-danger">Dalam Proses</span>';
                                                    }elseif ($pembayaran->status_validasi==1){
                                                        $html .= '<span class="badge badge-light-success">Sudah Divalidasi - Lunas</span>';
                                                    }elseif ($pembayaran->status_validasi==2){
                                                        $html .= '<span class="badge badge-light-primary">Sudah Divalidasi - Kurang Bayar</span>';
                                                    }
                                                }

                                                return $html;
                                            }


                                            function statusBerkasKb($bphtb){
                                                $html = '';
                                                $pembayaran = PembayaranPajakKurang::where('id_bphtb', '=', $bphtb)->first();
                                                    if ($pembayaran->status_validasi==0){
                                                        $html .= '<span class="badge badge-light-danger">Berkas proses verifikasi</span>';
                                                    }elseif ($pembayaran->status_validasi==1){
                                                        $html .= '<span class="badge badge-light-success">Berkas menunggu Penetapan</span>';
                                                    }elseif ($pembayaran->status_validasi==2){
                                                        $html .= '<span class="badge badge-light-primary">Berkas dikembalikan oleh PPTK - Kurang Bayar</span>';
                                                    }else{
                                                        $html .= '<span class="badge badge-light-danger">Berkas di PPTK/NOTARIS</span>';
                                                    }

                                                return $html;
                                            }
// SIBAPOKTING
function dinamikaHargaAvg($sekarang,$kemarin){
    $html='';
    if(empty($kemarin) || empty($sekarang)){
        $html .= '<span class="badge badge-light-primary"><i class="ki-outline ki-minus fs-2 text-primary me-2"></i> Harga Tetap </span>';
    }else{
        if ($sekarang > $kemarin){
            $html .= '<span class="badge badge-light-danger"><i class="ki-outline ki-arrow-up-right fs-2 text-danger me-2"></i> Kenaikan Sebesar '
            .presentaseKenaikan($sekarang,$kemarin).
            '</span>';
        }elseif ($sekarang < $kemarin){
            $html .= '<span class="badge badge-light-success"><i class="ki-outline ki-arrow-down-right fs-2 text-success me-2"></i> Penurunan Sebesar '
            .presentasePenurunan($sekarang,$kemarin).
            '</span>';
        }elseif($sekarang == $kemarin){
            $html .= '<span class="badge badge-light-primary"><i class="ki-outline ki-minus fs-2 text-primary me-2"></i> Harga Tetap </span>';
        }

    }
    return $html;
}

function dinamikaHargaAvgIcon($sekarang,$kemarin){
    $html='';
    if(empty($kemarin) || empty($sekarang)){
        $html .= '<span class="badge badge-light-primary"><i class="ki-outline ki-minus fs-2 text-primary me-2"></i>Tetap 0% </span>';
    }else{
        if ($sekarang > $kemarin){
            $html .= '<span class="badge badge-light-danger"><i class="ki-outline ki-arrow-up-right fs-2 text-danger me-2"></i>Naik '
            .presentaseKenaikan($sekarang,$kemarin).
            '</span>';
        }elseif ($sekarang < $kemarin){
            $html .= '<span class="badge badge-light-success"><i class="ki-outline ki-arrow-down-right fs-2 text-success me-2"></i>Turun '
            .presentasePenurunan($sekarang,$kemarin).
            '</span>';
        }elseif($sekarang == $kemarin){
            $html .= '<span class="badge badge-light-primary"><i class="ki-outline ki-minus fs-2 text-primary me-2"></i>Tetap 0% </span>';
        }

    }
    return $html;
}

function inflasi($sekarang,$kemarin,$persen){
    $red = $persen;
    $yellow = $persen / 2;
    $green = $persen / 3;
    $blue = $persen / 2 ;
    $low_blue = $persen;

    $html='';
    if(empty($kemarin) || empty($sekarang)){
        $html .= '<span class="badge badge-light-primary"><i class="ki-outline ki-minus fs-2 text-primary me-2"></i>Tetap 0% </span>';
    }else{
        if ($sekarang > $kemarin){
            if(inflasiKenaikan($sekarang,$kemarin) >= 10){
                $html .= '<span class="badge badge-danger"><i class="ki-outline ki-arrow-up-right fs-2 text-white me-2"></i>Kenaikan '
                .inflasiKenaikan($sekarang,$kemarin).
                ' % </span>'; 
            }else if(inflasiKenaikan($sekarang,$kemarin) >= 5 && inflasiKenaikan($sekarang,$kemarin) < 10){
                $html .= '<span class="badge badge-warning"><i class="ki-outline ki-arrow-up-right fs-2 text-white me-2"></i>Kenaikan '
                .inflasiKenaikan($sekarang,$kemarin).
                ' % </span>';
            }else if(inflasiKenaikan($sekarang,$kemarin) >= 0 && inflasiKenaikan($sekarang,$kemarin) < 5){
                $html .= '<span class="badge badge-success"><i class="ki-outline ki-arrow-up-right fs-2 text-white me-2"></i>Kenaikan '
                .inflasiKenaikan($sekarang,$kemarin).
                ' % </span>';
            }
        }elseif ($sekarang < $kemarin){
            $html .= '<span class="badge badge-primary"><i class="ki-outline ki-arrow-down-right fs-2 text-white me-2"></i>Penurunan '
            .inflasiKenaikan($sekarang,$kemarin).
            ' % </span>';
        }elseif($sekarang == $kemarin){
            $html .= '<span class="badge badge-light-primary"><i class="ki-outline ki-minus fs-2 text-white me-2"></i>Tetap 0% </span>';
        }

    }
    return $html;
}

function classInflasi($sekarang,$kemarin,$persen){
    $red = $persen;
    $yellow = $persen / 2;
    $green = $persen / 3;
    $blue = $persen / 2 ;
    $low_blue = $persen;

    $html='';
    if(empty($kemarin) || empty($sekarang)){
        $html .= '<span class="badge badge-light-primary"><i class="ki-outline ki-minus fs-2 text-primary me-2"></i>Tetap 0% </span>';
    }else{
        if ($sekarang > $kemarin){
            if(inflasiKenaikan($sekarang,$kemarin) >= 10){
                $html .= 'bg-light-danger'; 
            }else if(inflasiKenaikan($sekarang,$kemarin) >= 5 && inflasiKenaikan($sekarang,$kemarin) < 10){
                $html .= 'bg-light-warning';
            }else if(inflasiKenaikan($sekarang,$kemarin) >= 0 && inflasiKenaikan($sekarang,$kemarin) < 5){
                $html .= 'bg-light-success';
            }
        }elseif ($sekarang < $kemarin){
            $html .= 'bg-light-primary';
        }elseif($sekarang == $kemarin){
            $html .= 'bg-light-primary';
        }

    }
    return $html;
}

function dinamikaHargaAvgVariant($sekarang,$kemarin){
    $html='';
    if(empty($kemarin) || empty($sekarang)){
        $html .= '<span class="badge badge-light-primary"><i class="ki-outline ki-minus fs-2 text-primary me-2"></i>0% </span>';
    }else{
        if ($sekarang > $kemarin){
            $html .= '<span class="badge badge-light-danger"><i class="ki-outline ki-arrow-up-right fs-2 text-danger me-2"></i>'
            .presentaseKenaikan($sekarang,$kemarin).
            '</span>';
        }elseif ($sekarang < $kemarin){
            $html .= '<span class="badge badge-light-success"><i class="ki-outline ki-arrow-down-right fs-2 text-success me-2"></i>'
            .presentasePenurunan($sekarang,$kemarin).
            '</span>';
        }elseif($sekarang == $kemarin){
            $html .= '<span class="badge badge-light-primary"><i class="ki-outline ki-minus fs-2 text-primary me-2"></i>0%</span>';
        }

    }
    return $html;
}

function dinamikaHargaAvgNilai($sekarang,$kemarin){
    $html='';
    if(empty($kemarin) || empty($sekarang)){
        $html = 0;
    }else{
        if ($sekarang > $kemarin){
            $html = presentaseKenaikan($sekarang,$kemarin);
        }elseif ($sekarang < $kemarin){
            $html = presentasePenurunan($sekarang,$kemarin);
        }elseif($sekarang == $kemarin){
            $html = 0;
        }

    }
    return $html;
}

function statusKondisi($kondisi,$sekarang,$kemarin){
    $html='';
    if(empty($kemarin) || empty($sekarang)){
        $html = 0;
    }else{
        if($kondisi == 'naik'){
            $html = 'Rp.'.number_format($kemarin - $sekarang,0, ',', '.');
        }elseif($kondisi == 'turun'){
            $html = 'Rp.'.number_format($sekarang - $kemarin,0, ',', '.');
        }elseif($kondisi == 'stabil'){
            $html = '';
        }
    }
    return $html;
}

function dinamikaHarga($id,$tgl){
    $dt = new \Carbon\Carbon($tgl);
    $tanggal = $dt->format('Y-m-d');
    $tanggal_sebelum = date('Y-m-d',strtotime($tanggal . "-1 days"));
    $komoditas = Komoditas::where('id',$id)->where('detail_tgl',$tanggal)->first();
    $komoditas_sebelum = Komoditas::where('pasar_id',$komoditas->pasar_id)
    ->where('komoditas_id',$komoditas->komoditas_id)
    ->where('detail_tgl',$tanggal_sebelum)->first();
    $html='';
    if(empty($komoditas_sebelum) || empty($komoditas)){
        $html .= '';
    }else{
        if ($komoditas->harga_publish > $komoditas_sebelum->harga_publish){
            $html .= '<span class="badge badge-light-danger"><i class="ki-outline ki-arrow-up-right fs-2 text-danger me-2"></i>'
            .presentaseKenaikan($komoditas->harga_publish,$komoditas_sebelum->harga_publish).
            '</span>';
        }elseif ($komoditas->harga_publish < $komoditas_sebelum->harga_publish){
            $html .= '<span class="badge badge-light-success"><i class="ki-outline ki-arrow-down-right fs-2 text-success me-2"></i>'
            .presentasePenurunan($komoditas->harga_publish,$komoditas_sebelum->harga_publish).
            '</span>';
        }elseif($komoditas->harga_publish == $komoditas_sebelum->harga_publish){
            $html .= '';
        }

    }
    return $html;
}


function hargaSelisih($komoditas,$pasar,$harga,$tgl){
    $dt = new \Carbon\Carbon($tgl);
    $tanggal = $dt->format('Y-m-d');
    $tanggal_sebelum = date('Y-m-d',strtotime($tanggal . "-1 days"));

    $komoditas_sebelum = Komoditas::where('pasar_id',$pasar)
    ->where('komoditas_id',$komoditas)
    ->where('detail_tgl',$tanggal_sebelum)->first();
    $value='';
    if(empty($komoditas_sebelum)){
        $value = 0;
    }else{
        if ($harga > $komoditas_sebelum->harga_publish){
            $value = $harga-$komoditas_sebelum->harga_publish;
        }elseif ($harga < $komoditas_sebelum->harga_publish){
            $value = $komoditas_sebelum->harga_publish - $harga;
        }elseif($harga == $komoditas_sebelum->harga_publish){
            $value = 0;
        }
    }

    return $value;
}

function statusDinamika($komoditas,$pasar,$harga,$tgl){
    $dt = new \Carbon\Carbon($tgl);
    $tanggal = $dt->format('Y-m-d');
    $tanggal_sebelum = date('Y-m-d',strtotime($tanggal . "-1 days"));

    $komoditas_sebelum = Komoditas::where('pasar_id',$pasar)
    ->where('komoditas_id',$komoditas)
    ->where('detail_tgl',$tanggal_sebelum)->first();
    $value='';
    if(empty($komoditas_sebelum)){
        $value = 'stabil';
    }else{
        if ($harga > $komoditas_sebelum->harga_publish){
            $value = 'naik';
        }elseif ($harga < $komoditas_sebelum->harga_publish){
            $value = 'turun';
        }elseif($harga == $komoditas_sebelum->harga_publish){
            $value = 'stabil';
        }
    }

    return $value;
}

function stokSebelum($barang,$pasar,$tgl){
    $dt = new \Carbon\Carbon($tgl);
    $tanggal = $dt->format('Y-m-d');
    $tanggal_sebelum = date('Y-m-d',strtotime($tanggal . "-1 days"));
    $barang_sebelum = barang::where('pasar_id',$pasar)
    ->where('barang_id',$barang)
    ->where('detail_tgl',$tanggal_sebelum)->first();
    if(empty($barang_sebelum)){
        $html = 0;
    }else{
        $html = $barang_sebelum->stok_akhir;
    }
    return $html;
}

function hargaSebelum($id,$tgl){
    $dt = new \Carbon\Carbon($tgl);
    $tanggal = $dt->format('Y-m-d');
    $tanggal_sebelum = date('Y-m-d',strtotime($tanggal . "-1 days"));
    $komoditas = Komoditas::where('id',$id)->where('detail_tgl',$tanggal)->first();
    $komoditas_sebelum = Komoditas::where('pasar_id',$komoditas->pasar_id)
    ->where('komoditas_id',$komoditas->komoditas_id)
    ->where('detail_tgl',$tanggal_sebelum)->first();
    if(empty($komoditas_sebelum)){
        $html = 0;
    }else{
        $html = $komoditas_sebelum->harga_publish;
    }
    return $html;
}

// function presentaseKenaikan($sekarang,$kemarin){
//     $selisih = $sekarang - $kemarin;
//     $presentase = $selisih / $kemarin;
//     $hasil = $presentase * 100;
//     return substr($hasil,0,4).'%';
// }
function presentaseKenaikan($sekarang, $kemarin) {
    if ($kemarin == 0) {
        return $sekarang > 0 ? '100%' : '0%'; // Jika awalnya nol, kenaikan tak terhingga atau tetap nol.
    }

    $selisih = $sekarang - $kemarin;
    $presentase = ($selisih / $kemarin) * 100;

    return number_format($presentase, 2) . '%';
}

function inflasiKenaikan($sekarang,$kemarin){
    $hasil = abs($sekarang/$kemarin * 100 - 100);
    return substr($hasil,0,4);
}

function presentasePenurunan($sekarang,$kemarin){
    $selisih = $kemarin - $sekarang;
    $presentase = $selisih / $sekarang;
    $hasil = $presentase * 100;
    return substr($hasil,0,4).'%';
}

function presentasePermintaan($awal,$masuk,$keluar){
    $stok = $awal + $masuk;
    $permintaan = $keluar / $stok;
    $hasil = floor($permintaan * 100);
    $html='';
    if($hasil < 25){
        $html .='<span class="badge badge-light-success">Permintaan '.$hasil.' % dari Ketersediaan</span>';
    }elseif($hasil >= 25 && $hasil < 49){
        $html .='<span class="badge badge-light-primary">Permintaan '.$hasil.' % dari Ketersediaan</span>';
    }elseif($hasil >= 50 && $hasil < 75){
        $html .='<span class="badge badge-light-warning">Permintaan '.$hasil.' % dari Ketersediaan</span>';
    }elseif($hasil >= 75){
        $html .='<span class="badge badge-light-danger">Permintaan '.$hasil.' % dari Ketersediaan</span>';
    }
    return $html;
}

function topPangan($id){
    $dt = new \Carbon\Carbon(now());
    $tanggal = $dt->format('Y-m-d');
    $tanggal_sebelum = date('Y-m-d',strtotime($tanggal . "-1 days"));
    $tanggal_sebelum_1 = date('Y-m-d',strtotime($tanggal_sebelum . "-1 days"));
    $komoditas = Komoditas::with('toKomoditas')->where('detail_tgl',$tanggal)->first();
    if(empty($komoditas)){
        $before_komoditas = Komoditas::with('toKomoditas')->where('detail_tgl',$tanggal_sebelum)->first();
        $komoditas_sebelum = Komoditas::where('pasar_id',$before_komoditas->pasar_id)
        ->where('komoditas_id',$before_komoditas->komoditas_id)
        ->where('detail_tgl',$tanggal_sebelum)->first();
    }else{  
        $komoditas_sebelum = Komoditas::where('pasar_id',$komoditas->pasar_id)
        ->where('komoditas_id',$komoditas->komoditas_id)
        ->where('detail_tgl',$tanggal_sebelum)->first();
    }
    return [
        'komoditas' => empty($komoditas) ? $before_komoditas : $komoditas,
        'komoditas_sebelum' => $komoditas_sebelum
    ];
}

function avgHarga($komoditas,$pasar,$tgl){
    $raw_date = $tgl;
    $date_parts = explode('-', $raw_date);

    $year = (int)$date_parts[0];
    $month = (int)$date_parts[1];
    $day = (int)$date_parts[2];
    if (checkdate($month, $day, $year)) {
        $date = $raw_date;
        if(empty($pasar)){
            $avg_komoditas = Komoditas::where('komoditas_id',$komoditas)->where('detail_tgl',$tgl)->Avg('harga_publish');
        }else{
            $avg_komoditas = Komoditas::where('komoditas_id',$komoditas)->where('detail_tgl',$tgl)->where('pasar_id',$pasar)->Avg('harga_publish');
        }
        return round($avg_komoditas);
    } else {
        if(empty($pasar)){
            $avg_komoditas = Komoditas::where('komoditas_id',$komoditas)->where('detail_tgl',getLastDayOfMonth($year, $month - 1))->Avg('harga_publish');
        }else{
            $avg_komoditas = Komoditas::where('komoditas_id',$komoditas)->where('detail_tgl',getLastDayOfMonth($year, $month - 1))->where('pasar_id',$pasar)->Avg('harga_publish');
        }
        return round($avg_komoditas);
    }
    
}

function iphHarga($komoditas,$tgl){
    $raw_date = $tgl;
    $date_parts = explode('-', $raw_date);

    // $year = (int)$date_parts[0];
    // $month = (int)$date_parts[1];
    // $day = (int)$date_parts[2];
    $startOfWeek = date('Y-m-d', strtotime('last monday', strtotime($tgl)));
    $endOfWeek = date('Y-m-d', strtotime($startOfWeek . "+6 days"));
    $avg_komoditas = Komoditas::where('komoditas_id', $komoditas)
        ->where('detail_tgl', '>=', $startOfWeek)
        ->where('detail_tgl', '<=', $endOfWeek)
        ->Avg('harga_publish');
    return round($avg_komoditas);
}

function getLastDayOfMonth($year, $month) {
    // Membuat objek DateTime untuk tanggal pertama dalam bulan
    $date = new DateTime("$year-$month-01");
    $date->modify('last day of this month');
    return $date->format('Y-m-d');
}

function avgHargaResult($komoditas,$pasar,$tgl){
    if(empty($pasar)){
        $avg_komoditas = Komoditas::selectRaw('komoditas_id, avg(harga_publish) as harga')
        ->where('detail_tgl',$tgl)
        ->groupBy('komoditas_id')->get();
    }else{
        $avg_komoditas = Komoditas::selectRaw('komoditas_id, avg(harga_publish) as harga')->where('detail_tgl',$tgl)->where('pasar_id',$pasar)
        ->groupBy('komoditas_id')->get();
    }

    dd($avg_komoditas);
}

function getNamaPasar($pasar){
    $data = RefPasar::where('id',$pasar)->first();

    return $data->namapasar;
}

function getUserByPasar($pasar){
    $pasar = RefPasar::where('id',$pasar)->first();
    $data = User::where('pasar_id',$pasar->id)->first();
    return $data;
}

function getKomoditas($komoditas){
    $data = RefKomoditas::where('id',$komoditas)->first();
    return $data;
}
      

function getBarang($barang){
    $data = RefBarang::where('id',$barang)->first();
    return $data;
}
      
                                            
                                            
                                            
                                            
                                            
                                            