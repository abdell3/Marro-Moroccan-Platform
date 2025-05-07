<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoryInterface;

class TagRepository extends BaseRepository implements TagRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(Tag $model)
    {
        parent::__construct($model);
    }

    public function getAllTagsAlpha()
    {
        return $this->model->orderBy('title', 'asc')->get();
    }
    public function getTagsPopulaires($limit = 10)
    {
        return $this->model->withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getTagsForPost($postId)
    {
        return $this->model->whereHas('posts', function($query) use ($postId) {
            $query->where('post_id', $postId);
        })->get();
    }
    
    public function getPostsWithTag($tagId, $paginate = 15)
    {
        $tag = $this->find($tagId);
        return $tag->posts()->with('auteur')->paginate($paginate);
    }
    
    public function tagExistsByTitle($title)
    {
        return $this->model->where('title', $title)->exists();
    }
    
    public function getTagByTitle($title)
    {
        return $this->model->where('title', $title)->first();
    }
}
