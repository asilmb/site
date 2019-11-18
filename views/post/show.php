<button class="btn btn-success" id="btn">Press</button>
<?php
echo ("Show Action");

//$this->registerJsFile('@web/js/scripts.js',['depends'=>'yii\web\YiiAsset']);
//$this->registerJs('$(\'.container\').append(\'<p>Hello</p>\');');

$js = <<<JS
     $('#btn').on('click',function() {
       $.ajax({
        url:'/post/test.php',
        data: {test:'123'},
        type:'GET',
        success: function(res){
            console.log(res);
        },
        error:function() {
          alert("ERROR");
        }
       });
     })
JS;

$this->registerJs($js);
?>
