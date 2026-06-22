<?php
/**
 * 模型基类
 * 所有模型都继承此类
 */

class Model {
    protected $db;
    protected $table;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * 获取所有记录
     */
    public function getAll($orderBy = 'id DESC', $limit = null, $offset = null) {
        $sql = "SELECT * FROM {$this->table}";
        
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        
        if ($limit !== null) {
            $sql .= " LIMIT {$limit}";
            if ($offset !== null) {
                $sql .= " OFFSET {$offset}";
            }
        }
        
        return $this->db->fetchAll($sql);
    }
    
    /**
     * 根据ID获取记录
     */
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->db->fetchOne($sql, [$id]);
    }
    
    /**
     * 根据条件获取记录
     */
    public function getBy($conditions, $orderBy = 'id DESC', $limit = null) {
        $where = [];
        $params = [];
        
        foreach ($conditions as $key => $value) {
            $where[] = "{$key} = ?";
            $params[] = $value;
        }
        
        $sql = "SELECT * FROM {$this->table} WHERE " . implode(' AND ', $where);
        
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        
        if ($limit !== null) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->fetchAll($sql, $params);
    }
    
    /**
     * 获取单条记录
     */
    public function getOneBy($conditions) {
        $where = [];
        $params = [];
        
        foreach ($conditions as $key => $value) {
            $where[] = "{$key} = ?";
            $params[] = $value;
        }
        
        $sql = "SELECT * FROM {$this->table} WHERE " . implode(' AND ', $where);
        return $this->db->fetchOne($sql, $params);
    }
    
    /**
     * 创建记录
     */
    public function create($data) {
        return $this->db->insert($this->table, $data);
    }
    
    /**
     * 更新记录
     */
    public function update($id, $data) {
        return $this->db->update($this->table, $data, 'id = ?', [$id]);
    }
    
    /**
     * 删除记录
     */
    public function delete($id) {
        return $this->db->delete($this->table, 'id = ?', [$id]);
    }
    
    /**
     * 获取记录总数
     */
    public function count($conditions = []) {
        if (empty($conditions)) {
            $sql = "SELECT COUNT(*) as count FROM {$this->table}";
            $result = $this->db->fetchOne($sql);
        } else {
            $where = [];
            $params = [];
            
            foreach ($conditions as $key => $value) {
                $where[] = "{$key} = ?";
                $params[] = $value;
            }
            
            $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE " . implode(' AND ', $where);
            $result = $this->db->fetchOne($sql, $params);
        }
        
        return $result ? $result['count'] : 0;
    }
    
    /**
     * 搜索记录
     */
    public function search($keyword, $fields = ['name'], $orderBy = 'id DESC', $limit = null) {
        $conditions = [];
        $params = [];
        
        foreach ($fields as $field) {
            $conditions[] = "{$field} LIKE ?";
            $params[] = "%{$keyword}%";
        }
        
        $sql = "SELECT * FROM {$this->table} WHERE " . implode(' OR ', $conditions);
        
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        
        if ($limit !== null) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->fetchAll($sql, $params);
    }
    
    /**
     * 分页获取记录
     */
    public function paginate($page = 1, $perPage = 20, $conditions = [], $orderBy = 'id DESC') {
        $offset = ($page - 1) * $perPage;
        
        $where = '';
        $params = [];
        
        if (!empty($conditions)) {
            $whereConditions = [];
            foreach ($conditions as $key => $value) {
                $whereConditions[] = "{$key} = ?";
                $params[] = $value;
            }
            $where = 'WHERE ' . implode(' AND ', $whereConditions);
        }
        
        // 获取总数
        $countSql = "SELECT COUNT(*) as count FROM {$this->table} {$where}";
        $countResult = $this->db->fetchOne($countSql, $params);
        $total = $countResult ? $countResult['count'] : 0;
        
        // 获取数据
        $sql = "SELECT * FROM {$this->table} {$where} ORDER BY {$orderBy} LIMIT {$perPage} OFFSET {$offset}";
        $data = $this->db->fetchAll($sql, $params);
        
        return [
            'data' => $data,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
            'from' => $offset + 1,
            'to' => min($offset + $perPage, $total)
        ];
    }
}