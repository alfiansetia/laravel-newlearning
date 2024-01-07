<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;
use App\Traits\CompanyTrait;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    use CompanyTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = $this->getUser();
        $data = Chat::with('messages')->withCount('messages')->orWhere('from_id', $user->id)->orWhere('to_id', $user->id)->get();
        $detail = null;
        $ids = [];
        foreach ($data as $key => $value) {
            if ($value->from_id == $user->id) {
                array_push($ids, $value->to_id);
            }
            if ($value->to_id == $user->id) {
                array_push($ids, $value->from_id);
            }
        }
        $users = User::whereNotIn('id', $ids)
            ->where('role', '!=', 'admin')
            ->where('id', '!=', $user->id)
            ->get();
        return view('chat.index', compact([
            'data',
            'detail',
            'users',
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'to'        => 'required|integer|exists:users,id',
            'message'   => 'required|max:200'
        ]);
        $user = $this->getUser();
        $chat = Chat::firstOrCreate([
            'to_id'     => $request->to,
            'from_id'   => $user->id,
        ], [
            'to_id'     => $request->to,
            'from_id'   => $user->id,
        ]);
        ChatMessage::create([
            'chat_id'   => $chat->id,
            'sender_id' => $user->id,
            'message'   => $request->message
        ]);
        return redirect()->back()->with(['success' => 'Chat Send!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        $user = $this->getUser();
        if ($chat->from_id != $user->id && $chat->to_id != $user->id) {
            abort(404);
        }
        $data = Chat::with('messages')->withCount('messages')->orWhere('from_id', $user->id)->orWhere('to_id', $user->id)->get();
        $detail = $chat->load('messages.sender', 'from', 'to');
        $ids = [];
        foreach ($data as $key => $value) {
            if ($value->from_id == $user->id) {
                array_push($ids, $value->to_id);
            }
            if ($value->to_id == $user->id) {
                array_push($ids, $value->from_id);
            }
        }
        $users = User::whereNotIn('id', $ids)
            ->where('role', '!=', 'admin')
            ->where('id', '!=', $user->id)
            ->get();
        return view('chat.index', compact([
            'data',
            'detail',
            'users',
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat)
    {
        $this->validate($request, [
            'message'   => 'required|max:250'
        ]);
        $user = $this->getUser();
        if ($chat->from_id != $user->id && $chat->to_id != $user->id) {
            abort(404);
        }
        ChatMessage::create([
            'chat_id'   => $chat->id,
            'message'   => $request->message,
            'sender_id' => $user->id,
        ]);
        $data = Chat::with('messages')->withCount('messages')->orWhere('from_id', $user->id)->orWhere('to_id', $user->id)->get();
        $detail = $chat->load('messages.sender', 'from', 'to');
        $ids = [];
        foreach ($data as $key => $value) {
            if ($value->from_id == $user->id) {
                array_push($ids, $value->to_id);
            }
            if ($value->to_id == $user->id) {
                array_push($ids, $value->from_id);
            }
        }
        $users = User::whereNotIn('id', $ids)
            ->where('role', '!=', 'admin')
            ->where('id', '!=', $user->id)
            ->get();
        return view('chat.index', compact([
            'data',
            'detail',
            'users',
        ]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        $user = $this->getUser();
        if ($chat->from_id != $user->id && $chat->to_id != $user->id) {
            abort(404);
        }
        $chat->delete();
        return redirect()->route('chat.index')->with(['success' => 'Delete Data Success!']);
    }
}
