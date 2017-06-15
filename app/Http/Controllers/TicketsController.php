<?php

namespace App\Http\Controllers;
use App\Ticket;
use App\TicketFiles;
use App\EmailsTickets;
use App\Email;
use App\Status;
Use Carbon\Carbon;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class TicketsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
            // $tickets_count = Ticket::select('status_id',  \DB::raw("count(status_id)"))->where('user_id', auth()->id())->groupBy('status_id')->get();
                // return dd($tickets_count);
      $ticketsUser =  Ticket::UserAction()->get();
      $ticketsPending =  Ticket::UserPending()->get();
      $tickets =  Ticket::UserAll()->get();

      return view('dashboard', compact('ticketsUser', 'ticketsPending', 'tickets'));
    }
    public function list($id='')
    {
      $tickets=  Ticket::UserAll($id)->get();
      $ticketsAll =  Ticket::UserStatus($id)->get();
      $status = Status::find($id);
      $estado = $status->name;
      return view('tickets.index', compact('tickets', 'ticketsAll', 'estado'));
    }
    public function create()
    {
     $categories = Category::all();
      $emails = Email::all();
      $tickets = Ticket::all();
      return view('tickets.create', compact('tickets', 'categories', 'emails'));
    }
    public function edit(Ticket $ticket )
    {
     $categories = Category::all();
      $emails = Email::all();
      $status = Status::all();
      $attachments = TicketFiles::where('ticket_id', $ticket->id)->get();
      return view('tickets.edit', compact('ticket', 'categories', 'emails', 'attachments', 'status'));
    }
     public function close(Ticket $ticket )
    {
     $categories = Category::all();
      $emails = Email::all();
      $status = Status::all();
      $attachments = TicketFiles::where('ticket_id', $ticket->id)->get();
      return view('tickets.close', compact('ticket', 'categories', 'emails', 'attachments', 'status'));
    }
    public function show(Ticket $ticket )
    {
      $categories = Category::all();
      $emails = Email::all();
      $attachments = TicketFiles::where('ticket_id', $ticket->id)->get();
      return view('tickets.show', compact('ticket', 'categories', 'emails', 'attachments'));
    }
    public function store(Request $request)
    {
      $this->validate($request, [
        'title'=>'required',
        'body'=>'required',
        'category'=>'required',
        'priority'=>'required'
      ]);
      $ticket = new Ticket();
      $ticket->title = $request->get('title');
      $ticket->url = str_slug($request->get('title'));
      $ticket->body = '<p><u>'.Carbon::now('America/Bogota').'</u> <u>'.auth()->user()->name.'</u></p>'. $request->get('body');
      $ticket->category_id = $request->get('category');
      $ticket->priority = $request->get('priority');
      $ticket->published_at = Carbon::now('America/Bogota');
       // $request->has('published_at') ? Carbon::parse($request->get('published_at')) : null;
      $ticket->status_id = 1;
      $ticket->user_id = auth()->id();
      $ticket->save();

      $ticket->emails()->attach($request->get('emails'));

      if($file = $request->hasFile('files')) {
        foreach ($request->file('files') as $file) {
          $extension = $file->getClientOriginalExtension();
          Storage::disk('public')->put($file->getFilename().'.'.$extension,  File::get($file));
          $safeName  = $file->getFilename().'.'.$extension;
          TicketFiles::create([
            'ticket_id' => $ticket->id,
            'filename' => $safeName,
            'mime' => $file->getMimeType(),
            'original_file' => $file->getClientOriginalName(),
            'user_id' => auth()->id()
            ]);
        }
      }
      // Create the array Emails
      $correos = [];
      if($ticket->emails()->count())
      {
        foreach ($ticket->emails as $value) {
          $correos[] = $value->email;
        }
      }
       $adjuntos = [];
      if(TicketFiles::where('ticket_id', $ticket->id)->count())
      {
        foreach (TicketFiles::where('ticket_id', $ticket->id)->get() as $value) {
          $adjuntos[] = $value->filename;
        }
      }
      $data = array(
      'ticket' => $ticket->id,
      'title' => $ticket->title,
      'description' => $ticket->body,
      'email' => $ticket->user->email,
      'user' => $ticket->user->name,
       'status' => $ticket->status->name,
       'priority' => $ticket->priority,
       'date' => $ticket->updated_at,
        'subj' => $ticket->id . ' '. $ticket->title,
        'mails'=>$correos,
        'attachments'=>$adjuntos,
        'type' => 'Crear',
        );
      Mail::send('template.ticket', $data, function ($message) use ($data) {
          $message->from('helpdesk@marpico.net', 'Mesa de Ayuda');
          $message->to($data['email']);
              // ->cc('jatelleza@marpico.com.co', 'Jorge Tellez')
              // ->cc('jtorroledo@marpico.com.co', 'Johan Torroledo')->subject($data['subj']);

          if($data['mails'] != ""){
              $message->cc($data['mails'])->subject($data['subj']);
              $message->bcc('jtorroledo@marpico.com.co', 'Johan Torroledo')->subject($data['subj']);
          }
      });

      return back()->with('flash', 'El incidente ha sido creado con el Numero '.  $ticket->id. '!!');
    }
    public function update(Request $request, Ticket $ticket)
    {
      $this->validate($request, [
        'body'=>'required',
      ]);
      // Create the array Emails
      $correos = [];
      if($ticket->emails()->count())
      {
        foreach ($ticket->emails as $value) {
          $correos[] = $value->email;
        }
      }
       $adjuntos = [];
      if(TicketFiles::where('ticket_id', $ticket->id)->count())
      {
        foreach (TicketFiles::where('ticket_id', $ticket->id)->get() as $value) {
          $adjuntos[] = $value->filename;
        }
      }
      $ticket->body = '<p><u>'.Carbon::now('America/Bogota').'</u> <u>'.auth()->user()->name.'</u></p>'. $request->get('body').$ticket->body;
      if(auth()->user()->role_id == 1 ){
        $ticket->status_id = $request->get('status');
        $ticket->category_id = $request->get('category');
        $ticket->priority = $request->get('priority');
        }
        else{
        $ticket->status_id = 3;
      }
      $ticket->updated_at = Carbon::now('America/Bogota');
      $ticket->user_update = auth()->id();
      $ticket->save();
      if($file = $request->hasFile('files')) {
        foreach ($request->file('files') as $file) {
          $extension = $file->getClientOriginalExtension();
          Storage::disk('public')->put($file->getFilename().'.'.$extension,  File::get($file));
          $safeName  = $file->getFilename().'.'.$extension;
          TicketFiles::create([
            'ticket_id' => $ticket->id,
            'filename' => $safeName,
            'mime' => $file->getMimeType(),
            'original_file' => $file->getClientOriginalName(),
            'user_id' => auth()->id()
            ]);
        }
      }
      $data = array(
        'ticket' => $ticket->id,
        'title' => $ticket->title,
      'description' => $ticket->body,
      'email' => $ticket->user->email,
      'user' => $ticket->user->name,
       'status' => $ticket->status->name,
       'priority' => $ticket->priority,
       'date' => $ticket->updated_at,
        'subj' => $ticket->id . ' '. $ticket->title,
        'mails'=>$correos,
        'attachments'=>$adjuntos,
        'type' => 'Modificar',
        );
      Mail::send('template.ticket', $data, function ($message) use ($data) {
          $message->from('helpdesk@marpico.net', 'Mesa de Ayuda');
          $message->to($data['email']);
              // ->cc('jatelleza@marpico.com.co', 'Jorge Tellez')
              // ->cc('jtorroledo@marpico.com.co', 'Johan Torroledo')->subject($data['subj']);

          if($data['mails'] != ""){
              $message->cc($data['mails'])->subject($data['subj']);
              $message->bcc('jtorroledo@marpico.com.co', 'Johan Torroledo')->subject($data['subj']);
          }
      });
      return redirect('/')->with('flash', 'El incidente ha sido creado con el Numero '.  $ticket->id. '!!');
    }

  public function closed(Request $request, Ticket $ticket)
    {
      // Create the array Emails
      $correos = [];
      if($ticket->emails()->count())
      {
        foreach ($ticket->emails as $value) {
          $correos[] = $value->email;
        }
      }
       $adjuntos = [];
      if(TicketFiles::where('ticket_id', $ticket->id)->count())
      {
        foreach (TicketFiles::where('ticket_id', $ticket->id)->get() as $value) {
          $adjuntos[] = $value->filename;
        }
      }
      $ticket->body = '<p><u>'.Carbon::now('America/Bogota').'</u> <u>'.auth()->user()->name.'</u></p>'. $request->get('body').$ticket->body;
      $ticket->status_id = 4;
      $ticket->closed_at = Carbon::now('America/Bogota');
      $ticket->user_update = auth()->id();
      $ticket->save();
      $data = array(
        'ticket' => $ticket->id,
        'title' => $ticket->title,
      'description' => $ticket->body,
      'email' => $ticket->user->email,
      'user' => $ticket->user->name,
       'status' => $ticket->status->name,
       'priority' => $ticket->priority,
       'date' => $ticket->updated_at,
        'subj' => $ticket->id . ' '. $ticket->title,
        'mails'=>$correos,
        'attachments'=>$adjuntos,
        'type' => 'Cerrar',
        );
      Mail::send('template.ticket', $data, function ($message) use ($data) {
          $message->from('helpdesk@marpico.net', 'Mesa de Ayuda');
          $message->to($data['email']);
              // ->cc('jatelleza@marpico.com.co', 'Jorge Tellez')
              // ->cc('jtorroledo@marpico.com.co', 'Johan Torroledo')->subject($data['subj']);

          if($data['mails'] != ""){
              $message->cc($data['mails'])->subject($data['subj']);
              $message->bcc('jtorroledo@marpico.com.co', 'Johan Torroledo')->subject($data['subj']);
              $message->bcc('jatelleza@marpico.com.co', 'Jorge Tellez')->subject($data['subj']);
          }
      });
      return redirect('/')->with('flash', 'El incidente con el Numero '.  $ticket->id. ' ha sido cerrado!!');
    }
}
