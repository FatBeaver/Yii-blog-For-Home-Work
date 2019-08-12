<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Комментарии';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!empty($comments)): ?>

        <table class="table">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Автор</td>
                    <td>Содержание</td>
                    <td>Статус</td>
                    <td>Действие</td>
                </tr>
            </thead>

            <tbody>
                <?php foreach($comments as $comment): ?>
                    <tr>
                        <td><?= $comment['id'];      ?></td>
                        <td><?= $comment['user_id']; ?></td>
                        <td><?= $comment['text'];    ?></td>
                        <td><?= $comment['status'];  ?></td>
                        <?php 
                        
                            
                        ?>
                        <td>
                            <?php if($comment['status'] == 0): ?>
                                <a class="btn btn-success" 
                                href="<?= Url::toRoute(['comment/allow', 'id' => $comment['id']]) ?>">Разрешить</a>
                            <?php else: ?>
                                <a class="btn btn-warning"
                                href="<?= Url::toRoute(['comment/disallow', 'id' => $comment['id']]) ?>">Запретить</a>
                            <?php endif; ?>
                            <a class="btn btn-danger" 
                            href="<?= Url::toRoute(['comment/delete', 'id' => $comment['id']]) ?>">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>


</div>