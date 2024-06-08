<?php

namespace App\Database;

use PDO;

class bindParam
{
    // TODO: param types as enums
    public function __construct(private readonly string $paramName, private mixed $value, private string $type)
    {
        if ($type === "s" && isset($value))
            $this->value = htmlspecialchars($this->value, ENT_QUOTES, "UTF-8");

        $this->type = $this->mapParamType($type);
    }


    // TODO: param types as enums
    private function mapParamType(string $type): int|string
    {
        return match ($type) {
            'i' => PDO::PARAM_INT,
            'b' => PDO::PARAM_BOOL,
            'blob' => PDO::PARAM_LOB,
            'NULL' => PDO::PARAM_NULL,
//            'array_i' => 'array_i', // TODO: add handling for array params
//            'array_s' => 'array_s',
            default => PDO::PARAM_STR,
        };
    }

    public function getName(): string
    {
        return $this->paramName;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getType(): string
    {
        return $this->type;
    }
}