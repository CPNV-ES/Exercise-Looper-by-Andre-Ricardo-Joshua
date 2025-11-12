<?php

namespace App\Models;

class Answer extends BaseModel
{
    /**
     * Creates or updates an answer for a given fulfillment and field.
     * This is an "upsert" operation.
     *
     * @param int $fulfillmentId
     * @param int $fieldId
     * @param string $value
     * @return void
     */
    public static function save(int $fulfillmentId, int $fieldId, string $value): void
    {
        // Using REPLACE INTO for SQLite, which is a convenient way to do an upsert.
        // For MySQL, you would use INSERT ... ON DUPLICATE KEY UPDATE.
        // This assumes a UNIQUE constraint on (fulfillment_id, field_id).
        $sql = "REPLACE INTO answers (fulfillment_id, field_id, value) VALUES (?, ?, ?)";
        static::executeQuery($sql, [$fulfillmentId, $fieldId, $value]);
    }
}