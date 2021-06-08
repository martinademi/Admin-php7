<?php

/**
 * DataTable
 */
class DataTable
{
    private $requestData;

    public function __construct($requestSrc = null)
    {
        $requestSrc = is_null($requestSrc) ? $_POST : $requestSrc;

        $this->requestData = [
            'draw'    => isset($requestSrc['draw']) ? intval($requestSrc['draw']) : 0,
            'columns' => isset($requestSrc['columns']) ? $requestSrc['columns'] : 0,
            'order'   => isset($requestSrc['order']) ? $requestSrc['order'] : 0,
            'start'   => isset($requestSrc['start']) ? intval($requestSrc['start']) : 0,
            'length'  => isset($requestSrc['length']) ? intval($requestSrc['length']) : 0,
            'search'  => isset($requestSrc['search']) ? $requestSrc['search'] : 0,
        ];
    }

    public static function isValid($requestSrc = null)
    {
        $requestSrc = is_null($requestSrc) ? $_POST : $requestSrc;

        if (isset($requestSrc['draw']) && isset($requestSrc['columns']) && is_array($requestSrc['columns'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getDraw()
    {
        return $this->requestData['draw'];
    }

    public function getStart()
    {
        return $this->requestData['start'];
    }

    public function getLength()
    {
        return $this->requestData['length'];
    }

    public function getGlobalSearch()
    {
        return $this->requestData['search']['value'];
    }

    public function getOrderColumn()
    {
        return $this->requestData['columns'][$this->requestData['order'][0]['column']]['name'];
    }

    public function getOrderDirection()
    {
        return $this->requestData['order'][0]['dir'];
    }

    public function getColumns()
    {
        return $this->requestData['columns'];
    }

    public function getSearches()
    {
        $searches = [];

        foreach ($this->requestData['columns'] as $column) {
            if (strlen($column['search']['value'])) {
                $searches[] = ['column' => $column['name'], 'value' => $column['search']['value']];
            }
        }

        return $searches;
    }

    public function getSearch($columnName)
    {
        $index = array_search($columnName, array_column($this->requestData['columns'], 'name'));

        if ($index === false) {
            return false;
        }

        return $this->requestData['columns'][$index]['search']['value'];
    }

    public function sendResponse($data, $recordsTotal, $recordsFiltered)
    {
        $draw = $this->requestData['draw'];

        return compact('draw', 'recordsTotal', 'recordsFiltered', 'data');
    }

    public function sendError($error)
    {
        $draw = $this->requestData['draw'];
        $data = [];

        return compact('draw', 'data', 'error');
    }
}
