<?php
require_once(__CA_APP_DIR__ . "/plugins/ShelfMarkGen/models/Label.php");
$labels = $this->getVar("labels");
?>
<div class="sectionBox">
	<form method="post" target="_blank" action="<?php echo __CA_URL_ROOT__; ?>/index.php/find/SearchObjects/printLabels">
	<table id="tudLabelList" class="listtable" width="100%" border="0" cellpadding="0" cellspacing="1">
		<thead>
		<tr>
			<th>
				<?php _p('Shelf Mark'); ?>
			</th>
			<th>
				<?php _p('Print'); ?>
			</th>
		</tr>
		</thead>
		<tbody>
		<?php
		if (sizeof($labels)) {
			$i = -1;
			foreach($labels as $label) {
				$i++;

				?>
				<tr>
					<td>
						<?php print $label->getShelfMark(); ?>
					</td>
					<td>
						<input type="checkbox" class="labelCheckbox" checked name="print[<?php echo $i; ?>][shelfmark]" value="<?php echo $label->getShelfMark(); ?>"/>
					</td>
				</tr>
			<?php
			}
		} else {
			?>
			<tr>
				<td colspan="2" align="center"><?php print _t("No labels to print."); ?></td>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>
		<input type="hidden" name="_formName" value="caPrintLabelsForm"/>
		<input type="hidden" name="form_timestamp" id="form_timestamp" value="caPrintLabelsForm"/>
		<input type="hidden" name="label_form" value="_pdf_tud_all_copies"/>
		<input type="hidden" name="download" value="1"/>
	<input type="button" id="printButton" value="Print Labels"/>
	<input type="submit" formaction="<?php echo __CA_URL_ROOT__; ?>/index.php/ShelfMarkGen/PrintLabels/Delete" value="Delete from Queue"/>
	</form>
	<iframe style="display: none;" id="hiddenIFrame" name="hiddenIFrame">

	</iframe>
	<script type="text/javascript">
		$(function(){
			var generateSearchExpression, tudUrlRoot = "<?php echo __CA_URL_ROOT__; ?>";
			generateSearchExpression = function(){
				var searchExpression = null;
				$(".labelCheckbox:checked").each(function(){
					if(searchExpression === null){
						searchExpression = "ca_objects.preferred_labels:" + $(this).val();
					} else {
						searchExpression += " OR ca_objects.preferred_labels:" + $(this).val();
					}
					$(this).parents("tr").first().hide();
				});
				return searchExpression;
			};
			$("#printButton").click(function(e){
				var timeStamp = new Date().getTime();
				var loadSecondForm = true;
				$("#hiddenIFrame").load(function(){
					if(loadSecondForm){
						var form2=$("<form/>").attr({
							method: "post",
							action: tudUrlRoot + "/index.php/find/SearchObjects/printLabels",
							target: "hiddenIFrame"
						});
						form2.append($("<input/>").attr({name:"_formName", value:"caPrintLabelsForm"}));
						form2.append($("<input/>").attr({name:"form_timestamp", value:timeStamp + 1}));
						form2.append($("<input/>").attr({name:"label_form", value:"_pdf_tud_all_copies"}));
						form2.append($("<input/>").attr({name:"download", value:"1"}));
						$("body").append(form2);
						form2.submit();
						loadSecondForm = false;
					}
				});
				var form=$("<form/>").attr({
					method: "post",
					action: tudUrlRoot + "/index.php/find/SearchObjects/Index",
					target: "hiddenIFrame"
				});
				form.append($("<input/>").attr({name:"_formName", value:"BasicSearchForm"}));
				form.append($("<input/>").attr({name:"form_timestamp",value:timeStamp}));
				form.append($("<input/>").attr({name:"search",value:generateSearchExpression()}));
				$("body").append(form);
				form.submit();
			});
		});
	</script>
</div>