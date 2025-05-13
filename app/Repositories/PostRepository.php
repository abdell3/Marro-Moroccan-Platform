<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function getDerniersPostsPagines($perPage = 15)
    {
        return $this->model->with(['auteur', 'community', 'tags', 'votes', 'comments', 'savedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getDerniersPosts($limit = 10)
    {
        return $this->model->with(['auteur', 'community'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getPostsPopulaires($limit = 10)
    {
        return $this->model->with(['auteur', 'community'])
            ->orderBy('like', 'desc')
            ->limit($limit)
            ->get();
    }
    
    public function getPostsByCommunity($communityId, $paginate = 15)
    {
        return $this->model->with(['auteur', 'community'])
            ->where('community_id', $communityId)
            ->orderBy('created_at', 'desc')
            ->paginate($paginate);
    }

    public function getPostsByUser($userId, $paginate = 15)
    {
        return $this->model->with(['auteur', 'community'])
            ->where('auteur_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($paginate);
    }
    
    public function rechercherPosts($keyword, $paginate = 15)
    {
        return $this->model->with(['auteur', 'community'])
            ->where('titre', 'like', "%{$keyword}%")
            ->orWhere('contenu', 'like', "%{$keyword}%")
            ->orderBy('created_at', 'desc')
            ->paginate($paginate);
    }
    
    public function getPostsSauvegardes($userId, $paginate = 15)
    {
        return $this->model->with(['auteur', 'community'])
            ->whereHas('savedBy', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($paginate);
    }

    public function sauvegarderPost($postId, $userId)
    {
        $post = $this->find($postId);

        if ($post->savedBy()->where('user_id', $userId)->exists()) {
            return true; 
        }
        $post->savedBy()->attach($userId);
        return true;
    }

    public function enleverPostSauvegarde($postId, $userId)
    {
        $post = $this->find($postId);
        $post->savedBy()->detach($userId);
        return true;
    }

    public function isPostSauvegarde($postId, $userId)
    {
        $post = $this->find($postId);
        return $post->savedBy()->where('user_id', $userId)->exists();
    }

    public function ajouterLike($postId)
    {
        $post = $this->find($postId);
        $post->increment('like');
        return $post;
    }
    
    public function upvotePost($postId)
    {
        $post = $this->find($postId);
        $userId = auth()->id();
        $vote = $post->votes()->where('user_id', $userId)->first();
        
        if (!$vote) {
            $post->votes()->create([
                'user_id' => $userId,
                'vote_type' => 'upvote'
            ]);
            $post->increment('like');
        } elseif ($vote->vote_type == 'upvote') {
            $vote->delete();
            $post->decrement('like');
        } else {
            $vote->update(['vote_type' => 'upvote']);
            $post->increment('like', 2);
        }
        return $post;
    }
    
    public function downvotePost($postId)
    {
        $post = $this->find($postId);
        $userId = auth()->id();
        $vote = $post->votes()->where('user_id', $userId)->first();
        
        if (!$vote) {
            $post->votes()->create([
                'user_id' => $userId,
                'vote_type' => 'downvote'
            ]);
            $post->decrement('like');
        } elseif ($vote->vote_type == 'downvote') {
            $vote->delete();
            $post->increment('like');
        } else {
            $vote->update(['vote_type' => 'downvote']);
            $post->decrement('like', 2);
        }
        return $post;
    }

    public function ajouterTag($postId, $tagId)
    {
        $post = $this->find($postId);
        if ($post->tags()->where('tag_id', $tagId)->exists()) {
            return true;
        }
        $post->tags()->attach($tagId);
        return true;
    }
    
    public function enleverTag($postId, $tagId)
    {
        $post = $this->find($postId);
        $post->tags()->detach($tagId);
        return true;
    }
}
