<hr />
<div class="row">
	<div class="col-md-12">

		<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
				<a href="#list" data-toggle="tab">
					<i class="entypo-menu"></i>
					<?php echo get_phrase('income_category_list'); ?>
				</a>
			</li>
			<li>
				<a href="#add" data-toggle="tab">
					<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_income_category'); ?>
				</a>
			</li>
		</ul>
		<!------CONTROL TABS END------>

		<div class="tab-content">
			<br>
			<!----TABLE LISTING STARTS-->
			<div class="tab-pane box active" id="list">

				<div id="editIncomeCategoryHolder"></div>
				<div id="IncomeCategoryList">

					<table class="table table-bordered datatable" id="table_export">
						<thead>
							<tr>
								<th>
									<div>#</div>
								</th>
								<th>
									<div>
										<?php echo get_phrase('name');?>
									</div>
								</th>
								<th>
									<div>
										<?php echo get_phrase('options');?>
									</div>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$count = 1;
								$incomes = $this->db->get('income_category')->result_array();
								foreach ($incomes as $row):
							?>
							<tr id="income_category<?php echo $row['income_category_id'];?>">
								<td>
									<?php echo $count++;?>
								</td>
								<td>
									<?php echo ucwords(str_replace('_', ' ', $row['name']));?>
								</td>
								<td>

									<div class="btn-group">
										<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
											Action
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu dropdown-default pull-right" role="menu">

											<!-- Category EDITING LINK -->
											<li>
												<a href="#" onclick="editIncomeCategory('<?php echo $row['income_category_id'];?>')">
													<i class="entypo-pencil"></i>
													<?php echo get_phrase('edit');?>
												</a>
											</li>
											<li class="divider"></li>

											<!-- Category DELETION LINK -->
											<li>
												<a href="#" onclick="confDelete('admin','ajax_delete_income_category','<?php echo $row['income_category_id'];?>','income_category<?php echo $row['income_category_id'];?>')">
													<i class="entypo-trash"></i>
													<?php echo get_phrase('delete');?>
												</a>
											</li>
										</ul>
									</div>

								</td>
							</tr>
							<?php endforeach;?>
						</tbody>
					</table>

				</div>
			</div>
			<!----TABLE LISTING ENDS--->


			<!----CREATION FORM STARTS---->
			<div class="tab-pane box" id="add" style="padding: 5px">
				<div class="box-content">

					<form id="createIncomeCategory" action="<?php echo base_url() .'index.php?admin/ajax_income_category_create'; ?>" class="form-horizontal form-groups-bordered"
					    method="post">

						<div class="form-group">
							<label for="field-1" class="col-sm-3 control-label">
								<?php echo get_phrase('name');?>
							</label>

							<div class="col-sm-6">
								<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"
								    value="" autofocus>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-5">
								<button type="submit" class="btn btn-info">
									<?php echo get_phrase('add_income_category');?>
								</button>
							</div>
						</div>
						<?php echo form_close();?>

				</div>
			</div>
			<!----CREATION FORM ENDS-->
		</div>

	</div>
</div>



<script type="text/javascript">
	$(document).ready(function () {

		$('#createIncomeCategory').ajaxForm({
			beforeSend: function () {
				$('#loading2').show();
				$('#overlayDiv').show();
			},
			success: function (data) {
				var jData = JSON.parse(data);

				if (!jData.type) {
					toastr.error(jData.msg);
				} else {
					toastr.success(jData.msg);
					$("#IncomeCategoryList").html(jData.html);
					$("#table_export").dataTable();
					$('#createIncomeCategory').resetForm();
				}
				$('body,html').animate({
					scrollTop: 0
				}, 800);
				$('#loading2').fadeOut('slow');
				$('#overlayDiv').fadeOut('slow');
			}
		});

	});

	function editIncomeCategory(incomeCategoryID) {
		$.ajax({
			type: 'GET',
			url: '<?php echo base_url();?>index.php?admin/ajax_income_category_edit/' + incomeCategoryID,
			beforeSend: function () {
				$('#loading2').show();
				$('#overlayDiv').show();
			},
			success: function (data) {
				var jData = JSON.parse(data);

				toastr.success(jData.msg);
				$("#editIncomeCategoryHolder").html(jData.html);
				$('body,html').animate({
					scrollTop: 350
				}, 800);
				$('#loading2').fadeOut('slow');
				$('#overlayDiv').fadeOut('slow');
			}
		});
	}


	jQuery(document).ready(function ($) {

		var datatable = $("#table_export").dataTable({
			"sPaginationType": "bootstrap",
			"sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
			"oTableTools": {
				"aButtons": [{
						"sExtends": "xls",
						"mColumns": [1, 2, 3, 4, 5]
					},
					{
						"sExtends": "pdf",
						"mColumns": [1, 2, 3, 4, 5]
					},
					{
						"sExtends": "print",
						"fnSetText": "Press 'esc' to return",
						"fnClick": function (nButton, oConfig) {
							datatable.fnSetColumnVis(2, false);

							this.fnPrint(true, oConfig);

							window.print();

							$(window).keyup(function (e) {
								if (e.which == 27) {
									datatable.fnSetColumnVis(2, true);
								}
							});
						},

					},
				]
			},

		});

		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
</script>