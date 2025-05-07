<?php

namespace App\Services\Interfaces;

interface TagServiceInterface
{
    public function getAllTags();
    public function getAllTagsAlpha();
    public function getTagById($id);
    public function createTag($data);
    public function updateTag($id, $data);
    public function deleteTag($id);
    public function getTagsPopulaires($limit = 10);
    public function getTagsForPost($postId);
    public function getPostsWithTag($tagId, $paginate = 15);
    public function getOrCreateTagByTitle($title, $description = null);
    public function attachTagsToPost($postId, $tagTitles);
}
