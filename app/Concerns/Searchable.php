<?php


namespace App\Concerns;


trait Searchable
{
    public function getSearchIndex()
    {
        return $this->getTable();
    }
    public function getSearchType()
    {
        if (property_exists($this, 'useSearchType')) {
            return $this->useSearchType;
        }
        return $this->getTable();
    }
    public function toSearchArray()
    {
        return $this->toArray();
    }

    public abstract function getSearchFields(): array;
}
