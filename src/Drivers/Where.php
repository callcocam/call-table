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
    protected $where = [];

    public function setLike( $queryString, $searchTerm )
    {
        $this->like = "{$queryString} LIKE '%{$searchTerm}%'";
        return $this->like;
    }

    public function setConcat( array $colls, $searchTerm, $condiction = "LIKE" )
    {
        $colls = implode(",", $colls);
        $this->concat = "CONCAT_WS(' ', {$colls} ) {$condiction} '%{$searchTerm}%'";
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
    }

    public function getLimit( $limit )
    {
        $this->limit = sprintf("LIMIT %s", $limit);
    }

    public function getOffset( $Offset )
    {
        $this->offset = sprintf("OFFSET %s", $Offset);
    }

}