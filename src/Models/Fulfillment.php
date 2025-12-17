<?php

namespace App\Models;

class Fulfillment extends BaseModel
{
    public $timestamp;
    public int $id;
    public int $exercise_id;

    /**
     * Finds a single fulfillment by its ID.
     *
     * @param int|string $id
     * @return static|null
     */
    public static function find($id): ?static
    {
        return static::queryAndMap('SELECT * FROM fulfillments WHERE id = ?', [$id], true);
    }

    /**
     * Creates a new fulfillment for an exercise.
     *
     * @param int $exerciseId The ID of the exercise.
     * @return int The ID of the newly created fulfillment.
     */
    public static function create(int $exerciseId): int
    {
        static::executeQuery('INSERT INTO fulfillments (exercise_id) VALUES (?)', [$exerciseId]);
        return static::getLastInsertId();
    }

    /**
     * Gets all answers for a specific fulfillment, indexed by field_id.
     *
     * @param int|string $fulfillmentId
     * @return array
     */
    public static function getAnswersForFulfillment($fulfillmentId): array
    {

        $stmt = static::executeQuery(
            'SELECT field_id, value FROM answers WHERE fulfillment_id = ?',
            [$fulfillmentId]
        );

        $results = $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);

        // The result is an array like [field_id => value, ...]
        return $results ?: [];
    }

    public static function getAnswersForField($fieldId): array
    {

        $stmt = static::executeQuery(
            'SELECT fulfillment_id, value FROM answers WHERE field_id = ?',
            [$fieldId]
        );

        $results = $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);

        // The result is an array like [fulfillment_id => value, ...]
        return $results ?: [];
    }

    public static function getAllAnswersForFulfillment($fulfillmentArray): array
    {
        $arrayIds = null;

        foreach ($fulfillmentArray as $fulfillment => $element) {

            if($element == end($fulfillmentArray)) {
                $arrayIds .= $element->id;
            } else {
                $arrayIds .= $element->id . ", ";
            }
        }

        $stmt = static::executeQuery(
            "SELECT field_id, fulfillment_id, value FROM answers WHERE fulfillment_id IN ($arrayIds)"
        );

        $results = [];

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $fulfillmentId = $row['fulfillment_id'];
            $fieldId = $row['field_id'];
            $value = $row['value'];

            // Structure the output as [fulfillment_id => [field_id => value, ...], ...]
            $results[$fulfillmentId][$fieldId] = $value;
        }

        // The result is an array like [field_id => value, ...], which is perfect for the view.
        return $results;
    }

    public static function getFulfillmentsForExercise($exerciseId)
    {
        $sql = 'SELECT * FROM fulfillments WHERE exercise_id = ?';
        return self::queryAndMap($sql, [$exerciseId]);
    }
}