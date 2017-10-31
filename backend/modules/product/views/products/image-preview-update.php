
<style>


	div.show-image {
		position: relative;
		float:left;
		margin:5px;
	}
	div.show-image:hover img{
		opacity:0.5;
	}
	div.show-image:hover a {
		display: block;
	}
	div.show-image a {
		position:absolute;
		display:none;
	}
	div.show-image span.profile_image {
		position: absolute;
		width: 53%;
		top: 0;
		background: #007eff;
		text-align: center;
		color: white;
	}
	div.show-image a.update {
		top:0;
		left:0;
	}
	div.show-image a.btn {
		padding: 1px 7px;
	}
	div.show-image a.btn i {
		font-size: 10px;
	}
	div.show-image a.delete_image {
		top: 4px;
		left: 80%;
	}



</style>
<style>
	/* The container */
	.radio_btn {
		display: block;
		position: relative;
		padding-left: 35px;
		margin-bottom: 12px;
		cursor: pointer;
		font-size: 22px;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}

	/* Hide the browser's default radio button */
	.radio_btn input {
		position: absolute;
		opacity: 0;
	}

	/* Create a custom radio button */
	.checkmark {
		position: absolute;
		top: 0;
		left: 34px;
		height: 18px;
		width: 18px;
		background-color: #eee;
		border-radius: 50%;
	}

	/* On mouse-over, add a grey background color */
	.radio_btn:hover input ~ .checkmark {
		background-color: #ccc;
	}

	/* When the radio button is checked, add a blue background */
	.radio_btn input:checked ~ .checkmark {
		background-color: #2196F3;
	}

	/* Create the indicator (the dot/circle - hidden when not checked) */
	.checkmark:after {
		content: "";
		position: absolute;
		display: none;
	}

	/* Show the indicator (dot/circle) when checked */
	.radio_btn input:checked ~ .checkmark:after {
		display: block;
	}

	/* Style the indicator (dot/circle) */
	.radio_btn .checkmark:after {
		top: 6px;
		left: 6px;
		width: 6px;
		height: 6px;
		border-radius: 50%;
		background: white;
	}
</style>
<input type="hidden" id="prof-change-model-id" name="prof-change-model-id" value="<?= $model->id ?>">
<div class="show-image" id="<?= $k ?>">
	<div style="min-height: 74px;">
		<img srcset="<?= Yii::$app->homeUrl . '../uploads/products/' . $split_folder . '/' . $model->id . '/profile/' . $model->canonical_name . '_thumb.' . $model->gallery_images ?>" alt="no-image" newpath="<?= $model->canonical_name . '.' . $model->gallery_images ?>"style="" id="prof_image_changed">

		<a class="update delete_image btn btn-icon btn-red"  id-for="<?= $model->canonical_name . '.' . $model->gallery_images ?>" id="model_<?= $model->id ?>_<?= $id ?>" href="" ><i class="fa-remove"></i>
		</a>
	</div>
	<label class="radio_btn">
		<input type="radio" name="profile-image" id="radio-btn-<?= $id ?>"  id-for="<?= $id ?>" value="profile-image<?= $id ?>" checked class="setProfile">
		<span class="checkmark"></span>
	</label>
</div>
<?php
$path = \Yii::$app->basePath . '/../uploads/products/' . $split_folder . '/' . $model->id . '/gallery_thumb';

if (count(glob("{$path}/*")) > 0) {

	$k = 0;
	$id = 0;
	foreach (glob("{$path}/*") as $file) {
		if (!is_dir($file)) {
			$arry = explode('/', $file);
			?>
			<div class="show-image" id="<?= $k ?>">
				<div style="min-height: 74px;">
					<img srcset="<?= Yii::$app->homeUrl . '../uploads/products/' . $split_folder . '/' . $model->id . '/gallery_thumb' . '/' . end($arry) ?>?<?= rand(); ?>" alt="no-image" img-name="<?= end($arry) ?>"style="" id="image_<?= $id ?>">

					<a class="update delete_image btn btn-icon btn-red"  id-for="<?= end($arry) ?>" id="delete_id_<?= $id ?>_<?= $model->id ?>" href="" hide_delete="<?= $id ?>"><i class="fa-remove"></i>
					</a>
				</div>
				<label class="radio_btn">
					<input type="radio" name="profile-image" id="radio-btn-<?= $id ?>"  id-for="<?= $id ?>" value="profile-image<?= $id ?>"  class="setProfile cbr cbr-red" >
					<span class="checkmark"></span>
				</label>


			</div>

			<?php
		}
		?>


		<?php
		$id++;
		$k++;
	}
}
?>


<script>
	$(document).ready(function () {
		var radio_btn = $('input[name="profile-image"]:checked').attr("id-for");
		var modelid = $('#prof-change-model-id').val();
		var delete_link_id = 'model_' + modelid;
		$('#' + delete_link_id + '_' + radio_btn).hide();
		$('input[name=profile-image]').mouseup(function () {
			var previous = $('input[name=profile-image]:checked').attr("id-for");
			$('#' + delete_link_id + '_' + previous).show();
		}).change(function () {
			var current = $('input[name=profile-image]:checked').attr("id-for");
			$('#' + delete_link_id + '_' + current).hide();
		});
		$("input[name='profile-image']").change(function (event) {
//		$('.setProfile').click(function (event) {
			event.preventDefault();
			var modelid = $('#prof-change-model-id').val();

			var id = $(this).attr("id-for");

			var img_path = $('#image_' + id).attr("img-name");
			$.ajax({
				url: '<?= Yii::$app->homeUrl; ?>product/products/set-newprofile-image', // Upload Script
				data: {imagepath: img_path, modelid: modelid},
				type: 'post',
				success: function (data) {
//					$('#' + 0).hide();
					alert("set as profile image");
				},
				error: function (data) {
				}
			});
		});
		$('.delete_image').click(function (event) {
			event.preventDefault();
			var image = $(this).attr("id-for");
			var id = $(this).attr("id");
			if (confirm('Are you sure you want to delete this?')) {
				$.ajax({
					url: '<?= Yii::$app->homeUrl; ?>product/products/delete-gallery-image', // Upload Script
					data: {image: image, id: id},
					type: 'post',
					success: function (data) {
						var $data = JSON.parse(data);
						if ($data.msg == "success") {
							$('#' + $data.id).hide();

						} else {
							alert($data.title);
						}
					},
					error: function (data) {
						alert(data);
					}
				});
			}
		});
	});
</script>




