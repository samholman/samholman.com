<?php namespace SamHolman\Site\Article;

interface Repository
{
    public function findAll();
    public function find($slug);
}
