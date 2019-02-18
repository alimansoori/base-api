<?php
namespace Modules\System\PageManager\Models\Routes;


use Lib\Mvc\Model\Users\ModelUsers;
use Modules\System\PageManager\Models\Pages\ModelPages;

/**
 * @method ModelPages[] getPages()
 * @method ModelUsers   getCreator()
 */
trait TModelRoutesRelations
{
    protected function relations()
    {
        $this->hasMany(
            'id',
            ModelPages::class,
            'route_id',
            [
                'alias' => 'Pages',
                'foreignKey' => [
                    'message' => 'The Route could not be delete because other Pages are using it'
                ]
            ]
        );

        $this->belongsTo(
            'creator_id',
            ModelUsers::class,
            'id',
            [
                'alias' => 'Creator',
                'foreignKey' => [
                    'message' => 'The creator_is not exist in ModelUsers'
                ]
            ]
        );
    }
}