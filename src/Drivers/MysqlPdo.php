<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 14/04/2018
 * Time: 00:13
 */

namespace Table\Drivers;


class MysqlPdo implements DriverStrategy
{

    protected $pdo;
    protected $table;
    protected $condiction;
    /**
     * @var \PDOStatement
     */
    protected $query;

    public function __construct( \PDO $pdo )
    {
        $this->pdo = $pdo;
    }

    public function setTable( string $table )
    {
        $this->table = $table;
        return $this;
    }

    public function select( $field = "*" )
    {
        $query[] = "SELECT {$field} FROM {$this->table}";
        if ($this->condiction) {
            $query[] = implode(' ', $this->condiction);
        }
        var_dump(implode(' ', $query));
        $this->query = $this->pdo->prepare(implode(' ', $query));
        return $this;
    }

    public function count( $field )
    {
        $query[] = "SELECT COUNT({$field}) as total FROM {$this->table}";
        if ($this->condiction) {
            $query[] = implode(' ', $this->condiction);
        }
        var_dump(implode(' ', $query));
        $this->query = $this->pdo->prepare(implode(' ', $query));
        return $this;
    }


    public function exec( string $query = null )
    {
        if ($query) {
            $this->query = $this->pdo->prepare($query);
        }
        $this->query->execute();
        $this->condiction = [];
        return $this;
    }

    public function first()
    {
        return $this->query->fetch(\PDO::FETCH_ASSOC);
    }

    public function all()
    {
        return $this->query->fetchaLL(\PDO::FETCH_ASSOC);
    }

    public function where(array $where )
    {
        if ($where) {
            if ($this->condiction) {
                $this->condiction[] = ' AND ';
            } else {
                $this->condiction[] = ' WHERE ';
            }
            $this->condiction[] = implode(" ", $where);
        }

        return $this;
    }

    public function like( $like )
    {
        if (!empty($like)) {
            if ($this->condiction) {
                $this->condiction[] = ' AND ';
            } else {
                $this->condiction[] = ' WHERE ';
            }
            $this->condiction[] = $like;
        }

        return $this;
    }

    public function concat( $concat )
    {
        if (!empty($concat)) {
            if ($this->condiction) {
                $this->condiction[] = ' AND ';
            } else {
                $this->condiction[] = ' WHERE ';
            }
            $this->condiction[] = $concat;
        }

        return $this;
    }

    public function setLimit( $limit )
    {
        if ($limit)
            $this->condiction[] = $limit;
        return $this;
    }


    public function setOffset( $offset )
    {
        if ($offset)
            $this->condiction[] = $offset;
        return $this;
    }

    public function setOrder( $order )
    {
        if ($order)
            $this->condiction[] = $order;
        return $this;
    }

    public function bind( $data )
    {
        if ($data):
            foreach ($data as $field => $value) {
//                echo "<pre>";
//                var_dump([$field,$value]);
//                echo "</pre>";
                $this->query->bindValue($field, $value);
            }
        endif;
        return $this;
    }

}