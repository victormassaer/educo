<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MandatoryCourseRequest;
use App\Models\Course;
use App\Models\Profile;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MandatoryCourseCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MandatoryCourseCrudController extends CrudController
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
        CRUD::setModel(\App\Models\MandatoryCourse::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/mandatory-course');
        CRUD::setEntityNameStrings('mandatory course', 'mandatory courses');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('course_id');
        CRUD::column('profile_id');
        CRUD::column('company_id');

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
        $profiles = Course::all();
        $profileSelect = [];
        foreach($profiles as $pr){
            $profileSelect[] = $pr->title;
        }

        $coursesArray = $profileSelect;
        array_unshift($coursesArray,"");
        unset($coursesArray[0]);

        $profiles = Profile::all();
        $profileSelect = [];
        foreach($profiles as $pr){
            $profileSelect[] = $pr->title;
        }

        $profilesArray = $profileSelect;
        array_unshift($profilesArray,"");
        unset($profilesArray[0]);

        CRUD::setValidation(MandatoryCourseRequest::class);

        $this->crud->addField([
            'name' => 'course_id',
            'type' => 'select_from_array',
            'options' => $coursesArray,
            'label' => 'Course'
        ]);

        $this->crud->addField([
            'name' => 'profile_id',
            'type' => 'select_from_array',
            'options' => $profilesArray,
            'label' => 'Profile'
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
