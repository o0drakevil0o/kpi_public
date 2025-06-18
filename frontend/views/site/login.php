<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url; 

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="my-1 mx-0" style="color:#999;">
                    If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                    <br>
                    Need new verification email? <?= Html::a('Resend', ['site/resend-verification-email']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
             <button class="btn provider-btn w-100 d-flex align-items-center justify-content-center gap-3 py-3 my-3 bg-success" id="providerID-btn">
                    <span>
                        <?= Html::img('@web/image/provLogo.webp' , ["class" => "provider-logo"]) ?>
                    </span>
                    <span class="provider-text">เข้าสู่ระบบด้วย ProviderID</span>
                </button>
        </div>
    </div>
</div>
<script>
       $(document).ready(() => {
            $(`#providerID-btn`).on('click' , () => { 
                window.location.href = "<?= Url::to('login-provider')?>"
            })
       })
</script>