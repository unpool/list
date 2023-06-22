<?php

namespace App\Http\Controllers\Api;

use App\Models\Channel;
use App\Models\ChannelMassage;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelUserController extends Controller
{
    public function getAllChannelUser()
    {
        $user = auth()->user();

        $channels = Channel::where('type', 'public')->get()->toArray();

        $privateChannels = $user->channels()->get()->toArray();

        if (count($privateChannels) != 0){
            $channels = array_merge($channels, $privateChannels);
        }

        return $this->setDataChannelUser($channels);
    }

    /**
     * @param $channels
     * @return array
     */
    private function setDataChannelUser($channels): array
    {
        $returnChannels = [];

        foreach ($channels as $channel){
            $returnChannels[] = [
                'id'=> $channel['id'],
                'title'=> $channel['title'],
                'description'=> $channel['description'],
                'address_photo'=> url('storage/'. $channel['address_photo']),
                'type'=> $channel['type'],
            ];
        }

        return $returnChannels;
    }

    public function showMassageChannel(Channel $channel)
    {
        $massagesData = ChannelMassage::where('channel_id', $channel['id'])
            ->with('fileMassage')->get()->toArray();

        return $this->steShowMassageChannel($massagesData);
    }


    /**
     * @param $channels
     * @return array
     */
    private function steShowMassageChannel($massagesData)
    {
        $returnMassagesData = [];

        foreach ($massagesData as $massageData){

            if ($massageData['is_file']){
                $returnMassagesData[] = [
                    'id'=> $massageData['id'],
                    'is_file' => $massageData['is_file'],
                    'file_address'=> url('storage/'. $massageData['file_massage']['address']),
                    'file_type'=> $massageData['file_massage']['file_type'],
                    'file_size'=> $massageData['file_massage']['size'],
                ];
            } else {
                $returnMassagesData[] = [
                    'id'=> $massageData['id'],
                    'is_file' => $massageData['is_file'],
                    'body'=> $massageData['body'],
                ];
            }
        }

        return $returnMassagesData;
    }


}
