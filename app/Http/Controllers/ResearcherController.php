<?php

namespace App\Http\Controllers;

use App\Models\Researcher;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

/**
 * Class ResearcherController
 * @package App\Http\Controllers
 */
class ResearcherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(  )
    {
        $newUrl = "http://127.0.0.1:8001/api/orcid/list/";
        $researchers2 = Http::accept('application/json')->get($newUrl);
        $researchersPage = json_decode($researchers2, false);

        $researchers = json_decode($researchers2, false)->data;
        $links=$researchersPage->links;
        return view('researcher.index', compact('researchers','links'))
            ->with('i', (request()->input('page', 1) - 1) * $researchersPage->per_page);

//            ->with('i', (request()->input('page', 1) - 1) * 2);

    }
    public function indexPaginate($n )
    {
        $researchersa = Researcher::paginate(2);
        $newUrl = "http://127.0.0.1:8001/api/orcid/list/?page={$n}";
        $researchersx = Http::get($newUrl);
        $researchers2 = Http::accept('application/json')->get($newUrl);
        $researchersPage = json_decode($researchers2, false);

        $researchers = json_decode($researchers2, false)->data;
        $links=$researchersPage->links;
        return view('researcher.index', compact('researchers','links'))
            ->with('i', (request()->input('page', 1) - 1) * $researchersPage->per_page);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $researcher = new Researcher();
        return view('researcher.create', compact('researcher'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Researcher::$rules);
        $orcid = $request->get('nombre');
        $newUrl = "http://127.0.0.1:8001/api/orcid/create/{$orcid}";

        $usuarios = Http::accept('application/json')->post($newUrl);
       $usuarios=json_decode($usuarios,false);

        if($usuarios->error=="Researcher do not Exist into the API, search another"){
            $researcher = new Researcher();
            $notExist = false;
            return redirect()->route('researchers.create')
                ->with('warning', 'Researcher do not Exist into the API, search another');
            //return view('researcher.create', compact('researcher','notExist'));

        }else{
            if($usuarios->error==null){
                return redirect()->route('researchers.index')
                    ->with('success', 'Researcher created successfully.');
            }else{
                return redirect()->route('researchers.create')
                    ->with('warning', 'Researcher Exist into the database, Update It');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $newUrlShow = "http://127.0.0.1:8001/api/orcid/{$id}";
        $usuarios = Http::accept('application/json')->get($newUrlShow);
        $researcher=json_decode($usuarios,false);
        return view('researcher.show', compact('researcher'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $researcher = Researcher::find($id);
        return view('researcher.edit', compact('researcher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Researcher $researcher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $researcher)
    {

        $newUrlUpdate = "http://127.0.0.1:8001/api/orcid/edit/{$researcher}";

        $updateApi = $request->get('updateApi');

        if ($updateApi) {
            $newUrlUpdate=$newUrlUpdate;
            $usuariosUpdate = Http::accept('application/json')->put($newUrlUpdate,$request->all());



            return redirect()->route('researchers.index')
                ->with('success', 'Researcher updated successfully');

        } else {
            request()->validate(Researcher::$rules);
            $usuariosUpdate = Http::accept('application/json')->put($newUrlUpdate,$request->all());
            //$researcher->update($request->all());

            return redirect()->route('researchers.index')
                ->with('success', 'Researcher updated successfully');
        }

    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $newUrlShow = "http://127.0.0.1:8001/api/orcid/delete/{$id}";
        $usuarios = Http::accept('application/json')->delete($newUrlShow);
        $researcher=json_decode($usuarios,false);
        return redirect()->route('researchers.index')
            ->with('success', 'Researcher deleted successfully');
    }
}
