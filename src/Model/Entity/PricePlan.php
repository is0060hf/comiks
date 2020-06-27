<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PricePlan Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $plan_name
 * @property string|null $plan_context
 * @property string|null $icon_image_path
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 */
class PricePlan extends Entity
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
        'plan_name' => true,
        'plan_context' => true,
        'icon_image_path' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
    ];
}
