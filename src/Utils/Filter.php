<?php

namespace App\Utils;

use App\Exception\RequestValidationException;
use BadMethodCallException;
use Symfony\Component\HttpFoundation\RequestStack;
use Rakit\Validation\Validator as RakitValidator;
use Symfony\Component\HttpFoundation\Response;


/**
 * @method int getPage()
 * @method int getLimit()
 * @method string getOrderBy()
 * @method string getOrderDirection()
 */
class Filter
{
    private int $page;
    private int $limit;
    private string $orderBy;
    private string $orderDirection;
    private array $filters = [];

    /**
     * @throws RequestValidationException
     */
    public function __construct(
        public readonly RequestStack $request
    ){
        $this->validate();
        $this->page = $this->request->getCurrentRequest()->query->get('page', 1);
        $this->limit = $this->request->getCurrentRequest()->query->get('limit', 10);
        $this->orderBy = $this->request->getCurrentRequest()->query->get('orderBy', 'id');
        $this->orderDirection = $this->request->getCurrentRequest()->query->get('orderDirection', 'ASC');

        $this->loadFilters();
    }

    public function __call(string $name, array $arguments)
    {
        if (str_starts_with($name, 'get')) {
            $property = lcfirst(substr($name, 3));

            if (property_exists($this, $property)) {
                return $this->$property;
            }
        }

        throw new BadMethodCallException(sprintf('Method "%s" does not exist on class %s.', $name, __CLASS__));
    }

    /**
     * @throws RequestValidationException
     */
    private function validate(): void
    {
        $validator = new RakitValidator();
        $validated = $validator->validate($this->request->getCurrentRequest()->query->all(), $this->rules());

        if ($validated->fails()) {
            throw new RequestValidationException($validated->errors()->toArray(), 'Data validation failed', Response::HTTP_BAD_REQUEST);
        }
    }

    private function rules(): array
    {
        return [
            'page' => 'nullable|numeric',
            'limit' => 'nullable|numeric',
            'orderBy' => 'nullable',
            'orderDirection' => 'nullable|in:ASC,DESC',
        ];
    }

    public function loadFilters(): void
    {
        $reflection = new \ReflectionClass(self::class);

        $filters = $this->request->getCurrentRequest()->query->all();
        $selfVars = array_map(fn($prop) => $prop->getName(), $reflection->getProperties());

        foreach ($filters as $key => $value) {
            if (!in_array($key, $selfVars)) {
                $this->filters[$key] = $value;
            }
        }
    }

    public function getFilter(string $filter): string
    {
        if (!array_key_exists($filter, $this->filters)) {
            throw new \InvalidArgumentException('Filter not found');
        }

        return $this->filters[$filter];
    }

    public function filterExists(string $filter): bool
    {
        return array_key_exists($filter, $this->filters);
    }
}