<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PostImage Entity
 *
 * @property int $id
 * @property string $image_path
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class PostImage extends Entity
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
        'image_path' => true,
        'created' => true,
        'modified' => true,
    ];
}
