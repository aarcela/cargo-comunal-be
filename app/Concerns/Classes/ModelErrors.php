<?php


namespace App\Concerns\Classes;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ModelErrors extends Controller
{
    protected int $id;
    protected mixed $model;
    protected string $modelName;
    protected string $result;
    protected bool $found;

    public function __construct($id, $model, $modelName)
    {
        $this->setId($id);
        $this->setModel($model);
        $this->setModelName($modelName);
        $this->setFound(false);

        /** Not found */
        $this->notFound();
        /** Logical Erased */
        $this->logicalErased();
    }

    /**
     * @return void
     */
    public function notFound(): void
    {
        $check = $this->model->find($this->getId());
        if (is_null($check)) {
            $this->setResult($this->getModelName() . ' No encontrado');
        } else {
            $this->setFound(true);
        }
    }

    /**
     * @return void
     */
    public function logicalErased(): void
    {
        $check = $this->model->withTrashed()->find($this->getId());
        if (is_null($check)) {
            $this->setResult($this->getModelName() . ' No encontrado');
        } else {
            $this->setResult($this->getModelName() . ' se encontro, pero esta borrado lógicamente');
        }
    }

    public function processErrorLogic(): bool|JsonResponse
    {
        if (!$this->isFound()) {
            return $this->sendError($this->getResult());
        } else {
            return true;
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getModel(): mixed
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel(mixed $model): void
    {
        $this->model = resolve($model);
    }

    /**
     * @return string
     */
    public function getModelName(): string
    {
        return $this->modelName;
    }

    /**
     * @param string $modelName
     */
    public function setModelName(string $modelName): void
    {
        $this->modelName = $modelName;
    }

    /**
     * @return string
     */
    public function getResult(): string
    {
        return $this->result;
    }

    /**
     * @param string $result
     */
    public function setResult(string $result): void
    {
        $this->result = $result;
    }

    /**
     * @return bool
     */
    public function isFound(): bool
    {
        return $this->found;
    }

    /**
     * @param bool $found
     */
    public function setFound(bool $found): void
    {
        $this->found = $found;
    }
}
