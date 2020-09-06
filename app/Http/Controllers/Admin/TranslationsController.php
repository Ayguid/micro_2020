<?php

namespace App\Http\Controllers\Admin;

use Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Support\Collection;


class TranslationsController extends Controller
{

  public $paginate = 12;
  public $path = 'storage/lang/translations';

  public function index(Request $request)
  {

    $contentEN = json_decode(file_get_contents($this->path.'_en.json'), true);
    $collectionEN = new Collection($contentEN['en']);

    $contentPT = json_decode(file_get_contents($this->path.'_pt.json'), true);
    $collectionPT = new Collection($contentPT['pt']);

    $translations = [
      'en' => $collectionEN->paginate($this->paginate),
      'pt' => $collectionPT->paginate($this->paginate)
    ];
    // dd($translations);
    return view('admin.translations')->with('translations', $translations);
    // return response($translations, 200 );
  }



  public function save(Request $request)
  {

    $contentEN = json_decode(file_get_contents($this->path.'_en.json'), true);
    $contentPT = json_decode(file_get_contents($this->path.'_pt.json'), true);

    if ($request->newTranslation['word']) {
      $contentEN['en'][$request->newTranslation['word']] = $request->newTranslation['en'];
      $contentPT['pt'][$request->newTranslation['word']] = $request->newTranslation['pt'];
    }


    foreach ($request->all() as $palabra => $array) {
      if($palabra !="_token" && $palabra !="newTranslation"){
        $contentEN['en'][$palabra] = $array['en'];
        $contentPT['pt'][$palabra] = $array['pt'];
      }
    }

    $json_objectEN = json_encode($contentEN);
    file_put_contents($this->path.'_en.json', $json_objectEN);

    $json_objectPT = json_encode($contentPT);
    file_put_contents($this->path.'_pt.json', $json_objectPT);

    // chanchada para remover duplicates
    // file_put_contents($this->path.'_en.json', json_encode(array_unique($contentEN)));
    // file_put_contents($this->path.'_pt.json', json_encode(array_unique($contentPT)));

  }



  public function find(Request $request)
  {
    $searchword = $request->queryString;
    $contentEN = json_decode(file_get_contents($this->path.'_en.json'), true);
    $contentPT = json_decode(file_get_contents($this->path.'_pt.json'), true);

    $matchesEN = array();
    foreach($contentEN['en'] as $k=>$v) {
      if(preg_match("/\b$searchword\b/i", $k)) {
        $matchesEN[$k] = $contentEN['en'][$k];
      }
    }

    $matchesPT = array();
    foreach($contentPT['pt'] as $k=>$v) {
      if(preg_match("/\b$searchword\b/i", $k)) {
        $matchesPT[$k] = $contentPT['pt'][$k];
      }
    }
    $collectionEN = new Collection($matchesEN);
    $collectionPT = new Collection($matchesPT);

    $translations = [
      'en' => $collectionEN->paginate($this->paginate),
      'pt' => $collectionPT->paginate($this->paginate)
    ];
    //dd($translations);
    return view('admin.translations')->with('translations', $translations);

  }



}
