<?php

namespace App\DataTables;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    protected $Columns;
    protected $query;
    protected $buttons;
    protected $withAction;
    protected $viewName;
    /**
     * 
     */
    public function __construct($Columns = [], $query, $buttons = [],  $viewName = '', $withAction = ['edit', 'show', 'delete']){
        $this->setWithAction($withAction);
        $this->setColumns($Columns);
       $this->setQuery($query);
       $this->setButtons($buttons);
       $this->setViewName($viewName);
     }
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $elquent =  datatables()
            ->eloquent($query);
            if(count($this->getWithAction())){
                
                $elquent->addColumn('action', function ($data){
                    return $this->getActionColumn($data);
                }, 15);
            }
        return $elquent;
            // ->addColumn('action', 'users.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->query;
    }

    public function setQuery($query){

        $this->query = $query;
    }
    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('users-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons($this->getButtons())
                    ->addClass("table-hover")
                    ->parameters([ "language" => [ "url" => "//cdn.datatables.net/plug-ins/1.10.12/i18n/Arabic.json"] ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return $this->Columns;
    }

    protected function setColumns($Columns, $withDefualt = true){
        if($withDefualt){
            $Columns [] =  $Columns [0];
            $Columns [0] =['title' => __("master.id"), 'data'=> 'id'];
            if(count($this->getWithAction())){
                $Columns [] =  Column::computed('action', __("master.actions"))
                ->exportable(false)
                ->printable(false)
                // ->width(60)
                ->addClass('text-center');
            }
           
        }
        $this->Columns =  $Columns;
    }
    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Users_' . date('YmdHis');
    }

    /**
     * Get the value of buttons
     */ 
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * Set the value of buttons
     *
     * @return  self
     */ 
    public function setButtons($buttons, $withDefualt= true)
    {
        if($withDefualt){
            $this->buttons = array_merge($buttons,[
            Button::make('export'),
            Button::make('print'),
            Button::make('reset'),
            Button::make('reload')]);
        }else{
            $this->buttons = $buttons;
        }
        return $this;
    }

    protected function getActionColumn($data): string
    {
        $arrayOfBoolean = $this->getWithAction();
        $output = '';
        $arrayOfBoolean = array_map('strtolower', $arrayOfBoolean);
        if(in_array('show', $arrayOfBoolean)) {
            $showUrl = route($this->getViewName() . '.show', $data->id);
            $output .= "<a class='btn btn-outline-success' data-value='$data->id' href='$showUrl'><i class='cil-spreadsheet'></i></a>";
        }
        if(in_array('edit', $arrayOfBoolean)){
            $editUrl = route($this->getViewName() . '.edit', $data->id);
            $output .= "<a class='btn btn-outline-primary' data-value='$data->id' href='$editUrl'><i class='cil-pencil'></i></a>";
        }
        if(in_array('delete', $arrayOfBoolean)){
            $output .= "<button class='btn btn-outline-danger' onclick='deleteRecord($data->id,this)'  ><i class='cil-trash'></i></button>";
        }
        return $output;
    }

    /**
     * Get the value of withAction
     * return withAction array
     */ 
    public function getWithAction() : array
    {
        return $this->withAction;
    }

    /**
     * Set the value of withAction
     *  $options array of string show, edit, remove
     * @return  self
     */ 
    public function setWithAction(array  $withAction)
    {
        $this->withAction = $withAction;
        return $this;
    }

    /**
     * Get the value of viewName
     */ 
    public function getViewName()
    {
        return $this->viewName;
    }

    /**
     * Set the value of viewName
     *
     * @return  self
     */ 
    public function setViewName($viewName)
    {
        $this->viewName = $viewName;

        return $this;
    }
}
