<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">


    <p>
        <?= Html::a('新建栏目', ['create'], [
            'class' => 'btn btn-success',
            'id' => 'create',
            'data-toggle' => 'modal',
            'data-target' => '#operate-modal',
        ]) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}  {delete}',
                'header' => '操作',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a("编辑", $url, [
                            'title' => '栏目信息',
                            // btn-update 目标class
                            'class' => 'btn btn-default btn-update',
                            'data-toggle' => 'modal',
                            'data-target' => '#operate-modal',
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('删除', $url, [
                            'title' => '删除',
                            'class' => 'btn btn-default',
                            'data' => [
                                'confirm' => '确定要删除么?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
<?php
// 创建modal
Modal::begin([
    'id' => 'operate-modal',
    'header' => '<h4 class="modal-title"></h4>',
]);
Modal::end();
// 创建
$requestCreateUrl = Url::toRoute('create');
// 更新
$requestUpdateUrl = Url::toRoute('update');
$js = <<<JS
    // 创建操作
    $('#create').on('click', function () {
        $('.modal-title').html('创建');
        $.get('{$requestCreateUrl}',
            function (data) {
                $('.modal-body').html(data);
            }
        );
    });
    // 更新操作
    $('.btn-update').on('click', function () {
        $('.modal-title').html('编辑');
        $.get('{$requestUpdateUrl}', { id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }
        );
    });
JS;
$this->registerJs($js);
?>
