<?php /** @noinspection PsalmGlobal */

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Plugin\Pluggable;

abstract class AbstractPluggable implements VQPluggable
{
    function toHooks(): array
    {
        return [
            'actions' => array_values(
                $this instanceof VQPluggableAction && method_exists($this, 'addActions')
                    ? array_map(fn(array $params) => $this->bindHook($params), $this::addActions())
                    : []
            ),
            'filters' => array_values(
                $this instanceof VQPluggableFilter && method_exists($this, 'addFilters')
                    ? array_map(fn(array $params) => $this->bindHook($params), $this::addFilters())
                    : []
            ),
        ];
    }

    /**
     * @param  array{string, string, int|null, int|null}  $params
     *
     * @return array{string, callable, int|null, int|null}
     */
    public function bindHook(array $params): array
    {
        [$handle, $method, $priority, $acceptedArgs] = [
            $params[0],
            $params[1],
            $params[2] ?? 10,
            $params[3] ?? 1,
        ];

        return [
            $handle,
            [$this, $method],
            $priority,
            $acceptedArgs,
        ];
    }
}