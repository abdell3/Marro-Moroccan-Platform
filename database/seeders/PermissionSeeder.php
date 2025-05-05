<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $permissions = [
           
            ['name' => 'create_user'],
            ['name' => 'view_user'],
            ['name' => 'edit_user'],
            ['name' => 'delete_user'],
            ['name' => 'ban_user'],
            
         
            ['name' => 'create_community'],
            ['name' => 'view_community'],
            ['name' => 'edit_community'],
            ['name' => 'delete_community'],
            
        
            ['name' => 'create_post'],
            ['name' => 'view_post'],
            ['name' => 'edit_post'],
            ['name' => 'delete_post'],
            ['name' => 'pin_post'],
            
      
            ['name' => 'create_comment'],
            ['name' => 'view_comment'],
            ['name' => 'edit_comment'],
            ['name' => 'delete_comment'],
            
    
            ['name' => 'upvote_content'],
            ['name' => 'downvote_content'],
            

            ['name' => 'approve_content'],
            ['name' => 'reject_content'],
            ['name' => 'view_reports'],
            ['name' => 'handle_reports'],
            
      
            ['name' => 'manage_site_settings'],
            ['name' => 'view_analytics'],
            ['name' => 'manage_roles'],
        ];
        
   
        Permission::upsert($permissions, ['name']);
        
  
        $moderatorPermissions = [
            'view_user', 'ban_user',
            'view_community', 'edit_community',
            'view_post', 'edit_post', 'delete_post', 'pin_post',
            'view_comment', 'edit_comment', 'delete_comment',
            'upvote_content', 'downvote_content',
            'approve_content', 'reject_content', 'view_reports', 'handle_reports',
            'create_post', 'create_comment', 'create_community'
        ];
        
        $userPermissions = [
            'view_user',
            'view_community', 'create_community',
            'create_post', 'view_post', 'edit_post',
            'create_comment', 'view_comment', 'edit_comment', 
            'upvote_content', 'downvote_content'
        ];
        
        
        
        
        $adminRole = Role::where('role_name', 'Admin')->first();
        if ($adminRole) {
            $adminRole->permissions()->sync(Permission::pluck('id')->toArray());
        }
        
      
        $moderateurRole = Role::where('role_name', 'Moderateur')->first();
        if ($moderateurRole) {
            $moderateurRole->permissions()->sync(
                Permission::whereIn('name', $moderatorPermissions)->pluck('id')->toArray()
            );
        }
        
        
        $utilisateurRole = Role::where('role_name', 'Utilisateur')->first();
        if ($utilisateurRole) {
            $utilisateurRole->permissions()->sync(
                Permission::whereIn('name', $userPermissions)->pluck('id')->toArray()
            );
        }
    }
}
