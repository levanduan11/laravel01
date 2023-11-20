<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = DB::table('tickets')->get()->toArray();
        return view('ticket.index')->with('items', $tickets);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ticket.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $req)
    {
        $ticketReq = [
            ...$req->request,
            'user_id' => auth()->id()
        ];
        unset($ticketReq['_token']);
        $ticket = Ticket::create($ticketReq);
        if ($att = $req->file('attachment')) {
            $ext = $att->extension();
            $fileName = uuid_create();
            $content = file_get_contents($att);
            $path = "attachments/$fileName.$ext";
            Storage::disk('public')->put($path, $content);
            $ticket->attachment = $path;
            $ticket->save();
        }

        return redirect('ticket');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return view('ticket.show')->with(['ticket' => $ticket]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
        //dd($ticket);
        return view('ticket.edit', [
            'ticket' => $ticket
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
    
        //$ticket->update($request->validated());
        $arrReq = $request->toArray();
        //dd($arrReq);
        if (isset($arrReq['title'])) {
            $ticket->title = $arrReq['title'];
        }
        if (isset($arrReq['description'])) {
            $ticket->description = $arrReq['description'];
        }
        if (isset($arrReq['status'])) {
            $ticket->status = $arrReq['status'];
        }
        if (isset($arrReq['attachment'])) {
            Storage::disk('public')->delete($ticket->attachment);
            $att = $arrReq['attachment'];
            $ext = $att->extension();
            $fileName = uuid_create();
            $content = file_get_contents($att);
            $path = "attachments/$fileName.$ext";
            Storage::disk('public')->put($path, $content);
            $ticket->attachment = $path;
        }
        $ticket->save();
        if ($request->has('status')) {
            //$user = User::find($ticket->user_id);
           // $user = $ticket->user();
            //return (new TicketUpdatedNotification($ticket))->toMail($user);
        }
        return redirect()
            ->route('ticket.index')
            ->with(['message' => 'Updated successfully']);
    }

    protected function storeAttachment($request, $ticket)
    {
        if ($att = $request->file('attachment')) {
            $ext = $att->extension();
            $fileName = uuid_create();
            $content = file_get_contents($att);
            $path = "attachments/$fileName.$ext";
            Storage::disk('public')->put($path, $content);
            $ticket->attachment = $path;
            $ticket->save();
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()
            ->route('ticket.index')
            ->with(['message' => "Delete successfully"]);
    }
}
