<?php

namespace App\Livewire\Dashboard;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RoleAkses extends Component
{
    #[Layout('components.layouts.keenthemes.login')]
    public function render()
    {
        return view('livewire.dashboard.role-akses');
    }
    
    public function logout()
    {
        setActivity('Logout dari Aplikasi');
        Auth::logout();
        return redirect()->route('login');
    }
}
