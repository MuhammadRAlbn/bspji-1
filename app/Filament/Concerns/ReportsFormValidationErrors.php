<?php

namespace App\Filament\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

trait ReportsFormValidationErrors
{
    protected function withFormValidation(callable $operation): Model
    {
        try {
            return $operation();
        } catch (ValidationException $exception) {
            $errors = [];
            foreach ($exception->errors() as $field => $messages) {
                $errors[$this->form->getStatePath().'.'.$field] = $messages;
            }

            throw ValidationException::withMessages($errors);
        }
    }
}
