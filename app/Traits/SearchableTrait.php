<?php 

namespace App\Traits;

/**
 * 
 */
trait SearchableTrait
{
    private array $searchFields = [];

    /**
     * Добавляем новое поле для поиска
     *
     * @param string $alias
     * @param string $function
     * @param mixed ...$arguments
     * @return void
     */
    private function setSearchField(string $alias, string $function, mixed ...$arguments): void
    {
        $this->searchFields[$alias] = [
            'function' => $function,
            'arguments' => $arguments
        ];
    }

    /**
     * Возвращаем поисковое поле или false
     *
     * @param string $key
     * @return array|boolean
     */
    private function getSearchField(string $key): array|bool
    {
        if (! array_key_exists($key, $this->searchFields)) {
            return false;
        }

        return $this->searchFields[$key];
    }

    /**
     * Запускаем колбек, если поисковое поле есть в списке
     *
     * @param array $params
     * @return array
     */
    public function filterSearchField(array $params): array
    {
        foreach ($params as $key => $paramValue) {
            $searchField = $this->getSearchField($key);

            if ($searchField === false) {
                continue;
            }

            $function = $searchField['function'];
            $arguments = $searchField['arguments'];
            
            $this->$function(...$arguments, value:$paramValue);
        }

        return [];
    }
    
}
