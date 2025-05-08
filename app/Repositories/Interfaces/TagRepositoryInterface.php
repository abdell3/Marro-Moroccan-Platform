<?php

namespace App\Repositories\Interfaces;



use App\Repositories\Interfaces\BaseRepositoryInterface;

interface TagRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllTagsAlpha();
    public function getTagsPopulaires($limit = 10);
    public function getTagsForPost($postId);
    public function getPostsWithTag($tagId, $paginate = 15);
    public function tagExistsByTitle($title);
    public function getTagByTitle($title);
}
