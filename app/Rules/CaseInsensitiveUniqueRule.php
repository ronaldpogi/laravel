<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CaseInsensitiveUniqueRule implements Rule
{
    private $model;
    private $column;
    private $id;
    private $message;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($model, $id = null, $column = 'name', $message = null)
    {
        $this->model = $model;
        $this->column = $column;
        $this->id = $id;
        $this->message = $message;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $value = trim($value);

        // empty ID = create, with ID = update
        if (empty($this->id)) {
            $query = $this->model->where($this->column, 'like', $value)->whereNull('deleted_at');
        } else {
            $query = $this->model->where($this->column, 'like', $value)->where('id', '!=', $this->id)->whereNull('deleted_at');
        }

        if ($query->exists()) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if ($this->message) {
            return $this->message;
        }

        $path = explode('\\', get_class($this->model));
        $class = array_pop($path);
        $formatted = ucwords(implode(' ', preg_split('/(?=[A-Z])/', $class)));
        $formattedColumn = Str::replace('_', ' ', $this->column);

        return $formatted . ' with that ' . $formattedColumn . ' already exists.';
    }
}