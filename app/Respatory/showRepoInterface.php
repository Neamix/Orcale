<?php 

namespace App\Respatory;


interface showRepoInterface {
    public function key(); //get the provider key
    public function sortBy(string $sort); //sort the return data
    public function type(string $type); //tv 0r movie or persons
    public function find(int $id,$provider = []); //get show by id
    public function get(); //return data in general
    public function getByCategory($id); //return data by genre
    public function genre_id($type); //get tv or movie genre seprated
    public function genre_ids(); //get tv and movie togther
    public static function collected($type,$arr = [],$limit = null); //laravel collection 
    public function person($id); //get person by id
}