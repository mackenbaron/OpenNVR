<?php
/* @var $this AdminController */
$creators = array('0' => 'sys');
?>
<div class="col-sm-12">
	<?php
	if(Yii::app()->user->hasFlash('notify')) {
		$notify = Yii::app()->user->getFlash('notify');
		?>
		<div class="alert alert-<?php echo $notify['type']; ?>"><?php echo $notify['message']; ?>.</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="nav nav-tabs">
					<li <?php echo $type == 'system' ? 'class="active"' : ''; ?>>
						<?php echo CHtml::link(Yii::t('admin', 'Системные логи'), $this->createUrl('admin/logs', array('type' => 'system'))); ?>
					</li>
					<li <?php echo $type != 'system' ? 'class="active"' : ''; ?>>
						<?php echo CHtml::link(Yii::t('admin', 'Пользовательские логи'), $this->createUrl('admin/logs', array('type' => 'user'))); ?>
					</li>
				</ul>
			</div>
			<div class="panel-body">
				<?php
				if(!empty($logs)) {
					?>
					<table class="table table-striped">
						<thead>
							<th>#</th>
							<th><?php echo Yii::t('admin', 'Кто'); ?></th>
							<th><?php echo Yii::t('admin', 'Кому'); ?></th>
							<th><?php echo Yii::t('admin', 'Сообщение'); ?></th>
							<th><?php echo Yii::t('admin', 'Время'); ?></th>
						</thead>
						<tbody>
							<?php
							foreach($logs as $key => $log) {
								if(!isset($creators[$log->creator_id])) {
									$user = Users::model()->findByPK($log->creator_id);
									$creators[$log->creator_id] = $user->nick;
								} 
								if(!isset($creators[$log->dest_id])) {
									$user = Users::model()->findByPK($log->dest_id);
									$creators[$log->dest_id] = $user->nick;
								}
								echo '<tr>
								<td>'.($key+1).'</td>
								<td>'.CHtml::encode($log->creator_id == 0 ? 'Система' : $creators[$log->creator_id]).'</td>
								<td>'.CHtml::encode($log->dest_id == 0 ? 'Система' : $creators[$log->dest_id]).'</td>
								<td>'.CHtml::encode($log->msg).'</td>
								<td>'.CHtml::encode(date('d-m-Y H:i:s', $log->time)).'</td>
								</tr>';
							}
							?>
						</tbody>
					</table>
					<?php
				} else {
					echo Yii::t('admin', 'логи пусты');
				}
				?>
			</div>
		</div>
	</div>
