<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use illuminate\Http\Request;

class BaseFilter {
    protected $safeParameters = [];

    protected $columnMap = [];

    protected Builder $query;

    public function setQuery(Builder $query){
        $this->query = $query;
    }

    public function filter(Request $request){
        $eloQuery = $this->query;
        
        foreach($this->safeParameters as $parameter => $operator){
            if($request->has( $parameter )){
                $column = $this->columnMap[$parameter] ?? $parameter;

                if($operator == "like"){
                    $eloQuery->where($column, $operator, '%' . $request->query($parameter) . '%');
                }else{
                    $eloQuery->where($column, $operator, $request->query( $parameter));
                }
            }
        }

        return $eloQuery;
    }

}