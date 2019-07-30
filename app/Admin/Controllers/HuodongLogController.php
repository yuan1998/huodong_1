<?php

namespace App\Admin\Controllers;

use App\HuodongLog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class HuodongLogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '活动管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HuodongLog);
        $model = $grid->model();
        $model->orderBy('id', 'desc');

        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->equal('name', '姓名');
            $filter->equal('department', '部门');
            $filter->equal('number', '活动号码');

        });
        $grid->expandFilter();
        $grid->disableCreateButton();

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('姓名'));
        $grid->column('department', __('部门'));
        $grid->column('number', __('活动号码'));
        $grid->column('image', __('图片'))->display(function ($val) {
            return !$val ? '---' : "<img src='$val' style='max-width: 250px;max-height: 250px'>";
        });
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('修改时间'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(HuodongLog::query()->findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('姓名'));
        $show->field('department', __('部门'));
        $show->field('number', __('号码'));
        $show->field('image', __('图片'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('修改时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new HuodongLog);

        $form->text('name', __('姓名'));
        $form->text('department', __('部门'));
        $form->text('number', __('号码'));
        $form->image('image', __('图片'));

        return $form;
    }
}
