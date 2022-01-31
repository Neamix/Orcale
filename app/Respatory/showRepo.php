<?php 

namespace App\Respatory;

use App\Models\show;
use Closure;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Http;

class showRepo implements showRepoInterface {

    /** Variabels */

    protected $key;
    protected $base_url = 'https://api.themoviedb.org/3/';
    protected $sortBy   = 'popular';
    protected $type     = 'movie';
    protected $typeArr  = ['movie','tv','person'];
    protected $provider;
    protected $page = 1;
    protected $get;
    protected $next = false;

    public function key()
    {
        return '?api_key='.$this->key = "ca0d6bdec253ff1f6b0fe8d0b7f7c717";
    }

    /**
     * Resort the output show depend on the value
     * 
     * @param sort 
     * @return instance 
    */

    public function sortBy(string $sort)
    {
        $this->sortBy  = $sort; 
        
        return $this;
    }

    /**
     *  Set provider to shows
     *  @param provider 
     *  @return instacne 
    */

    public function provider($provider = [])
    {
        if(gettype($provider) == 'array')
        {
            $this->provider = implode(',',$provider);
        } else $this->provider = $provider;

        return  $this;
    }

    /**
     * Detect the type of show
     * @param type => tv | movie
     * @return instance
    */

    public function type(string $type)
    {
        $this->type = $type;
        
        return $this;
    }

    public function page(int $page)
    {
        $this->page = $page;

        return $this;
    }

    public function next($next)
    {
        $this->next = $next;
        return $this;
    }

     /**
     * get a person by id
     * @param id => person id
     * @return array 
    */

    public function person($id) 
    {
       $request = "https://api.themoviedb.org/3/person/$id".$this->key()."&language=en-US&append_to_response=combined_credits"  ;
       $request = Http::get($request)->json();
       ##Combined
       $cast = (isset($request['combined_credits']['cast'])) ? $request['combined_credits']['cast'] : [];
       $crew =  (isset($request['combined_credits']['crew'])) ? $request['combined_credits']['crew'] : [];
       $collection = static::collected('merge',[$cast,$crew])->toArray();
       $request['combined_credits']['cast'] = $collection;
       $request['combined_credits']['crew'] = [];
       return $request;
    }


    /**
     * get a show by id
     * @param args => return request with decalre value
     * @return array 
    */

    public function find(int $id,$provider = [])
    {
        if(in_array($this->type,$this->typeArr))
        {

            $request = $this->base_url.$this->type.'/'.$id . $this->key().'&append_to_response='.$this->provider;

            $request = Http::get($request)->json();

            if(str_contains($this->provider,'credits'))
            {
                $cast = (isset($request['credits']['cast'])) ? $request['credits']['cast'] : [];
                $crew =  (isset($request['credits']['crew'])) ? $request['credits']['crew'] : [];
                $collection = static::collected('merge',[$cast,$crew])->chunk(2)->toArray();
                $request['credits']['cast'] = $collection;
                $request['credits']['crew'] = [];
            }

            return $request;

        } else throw new Exception('The type of request must be set to tv | movie, the given type is either set to null or undefined');
    }

    /**
     * Detect the type of show
     * @param args => return request with decalre value
     * @return array 
    */
    
    public function get()
    {
        if(in_array($this->type,$this->typeArr))
        {  
            $get = ($this->sortBy == 'discover') ? $this->sortBy .'/'. $this->type : $this->type .'/'. $this->sortBy;

            $request = $this->base_url.  $get . $this->key().'&page='.$this->page;

            $request = Http::get($request)->json();

            if($this->next)
            {
                $nextRequest = $this->base_url.  $get . $this->key().'&page='.$this->page + 1;
                $nextRequest =   Http::get($nextRequest)->json();
                
                $request = $this->collected('merge',[$request['results'],$nextRequest['results']]);
            }

            return $request;

        } else throw new Exception('The type of request must be set to tv | movie, the given type is either set to null or undefined');
    }

    /**
     * Get shows depend on there category
     * @param $data
     * @return array
     */

    public function getByCategory($id) {
        $key = $this->key();

        $type = $this->type;

        $genreShow = [];

        $provider = $this->provider;

        $request = $this->base_url.'discover/'.$type.$key.'&append_to_response='.$provider ."&with_genres=$id".'&page='.$this->page;

        $request = Http::get($request)->json();

        if($this->next)
        {
            $nextRequest = $this->base_url.'discover/'.$type.$key.'&append_to_response='.$provider ."&with_genres=$id".'&page='.$this->page + 1;
            $nextRequest =   Http::get($nextRequest)->json();
            $request = $this->collected('merge',[$request['results'],$nextRequest['results']]);
        }
        
        return $request;
    }

    /**
     *  Get show genre
     * @param type => tv|movie
     * @return collection
     */

    public function genre_id($type) {

        $key = $this->key();
        
        return $this->collected('map',Http::get("https://api.themoviedb.org/3/genre/$type/list$key&language=en-US")->json()['genres']);
    }


    /**
     * Get all genre of tv|movie togther
     * @return collection
     */

    public function genre_ids()
    {
        return [
            'movie' => $this->genre_id('movie')->toArray(),
            'tv'     => $this->genre_id('tv')->toArray()
        ];
    }

    /**
     * @param type => chunk,map,merge
     * @param arr -> array need to apply collection on it 
     * @param limit => [0,9]
     * @return collection
    */

    public static function collected($type,$arr = [],$limit = null) {
        if($type == 'chunk') {
           $collection = collect($arr)->chunk($limit);
        } else if($type == 'map') {
          $collection = collect($arr)->mapWithKeys(function($arr){
             return [$arr['id'] => $arr['name']];
          });
        } else if($type == 'merge') {
          $collection = collect($arr[0])->merge($arr[1]);
        } else if($type == 'limit') {
          $collection = collect($arr)->take($limit);
        }
        
        return $collection;
    }

    public function searchFor(string $get)
    {
        $this->get = $get;
        return $this;
    }

    /**
     * Get array of shows that have keyword | genre that provided 
     * @param search 
     * 
     */
    public function fetch(string | int $search)
    {
        $request = $this->base_url . 'search/'. $this->get . $this->key() . "&language=en-US&page=1&include_adult=false&query=$search".'&page='.$this->page;

        $request =  Http::get($request)->json();

        if($this->next)
        {
            $nextRequest = $this->base_url . 'search/tv' . $this->key() . "&language=en-US&page=1&include_adult=false&query=$search".'&page='.$this->page + 1;
            $nextRequest =   Http::get($nextRequest)->json();
            $request = $this->collected('merge',[$request['results'],$nextRequest['results']]);
        } else {
            if(!empty($request['results']))
            {
                return \array_slice($request['results'],0,7);
            }
        }

        return $request;
    }

    public function latest() {
        $request =$this->base_url . 'tv/latest'. $this->get . $this->key();
        return dd(Http::get($request)->json(),$request);
    }
}
 

