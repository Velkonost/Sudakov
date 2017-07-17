<?php
/**
 * Money view
 *
 * @var $this \yii\web\View
 * @var $models \app\models\Money[]
 * @var $user \app\models\User
 *
 * @var $model \app\models\Money (Inside loops)
 */

use app\models\Money;
use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\MoneyAsset;
use app\models\Payment;
use app\components\MoneyHelper;

MoneyAsset::register($this);

$this->registerCssFile("https://fonts.googleapis.com/css?family=Open+Sans:400,300&subset=latin,cyrillic",
	[], 'open-sans-google');
$this->title = 'Финансовый мониторинг';

$year = date('Y');
$month = date('m');
if (!empty($_GET['date_period'])) {
	$period = explode('-', $_GET['date_period']);
	$month = substr('0' . $period[0], -2, 2);
	$year = $period[1];
}

$yearStr = "year";
// SOME OTHER CONTENT HERE

?>
<form id="money-search-form" action="<?= $_SERVER['REQUEST_URI'] ?>" method="get" data-url_all_update="<?=Url::to(["/money/all-for-period-update"])?>">
	<?= Html::hiddenInput(\Yii::$app->getRequest()->csrfParam, \Yii::$app->getRequest()->getCsrfToken(), []) ?>
	<div class="money-filter-container">
		<div class="fixed">
			<?php
			echo Html::dropDownList('date_period', $month.'-'.$year, $filter['months'], [
				'class'=>'form-control date-period-selector',
				'data-url' => str_replace('?' . Yii::$app->getRequest()->getQueryString(), '', Yii::$app->getRequest()->getUrl())
			]);
			?><span class="filter-values"><?php
				/* todo допилить JS отмены фильтра /js/money.js:415
                if (!empty($_GET['MoneySearch'])) {
                    foreach ($_GET['MoneySearch'] as $filter => $values) {
                        if (is_array($values)) {
                            foreach ($values as $option) {
                                if (empty($option)) continue;
                                ?><a href="#" class="btn btn-success btn-filter" data-filter="<?= $filter ?>"
                                     data-value="<?= $option ?>">
                                <?= Money::getLabel($filter) ?>
                                : <?= ($filter == 'status') ? LeadStatus::getStatusByExtId($option) : $option ?>
                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                                </a><?php
                            }
                        } else {
                            if (empty($values)) continue;
                            ?><a href="#" class="btn btn-success btn-filter" data-filter="<?= $filter ?>"
                                 data-value="<?= $values ?>">
                            <?= Money::getLabel($filter) ?>: <?= $values ?>
                            <i class="fa fa-times-circle" aria-hidden="true"></i>
                            </a><?php
                        }
                    }
                }
                */
				?></span><?php
			?>
			<div class="btn btn-default update_leads_btn">
				<i class="glyphicon glyphicon-refresh"></i>
			</div>
			<a class="btn btn-default download_to_csv_file" target="_blank" href="<?=Url::to(["/money/download","date_period"=>$date_period])?>">
				<i class="glyphicon glyphicon-leaf"></i> Выгрузка
			</a>
			<a class="btn btn-default download_to_csv_file" target="_blank" href="<?=Url::to(["/money/download", "date_period"=>"year"])?>">
				<i class="glyphicon glyphicon-leaf"></i> Выгрузка за год
			</a>
		</div>
	</div><?php
	ob_start(); // it needed
	?>

	<div class="clearfix"></div>
	<div class="money-layout">
		<div style="display:none;" class="money-abs-header js-money-abs-header"></div>
		<div class="money-table-clients money-abs-clients-header"></div>
		<div class="money-table-clients money-abs-clients js-money-abs-clients"></div>
	</div>
	<div class="clearfix"></div>
	<div class="money-layout js-money-layout-real">
		<div class="money-table money-table-clients js-money-table-clients">
			<div class="money-table-row money-table-row-title js-money-table-row-title" data-class="money-table-clients">
				<div class="money-table-cell">ID клиента</div>
			</div>
			<div class="money-table-row money-table-row-header js-money-table-row-header">
				<div class="money-table-cell">Ответственный</div>
				<div class="money-table-cell">Имя Фамилия</div>
				<div class="money-table-cell">Телефон</div>
				<div class="money-table-cell">Город</div>
				<div class="money-table-cell">Статус</div>
				<div class="money-table-cell small-paddings">CRM</div>
			</div>
			<div class="money-table-row money-table-row-header js-money-table-row-header search-row">
				<div class="money-table-cell">

				</div>
				<div class="money-table-cell">
					<input type="text" class="form-control" name="MoneySearch[client_name]" value="<?= @$_GET['MoneySearch']['client_name'] ?>">
				</div>
				<div class="money-table-cell">
					<input type="text" class="form-control" name="MoneySearch[phone]" value="<?= @$_GET['MoneySearch']['phone'] ?>">
				</div>
				<div class="money-table-cell">
					<input type="text" class="form-control" name="MoneySearch[city]" value="<?= @$_GET['MoneySearch']['city'] ?>">
				</div>
				<div class="money-table-cell lead-status-cell">
					<?= Html::dropDownList('MoneySearch[status]', @$_GET['MoneySearch']['status'],
						\app\models\LeadStatus::statuses(), ['class' => 'form-control', 'id' => 'lead-status', 'multiple' => 'multiple']) ?>
				</div>
				<div class="money-table-cell small-paddings">&nbsp;</div>
			</div>
			<div class="money-table-rows js-money-table-rows">
				<?php foreach ($models as $k => $model) { ?>
					<div class="money-table-row money-table-row-data money-item-<?= $model->id ?> <?= ($k%2==0) ? 'row-even' : 'row-odd' ?>" data-id="<?= $model->id ?>">
						<div class="money-table-cell">
							<div class="money-table-long-data money-column-client_menedger"><!-- don't replace "_" in client_name it's special field marker -->
								<?php if(isset($manager[$model->responsible_user_id])) { ?>
									<?= $manager[$model->responsible_user_id] ?>
								<?php } ?>
							</div>
						</div>
						<div class="money-table-cell">
							<div class="money-table-long-data money-column-client_name"><!-- don't replace "_" in client_name it's special field marker -->
								<?= $model->client_name ?>
							</div>
						</div>
						<div class="money-table-cell money-column-phone"><?= $model->phone ?></div>
						<div class="money-table-cell">
							<div class="money-table-long-data money-column-city"><?= $model->city ?></div>
						</div>
						<div class="money-table-cell small-paddings">
							<?php
							if ($model->status) {
								echo '<span class="status-label" style="background-color: ' . $model->status->color . ';">'
									. $model->status->label . '</span>';
							} else {
								echo '---';
							}
							?>
						</div>
						<div class="money-table-cell">
							<a href="https://jbyss.amocrm.ru/leads/detail/<?= $model->ext_id ?>" title="Перейти в сделку AMOCRM" target="_blank">
								<img src="/images/money_arr.png">
							</a>
						</div>
					</div>
				<?php } ?>
				<div class="money-table-row money-total-row">
					<div class="money-table-cell">&nbsp;</div>
				</div>
				<div class="money-table-row money-total-row">
					<div class="money-table-cell">&nbsp;</div>
				</div>
				<div class="money-table-row money-total-row">
					<div class="money-table-cell">&nbsp;</div>
				</div>
			</div>
		</div>

		<div class="money-table money-table-fact">
			<div class="money-table-row money-table-row-title js-money-table-row-title"  data-class="money-table-fact">
				<div class="money-table-cell">Деньги фактические</div>
			</div>
			<div class="money-table-row money-table-row-header js-money-table-row-header">
				<div class="money-table-cell">Бюджет финальный</div>
				<div class="money-table-cell">1-я оплата</div>
				<div class="money-table-cell">Как внесли 1-ю оплату</div>
				<div class="money-table-cell">Дата 1-й оплаты</div>
				<div class="money-table-cell">2-я оплата</div>
				<div class="money-table-cell">Как внесли 2-ю оплату</div>
				<div class="money-table-cell">Дата 2-й оплаты</div>
				<div class="money-table-cell">Комментарий</div>
			</div>
			<div class="money-table-row money-table-row-header js-money-table-row-header search-row">
				<div class="money-table-cell">
					<input type="text" class="form-control" name="MoneySearch[total_amount]" value="<?= @$_GET['MoneySearch']['total_amount'] ?>">
				</div>
				<div class="money-table-cell">
					<input type="text" class="form-control" name="MoneySearch[first_payment_amount]" value="<?= @$_GET['MoneySearch']['first_payment_amount'] ?>">
				</div>
				<div class="money-table-cell">
					<!--
				<?= Html::dropDownList('MoneySearch[status]', @$_GET['MoneySearch']['first_payment_method'],
						Money::paymentMethods(), ['class'=>'form-control', 'multiple' => 'multiple', 'id' => 'first_payment_method-search']) ?>
				-->
				</div>
				<div class="money-table-cell">
					<input type="text" class="form-control" name="MoneySearch[first_payment_date]" value="<?= @$_GET['MoneySearch']['first_payment_date'] ?>">
				</div>
				<div class="money-table-cell">
					<input type="text" class="form-control" name="MoneySearch[second_payment_amount]" value="<?= @$_GET['MoneySearch']['second_payment_amount'] ?>">
				</div>
				<div class="money-table-cell">
					<!--
				<?= Html::dropDownList('JobSearch[status]', @$_GET['JobSearch']['second_payment_method'],
						Money::paymentMethods(), ['class'=>'form-control', 'multiple' => 'multiple', 'id' => 'second_payment_method-search']) ?>
				-->
				</div>
				<div class="money-table-cell">
					<input type="text" class="form-control" name="MoneySearch[second_payment_date]" value="<?= @$_GET['MoneySearch']['second_payment_date'] ?>">
				</div>
				<div class="money-table-cell">
					<input type="text" class="form-control" name="MoneySearch[comment_fin]" value="<?= @$_GET['MoneySearch']['comment_fin'] ?>">
				</div>
			</div>
			<?php foreach ($models as $k => $model) { ?>
				<div class="money-table-row money-table-row-data money-item-<?= $model->id ?> <?= ($k%2==0) ? 'row-even' : 'row-odd' ?>" data-id="<?= $model->id ?>">
					<div class="money-table-cell money-column-total_amount">
						<?= number_format($model->total_amount, 0, ',', ' ') ?>
					</div>
					<div class="money-table-cell <?= 'money-table-cell-' . $model->getColor(1) ?> money-column-first_payment_amount">
						<span class="money-column-value"><?= number_format($model->first_payment_amount, 0, ',', ' ') ?></span>
						<input class="money-table-checkbox money-table-checkbox-right first-payment-status"
							   type="checkbox" data-id="<?= $model->id ?>" data-url_update="<?= Url::toRoute(['money/update']) ?>"
							<?= $model->first_payment_status ? 'checked' : '' ?> />
					</div>
					<div class="money-table-cell money-column-first_payment_method">
						<?= Money::getMethodLabel($model->first_payment_method) ?>
					</div>
					<div class="money-table-cell money-column-first_payment_date">
						<?= empty($model->first_payment_date) ? '' : date('d.m.y', $model->first_payment_date) ?>
					</div>
					<div class="money-table-cell <?= 'money-table-cell-' . $model->getColor(2) ?> money-column-second_payment_amount">
						<span class="money-column-value"><?= number_format($model->second_payment_amount, 0, ',', ' ') ?></span>
						<input class="money-table-checkbox money-table-checkbox-right second-payment-status"
							   type="checkbox" data-id="<?= $model->id ?>" data-url_update="<?= Url::toRoute(['money/update']) ?>"
							<?= $model->second_payment_status ? 'checked' : '' ?> />
					</div>
					<div class="money-table-cell money-column-second_payment_method">
						<?= Money::getMethodLabel($model->second_payment_method) ?>
					</div>
					<div class="money-table-cell money-column-second_payment_date">
						<?= empty($model->second_payment_date) ? '' : date('d.m.y', $model->second_payment_date) ?>
					</div>
					<div class="money-table-cell money-column-comment_fin comment-cell">
						<?php if (!empty($model->comment_fin)) { ?>
							<button type="button" data-toggle="modal" data-target="#comment-fin-modal" class="money-column-value">
								<?= mb_substr($model->comment_fin, 0, 30, 'utf8') . '...' ?>
							</button>
							<span class="hide"><?= $model->comment_fin ?></span>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
			<div class="money-table-row money-total-row">
				<div class="money-table-cell">&nbsp;</div>
			</div>
			<div class="money-table-row money-total-row">
				<div class="money-table-cell">&nbsp;</div>
			</div>
		</div>

		<div class="money-table money-table-sources">
			<div class="money-table-row money-table-row-title js-money-table-row-title"  data-class="money-table-sources">
				<div class="money-table-cell">Источники</div>
			</div>
			<div class="money-table-row money-table-row-header js-money-table-row-header">
				<div class="money-table-cell">Эквайринг</div>
				<div class="money-table-cell">Карта (НПК)</div>
				<div class="money-table-cell">БСО</div>
				<div class="money-table-cell">Нал</div>
				<div class="money-table-cell">Р/C</div>
			</div>
			<div class="money-table-row money-table-row-header js-money-table-row-header search-row">
				<div class="money-table-cell">
					<!--input type="text" class="form-control" name="MoneySearch[yandex_summ]" value="<?= @$_GET['MoneySearch']['yandex_summ'] ?>"-->
				</div>
				<div class="money-table-cell">
					<!--input type="text" class="form-control" name="MoneySearch[card_summ]" value="<?= @$_GET['MoneySearch']['card_summ'] ?>"-->
				</div>
				<div class="money-table-cell">
					<!--input type="text" class="form-control" name="MoneySearch[bso_summ]" value="<?= @$_GET['MoneySearch']['bso_summ'] ?>"-->
				</div>
				<div class="money-table-cell">
					<!--input type="text" class="form-control" name="MoneySearch[cash_summ]" value="<?= @$_GET['MoneySearch']['cash_summ'] ?>"-->
				</div>
				<div class="money-table-cell">
					<!--input type="text" class="form-control" name="MoneySearch[bank_summ]" value="<?= @$_GET['MoneySearch']['bank_summ'] ?>"-->
				</div>
			</div>
			<?php
			$sum = [Money::METHOD_YANDEX => 0, Money::METHOD_CARD => 0, Money::METHOD_BSO => 0, Money::METHOD_CASH => 0,
				/*Money::METHOD_BANK => 0,*/ Money::METHOD_BANK_RS => 0];
			foreach ($models as $k => $model) { ?>
				<div class="money-table-row money-table-row-data money-item-<?= $model->id ?> <?= ($k%2==0) ? 'row-even' : 'row-odd' ?>" data-id="<?= $model->id ?>">
					<?php foreach ($sum as $method => $val) {
						?><div class="money-table-cell money-column-payment_amount_<?= $method ?>"><?php
						$total = MoneyHelper::isSameMethodAndDate($model, $method, $year.'-'.$month);
						$sum[$method] += $total;
						echo number_format($total, 0, ',', ' ');
						?></div><?php
					} ?>
				</div>
			<?php } ?>
			<div class="money-table-row money-total-row">
				<div class="money-table-cell gray-cell {yPaymentColor}"><?= number_format($sum[Money::METHOD_YANDEX], 0, ',', ' ') ?></div>
				<div class="money-table-cell gray-cell"><?= number_format($sum[Money::METHOD_CARD], 0, ',', ' ') ?></div>
				<div class="money-table-cell gray-cell"><?= number_format($sum[Money::METHOD_BSO], 0, ',', ' ') ?></div>
				<div class="money-table-cell gray-cell"><?= number_format($sum[Money::METHOD_CASH], 0, ',', ' ') ?></div>
				<div class="money-table-cell gray-cell"><?= number_format($sum[Money::METHOD_BANK_RS], 0, ',', ' ') ?></div>
			</div>
			<div class="money-table-row money-total-row">
				<div class="money-table-cell">Итого:</div>
			</div>
			<div class="money-table-row money-total-row">
				<div class="money-table-cell gray-cell {yPaymentColor}">
					<?php $arraySumm = array_sum($sum); ?>
					<?= number_format($arraySumm, 0, ',', ' ') ?>
				</div>
			</div>
			<?php
			$sourcesYandexSum = $sum[Money::METHOD_YANDEX];
			?>
		</div>

		<div class="money-table money-table_acquiring">
			<div class="money-table-row money-table-row-title js-money-table-row-title"  data-class="money-table_acquiring">
				<div class="money-table-cell">Данные из эквайринга</div>
			</div>
			<div class="money-table-row money-table-row-header js-money-table-row-header">
				<div class="money-table-cell">1-я оплата</div>
				<div class="money-table-cell">Дата 1-й оплаты</div>
				<div class="money-table-cell">Ссылка на 1-й счет</div>
				<div class="money-table-cell">2-я оплата</div>
				<div class="money-table-cell">Дата 2-й оплаты</div>
				<div class="money-table-cell">Ссылка на 2-й счет</div>
				<div class="money-table-cell">Сверка с реестром</div>
			</div>
			<div class="money-table-row money-table-row-header js-money-table-row-header search-row">
				<div class="money-table-cell">&nbsp;</div>
				<div class="money-table-cell">&nbsp;</div>
				<div class="money-table-cell">&nbsp;</div>
				<div class="money-table-cell">&nbsp;</div>
				<div class="money-table-cell">&nbsp;</div>
				<div class="money-table-cell">&nbsp;</div>
				<div class="money-table-cell">&nbsp;</div>
			</div>
			<?php
			$realYandexSum = 0;
			foreach ($models as $k => $model) { ?>
				<div class="money-table-row money-table-row-data money-item-<?= $model->id ?> <?= ($k%2==0) ? 'row-even' : 'row-odd' ?>" data-id="<?= $model->id ?>">
					<?php
					$pay = $yaColor = '';
					if ($model->payments) {
						foreach ($model->payments as $payment) {
							if ($payment->pnum == 1 && $payment->status == Payment::STATUS_PAID) {
								$pay = number_format($payment->sum, 0, ',', ' ');
								if(date('Y-m', $payment->paid_at) == $year.'-'.$month) {
									$yaColor = 'money-table-cell-green';
									$realYandexSum += $payment->sum;
								} else {
									$yaColor = 'money-table-cell-greendark';
								}
							}
						}
					}
					?>
					<div class="money-table-cell money-column-yandex_1_amount <?= $yaColor ?>">
						<?= $pay ?>
					</div>
					<div class="money-table-cell money-column-yandex_1_date"><?php
						if ($model->payments) {
							foreach ($model->payments as $payment) {
								if ($payment->pnum == 1 && $payment->status == Payment::STATUS_PAID && $payment->paid_at > 0) {
									echo date('d.m.y', $payment->paid_at);
								}
							}
						}
						?></div>
					<div class="money-table-cell"><?php
						if ($model->payments) {
							foreach ($model->payments as $payment) {
								if ($payment->pnum == 1 && $payment->status == Payment::STATUS_PAID) {
									$hash = md5($payment->id . '&' . $payment->ext_id);
									$idOrder = $payment->id . '_' . $payment->created_at
									?><a href="http://payment.sergeysudakov.ru/payment/checkout?id=<?= $idOrder ?>&hash=<?= $hash ?>" title="">
										<img src="/images/money_arr.png">
									</a><?php
								}
							}
						}
						?></div>
					<?php
					$pay = $yaColor = '';
					if ($model->payments) {
						foreach ($model->payments as $payment) {
							if ($payment->pnum == 2 && $payment->status == Payment::STATUS_PAID) {
								$pay = number_format($payment->sum, 0, ',', ' ');
								if(date('Y-m', $payment->paid_at) == $year.'-'.$month) {
									$realYandexSum += $payment->sum;
									$yaColor = 'money-table-cell-green';
								} else {
									$yaColor = 'money-table-cell-greendark';
								}
							}
						}
					}
					?>
					<div class="money-table-cell money-column-yandex_2_amount <?= empty($pay) ? '' : 'money-table-cell-green' ?>">
						<?= $pay ?>
					</div>
					<div class="money-table-cell money-column-yandex_2_date"><?php
						if ($model->payments) {
							foreach ($model->payments as $payment) {
								if ($payment->pnum == 2 && $payment->status == Payment::STATUS_PAID && $payment->paid_at > 0) {
									echo date('d.m.y', $payment->paid_at);
								}
							}
						}
						?></div>
					<div class="money-table-cell">
						<?php if ($model->payments) {
							foreach ($model->payments as $payment) {
								if ($payment->pnum == 2 && $payment->status == Payment::STATUS_PAID) {
									$hash = md5($payment->id . '&' . $payment->ext_id);
									$idOrder = $payment->id . '_' . $payment->created_at
									?><a href="http://payment.sergeysudakov.ru/payment/checkout?id=<?= $idOrder ?>&hash=<?= $hash ?>" title="">
										<img src="/images/money_arr.png">
									</a><?php
								}
							}
						} ?>
					</div>
					<div class="money-table-cell">
						<input class="money-table-checkbox money-table-checkbox-right registry-check"
							   type="checkbox" <?= $model->registry_check ? 'checked' : '' ?>
							   data-id="<?= $model->id ?>" data-url_update="<?= Url::toRoute(['money/update']) ?>" />
					</div>
				</div>
			<?php } ?>
			<div class="money-table-row money-total-row">
				<div class="money-table-cell money-table-cell-green">
					<?= number_format($realYandexSum, 0, ',', ' ') ?>
				</div>
			</div>
			<div class="money-table-row money-total-row">
				<div class="money-table-cell cell-200px">Итого в эквайринге</div>
			</div>
		</div>

		<div class="money-table money-table-reciepts">
			<div class="money-table-row money-table-row-title js-money-table-row-title"  data-class="money-table-reciepts">
				<div class="money-table-cell">Товарные чеки</div>
			</div>
			<div class="money-table-row money-table-row-header js-money-table-row-header">
				<div class="money-table-cell">№</div>
				<div class="money-table-cell">Дата</div>
				<div class="money-table-cell">Комментарий</div>
			</div>
			<div class="money-table-row money-table-row-header js-money-table-row-header search-row">
				<div class="money-table-cell">
					<input type="text" class="form-control" name="MoneySearch[goods_bill_num]" value="<?= @$_GET['MoneySearch']['goods_bill_num'] ?>">
				</div>
				<div class="money-table-cell">
					<input type="text" class="form-control" name="MoneySearch[goods_bill_date]" value="<?= @$_GET['MoneySearch']['goods_bill_date'] ?>">
				</div>
				<div class="money-table-cell">
					<input type="text" class="form-control" name="MoneySearch[goods_bill_comment]" value="<?= @$_GET['MoneySearch']['goods_bill_comment'] ?>">
				</div>
			</div>
			<?php foreach ($models as $k => $model) { ?>
				<div class="money-table-row money-table-row-data money-item-<?= $model->id ?> <?= ($k%2==0) ? 'row-even' : 'row-odd' ?>" data-id="<?= $model->id ?>">
					<div class="money-table-cell money-column-goods_bill_num">
						<?= empty($model->goods_bill_num) ? '' : $model->goods_bill_num ?>
					</div>
					<div class="money-table-cell money-column-goods_bill_date">
						<?php
						$key = empty($model->goods_bill_date) ? '' : $model->id.'_'.$model->goods_bill_num;
						$url = ($key) ? Url::toRoute(['money/waybill', 'num' => $key]) : '';
						?>
						<a href="<?= $url ?>" title="" class="hidden-link" target="_blank">
							<?= empty($model->goods_bill_date) ? '' : date('d.m.y', $model->goods_bill_date) ?>
						</a>
					</div>
					<div class="money-table-cell select-cell money-column-goods_bill_comment">
						<?php
						if ($model->goods_bill_num > 0) {
							echo Html::dropDownList('ttn_komment', $model->goods_bill_comment,	Money::ttnComments(), [
								'class'=>'form-control multiselect',
								'data-id' => $model->id,
								'data-url_update' => Url::toRoute(['money/update']),
							]);
						}
						?>
					</div>
				</div>
			<?php } ?>
			<div class="money-table-row money-total-row">
				<div class="money-table-cell">&nbsp;</div>
			</div>
			<div class="money-table-row money-total-row">
				<div class="money-table-cell">&nbsp;</div>
			</div>
		</div>

		<div class="money-table money-table-comment">
			<div class="money-table-row money-table-row-title js-money-table-row-title" data-class="money-table-comment">
				<div class="money-table-cell">Комментарий</div>
			</div>
			<div class="money-table-row money-table-row-header js-money-table-row-header">
				<div class="money-table-cell">&nbsp;</div>
			</div>
			<div class="money-table-row money-table-row-header js-money-table-row-header search-row">
				<div class="money-table-cell">
					<input type="text" class="form-control" name="MoneySearch[comment]" value="<?= @$_GET['MoneySearch']['comment'] ?>">
				</div>
			</div>
			<?php foreach ($models as $k => $model) { ?>
				<div class="money-table-row money-table-row-data money-item-<?= $model->id ?> <?= ($k%2==0) ? 'row-even' : 'row-odd' ?>" data-id="<?= $model->id ?>">
					<div class="money-table-cell comment-cell money-column-comment">
						<button type="button" data-toggle="modal" data-target="#comment-modal" class="money-column-value">
							<?= $model->comment ?>
						</button>
					</div>
				</div>
			<?php } ?>
			<div class="money-table-row money-total-row">
				<div class="money-table-cell">&nbsp;</div>
			</div>
			<div class="money-table-row money-total-row">
				<div class="money-table-cell">&nbsp;</div>
			</div>
		</div>

		<div class="money-table money-table-ids">
			<div class="money-table-row money-table-row-title js-money-table-row-title" data-class="money-table-ids">
				<div class="money-table-cell">ID изделия</div>
			</div>
			<div class="money-table-row money-table-row-header js-money-table-row-header">
				<div class="money-table-cell">Коллекция</div>
				<div class="money-table-cell">Кол-во</div>
				<div class="money-table-cell">Единицы</div>
				<div class="money-table-cell">Дедлайн</div>
				<div class="money-table-cell">Успешно реализовано</div>
			</div>
			<div class="money-table-row money-table-row-header js-money-table-row-header search-row">
				<div class="money-table-cell">
					<input type="text" class="form-control" name="MoneySearch[collection]" value="<?= @$_GET['MoneySearch']['collection'] ?>">
				</div>
				<div class="money-table-cell">
					<input type="text" class="form-control" name="MoneySearch[count]" value="<?= @$_GET['MoneySearch']['count'] ?>">
				</div>
				<div class="money-table-cell">
					&nbsp;
				</div>
				<div class="money-table-cell">
					<input type="text" class="form-control" name="MoneySearch[deadline]" value="<?= @$_GET['MoneySearch']['deadline'] ?>">
				</div>
				<div class="money-table-cell">
					<input type="text" class="form-control" name="MoneySearch[finished_at]" value="<?= @$_GET['MoneySearch']['finished_at'] ?>">
				</div>
			</div>
			<?php foreach ($models as $k => $model) { ?>
				<div class="money-table-row money-table-row-data money-item-<?= $model->id ?> <?= ($k%2==0) ? 'row-even' : 'row-odd' ?>" data-id="<?= $model->id ?>">
					<div class="money-table-cell money-column-collection"><?= $model->collection ?></div>
					<div class="money-table-cell money-column-count">
						<?= $model->count ?>
					</div>
					<div class="money-table-cell money-column-units">
						<?= $model->units ?>
					</div>
					<div class="money-table-cell money-column-deadline">
						<?= empty($model->deadline) ? '' : date('d.m.y', $model->deadline) ?>
					</div>
					<div class="money-table-cell money-column-finished_at">
						<?= empty($model->finished_at) ? '' : date('d.m.y', $model->finished_at) ?>
					</div>
				</div>
			<?php } ?>
			<div class="money-table-row money-total-row">
				<div class="money-table-cell">&nbsp;</div>
			</div>
			<div class="money-table-row money-total-row">
				<div class="money-table-cell">&nbsp;</div>
			</div>
		</div>

		<div class="money-table money-table-planing">
			<div class="money-table-row money-table-row-title js-money-table-row-title"  data-class="money-table-planing">
				<div class="money-table-cell">Фин. планирование</div>
			</div>
			<div class="money-table-row money-table-row-header js-money-table-row-header">
				<div class="money-table-cell">Предоплаты с прошлых месяцев</div>
				<div class="money-table-cell">Должны в текущем месяце</div>
				<div class="money-table-cell">Должны в следующих месяцах</div>
			</div>
			<div class="money-table-row money-table-row-header js-money-table-row-header search-row">
				<div class="money-table-cell">&nbsp;</div>
				<div class="money-table-cell">&nbsp;</div>
				<div class="money-table-cell">&nbsp;</div>
			</div>
			<?php
			$sum = [0, 0, 0];
			foreach ($models as $k => $model) {
				$days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
				$fromDate = strtotime(date('Y-m-01 00:00:00'));
				$toDate = strtotime(date('Y-m-' . $days . ' 23:59:59'));
				?>
				<div class="money-table-row money-table-row-data money-item-<?= $model->id ?> <?= ($k%2==0) ? 'row-even' : 'row-odd' ?>" data-id="<?= $model->id ?>">
					<div class="money-table-cell money-column-payments_before"><?php
						$total = 0;
						if ($model->first_payment_date < $fromDate) {
							$total += intval($model->first_payment_amount);
						}
						if ($model->second_payment_date < $fromDate) {
							$total += intval($model->second_payment_amount);
						}
						$sum[0] += $total;
						echo number_format($total, 0, ',', ' ');
						?></div>
					<div class="money-table-cell money-column-payments_present"><?php
						$total = 0;
						if ($model->total_amount > 0 && $model->deadline <= $toDate && $model->deadline >= $fromDate) {
							$total = $model->total_amount - $model->first_payment_amount;
							if ($model->second_payment_date > 0 &&  $model->second_payment_amount > 0) {
								$total -= $model->second_payment_amount;
							}
						}
						$sum[1] += $total;
						echo number_format($total, 0, ',', ' ');
						?></div>
					<div class="money-table-cell money-column-payments_next"><?php
						$total = 0;
						if ($model->total_amount > 0 && $model->deadline > $toDate) {
							$total = $model->second_payment_amount;
							if ($model->second_payment_date > 0 &&  $model->second_payment_amount > 0) {
								$total -= $model->second_payment_amount;
							}
						}
						$sum[2] += $total;
						echo number_format($total, 0, ',', ' ');
						?></div>
				</div>
				<?php
			} ?>
			<div class="money-table-row money-total-row">
				<div class="money-table-cell">Итого:</div>
			</div>
			<div class="money-table-row money-total-row">
				<div class="money-table-cell gray-cell">
					<?= number_format($sum[0], 0, ',', ' ') ?>
				</div>
				<div class="money-table-cell gray-cell">
					<?= number_format($sum[1], 0, ',', ' ') ?>
				</div>
				<div class="money-table-cell gray-cell">
					<?= number_format($sum[2], 0, ',', ' ') ?>
				</div>
			</div>
		</div>

		<?php if ($user->hasRole('superadmin')) { ?>
			<div class="money-table money-table-operations">
				<div class="money-table-row money-table-row-title js-money-table-row-title">
					<div class="money-table-cell no-collapse">&nbsp;</div>
				</div>
				<div class="money-table-row money-table-row-header js-money-table-row-header">
					<div class="money-table-cell">Дата добавления</div>
					<div class="money-table-cell">&nbsp;</div>
				</div>
				<div class="money-table-row money-table-row-header js-money-table-row-header search-row">
					<div class="money-table-cell">
						<input type="text" class="form-control" name="MoneySearch[created_at]" value="<?= @$_GET['MoneySearch']['created_at'] ?>">
					</div>
					<div class="money-table-cell">&nbsp;</div>
				</div>
				<?php foreach ($models as $k => $model) { ?>
					<div class="money-table-row money-table-row-data money-item-<?= $model->id ?> <?= ($k%2==0) ? 'row-even' : 'row-odd' ?>" data-id="<?= $model->id ?>">
						<div class="money-table-cell">
							<?= date('d.m.y H:i', $model->created_at) ?>
						</div>
						<div class="money-table-cell">
							<a href="<?= Url::toRoute(['money/delete', 'id' => $model->id]) ?>" title="Удаление" class="money-delete-btn"
							   aria-label="Delete" data-confirm="Удалить выбранную заявку?" data-method="post" data-pjax="0">
								<span class="glyphicon glyphicon-trash"></span>
							</a>
						</div>
					</div>
				<?php } ?>
				<div class="money-table-row money-total-row">
					<div class="money-table-cell">&nbsp;</div>
				</div>
				<div class="money-table-row money-total-row">
					<div class="money-table-cell gray-cell">&nbsp;</div>
				</div>
			</div>
		<?php } ?>

	</div>
	<div class="clearfix"></div>
	<?php
	$content = ob_get_clean();
	$yPaymentColor = ($sourcesYandexSum == $realYandexSum) ? 'money-table-cell-green' : 'money-table-cell-red';
	$content = str_replace('{yPaymentColor}', $yPaymentColor, $content);

	echo $content;

	?></form><?php


// SOME OTHER CONTENT HERE


// modal dialog
?>
<div class="modal" id="comment-modal" data-id="0" data-url_update="<?= Url::toRoute(['money/update']) ?>">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Комментарий</h4>
			</div>
			<div class="modal-body">
				<textarea id="comment_textarea"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
				<button type="button" class="btn btn-primary save-btn">Сохранить</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal" id="comment-fin-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Комментарий</h4>
			</div>
			<div class="modal-body">
				<span id="comment_fin_text"></span>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

