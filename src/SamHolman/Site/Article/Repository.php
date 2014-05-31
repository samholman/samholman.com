<?php namespace SamHolman\Site\Article;

interface Repository
{
    public function findAll($start=0, $limit=1);
    public function find($slug);
    public function count();
}
