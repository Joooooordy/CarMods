<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class OrderTable extends PowerGridComponent
{
    public const TABLE_NAME = 'order-table';

    public string $tableName = 'order-table';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Order::query()->with('user');
    }

    public function relationSearch(): array
    {
        return [
            'user' => ['name', 'email'],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('order_number')
            ->add('user_name', fn (Order $model) => $model->user?->name)
            ->add('user_email', fn (Order $model) => $model->user?->email)
            ->add('total_amount')
            ->add('status')
            ->add('created_at')
            ->add('created_at_formatted', fn (Order $model) => $model->created_at->format('d/m/Y H:i'));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable(),

            Column::make('Order Number', 'order_number')
                ->sortable()
                ->searchable(),

            Column::make('Customer Name', 'user_name')
                ->sortable()
                ->searchable(),

            Column::make('Customer Email', 'user_email')
                ->sortable()
                ->searchable(),

            Column::make('Total Amount', 'total_amount')
                ->sortable(),

            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),

            Column::make('Created At', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datepicker('created_at'),
            Filter::select('status', 'Status', [
                'pending' => 'Pending',
                'processing' => 'Processing',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
            ]),
        ];
    }

    public function actions($row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit')
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatchTo('settings.admin.order-edit-modal', 'edit', ['rowId' => $row->id]),
        ];
    }

    public function actionRules($row): array
    {
        return [
            // eventueel regels om buttons te verbergen voor bepaalde orders
        ];
    }
}
