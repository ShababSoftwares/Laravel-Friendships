<?php


namespace ShababSoftwares\Friendships\Repositories;


use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class PaginateRepository
{
    /**
     * @param Builder|MorphMany $builder
     * @param int $resultPerPage
     * @param string $paginateType
     * @return LengthAwarePaginator|Paginator|Collection
     * @throws Exception
     */
    public static function resolvePaginator(MorphMany $builder, $resultPerPage = 0,  $paginateType = 'default')
    {
        if (!in_array($paginateType, ['default', 'simple', 'none'])) {
            throw new Exception("Paginate type ins't available");
        } else {
            if ($resultPerPage === 0 || $paginateType === 'none') {
                return $builder->get();
            }
            if ($paginateType === 'default') {
                return $builder->paginate($resultPerPage);
            } else {
                return $builder->simplePaginate($resultPerPage);
            }
        }
    }
}
