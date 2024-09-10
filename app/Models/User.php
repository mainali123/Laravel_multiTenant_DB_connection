<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_name',
        'user_email',
        'user_phoneNumber',
        'user_password',
        'associated_company',
    ];

    protected $hidden = [
        'user_password',
    ];

    public function check_for_users($data): array
    {
        $user = User::leftJoin('companies', 'users.associated_company', '=', 'companies.id')
            ->where('user_email', $data['email'])
            ->where('user_password', $data['password'])->get();
        if ($user->count() > 0) {
            $associated_company = $user->pluck('associated_company', 'name');
            $finalResponse = ['success' => true, 'message' => $associated_company];
        } else {
            $finalResponse = ['success' => false, 'message' => 'User not found'];
        }
        return $finalResponse;
    }
}
