<?php namespace FelipeeDev\LaravelSortable;

/**
 * Trait Sortable
 * @package FelipeeDev\LaravelSortable
 *
 * @property array attributes
 * @method \Illuminate\Database\Eloquent\Builder newQuery()
 */
trait Sortable
{
    /**
     * Get current sorting sequence value.
     *
     * @return int
     */
    public function getSortSeq()
    {
        return (int) array_get($this->attributes, $this->getSortSeqCol());
    }

    /**
     * Get sorting sequence column name.
     *
     * @return int
     */
    public function getSortSeqCol()
    {
        return (int )object_get($this, 'sort_seq_column', 'sort_seq');
    }

    /**
     * Get sorting scope.
     *
     * @return array
     */
    public function getSortScope()
    {
        return (array) object_get($this, 'sort_scope_col', []);
    }

    /**
     * Get a new sorting query builder for the model's table.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newSortQuery()
    {
        $query = $this->newQuery();
        foreach ($this->getSortScope() as $scopeAttribute) {
            if ($scopeValue = object_get($this, $scopeAttribute)) {
                $query->where($scopeAttribute, $scopeValue);
                continue;
            }
            $query->whereNull($scopeAttribute);
        }
        return $query;
    }
}
