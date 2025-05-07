<?php

namespace App\Repositories\Interfaces;

interface PostRepositoryInterface extends BaseRepositoryInterface
{
    public function getDerniersPosts($limit = 10);

    public function getPostsPopulaires($limit = 10);

    public function getPostsByCommunity($communityId, $paginate = 15);

    public function getPostsByUser($userId, $paginate = 15);

    public function rechercherPosts($keyword, $paginate = 15);

    public function getPostsSauvegardes($userId, $paginate = 15);

    public function sauvegarderPost($postId, $userId);
    
    public function enleverPostSauvegarde($postId, $userId);
    
    public function isPostSauvegarde($postId, $userId);
    
    public function ajouterLike($postId);
    
    public function ajouterTag($postId, $tagId);
    
    public function enleverTag($postId, $tagId);
}
