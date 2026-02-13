<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Notifications\WelcomeInviteNotification;

class CreateUser extends Component
{
    public $first_name, $last_name, $email, $role;

    protected $rules = [
        'first_name' => 'required|string|min:2',
        'last_name' => 'required|string|min:2',
        'email' => 'required|email|unique:users,email',
        'role' => 'required|exists:roles,name',
    ];

    public function save()
    {
        $this->validate();

        // Automatically use the Admin's Organization ID
        $adminOrgId = auth()->user()->organization_id;
        $originalTeamId = getPermissionsTeamId();

        try {
            $user = DB::transaction(function () use ($adminOrgId) {
                $newUser = User::create([
                    'first_name' => $this->first_name,
                    'last_name' => $this->last_name,
                    'email' => $this->email,
                    'organization_id' => $adminOrgId, // Forced to Admin's Org
                    'password' => Hash::make(Str::random(32)),
                    'password_set_at' => null,
                ]);

                // Scope permissions to this organization
                setPermissionsTeamId($adminOrgId);
                $newUser->assignRole($this->role);

                return $newUser;
            });

            $user->notify(new WelcomeInviteNotification());

            setPermissionsTeamId($originalTeamId);
            $this->dispatch('close-user-modal');

            $this->dispatch('swal:modal', [
                'type'  => 'success',
                'title' => 'Member Invited',
                'text'  => "{$this->first_name} has been added to your organization.",
            ]);

            $this->reset(['first_name', 'last_name', 'email', 'role']);

        } catch (\Exception $e) {
            setPermissionsTeamId($originalTeamId);
            session()->flash('error', "Error: " . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.create-user', [
            // Only fetch the specific roles allowed for tenant users
            'roles' => Role::whereIn('name', ['requester', 'approver', 'disburser'])->get()
        ]);
    }
}
