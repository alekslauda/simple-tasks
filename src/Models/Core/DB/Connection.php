<?php

namespace Application\Models\Core\DB;

use Aura\Sql\ExtendedPdo;
use Aura\SqlQuery\QueryFactory;

class Connection 
{
    private $PDO;

    private $queryFactory;

    public function __construct(ExtendedPdo $PDO)
    {
        $this->PDO = $PDO;
        $this->queryFactory = new QueryFactory('mysql');
    }

    public function getQueryFactory()
    {
        return $this->queryFactory;	
    }

    public function getPDO()
    {
        return $this->PDO;
    }

    public function insert($table, array $data)
    {
        if ($data == false) {
            throw new \RuntimeException('No Data passed');
        }

        $keys = array_keys($data);

        $sql = 'INSERT INTO ' . $table . ' (' . implode(', ', $keys) . ') VALUES (:' . implode(', :', $keys) . ');';

        $query = $this->PDO->prepare($sql);

        foreach ($data as $key => $value) {
                $query->bindValue(':' . $key, $data[$key]);
        }

        $query->execute();

        $insert = $query->rowCount();

        if ($insert) {
            return (int)$this->PDO->lastInsertId();
        }

        throw new \RuntimeException('Insert Failed');
    }
}