<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Services\Interfaces\TagServiceInterface;

class TagService implements TagServiceInterface
{
    protected $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function getAllTags()
    {
        return $this->tagRepository->all();
    }
    
    public function getAllTagsAlpha()
    {
        return $this->tagRepository->getAllTagsAlpha();
    }
    
    public function getTagById($id)
    {
        return $this->tagRepository->find($id);
    }
    
    public function createTag($data)
    {
        $data['title'] = trim($data['title']);
        
        if ($this->tagRepository->tagExistsByTitle($data['title'])) {
            return $this->tagRepository->getTagByTitle($data['title']);
        }
        return $this->tagRepository->create($data);
    }
    public function updateTag($id, $data)
    {
        if (isset($data['title'])) {
            $data['title'] = trim($data['title']);
        }
        return $this->tagRepository->update($id, $data);
    }
    
    public function deleteTag($id)
    {
        return $this->tagRepository->delete($id);
    }
    
    public function getTagsPopulaires($limit = 10)
    {
        return $this->tagRepository->getTagsPopulaires($limit);
    }
    
    public function getTagsForPost($postId)
    {
        return $this->tagRepository->getTagsForPost($postId);
    }
    
    public function getPostsWithTag($tagId, $paginate = 15)
    {
        return $this->tagRepository->getPostsWithTag($tagId, $paginate);
    }
    
    public function getOrCreateTagByTitle($title, $description = null)
    {
        $title = trim($title);
        
        if ($this->tagRepository->tagExistsByTitle($title)) {
            return $this->tagRepository->getTagByTitle($title);
        }
        $data = [
            'title' => $title,
            'description' => $description,
        ];
        return $this->tagRepository->create($data);
    }
    
    public function attachTagsToPost($postId, $tagTitles)
    {
        $tagIds = [];
        if (is_string($tagTitles)) {
            $tagTitles = explode(',', $tagTitles);
        }
        foreach ($tagTitles as $title) {
            $title = trim($title);
            if (empty($title)) {
                continue;
            }
            $tag = $this->getOrCreateTagByTitle($title);
            $tagIds[] = $tag->id;
        }
        $post = Post::find($postId);
        $post->tags()->sync($tagIds);
        return $post;
    }
}
