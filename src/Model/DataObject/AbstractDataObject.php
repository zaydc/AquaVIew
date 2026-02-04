<?php
namespace App\Model\DataObject;

abstract class AbstractDataObject {
    public abstract function toArray(): array;

    public static function fromArray(array $data): static {
        return new static(...array_values($data));
    }
}
