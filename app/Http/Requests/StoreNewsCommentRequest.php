<?php

namespace App\Http\Requests;

use App\Models\News;
use App\Models\NewsComment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreNewsCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'parent_id' => ['nullable', 'integer', 'exists:news_comments,id'],
            'author_name' => ['required', 'string', 'max:100'],
            'author_email' => ['required', 'email', 'max:255'],
            'content' => ['required', 'string', 'min:3', 'max:2000'],
        ];
    }

    /**
     * @return array<int, callable(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $parentId = $this->input('parent_id');
                $news = $this->route('news');

                if (! $parentId || ! $news instanceof News) {
                    return;
                }

                $parent = NewsComment::query()
                    ->select(['id', 'news_id', 'parent_id'])
                    ->find($parentId);

                if (! $parent) {
                    return;
                }

                if ($parent->news_id !== $news->id || $parent->parent_id !== null) {
                    $validator->errors()->add('parent_id', 'Komentar yang dibalas tidak valid.');
                }
            },
        ];
    }
}
