<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Channel\AddUserToChannelRequest;
use App\Http\Requests\Admin\Channel\CreateRequest;
use App\Http\Requests\Admin\Channel\SendNewFileRequest;
use App\Http\Requests\Admin\Channel\SendNewMassageRequest;
use App\Http\Requests\Admin\Channel\UpdateRequest;
use App\Models\Channel;
use App\Models\ChannelFile;
use App\Models\ChannelMassage;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;

class ChannelController extends Controller
{
    public function index()
    {
        $channels = Channel::all();

        return view('admin.channel.index', compact('channels'));

    }

    public function show(Channel $channel)
    {
        $users = User::all();
        if ($channel['type'] == "private"){
            $usersChannel = $channel->users;
        }else{
            $usersChannel = [];
        }

        $massagesData = ChannelMassage::where('channel_id', $channel['id'])
            ->with('fileMassage')->get();


        return view('admin.channel.show', compact('channel', 'massagesData', 'users' , 'usersChannel'));
    }

    public function create()
    {
        return view('admin.channel.create');
    }

    public function store(CreateRequest $request)
    {
        $upload_file = upload_file($request['photo'], 'channel/image');

        Channel::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'admin_id' => auth()->guard('admin')->user()->id,
            'type' => $request['type'],
            'address_photo' => $upload_file['file_address'],
        ]);

        return redirect()->route('admin.channel.index');
    }

    public function sendNewMassage(Channel $channel, SendNewMassageRequest $request)
    {
        $channelNewMassage = ChannelMassage::create([
            'body' => $request['body'],
            'channel_id' => $channel['id'],
            'is_file' => 0,
            'admin_id' => auth()->guard('admin')->user()->id,
        ]);

        return redirect()->route('admin.channel.show', $channel);
    }

    public function sendNewFile(Channel $channel, SendNewFileRequest $request)
    {

        $upload_file = upload_file($request['file'], 'channel/file');


        $channelNewMassage = ChannelMassage::create([
            'body' => null,
            'channel_id' => $channel['id'],
            'is_file' => 1,
            'admin_id' => auth()->guard('admin')->user()->id,
        ]);

        ChannelFile::create([
            'address' => $upload_file['file_address'],
            'file_type' => $request['file']->getMimeType(),
            'size' => $request['file']->getSize(),
            'channel_massage_id' => $channelNewMassage['id'],
        ]);

        return redirect()->route('admin.channel.show', $channel);
    }

    public function addUserToChannel(Channel $channel, AddUserToChannelRequest $request)
    {
        $channel->users()->sync($request['users']);
        return redirect()->route('admin.channel.show', $channel);
    }

    public function removeUserAsChannel(Channel $channel, User $user){
        $channel->users()->detach($user['id']);
        return redirect()->route('admin.channel.show', $channel);
    }

    public function update(Channel $channel, UpdateRequest $request)
    {

    }

    public function delete(Channel $channel)
    {

    }
}
