<?php

namespace App\Modules\MapHistory\Repositories;

use App\Models\MapHistory;
use App\Repositories\BaseRepository;
use App\Modules\User\Repositories\UserRepository;

class MapHistoryRepository extends BaseRepository
{

    protected $_userRepository;

    public function __construct(MapHistory $MapHistory, UserRepository $userRepository)
    {
        parent::__construct($MapHistory);
        $this->_userRepository =$userRepository;
    }

    public function historyUser(int  $id,int $size)
    {
        $user = $this->_userRepository->get($id);
        $histories= $user->histories()->paginate($size);
        foreach ($histories as $key => $value) {

            $value->city= $value->city;
        }
        return collect($histories);
    }
}
