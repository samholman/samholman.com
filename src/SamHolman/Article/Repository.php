<?php namespace SamHolman\Article;

interface Repository
{
    public function findAll();
    public function find($slug);
}
