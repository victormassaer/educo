<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProfileHasSkillRequest;
use App\Models\Profile;
use App\Models\Skill;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProfileHasSkillCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProfileHasSkillCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        $user = backpack_user();
        CRUD::setModel(\App\Models\ProfileHasSkills::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/profile-has-skill');
        CRUD::setEntityNameStrings('profile has skill', 'profile has skills');

        $this->crud->addClause('where', 'company_id', '=', $user->company_id);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('profile_id');
        CRUD::column('skill_id');
        /*CRUD::column([
            // any type of relationship
            'name'         => 'skills', // name of relationship method in the model
            'type'         => 'relationship',
            'label'        => 'Profile', // Table column heading
            // OPTIONAL
            // 'entity'    => 'tags', // the method that defines the relationship in your Model
            // 'attribute' => 'name', // foreign key attribute that is shown to user
            // 'model'     => App\Models\Category::class, // foreign key model
        ],);*/

        /*$this->crud->addColumn([
            'label'     => 'profile', // Table column heading
            'type'      => 'number',
            'name'      => 'user_id',
            'key'=>'profile_id',
           'entity'    => 'profile', // the method that defines the relationship in your Model
           'attribute' => 'email', // foreign key attribute that is shown to user
           'model'     => Profile::class, // foreign key model
        ]);*/
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $profiles = Profile::where('company_id', backpack_user()->company_id)->get();
        $profileSelect = [];
        foreach($profiles as $key => $pr){
            $profileSelect[$pr->id] = $pr->title;

        }

        $skills = Skill::all();
        $skillSelect = [];
        foreach($skills as $skill){
            $skillSelect[$skill->id] = $skill->title;
        }
        CRUD::setValidation(ProfileHasSkillRequest::class);

        CRUD::addField([
            'name' => 'profile_id',
            'type' => 'select_from_array',
            'options' => $profileSelect,
            'label' => 'Profile'
        ]);

        CRUD::addField([
            'name' => 'skill_id',
            'type' => 'select_from_array',
            'options' => $skillSelect,
            'label' => 'Skill'
        ]);

        CRUD::addField([
            'name' => 'company_id',
            'type' => 'text',
            'label' => 'Company_id',
            'value' => backpack_user()->company_id,
            'attributes' => [
                'readonly' => 'readonly'
            ]
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
