<?php

namespace App\Http\Controllers\Cms\Groups;

use Illuminate\Http\Request;
use App\Http\Controllers\Cms\BaseController;
use App\Models\Group as PageModel;
use View;
use File;

class GroupsController extends BaseController
{
    /**
     * CustomersController constructor.
     * @param PageModel $model
     */
    public function __construct(PageModel $model)
    {
        $this->middleware('auth');
        $this->pageUrl = 'groups';
        $this->pageName = 'Gruplar';
        $this->pageItem = 'Grup';
        $this->urlColumn = 'name';
        $this->hasUrl = false;
        $this->hasPublish = false;
        $this->model = $model;
        $this->fields = $model::$fields;
        $this->imageFields = $model::$imageFields;
        $this->docFields = $model::$docFields;
        $this->dateFields = $model::$dateFields;
        $this->urlFields = $model::$urlFields;
        $this->booleanFields = $model::$booleanFields;
        View::share(array(
            'pageUrl' => $this->pageUrl,
            'pageName' => $this->pageName,
            'pageItem' => $this->pageItem,
        ));
    }

    /**
     * Show the listing page.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
       // checkPermissionFor('edit_content');
        $records = PageModel::where('isBanned','0')->get();
        return view('cms.'.$this->pageUrl.'.index', compact('records'));
    }

    /**
     * Show the form for creating new record.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
       // checkPermissionFor('create_content');

        return view('cms.'.$this->pageUrl.'.create');
    }

    /**
     * Show the re-ordering page.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sort()
    {
        //checkPermissionFor('edit_content');
        $records = PageModel::all();
        return view('cms.'.$this->pageUrl.'.sort', compact('records'));
    }



    public function store(Request $request)
    {
        //checkPermissionFor('create_content');
        $this->validate($request, PageModel::$rules,PageModel::messages());
        $record = new PageModel;
        if($this->hasPublish){
            (($request->publish) ? $record->publish = true : $record->publish = false);
        }
        if($this->hasUrl){
            foreach($this->urlFields as $urlField){
                $record->{$urlField['name']} = parent::seo_friendly_url($request->{$urlField['map']});
            }
        }
        /** Regular Inputs **/
        foreach($this->fields as $field){
            $record->$field = $request->get($field);
        }
        /** Date Inputs **/
        if($this->dateFields){
            foreach($this->dateFields as $dateField){
                parent::handleDateInput($record, $request->get($dateField), $dateField);
            }
        }
        /** Boolean Inputs **/
        if($this->booleanFields){
            foreach($this->booleanFields as $booleanField){
                (($request->get($booleanField)) ? $record->$booleanField = true : $record->$booleanField = false);
            }
        }
        /** File Inputs **/
        if($this->docFields){
            foreach($this->docFields as $docField){
                parent::handleFileUpload($record, $this->urlColumn, $request->file($docField), $docField);
            }
        }
        /** Image Inputs **/
        if($this->imageFields){
            foreach($this->imageFields as $imageField){
                parent::handleImageCropUpload(
                    $record,
                    $imageField['naming'],
                    $imageField['diff'],
                    $request->get($imageField['name']),
                    $imageField['name'],
                    $imageField['width'],
                    $imageField['height'],
                    round($request->get($imageField['name'].'_w')), round($request->get($imageField['name'].'_h')), round($request->get($imageField['name'].'_x')), round($request->get($imageField['name'].'_y'))
                );
            }
        }

        $record->save();


        session()->flash('success', 'Yeni '.$this->pageItem.' oluşturuldu.');
        return redirect()->route('cms.'.$this->pageUrl.'.edit', ['record' => $record->id]);
    }

    /**
     * Show the form for editing existing record.
     * @param PageModel $record
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(PageModel $record)
    {
        //checkPermissionFor('edit_content');
        return view('cms.'.$this->pageUrl.'.edit', compact('record'));
    }

    /**
     * Update existing record.
     * @param Request $request
     * @param PageModel $record
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, PageModel $record)
    {
        //checkPermissionFor('edit_content');
        $this->validate($request, PageModel::$updaterules,PageModel::messages());

        if($this->hasPublish){
            (($request->publish) ? $record->publish = true : $record->publish = false);
        }
        if($this->hasUrl){
            foreach($this->urlFields as $urlField){
                $record->{$urlField['name']} = $request->{$urlField['name']};
            }
        }
        /** Regular Inputs **/
        foreach($this->fields as $field){
            $record->$field = $request->get($field);
        }
        /** Date Inputs **/
        if($this->dateFields){
            foreach($this->dateFields as $dateField){
                parent::handleDateInput($record, $request->get($dateField), $dateField);
            }
        }
        /** Boolean Inputs **/
        if($this->booleanFields){
            foreach($this->booleanFields as $booleanField){
                (($request->get($booleanField)) ? $record->$booleanField = true : $record->$booleanField = false);
            }
        }
        /** File Inputs **/
        if($this->docFields){
            foreach($this->docFields as $docField){
                parent::handleFileUpload($record, $this->urlColumn, $request->file($docField), $docField);
            }
        }
        /** Image Inputs **/
        if($this->imageFields){
            foreach($this->imageFields as $imageField){
                parent::handleImageCropUpload(
                    $record,
                    $imageField['naming'],
                    $imageField['diff'],
                    $request->get($imageField['name']),
                    $imageField['name'],
                    $imageField['width'],
                    $imageField['height'],
                    round($request->get($imageField['name'].'_w')), round($request->get($imageField['name'].'_h')), round($request->get($imageField['name'].'_x')), round($request->get($imageField['name'].'_y'))
                );
            }
        }
        $record->save();

        session()->flash('success', $this->pageItem.' güncellendi.');
        return redirect()->back();
    }

    /**
     * Delete existing record
     * @param PageModel $record
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(PageModel $record)
    {
       // checkPermissionFor('delete_content');

       $record->isBanned=1;
       $record->save();
        return redirect()->route('cms.'.$this->pageUrl.'.index');

    }

    /**
     * Delete existing record's single file
     * @param Request $request
     * @param PageModel $record
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteFile(Request $request, PageModel $record)
    {
        //checkPermissionFor('delete_content');

        $field = $request->field;
        File::delete(public_path('storage/'.$record->$field ));
        $record->$field  = "";
        $record->save();
        session()->flash('success', 'Öğe silindi.');
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return string
     */
    public function togglePromotion(Request $request){
        $record = PageModel::findOrFail($request->record_id);
        if($record->promote){
            $record->promote = false;
        }else{
            $record->promote = true;
        }
        $record->save();
        return 'success';
    }
}
