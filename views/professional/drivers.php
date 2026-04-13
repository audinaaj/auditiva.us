<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\User;

/* @var $this yii\web\View */
$this->title = 'Drivers';
$this->params['breadcrumbs'][] = ['label'=> 'Professionals', 'url' => Url::toRoute(['professional/index'])];
$this->params['breadcrumbs'][] = Html::encode($this->title);

// get files from s3 drivers/
$s3 = Yii::$app->get('s3');
$file_list = $s3->commands()->list('drivers/')->execute();

$files = [];
if (!empty($file_list['Contents'])) {
    // Filter to only files directly in /drivers/ (not in subfolders)
    $filtered_files = array_filter(
        $file_list['Contents'],
        function($file) {
            $key = $file['Key'];
            // Not a directory (doesn't end with /)
            if (substr($key, -1) === '/') {
                return false;
            }
            // Get filename part (after 'drivers/')
            $filename = substr($key, strlen('drivers/'));
            // No subdirectories (no additional slashes)
            if (strpos($filename, '/') !== false) {
                return false;
            }
            return true;
        }
    );

    // Extract just the filenames and reindex
    $files = array_values(array_map(fn($f) => basename($f['Key']), $filtered_files));
}

?>
<div class="site-drivers">
       
    <h1><?= $this->title; ?></h1>

    <div class="row">
        <div class="col-md-12">
            <?php
                if (empty($files)) {
                    echo '<p>No drivers available at this time.</p>';
                } else {
                    echo '<ul>';
                    foreach ($files as $file) {
                        // prevent hotlinking by generating a presigned URL that expires in 1 hour
                        $signedUrl = $s3->commands()->getPresignedUrl('drivers/'.$file)->execute();
                        echo '<li><a href="'.$signedUrl.'">'.Html::encode($file).'</a></li>';
                    }
                    echo '</ul>';
                }
            ?>
        </div>
    </div>
</div>
