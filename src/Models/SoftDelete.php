<?php

namespace LaraZeus\Tartarus\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Sushi\Sushi;

/**
 * @property string $table_name
 * @property string $table_count
 */
class SoftDelete extends Model
{
    use Sushi;

    private array $forceDelete = [
        'Sites' => [
            'Sites', 'app_catalog',
        ],
        'MenusItems' => [
            'MenusItems',
        ],
        'Categories' => [
            'Categories',
        ],
    ];

    protected function sushiShouldCache(): bool
    {
        return ! app()->isLocal();
    }

    public function getRows(): array
    {
        return collect(Schema::getTables())
            ->mapWithKeys(function ($item, $key) {
                return [
                    $key => [
                        'table_name' => $item['name'],
                        'table_count' => $this->runSelect($item['name']),
                    ],
                ];
            })
            ->toArray();
    }

    public function clean(string $tableName, ?string $endDate = null): void
    {
        if ($tableName === 'all') {
            foreach (Schema::getTables() as $table) {
                $this->runDelete($table->table, $endDate);
                //force delete
                if (array_key_exists($table->table, $this->forceDelete)) {
                    foreach ($this->forceDelete[$table->table] as $query) {
                        $this->forceDeleteTreeRelation($query);
                    }
                }
            }
        } else {
            $this->runDelete($tableName, $endDate);
            //force delete
            if (array_key_exists($tableName, $this->forceDelete)) {
                foreach ($this->forceDelete[$tableName] as $query) {
                    $this->forceDeleteTreeRelation($query);
                }
            }
        }
    }

    private function runSelect(string $table, ?string $endDate = null): ?int
    {
        $endDate ??= config('zeus-gaia.delete-before-date');
        if (Schema::hasColumn($table, 'deleted_at')) {
            return DB::select("SELECT COUNT(1) AS counter FROM {$table} WHERE deleted_at <= '{$endDate}'")[0]->counter;
        }

        return null;
    }

    private function runDelete(string $table, ?string $endDate = null): void
    {
        $endDate ??= config('zeus-gaia.delete-before-date');

        DB::delete("DELETE FROM {$table} WHERE deleted_at <= '{$endDate}'");
    }

    private function forceDeleteTreeRelation(string $table): void
    {
        //replace table by method name if existed or skip
        if (method_exists($this, 'get' . $table)) {
            $table = $this->{'get' . $table}();
        }

        DB::select("
                    DELETE child FROM {$table} child
                    LEFT JOIN {$table} parent on (child.parent_id = parent.id)
                    WHERE parent.id is null
                    and (child.parent_id != 0 or child.parent_id is null)
                ");
    }
}
