<?php

namespace App\Database;

use Closure;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Builder;


abstract class Migration
{
    abstract public function up(): void;
    abstract public function down(): void;

    protected function schema(): Builder
    {
        return Capsule::schema();
    }

  
    protected function create(string $table, Closure $callback): void
    {
        if (!$this->hasTable($table)) {
            $this->schema()->create($table, $callback);
        }
    }


    protected function table(string $table, Closure $callback): void
    {
        $this->schema()->table($table, $callback);
    }

    protected function dropIfExists(string $table): void
    {
        $this->schema()->dropIfExists($table);
    }

    protected function hasTable(string $table): bool
    {
        return $this->schema()->hasTable($table);
    }


    protected function hasIndex(string $table, string $indexName): bool
    {
        $connection = Capsule::connection();
        $result = $connection->select(
            'SELECT COUNT(1) AS aggregate FROM information_schema.statistics
             WHERE table_schema = ? AND table_name = ? AND index_name = ?',
            [$connection->getDatabaseName(), $table, $indexName]
        );

        return ((int) ($result[0]->aggregate ?? 0)) > 0;
    }

        protected function hasForeign(string $table, string $foreignKeyName): bool
    {
        $connection = Capsule::connection();
        $result = $connection->select(
            'SELECT COUNT(1) AS aggregate FROM information_schema.table_constraints
             WHERE table_schema = ? AND table_name = ? AND constraint_name = ?
             AND constraint_type = \'FOREIGN KEY\'',
            [$connection->getDatabaseName(), $table, $foreignKeyName]
        );

        return ((int) ($result[0]->aggregate ?? 0)) > 0;
    }
}