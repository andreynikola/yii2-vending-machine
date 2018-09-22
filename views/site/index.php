<div class="container">
    <div class="row">
    <?php foreach ($balance as $obj){ ?>
        <div class="col-md-5">
            <p>Кошелек <b><?php echo $obj['name'];?></b>:</p>
            <table class="table table-striped table-bordered text-center">
                <tr>
                    <td>Достоинство</td>
                    <td>1</td>
                    <td>2</td>
                    <td>5</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>Количество</td>
                    <td><?php echo $obj['one'];?></td>
                    <td><?php echo $obj['two'];?></td>
                    <td><?php echo $obj['five'];?></td>
                    <td><?php echo $obj['ten'];?></td>
                </tr>
                <?php if ($obj['name'] == 'user') { ?>
                    <tr>
                        <td></td>
                        <td><input type="button" class="contribute" value="внести" data-value="one" /></td>
                        <td><input type="button" class="contribute" value="внести" data-value="two" /></td>
                        <td><input type="button" class="contribute" value="внести" data-value="five" /></td>
                        <td><input type="button" class="contribute" value="внести" data-value="ten" /></td>
                    </tr>
                <?php } ?>
            </table>


        </div>
    <?php } ?>
        <p>Внесенная сумма: <?= Yii::$app->session->get('deposit'); ?></p>
        <input type="button" value="Вернуть деньги" class="return" />
    </div>
</div>

<div class="container">
    <div class="row">
        <?php foreach ($products as $obj){ ?>
            <div class="col-md-3 text-center">
                <p>Наименование: <b><?php echo $obj['name'];?></b></p>
                <p>Стоимость: <b><?php echo $obj['price'];?> руб.</b></p>
                <p>Остаток: <b><?php echo $obj['count'];?></b></p>
                <div>
                    <input type="button" value="купить" data-action="buy_product" data-id="<?php echo $obj['id'];?>" />
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php

$js = <<<JS

    $('[data-action="buy_product"]').on('click', function(event) {
        $.ajax({
            url: '/site/buy',
            type: 'POST',
            data: {product_id: $(event.currentTarget).attr('data-id')},
            success: function(data){
                alert(JSON.parse(data)['text']);
                location.reload(); 
            },
            error: function (data) {
                console.log('error');
            }
        });
    });

    $('.contribute').on('click', function(event) {
        $.ajax({
            url: '/site/contribute',
            type: 'POST',
            data: {amount: $(event.currentTarget).attr('data-value')},
            success: function(data){
                location.reload(); 
            },
            error: function () {
                console.log('error');
            }
        });
    });

    $('.return').on('click', function(event) {
        $.ajax({
            url: '/site/return',
            type: 'POST',
            success: function(data){
                location.reload(); 
                console.log(data);
            },
            error: function () {
                console.log('error');
            }
        });
    });
JS;

$this->registerJs($js);

?>