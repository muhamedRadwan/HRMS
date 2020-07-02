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
    /**
     * 
     */

    public function __construct($Columns = [], $query, $buttons = []){
       $this->setColumns($Columns);
       $this->setQuery($query);
       $this->setButtons($buttons);
     }
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query);
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
                    ->buttons($this->getButtons());
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
        if($withDefualt)
            $this->Columns = array_merge([
            //     Column::computed('action')
            // ->exportable(true)
            // ->printable(true)
            // // ->width(60)
            // ->addClass('text-center'),
            Column::make('id')],$Columns);
        else
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
}
