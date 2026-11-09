<?php

namespace App\Features\Admin\Livewire;

use App\Features\Admin\Services\AdminUserService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
#[Title('User Management - Admin')]
class UserList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $roleFilter = '';
    public string $viewMode = 'bento';

    protected $queryString = [
        'search' => ['except' => ''],
        'roleFilter' => ['except' => ''],
        'viewMode' => ['except' => 'bento'],
    ];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function setRole(string $role): void
    {
        $this->roleFilter = $role;
        $this->resetPage();
    }

    public function setViewMode(string $mode): void
    {
        $this->viewMode = $mode;
    }

    public function render(AdminUserService $adminService): View
    {
        $users = $adminService->getUsersList($this->search ?: null, $this->roleFilter ?: null, 8);
        $telemetry = $adminService->getAdminTelemetry();

        return view('livewire.admin.user-list', [
            'users' => $users,
            'telemetry' => $telemetry,
        ]);
    }
}

