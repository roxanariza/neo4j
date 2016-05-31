<?php
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'Neo4j Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Neo4j </h1>

        

        <p><a class="btn btn-lg btn-success" href="<?php echo Url::to(['/node4j/create']);?>">Create new node</a></p>
        <p><a class="btn btn-lg btn-success" href="<?php echo Url::to(['/node4j/nodes']);?>">View all nodes</a></p>
        <p><a class="btn btn-lg btn-success" href="<?php echo Url::to(['/node4j/add']);?>">View relationships</a></p>
    </div>
</div>
