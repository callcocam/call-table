<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 14/04/2018
 * Time: 01:13
 */

namespace Table\Drivers;


abstract class Where
{


    protected $concat = '';
    protected $like = '';
    protected $offset = '';
    protected $limit = '';
    protected $order = '';
    protected $between = [];
    protected $where = [];

    public function setBetween($between){
        $this->between[] = "{$between} BETWEEN :start_date AND :end_date";
        return $this;
    }
    public function setLike( $queryString, $searchTerm )
    {
        $this->like = "{$queryString} LIKE '%{$searchTerm}%'";
        return $this;
    }

    public function setConcat( array $columns, $searchTerm, $condiction = "LIKE" )
    {
        $columns = implode(",", $columns);
        $this->concat = "CONCAT_WS(' ', {$columns} ) {$condiction} '%{$searchTerm}%'";
        return $this->concat;
    }

    public function setWhere( $params)
    {
        $this->where[$params] = sprintf( '%s=:%s',$params,$params);
        return $this;
    }

    public function setOrder( $field, $order = "ASC" )
    {
        $this->order = sprintf("ORDER BY %s %s", $field, $order);
        return $this;
    }

    public function getLimit( $limit )
    {
        $this->limit = sprintf("LIMIT %s", $limit);
        return $this;
    }

    public function getOffset( $Offset )
    {
        $this->offset = sprintf("OFFSET %s", $Offset);
        return $this;
    }

}