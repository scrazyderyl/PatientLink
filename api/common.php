<?php
    function queryOnceRun($sql, $query, $types, $params) {
        $stmt = initializeQuery($sql, $query, $types, $params);
        
        $stmt->execute();
        $stmt->close();
    }

    function queryOnceExists($sql, $query, $types, $params) {
        $stmt = initializeQuery($sql, $query, $types, $params);
        
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows !== 0;
        $stmt->close();
        
        return $exists;
    }

    function queryOnceGetData($sql, $query, $types, $params) {
        $result = null;
        $stmt = initializeQuery($sql, $query, $types, $params);
        
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows !== 0) {
            $result = [];

            for ($i = 0; $i < $stmt->num_rows; $i++) {
                $metadata = $stmt->result_metadata();
                $row = [];

                while ($column = $metadata->fetch_field()) {
                    $row[] = &$result[$i][$column->name];
                }

                call_user_func_array(array($stmt, 'bind_result'), $row);
                $stmt->fetch();
            }
        }
        
        $stmt->close();
        
        return $result;
    }

    function initializeQuery($sql, $query, $types, $params) {
        $stmt = $sql->prepare($query);
        
        if ($types) {
            switch (count($params)) {
                case 1:
                    $stmt->bind_param($types, $params[0]);
                    break;
                case 2:
                    $stmt->bind_param($types, $params[0], $params[1]);
                    break;
                case 3:
                    $stmt->bind_param($types, $params[0], $params[1], $params[2]);
                    break;
                case 4:
                    $stmt->bind_param($types, $params[0], $params[1], $params[2], $params[3]);
                    break;
                case 5:
                    $stmt->bind_param($types, $params[0], $params[1], $params[2], $params[3], $params[4]);
                    break;
                default:
                    call_user_func_array(array($stmt, "bind_param"), array_merge([$types], $params));
                    break;
            }
        }
        
        return $stmt;
    }
    ?>
