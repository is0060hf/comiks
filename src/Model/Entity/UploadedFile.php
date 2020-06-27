<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UploadedFile Entity
 *
 * @property int $id
 * @property string|null $file_path
 * @property bool $used_flg
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class UploadedFile extends Entity
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
        'file_path' => true,
        'used_flg' => true,
        'created' => true,
        'modified' => true,
    ];
}
