<?php

use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;

class BREADSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('form')->insert([
            'name' => 'Example',
            'table_name' => 'example',
            'read' => 1,
            'edit' => 1,
            'add' => 1,
            'delete' => 1,
            'pagination' => 5
        ]);
        $formId = DB::getPdo()->lastInsertId();
        DB::table('form_field')->insert([
            'name' => 'Title',
            'type' => 'text',
            'browse' => 1,
            'read' => 1,
            'edit' => 1,
            'add' => 1,
            'form_id' => $formId,
            'column_name' => 'name'
        ]);
        DB::table('form_field')->insert([
            'name' => 'Description',
            'type' => 'text_area',
            'browse' => 1,
            'read' => 1,
            'edit' => 1,
            'add' => 1,
            'form_id' => $formId,
            'column_name' => 'description'
        ]);
        DB::table('form_field')->insert([
            'name' => 'Status',
            'type' => 'relation_select',
            'browse' => 1,
            'read' => 1,
            'edit' => 1,
            'add' => 1,
            'form_id' => $formId,
            'column_name' => 'status_id',
            'relation_table' => 'status',
            'relation_column' => 'name'
        ]);
        $role = Role::where('name', '=', 'guest')->first();
        $Permission_browse  = Permission::create(['name' => 'browse bread '   . $formId, 'slug' => 'browse.bread '   . $formId]); 
        $Permission_read    = Permission::create(['name' => 'read bread '     . $formId, 'slug' => 'read.bread '   . $formId]); 
        $Permission_edit    = Permission::create(['name' => 'edit bread '     . $formId, 'slug' => 'edit.bread '   . $formId]); 
        $Permission_add     = Permission::create(['name' => 'add bread '      . $formId, 'slug' => 'add.bread '   . $formId]); 
        $Permission_delete  = Permission::create(['name' => 'delete bread '   . $formId, 'slug' => 'delete.bread '   . $formId]); 
        $role->attachPermission($Permission_browse);
        $role->attachPermission($Permission_read);
        $role->attachPermission($Permission_edit);
        $role->attachPermission($Permission_add);
        $role->attachPermission($Permission_delete);
    }
}
