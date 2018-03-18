<?php


namespace App\DataView;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Serializer;

class InventoryView implements \JsonSerializable
{
    protected $inventory = [];

    public function addItem(InventoryItemView $item)
    {
        $this->inventory[] = $item;
    }

    public function serializeToJson()
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new JsonSerializableNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($this, 'json');

        return $jsonContent;
    }

    public function jsonSerialize()
    {
        // Was unable to use sdClass as currently used standard
        // Symfony 4 Serialization Encoders/Normalizers as based on docs here
        // https://symfony.com/doc/current/components/serializer.html it always converts data
        // to array before processing it further and thus creates a lot of unnecessary problems
        $obj = [
            'inventory' => $this->inventory
        ];

        return $obj;
    }


}