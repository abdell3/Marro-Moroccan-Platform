<?php

namespace App\Services\Interfaces;

interface PostServiceInterface
{
    public function getAllPosts($perPage = 15);
    public function getPostById($id);
    public function createPost($data);
    public function updatePost($id, $data);
    public function deletePost($id);
    public function getDerniersPostsPagines($perPage = 15);
    public function getDerniersPosts($limit = 10);
    public function getPostsPopulaires($limit = 10);
    public function getPostsByCommunity($communityId, $paginate = 15);
    public function getPostsByUser($userId, $paginate = 15);
    public function rechercherPosts($keyword, $paginate = 15);
    public function getPostsSauvegardes($userId, $paginate = 15);
    public function sauvegarderPost($postId, $userId);
    public function enleverPostSauvegarde($postId, $userId);
    public function likePost($postId);
    public function upvotePost($postId);
    public function downvotePost($postId);
    public function ajouterTag($postId, $tagId);
    public function enleverTag($postId, $tagId);
}
