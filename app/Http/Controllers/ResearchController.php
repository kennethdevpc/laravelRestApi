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
class ResearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $researchers = Researcher::paginate(1);
        view('researcher.index', compact('researchers'))
            ->with('i', (request()->input('page', 1) - 1) * $researchers->perPage());
        return $researchers;

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
    public function store($orcid)
    {
        $newUrl = "https://pub.orcid.org/v3.0/{$orcid}";
        $usuarios = Http::accept('application/json')->get($newUrl);
        if ($usuarios->response->reasonPhrase == "Not Found") {
            $researcher = new Researcher();
            $notExist = false;
            return $data = ["orcid" => $orcid, "error" => "Researcher do not Exist into the API, search another"];

        } else {
            $dataResearcher = json_decode($usuarios, false);
            $name = $dataResearcher->person->name->{'given-names'}->value;
            $familyName = $dataResearcher->person->name->{'family-name'}->value;
            $keywords = $dataResearcher->person->keywords->keyword;
            $keywordsPluck = Arr::pluck($keywords, 'content');
            $email = $dataResearcher->person->emails?->email;
            if ($email) {
                $emailFirst = Arr::first($email, function ($value, $key) {
                    return $value->primary == true;
                });
                $emailFirst = $emailFirst->email;
            } else {
                $emailFirst = "Email not found";
            }
            $data = ["orcid" => $orcid, "nombre" => $name, "name" => $name, "familyName" => $familyName, "keywords" => $keywordsPluck, "email" => $emailFirst];


            $exist = Researcher::where('orcid', '=', $orcid)->first();

            if ($exist == null) {
                $researcher = Researcher::create($data);
                return $data = ["orcid" => $orcid, "error" => null, "msj" => "Researcher created successfully.", "status" => 200];

            } else {
                return $data = ["orcid" => $orcid, "error" => "Researcher Exist into the database, Update It"];
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
        $researcher = Researcher::find($id);
        if ($researcher == null) {
            return $data = ["id" => $id, "error" => "Researcher no Exist into the database"];
        } else {
            return ($researcher);
        }
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
    public function update(Request $request, $researcher)
    {

        $researcher = Researcher::find($researcher);
        $updateApi = $request->get('updateApi');
        $orcid = $request->all();


        if ($updateApi) {
            $orcid = $request->get('orcid');
            $newUrl = "https://pub.orcid.org/v3.0/{$orcid}";

            $usuarios = Http::accept('application/json')->get($newUrl);

            $dataResearcher = json_decode($usuarios, false);

            $name = $dataResearcher->person->name->{'given-names'}->value;

            $familyName = $dataResearcher->person->name->{'family-name'}->value;
            $keywords = $dataResearcher->person->keywords->keyword;

            $keywordsPluck = Arr::pluck($keywords, 'content');

            $email = $dataResearcher->person->emails?->email;
            if ($email) {
                $emailFirst = Arr::first($email, function ($value, $key) {
                    return $value->primary == true;
                });
                $emailFirst = $emailFirst->email;
            } else {
                $emailFirst = "Email not found";
            }
            $data = ["_token" => $request->get('_token'), "orcid" => $orcid, "nombre" => $name, "name" => $name, "familyName" => $familyName, "keywords" => $keywordsPluck, "email" => $emailFirst];
            $updateResponse = $researcher->update($data);
            return ($updateResponse);
        } else {
            $updateResponse = $researcher->update($request->all());
            return ($updateResponse);
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $researcher = Researcher::find($id);
        if ($researcher == null) {
            return $data = ["id" => $id, "error" => "Researcher no Exist into the database"];
        } else {
            $researcher = Researcher::find($id)->delete();
            return ($researcher);
        }
        //$researcher = Researcher::find($id)->delete();


    }
}
