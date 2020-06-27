<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserSkill Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $value
 * @property string $title
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 */
class UserSkill extends Entity
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
        'user_id' => true,
        'value' => true,
        'title' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
    ];
}
