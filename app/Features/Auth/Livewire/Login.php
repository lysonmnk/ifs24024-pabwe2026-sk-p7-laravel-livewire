<?php

namespace App\Features\Auth\Livewire;

use App\Features\Auth\Actions\LoginUserAction;
use App\Features\Auth\Actions\RegisterUserAction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Login - TodoApp')]
class Login extends Component
{
    // Login Credentials
    public string $login = '';
    public string $password = '';
    public bool $remember = false;

    // Register Credentials (for the back side of 3D FlipCard)
    public string $reg_name = '';
    public string $reg_username = '';
    public string $reg_email = '';
    public string $reg_password = '';
    public string $reg_password_confirmation = '';

    public bool $isFlipped = false;

    /**
     * @return array<string, array<int, string>>
     */
    protected function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(LoginUserAction $action): mixed
    {
        $this->validate();

        if ($action->execute(trim($this->login), $this->password, $this->remember)) {
            $user = Auth::user();
            if ($user && $user->isAdmin()) {
                return $this->redirectRoute('admin.users');
            }

            return $this->redirectRoute('stocks.index');
        }

        $this->addError('login', 'Username/email atau password yang Anda masukkan tidak sesuai.');
        return null;
    }

    public function registerUser(RegisterUserAction $action): mixed
    {
        $this->validate([
            'reg_name' => ['required', 'string', 'max:255'],
            'reg_username' => ['required', 'string', 'alpha_dash', 'min:3', 'max:50', 'unique:users,username'],
            'reg_email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'reg_password' => ['required', 'string', 'min:8', 'same:reg_password_confirmation'],
        ], [
            'reg_name.required' => 'Nama lengkap wajib diisi.',
            'reg_username.required' => 'Username wajib diisi.',
            'reg_username.unique' => 'Username sudah digunakan.',
            'reg_email.required' => 'Email wajib diisi.',
            'reg_email.unique' => 'Email sudah terdaftar.',
            'reg_password.required' => 'Password wajib diisi.',
            'reg_password.min' => 'Password minimal 8 karakter.',
            'reg_password.same' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = $action->execute([
            'name' => $this->reg_name,
            'username' => $this->reg_username,
            'email' => $this->reg_email,
            'password' => $this->reg_password,
            'role' => 'member',
        ]);

        Auth::login($user);
        session()->regenerate();
        session()->flash('success', 'Registrasi berhasil! Selamat datang di Aplikasi Stock Barang.');

        return $this->redirectRoute('stocks.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.auth.login');
    }
}

