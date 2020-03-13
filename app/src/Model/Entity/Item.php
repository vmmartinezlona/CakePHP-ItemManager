<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Item Entity
 *
 * @property int $id
 * @property string $name
 * @property int $vendor_id
 * @property int $type_id
 * @property string $serial_number
 * @property float $price
 * @property float $weight
 * @property string $color
 * @property \Cake\I18n\FrozenDate $release_date
 * @property string $photo
 * @property string $tags
 * @property \Cake\I18n\FrozenDate $created_date
 *
 * @property \App\Model\Entity\Vendor $vendor
 * @property \App\Model\Entity\Type $type
 */
class Item extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'vendor_id' => true,
        'type_id' => true,
        'serial_number' => true,
        'price' => true,
        'weight' => true,
        'color' => true,
        'release_date' => true,
        'photo' => true,
        'tags' => true,
        'created_date' => true,
        'vendor' => true,
        'type' => true,
    ];
}
