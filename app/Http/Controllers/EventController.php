<?php

namespace App\Http\Controllers;

use App\Models\PIC;
use App\Models\Event;
use App\Models\Proposal;
use App\Models\Pembicara;
use Illuminate\Http\Request;
use App\Models\PembicaraDanEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->query('id_event');
        if($id){
            $singleEvent = Event::select("id_event","nama_event", "cara_pelaksanaan", "tempat_pelaksanaan","link","jam_mulai", "jam_selesai", "laporan_akhir", "background", "flyer", "file_proposal")->leftJoin('pic', 'event.id_pic', '=', 'pic.id_pic')->leftJoin('proposal', 'event.id_proposal', '=', 'proposal.id_proposal')->where('id_event', $id)->with('pembicara')->get()->first();
            // dd($singleEvent); //pake Event karena ada relasi di model Event
            $event = Event::select('*')->leftJoin('pic', 'event.id_pic', '=', 'pic.id_pic')->leftJoin('proposal', 'event.id_proposal', '=', 'proposal.id_proposal')->with('pembicara')->get();
            return view('dashboard-admin.event.detail-event.detail-event',[
            'title' => 'Data Event - Pradita University\'s Guest Lecturers',
            'event' => $event,
            'singleEvent' => $singleEvent,
            ]);
        }else{
            $event = Event::select('*')->leftJoin('pic', 'event.id_pic', '=', 'pic.id_pic')->leftJoin('proposal', 'event.id_proposal', '=', 'proposal.id_proposal')->with('pembicara')->get();
            return view('dashboard-admin.event.detail-event.detail-event',[
                'title' => 'Data Event - Pradita University\'s Guest Lecturers',
                'event' => $event,
                'singleEvent' => null
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pic = PIC::all();
        $proposal = Proposal::select(['id_proposal', 'mata_kuliah', 'waktu_pengunggahan'])->get();
        return view('dashboard-admin.event.input-event.input-event',[
            'title' => 'Input Event - Pradita University\'s Guest Lecturers',
            'pic' => $pic,
            'proposal' => $proposal,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_event' => 'required',
            'cara_pelaksanaan' => 'required',
            'background' => 'required|mimes:jpg,png,jpeg|max:2048',
            'flyer' => 'required|mimes:jpg,png,jpeg|max:2048',
            'tempat_pelaksanaan' => 'required',
            'link' => 'nullable',
            'tanggal_pelaksanaan' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'id_pic' => 'required',
            'id_proposal' => 'required',
        ]);

        // $validatedData['background'] = $request->file('background')->store('background');
        // $validatedData['flyer'] = $request->file('flyer')->store('flyer');

        // $validatedData['background'] = $request->file('background');
        // $background_name = $validatedData['background']->getClientOriginalName();
        // $validatedData['background']->move(public_path('/penyimpanan/background'), $background_name);

        // $validatedData['flyer'] = $request->file('flyer');
        // $flyer_name = $validatedData['flyer']->getClientOriginalName();
        // $validatedData['flyer']->move(public_path('/penyimpanan/flyer'), $flyer_name);

        Event::create($validatedData);
        return redirect()->route('event.index')->with('success','Data Event has been added successfully');
    }

    public function storePembicara(Request $request)
    {
        $validatedData = $request->validate([
            'id_event' => 'required',
            'id_pembicara' => 'required'
        ]);
        for($i = 0; $i < count($validatedData['id_pembicara']); $i++){
            $batchPembicara[$i] = [
                'id_event' => $validatedData['id_event'],
                'id_pembicara' => $validatedData['id_pembicara'][$i]
            ];
        }
        PembicaraDanEvent::insert($batchPembicara);
        return redirect()->route('event.index')->with('success', 'Data Pembicara has been added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = DB::select('SELECT * FROM event NATURAL LEFT JOIN pembicara_dan_event NATURAL LEFT JOIN pembicara NATURAL LEFT JOIN pic NATURAL LEFT JOIN proposal WHERE event.id_event = ?', [$id]);
        $pic = PIC::all();
        $proposal = Proposal::all();
        return view('dashboard-admin.event.edit-event.edit-event',[
            'title' => 'Edit Event - Pradita University\'s Guest Lecturers',
            'event' => $event,
            'pic' => $pic,
            'proposal' => $proposal
        ]);

    }

    public function editPembicara($id){
        $singleEvent = DB::select('SELECT * FROM event NATURAL LEFT JOIN pembicara_dan_event WHERE event.id_event = ?', [$id]);
        $pembicara = Pembicara::all();
        // dd($singleEvent);
        return view('dashboard-admin.event.edit-pembicara-ke-event.edit-pembicara-ke-event',[
            'title' => 'Edit Pembicara - Pradita University\'s Guest Lecturers',
            'singleEvent' => $singleEvent,
            'pembicara' => $pembicara
        ]);
    }

    public function editLaporanAkhir($id){
        $event = Event::where('id_event', $id)->get()->first();
        return view('dashboard-admin.event.edit-laporan-akhir.edit-laporan-akhir',[
            'title' => 'Edit Laporan Akhir - Pradita University\'s Guest Lecturers',
            'event' => $event
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_event' => 'required',
            'cara_pelaksanaan' => 'required',
            'background' => 'nullable|mimes:jpg,png,jpeg|max:2048',
            'flyer' => 'nullable|mimes:jpg,png,jpeg|max:2048',
            'tempat_pelaksanaan' => 'required',
            'link' => 'nullable',
            'tanggal_pelaksanaan' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'id_pic' => 'required',
            'id_proposal' => 'required',
            'oldbackground' => 'required',
            'oldflyer' => 'required'
        ]);

        if($request->background != null){
            $file = $request->file('background')->store('background');
            $event['background'] = $file;
            if($validatedData['oldbackground'] != null){
                Storage::delete($validatedData['oldbackground']);
            }
        }

        if($request->flyer != null){
            $file = $request->file('flyer')->store('flyer');
            $event['flyer'] = $file;
            if($validatedData['oldflyer'] != null){
                Storage::delete($validatedData['oldflyer']);
            }
        }

        $event = [
            'nama_event' => $validatedData['nama_event'],
            'cara_pelaksanaan' => $validatedData['cara_pelaksanaan'],
            'tempat_pelaksanaan' => $validatedData['tempat_pelaksanaan'],
            'link' => $validatedData['link'],
            'tanggal_pelaksanaan' => $validatedData['tanggal_pelaksanaan'],
            'jam_mulai' => $validatedData['jam_mulai'],
            'jam_selesai' => $validatedData['jam_selesai'],
            'id_pic' => $validatedData['id_pic'],
            'id_proposal' => $validatedData['id_proposal'],
        ];

        Event::where('id_event', $id)->update($event);
        return redirect()->route('event.index')->with('success', 'Data Event has been updated successfully');

    }

    public function updateLaporanAkhir(Request $request, $id){
        // dd($request->all());
        $validatedData = $request->validate([
            'laporan_akhir' => 'required|mimes:pdf,docx,doc|max:2048',
            'oldlaporan_akhir' => 'nullable'
        ]);
        $proposal = [
            'laporan_akhir' => $request->file('laporan_akhir')->store('laporan_akhir'),
            // ->getClientOriginalName(),
        ];
        Storage::delete($request->oldlaporan_akhir);
        Event::where('id_event',$id)->update($proposal);
        return redirect()->route('event.index')->with('success', 'Data Laporan Akhir has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::where('id_event', $id)->get()->first();
        Storage::delete($event->background);
        Storage::delete($event->flyer);
        if($event->laporan_akhir != null){
            Storage::delete($event->laporan_akhir);
        }
        Event::where('id_event', $id)->delete();
        return redirect()->route('event.index')->with('success', 'Data Event has been deleted successfully');
    }

    public function destroyPembicara($id_event, $id_pembicara)
    {
        PembicaraDanEvent::where('id_event', $id_event)->where('id_pembicara', $id_pembicara)->delete();
        return redirect()->route('event.index')->with('success', 'Data Pembicara has been deleted successfully');
    }
}
