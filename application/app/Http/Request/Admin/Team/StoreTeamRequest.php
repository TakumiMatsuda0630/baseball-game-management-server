<?php

declare(strict_types=1);

namespace Application\Http\Request\Admin\Team;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamRequest extends FormRequest
{
    /**
     * チーム登録時の入力検証ルールを返す。
     *
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'team_name' => ['required', 'string', 'max:100'],
        ];
    }

    /**
     * 検証済みの入力からチーム名を取得する。
     */
    public function teamName(): string
    {
        return $this->string('team_name')->toString();
    }
}
