$(document).ready(function () {
	$('#filter_display').hide();
	$('#filter_options').hide();
	$('#search_tags').hide();
	$('#sub_categg').hide();
	var host = 'http://' + window.location.host + '/' + 'tjar/';
	var url_type = '';
	$('#refresh').click(function () {
		$(':input').val('');
		$('#created_url').html(host);
	});

	$('#copy_url').click(function () {
		var copyText = document.getElementById("created_url");
		copyText.select();
		document.execCommand("Copy");
	});

	$("#filter_option").select2({
		placeholder: 'select option',
		allowClear: true
	}).on('select2-open', function ()
	{
		$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
	});
	$("#search_tag").select2({
		placeholder: 'select option',
		allowClear: true
	}).on('select2-open', function ()
	{
		$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
	});


	$('#url_type').change(function () {
		var type = this.value;
		if (type == 1) {
			url_type = host + 'products/index?';
			$('#sub_categg').show();
			$('#filter_display').hide();
			$('#filter_options').hide();
			$('#search_tags').hide();
		} else if (type == 2) {
			$('#filter_display').show();
			$('#filter_options').show();
			$('#sub_categg').show();
			$('#search_tags').hide();
			url_type = host + 'products/index?';
//				$('#products-category').attr("disabled", true);
//				$('#products-subcategory').attr("disabled", true);
		} else if (type == 3) {
			$('#filter_display').hide();
			$('#filter_options').hide();
			$('#sub_categg').hide();
			$('#search_tags').show();
			url_type = host + 'products/product-search?';
		}

		$('#created_url').html(url_type);
	});
	$('#products-category').change(function () {
		$('#created_url').html('');
		var category_id = this.value;
		var type = 1;
		category(category_id, type);
		featureselect(category_id, 1);
		searchtags(category_id, type);

	});
	$('#products-subcategory').change(function () {
		$('#created_url').html('');
		var category_id = this.value;
		var type = 2;
		category(category_id, type);
		featureselect(category_id, 2);

	});
	$('#filter_value').change(function () {
		var filter_id = this.value;
		filterdatas(filter_id);


	});
	$('#search_tag').change(function () {
		var current = $('#created_url').val();
		var default_url = $('#url_before_option').val();
		var check = 'query_search';
		if (current.indexOf(check) > -1) {
			alert('yes');
			var url = default_url + '&query_search=' + this.value;
		} else {
			alert('no');
			var url = current + '&query_search=' + this.value;
		}
		$('#created_url').html(url);



	});
	$('#filter_option').change(function () {
//			alert(this.value);
		$("#filter_option option:selected").each(function () {
			var current_url = $('#created_url').val();
			var $this = $(this);
			var filter_categ = $this.attr('filtercateg');
			if ($this.length) {
				var check = filter_categ + '=' + $this.val();
				if (current_url.indexOf(check) > -1) {
					var url = current_url;
					$('#created_url').html(url);
				} else {
					var url = current_url + '&' + check;
					$('#created_url').html(url);
				}
				console.log(url);
			}
		});
//			var values = $('#filter_option').val();

//			setfilteroptions(values, filter_categ);


	});


	function filterdatas(filter_id) {
		var category_id = $('#category_').val();
		var sub_categ_id = $('#sub_category_').val();
		var crnt = $('#url_before_option').val();
		var current = $('#created_url').val();
		showLoader();
		$.ajax({
			type: 'POST',
			url: homeUrl + 'url-creation/filter-datas', //get featrues
			data: {filterid: filter_id, categ: category_id, sub_categ: sub_categ_id},
			success: function (data) {
//					console.log(data);
				var $data = JSON.parse(data);
				if ($data.con === "1") {
					$('#filter_option').html('').html($data.val);
					hideLoader();
				} else {
					alert('Internal Error');
					hideLoader();
				}
//					$('#created_url').html(url);
			},
			error: function (data) {
				hideLoader();

			}
		});
	}

	function featureselect(category_id, index) {/* indx for differnciate category and sub category*/
		showLoader();
		$.ajax({
			type: 'POST',
			url: homeUrl + 'url-creation/features', //get featrues
			data: {categ_id: category_id, type: index},
			success: function (data) {
				var $data = JSON.parse(data);
				if ($data.con === "1") {
					$('#filter_value').html('').html($data.val);
					hideLoader();
				} else {
					alert('Internal Error');
					hideLoader();
				}
			},
			error: function (data) {

			}
		});
	}
	function category(category_id, type) {
		showLoader();
		$.ajax({
			type: 'POST',
			url: homeUrl + 'url-creation/category', //get main category
			data: {categ_id: category_id, type: type},
			success: function (data) {
				var result = JSON.parse(data);
//					console.log(result);

				if (type == 1) {
					$('#main_category').val(result.main_categ_id);
					$('#category_').val(result.category_id);
					$("#main_category").attr("can_name", result.main_categ_cano_name);
					$("#category_").attr("can_name", result.canonical_name);
					url = url_type + 'main_categ=' + result.main_categ_cano_name + '&categ=' + result.canonical_name;
				} else if (type == 2) {
//						console.log(result);
					$('#main_category').val(result.main_categ_id);
					$("#main_category").attr("can_name", result.main_categ_cano_name);
					$('#category_').val(result.category_id);
					$("#category_").attr("can_name", result.categ_cano_name);
					$('#sub_category_').val(result.sub_categ_id);
					$("#sub_category_").attr("can_name", result.sub_categ_cano_name);
					url = url_type + 'main_categ=' + result.main_categ_cano_name + '&sub_categ=' + result.sub_categ_cano_name;
				}
				$('#url_before_option').val(url);
				$('#created_url').html(url);
				hideLoader();
			},
			error: function (data) {
				hideLoader();
			}
		});
	}
	function searchtags(category_id, type) {
		showLoader();
		$.ajax({
			type: 'POST',
			url: homeUrl + 'url-creation/search-tags', //get search tags
			data: {categ_id: category_id, type: type},
			success: function (data) {
				var $data = JSON.parse(data);
				if ($data.con === "1") {
					$('#search_tag').html('').html($data.val);
					hideLoader();
				} else {
					alert('Internal Error');
					hideLoader();
				}
			},
			error: function (data) {

			}
		});
	}

});