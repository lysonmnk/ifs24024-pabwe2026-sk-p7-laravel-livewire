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
#[Title('Register - TodoApp')]
class Register extends Component
{
    // Register fields (Primary on /register)
    public string $name = '';
    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    // Login fields (for the front face of 3D FlipCard)
    public string $login = '';
    public string $login_password = '';
    public bool $remember = false;

    public bool $isFlipped = true;

    /**
     * @return array<string, array<int, string>>
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'alpha_dash', 'min:3', 'max:50', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function register(RegisterUserAction $action): mixed
    {
        $this->validate();

        $user = $action->execute([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
            'role' => 'member',
        ]);

        Auth::login($user);
        session()->regenerate();
        session()->flash('success', 'Registrasi berhasil! Selamat datang di Aplikasi Stock Barang.');

        return $this->redirectRoute('stocks.index', navigate: true);
    }

    public function authenticateUser(LoginUserAction $action): mixed
    {
        $this->validate([
            'login' => ['required', 'string'],
            'login_password' => ['required', 'string'],
        ], [
            'login.required' => 'Username atau email wajib diisi.',
            'login_password.required' => 'Password wajib diisi.',
        ]);

        if ($action->execute(trim($this->login), $this->login_password, $this->remember)) {
            $user = Auth::user();
            if ($user && $user->isAdmin()) {
                return $this->redirectRoute('admin.users');
            }

            return $this->redirectRoute('stocks.index');
        }

        $this->addError('login', 'Username/email atau password yang Anda masukkan tidak sesuai.');
        return null;
    }

    public function render(): View
    {
        return view('livewire.auth.register');
    }
}

