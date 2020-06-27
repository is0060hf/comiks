<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Access Entity
 *
 * @property int $id
 * @property string $url
 * @property \Cake\I18n\FrozenTime $access_time
 * @property string|null $ip_address
 * @property string|null $host_name
 * @property string|null $referer
 * @property string|null $browser_info
 * @property string|null $request_method
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Access extends Entity
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
        'url' => true,
        'access_time' => true,
        'ip_address' => true,
        'host_name' => true,
        'referer' => true,
        'browser_info' => true,
        'request_method' => true,
        'created' => true,
        'modified' => true,
    ];
}
