<?php
/*
 * @package     Joomla.Administrator
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');
$this->sortColumn	= $this->escape($this->state->get('list.ordering'));
$this->sortDirection	= $this->escape($this->state->get('list.direction'));

//Get tshirt-size options
JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');
$accredOptions = JFormHelper::loadFieldType('Accred', false);
$daysOptions=$accredOptions->getOptionsDays(); // works only if you set your field getOptions on public!!

?>
<script language="javascript" type="text/javascript">
function tableOrdering( order, dir, task )
{
	var form = document.adminForm;
 
	form.filter_order.value = order;
	form.filter_order_Dir.value = dir;
	document.adminForm.submit( task );
}
</script>
<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>

<div id="j-main-container" class="span10">
	<h1>Liste des accréditations</h1>
	<form action="<?php echo JRoute::_('index.php?option=com_estipress&view=accred');?>" method="post" name="adminForm" id="adminForm">
		<div id="j-main-container">
			<div id="filter-bar" class="btn-toolbar">
				<div class="filter-search btn-group pull-left">
					<label for="filter_search" class="element-invisible">Rechercher dans le titre</label>
					<input type="text" name="filter_search" id="filter_search" placeholder="Rechercher" value="<?php echo $this->escape($this->searchterms); ?>" class="hasTooltip" title="Rechercher dans le titre" />
				</div>
				<div class="btn-group pull-left">
					<button type="submit" class="btn hasTooltip" title="Rechercher"><i class="icon-search"></i></button>
					<button type="button" class="btn hasTooltip" title="Effacer" onclick="document.getElementById('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
				</div>
				<div class="btn-group pull-right hidden-phone">
					<select name="filter_day_presence" class="inputbox" onchange="this.form.submit()">
						<option value=""> - Select day - </option>
						<?php echo JHtml::_('select.options', $daysOptions, 'value', 'text', $this->state->get('filter.day_presence'));?>
					</select>
					<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
					<?php echo $this->pagination->getLimitBox(); ?>
				</div>
			</div>
			<table class="table table-striped">
				<thead>
					<tr>
						<th width="1%" class="hidden-phone">
							<?php echo JHtml::_('grid.checkall'); ?>
						</th>
						<th>#</th>
						<th class="left">
							<?php echo JHTML::_( 'grid.sort', 'Nom', 'u.name', $this->sortDirection, $this->sortColumn); ?>
						</th>
						<th class="left">
							<?php echo JHTML::_( 'grid.sort', 'Email', 'u.email', $this->sortDirection, $this->sortColumn); ?>
						</th>
						<th class="left">
							<?php echo JText::_('Média'); ?>
						</th>
						<th class="left">
							<?php echo JText::_('Type média'); ?>
						</th>
						<th class="left">
							<?php echo JText::_('Fonction'); ?>
						</th>
						<th class="left">
							<?php echo JText::_( 'Zone diffusion' ); ?>
						</th>
						<th class="left">
							<?php echo JText::_( 'Dates présence' ); ?>
						</th>
						<th class="center">
							<?php echo JText::_('Actions'); ?>
						</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				$itemNumber = $this->limitstart;
				foreach ($this->accred as $i => $item){
					$userId = $item->user_id; 
					$user = JFactory::getUser($userId);
					$userProfile = JUserHelper::getProfile( $userId );
					$userEstipress = EstipressHelpersUser::getProfilEstipress( $userId );
					$itemNumber++;
				?>
					<tr class="row<?php echo $i % 2; ?>">
						<td class="center hidden-phone">
							<?php echo JHtml::_('grid.id', $i, $item->accred_id); ?>
						</td>
						<td><?php echo $itemNumber; ?></td>
						<td class="left">
							<a href="<?php echo JRoute::_('index.php?option=com_estipress&task=member.edit&member_id='.(int) $item->member_id); ?>">
								<?php echo JText::_($user->name); ?>
							</a>
						</td>
						<td class="left">
							<a href="mailto:<?php echo $item->email; ?>">
							<?php echo JText::_($item->email); ?>
							</a>
						</td>
						<td class="left">
							<?php if($userEstipress->estipress['site_media']!=''){ echo '<a href=http://'.$userEstipress->estipress['site_media'].'>'; } echo JText::_($userEstipress->estipress['media']); if($userEstipress->estipress['site_media']!=''){ echo '</a>'; } ?>
						</td>
						<td class="left">
							<?php echo JText::_($userEstipress->estipress['type_media']); ?>
						</td>
						<td class="left">
							<?php echo JText::_($userEstipress->estipress['fonction']); ?>
						</td>
						<td class="left">
							<?php echo JText::_($userEstipress->estipress['zone_diffusion']); ?>
						</td>
						<td class="left">
							<?php foreach($userEstipress->estipress['dates_presence'] as $i=>$item){ echo $item.'<br />'; } ?>
						</td>
						<td class="center">
							<!--<a class="btn" onclick="composeEmail('<?php echo $this->member->member_id; ?>')">
								<i class="icon-mail"></i>
							</a>-->
							<?php echo JHtml::_('job.deleteListMember', $item->member_id, $i); ?>
						</td>
					</tr>
				<?php 
				} 
				?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="8">
							<?php echo $this->pagination->getListFooter(); ?>
						</td>
					</tr>
				</tfoot>
			</table>
			<div class="pagination">
				<p class="counter">
				<?php echo $this->pagination->getPagesCounter(); ?>
				</p>
			</div>

			<input type="hidden" name="task" value="" />
			<input type="hidden" name="filter_order" value="<?php echo $this->sortColumn; ?>" />
			<input type="hidden" name="filter_order_Dir" value="<?php echo $this->sortDirection; ?>" />
			<input type="hidden" name="boxchecked" value="0" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</form>
</div>