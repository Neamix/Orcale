<?php

namespace App\Http\Controllers;

use App\Models\show;
use App\Respatory\showRepo;
use App\Result;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    /** ================= Get Repo ================ */
    public $show;
    public function __construct(showRepo $show)
    {
        $this->show = $show;
    }

    /**
     * Get all genres
     * @return array => genres
    */

    public function genre_ids()
    {
        $genre = $this->show->genre_ids();
        return $genre;
    }

    /**
     * Get genre of show type
     * @param type => movie tv
     * @return bool message 
     * @return array payload => genre
     */
    public function genre_id($type)
    {
        $genre = $this->show->genre_id($type);

        return Result::response(true,$genre);
    }

    /**
     * Get show collection
     * @param type
     * @param page
     * @param provider
     * @return array => shows
    */

    public function get(Request $request,string $type,int $page = 1,$sort = 'popular')
    {
        $next = (!empty($request->only('next'))) ? $request->only('next')['next'] : false;

        $shows = $this->show->type($type)->sortBy($sort)->page($page)->next($next)->get();
        
        if($type == 'person') {
            $shows = $this->show->collected('chunk',$shows['results'],2);
        }

        return $shows;
    }
    
    /**
     * Get show collection by category
     * @param cat
     * @param page
     * @param provider
     * @return array => shows
    */

    public function getByCategory(Request $request,$type,int $page = 1,int|null $cat = null,array $provider = [])
    {
        $next = (!empty($request->only('next'))) ? $request->only('next')['next'] : false;
        $shows = $this->show
                      ->provider($provider)
                      ->page($page)
                      ->type($type)
                      ->next($next)
                      ->getByCategory($cat);
        return $shows;
    }

    /**
     * Get a movie 
     * @param type
     * @param id
     * @return array => movie
    */

    public function find(Request $request,string $type,int $id = 1)
    {
        $shows = $this->show
                      ->type($type)
                      ->provider($request->provider)
                      ->find($id);
        return $shows;
    }

    /**
     * Get shows by keyword or query
     * @param search
     * @param type
    */

    public function search(Request $request,string $type,string $search,int $limit = null)
    {
        $next = (isset($request->next)) ? $request->next : false;
        $page = (isset($request->page)) ? $request->page : 1;
        $shows = $this->show
                      ->searchFor($type)
                      ->page($page)
                      ->next($next)
                      ->fetch($search);

        if($limit !== null)
        {
            return $this->show->collected('limit',$shows['results'],$limit);
        }

        return $shows;

    }

    public function people()
    {
        $ppl = $this->show
                    ->type('person')
                    ->get();
        return $ppl;
    }

    public function person($id)
    {
        $ppl = $this->show->person($id);
        return $ppl;   
    }

    public function actions(Request $request)
    {
        $shows = $this->show
                      ->type($request->show_type)
                      ->find($request->id);
        $name =  $shows['name'] ?? $shows['title'];
        show::action(['id' => $shows['id'],'name'=>$name,'type'=>$request->show_type,'poster_path' => $shows['poster_path']],$request->short);
    }

}
