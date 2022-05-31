<?php namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\Profile;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Auth;

//use App\Http\Requests\TagRequest;

class UserCrudController extends CrudController {

    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel("App\Models\User");
        $this->crud->setRoute("admin/user");
        $this->crud->setEntityNameStrings('user', 'users');
    }

    protected function setupListOperation()
    {
        CRUD::column('name');
        CRUD::column('email');
        CRUD::column('profile');

        $user = backpack_user();
        $organisation = Company::where('id', $user->company_id)->firstOrFail();
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        //$this->crud->setFromDb();
        $this->crud->addClause('where', 'company_id', '=', $user->company_id);
    }

    protected function setupCreateOperation()
    {
        $profiles = Profile::all();
        $profileSelect = [];
        foreach($profiles as $pr){
            $profileSelect[] = $pr->title;
        }
        dd($profileSelect);
        //$this->crud->setValidation(TagRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        //$this->crud->setFromDb();
        $this->crud->addField([
            'name' => 'name',
            'type' => 'text',
            'label' => "Name"
        ]);
        $this->crud->addField([
            'name' => 'email',
            'type' => 'email',
            'label' => 'Email',
        ]);
        $this->crud->addField([
            'name' => 'profile_id',
            'type' => 'select_from_array',
            'options' => $profileSelect,
            'label' => 'Profile'
        ]);
        $this->crud->addField([
            'name' => 'password',
            'type' => 'password',
            'label' => 'Password'
        ]);
        $this->crud->addField([
            'name' => 'company_id',
            'type' => 'text',
            'label' => 'Company_id',
            'value' => backpack_user()->company_id,
            'attributes' => [
                'readonly' => 'readonly'
            ]
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
