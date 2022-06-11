<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserHasSkillRequest;
use App\Models\Profile;
use App\Models\Skill;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserHasSkillCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserHasSkillCrudController extends CrudController
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
        CRUD::setModel(\App\Models\UserHasSkill::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user-has-skill');
        CRUD::setEntityNameStrings('user has skill', 'user has skills');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('user_id');
        CRUD::column('skill_id');

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
        $users = User::where('company_id', backpack_user()->company_id)->get();
        $userSelect = [];
        foreach($users as $user){
            $userSelect[$user->id] = $user->name;
        }

        $skills = Skill::all();
        $skillSelect = [];
        foreach($skills as $skill){
            $skillSelect[$skill->id] = $skill->title;
        }

        CRUD::setValidation(UserHasSkillRequest::class);

        CRUD::addField([
            'name' => 'user_id',
            'type' => 'select_from_array',
            'options' => $userSelect,
            'label' => 'User'
        ]);

        CRUD::addField([
            'name' => 'skill_id',
            'type' => 'select_from_array',
            'options' => $skillSelect,
            'label' => 'Skill'
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
