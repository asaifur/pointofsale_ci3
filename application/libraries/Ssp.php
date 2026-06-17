<?php
class SSP
{

    public static function simple($request, $conn, $table, $primaryKey, $columns)
    {
        $bindings = [];
        $limit = self::limit($request);
        $order = self::order($request, $columns);
        $where = self::filter($request, $columns, $bindings);

        $cols = implode(", ", self::pluck($columns, 'db'));

        $sql = "SELECT {$cols}
                FROM {$table}
                {$where}
                {$order}
                {$limit}";

        $data = self::sql_exec($conn, $bindings, $sql);

        $resFilterLength = self::sql_exec(
            $conn,
            $bindings,
            "SELECT COUNT({$primaryKey}) FROM {$table} {$where}"
        );
        $recordsFiltered = $resFilterLength[0][0];

        $resTotalLength = self::sql_exec(
            $conn,
            [],
            "SELECT COUNT({$primaryKey}) FROM {$table}"
        );
        $recordsTotal = $resTotalLength[0][0];

        return [
            "draw" => intval($request['draw']),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => self::data_output($columns, $data)
        ];
    }

    private static function data_output($columns, $data)
    {
        $out = [];

        foreach ($data as $row) {
            $rowData = [];

            foreach ($columns as $col) {
                $rowData[$col['dt']] = $row[$col['db']];
            }

            $out[] = $rowData;
        }

        return $out;
    }

    private static function limit($request)
    {
        if (isset($request['start']) && $request['length'] != -1) {
            return "LIMIT " . intval($request['start']) . ", " . intval($request['length']);
        }
        return '';
    }

    private static function order($request, $columns)
    {
        if (!isset($request['order'])) return '';

        $order = [];

        foreach ($request['order'] as $ord) {
            $colIdx = intval($ord['column']);
            $dir = $ord['dir'] === 'asc' ? 'ASC' : 'DESC';
            $order[] = $columns[$colIdx]['db'] . ' ' . $dir;
        }

        return 'ORDER BY ' . implode(', ', $order);
    }

    private static function filter($request, $columns, &$bindings)
    {
        if (empty($request['search']['value'])) return '';

        $search = $request['search']['value'];
        $like = [];

        foreach ($columns as $col) {
            $like[] = "{$col['db']} LIKE '%{$search}%'";
        }

        return 'WHERE (' . implode(' OR ', $like) . ')';
    }

    private static function sql_exec($conn, $bindings, $sql)
    {
        $query = $conn->query($sql);
        return $query->result_array();
    }

    private static function pluck($a, $prop)
    {
        return array_map(fn($x) => $x[$prop], $a);
    }
}
