<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers($perPage = 15)
    {
        return User::with('role')->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getUserById($id)
    {
        return User::with(['role', 'communities', 'posts', 'comments', 'badges'])->findOrFail($id);
    }

    public function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function getUsersWithRole($roleId, $perPage = 15)
    {
        return User::where('role_id', $roleId)->paginate($perPage);
    }

    public function getUsersCreatedBetween($startDate, $endDate, $perPage = 15)
    {
        return User::whereBetween('created_at', [$startDate, $endDate])
            ->paginate($perPage);
    }

    public function searchUsers($query, $perPage = 15)
    {
        return User::where('nom', 'like', "%{$query}%")
            ->orWhere('prenom', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->paginate($perPage);
    }

    public function updateUser($id, array $data)
    {
        $user = $this->getUserById($id);
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        
        $user->update($data);
        if (isset($data['badge_ids'])) {
            $user->badges()->sync($data['badge_ids']);
        }
        
        return $user;
    }

    public function updateUserRole($id, $roleId)
    {
        $user = $this->getUserById($id);
        $user->role_id = $roleId;
        $user->save();
        return $user;
    }

    public function getUserStats($id)
    {
        $user = $this->getUserById($id);
        return [
            'posts_count' => $user->posts()->count(),
            'comments_count' => $user->comments()->count(),
            'communities_count' => $user->communities()->count(),
            'reports_submitted' => DB::table('reports')->where('user_id', $id)->count(),
            'reports_received' => $this->getReportsAgainstUser($id),
            'banned_count' => DB::table('banned_users')->where('user_id', $id)->count()
        ];
    }

    public function getRecentUsers($limit = 10)
    {
        return User::orderBy('created_at', 'desc')->limit($limit)->get();
    }

    public function getUsersByActivity($limit = 10)
    {
        return User::withCount(['posts', 'comments'])
            ->orderByRaw('posts_count + comments_count DESC')
            ->limit($limit)
            ->get();
    }

    public function deleteUser($id)
    {
        $user = $this->getUserById($id);
        $user->posts()->delete();
        $user->comments()->delete();
        $user->reports()->delete();
        $user->communities()->detach();
        $user->badges()->detach();
        
        return $user->delete();
    }

    public function banUser($userId, $adminId, $reason = null, $days = 30)
    {
        $banUntil = now()->addDays($days);
        
        $ban = [
            'user_id' => $userId,
            'banned_by' => $adminId,
            'reason' => $reason ?? 'Violation des règles de la communauté',
            'banned_until' => $banUntil
        ];
        
        DB::table('banned_users')->insert($ban);
        
        return true;
    }

    public function unbanUser($userId)
    {
        return DB::table('banned_users')
            ->where('user_id', $userId)
            ->delete();
    }
    
    private function getReportsAgainstUser($userId)
    {
        return DB::table('reports')
            ->join('posts', function ($join) use ($userId) {
                $join->on('reports.reportable_id', '=', 'posts.id')
                    ->where('reports.reportable_type', '=', 'App\\Models\\Post')
                    ->where('posts.auteur_id', '=', $userId);
            })
            ->orJoin('comments', function ($join) use ($userId) {
                $join->on('reports.reportable_id', '=', 'comments.id')
                    ->where('reports.reportable_type', '=', 'App\\Models\\Comment')
                    ->where('comments.auteur_id', '=', $userId);
            })
            ->count();
    }
}
